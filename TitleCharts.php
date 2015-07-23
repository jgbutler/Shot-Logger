<?php require_once('Connections/ShotLoggerVM.php'); ?><?php
/*
    Shot Logger facilitates the analysis of visual style in film and television 
	through frame captures and editing statistics.
    Copyright (C) 2008-2011 Jeremy Butler

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysql_select_db($database_ShotLoggerVM, $ShotLoggerVM);
$query_DetailRS1 = sprintf("SELECT * FROM sl_Title2 WHERE slTitleID = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysql_query($query_DetailRS1, $ShotLoggerVM) or die(mysql_error());
$row_DetailRS1 = mysql_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysql_num_rows($DetailRS1);

$colname_rsShotListing = "-1";
if (isset($_GET['recordID'])) {
  $colname_rsShotListing = $_GET['recordID'];
}
mysql_select_db($database_ShotLoggerVM, $ShotLoggerVM);
$query_rsShotListing = sprintf("SELECT * FROM sl_ShotData WHERE slTitleID = %s ORDER BY TimeCode ASC", GetSQLValueString($colname_rsShotListing, "int"));
$rsShotListing = mysql_query($query_rsShotListing, $ShotLoggerVM) or die(mysql_error());
$row_rsShotListing = mysql_fetch_assoc($rsShotListing);
$totalRows_rsShotListing = mysql_num_rows($rsShotListing);

// ListDir function by frasq at frasq dot org, http://php.net/manual/en/function.readdir.php
function listdir($dir='.') { 
    if (!is_dir($dir)) { 
        return false; 
    } 
    
    $files = array(); 
    listdiraux($dir, $files); 

    return $files; 
} 

function listdiraux($dir, &$files) { 
    $handle = opendir($dir); 
    while (($file = readdir($handle)) !== false) { 
        if ($file == '.' || $file == '..') { 
            continue; 
        } 
        $filepath = $dir == '.' ? $file : $dir . '/' . $file; 
        if (is_link($filepath)) 
            continue; 
        if (is_file($filepath)) 
            $files[] = $filepath; 
        else if (is_dir($filepath)) 
            listdiraux($filepath, $files); 
    } 
    closedir($handle); 
} 

// Set directory to list files from
$files = listdir('images'); 

// Function to select a random item from an array
function getRandomFromArray($ar) { 
    mt_srand( (double)microtime() * 1000000 ); 
    $num = array_rand($ar); 
    return $ar[$num]; 
} 

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shot Logger 2.0 Charts:<?php echo $row_DetailRS1['Title']; ?></title>
<link href="twoColLiqLtHdr.css" rel="stylesheet" type="text/css" />
</head>

<body>
<!-- start .header -->
<div class="container">
  <div class="header"><a href="/index.php"><img src="images_site/LogoV2.png" name="Insert_logo" width="400" height="80" border="0" align="left" id="Insert_logo" style="display:block;" /><img src="
  <?php 
  // Insert a random image from the $files array
$img4 = getRandomFromArray($files);
  echo $img4 ; ?>
  " alt="Shot Logger Logo" name="Insert_logo" height="80" align="left" class="image_framed" id="Insert_logo" style="background: #FFFFFF; display:block;" /></a>
  <a href="/index.php"><img src="
  <?php 
  // Insert a random image 
$img4 = getRandomFromArray($files);
  echo $img4 ; ?>
  " alt="Shot Logger Logo" name="Insert_logo" height="80" align="left" class="image_framed" id="Insert_logo" style="background: #FFFFFF; display:block;" /></a> <a href="/index.php"><img src="
  <?php 
  // Insert a random image 
$img4 = getRandomFromArray($files);
  echo $img4 ; ?>
  " alt="Shot Logger Logo" name="Insert_logo" height="80" align="left" class="image_framed" id="Insert_logo" style="background: #FFFFFF; display:block;" /></a> 
  <!-- end .header --></div>

  <!-- start .content -->
<div class="content">
<!--<div class="content_wide">-->

<h1>Title Charts - <em><?php echo $row_DetailRS1['Title']; ?></em></h1>
<p></p>

<!--Display Cinemetics Chart-->

<table border="0">
  <tr>
    <td align="center"><strong>Shot-Length Graph</strong></td>
  </tr>
  <tr>
    <td align="center"><!--build URL for graph
	Works:
        <img src="http://www.cinemetrics.lv/getgraph.php?step=1&height=200&vr=1&degree=1&cc=0&shots=
  -->
      
  <!--     Works: modified below on 10/19/2011
 <img src="http://www.cinemetrics.lv/getgraph.php?step=1&height=200&vr=1&degree=8&cc=0&shots=

-->
      <img src="http://www.cinemetrics.lv/getgraph.php?<?php 
/*
Here the variables after ? are:

step - 
height – height of the graph in pixels
vr – vertical resolution (1 means 10 pixels per second, 2 means 20 pixels per second 0.5 means 5 pixels per second etc.)
degree – degree of the trendline
cc - color code?

E.g.,
http://www.cinemetrics.lv/getgraph.php?height=200&vr=1&degree=1&shots=10,20,30,40,50,60,70,80,90,100

*/

// Set Step parameter
echo 'step=';
	  	if (isset($_POST['step'])) {
  			$_POST['step'] = ( get_magic_quotes_gpc() ) ? $_POST['step'] : addslashes( $_POST['step'] )  ;
		} else {
			$_POST['step'] = 1 ;
		}
		echo $_POST['step'] ;

// Set Height parameter
echo '&height=' ; 

		if (isset($_POST['height'])) {
  			$_POST['height'] = ( get_magic_quotes_gpc() ) ? $_POST['height'] : addslashes( $_POST['height'] )  ;
		} else {
			$_POST['height'] = 200 ;
		}
		echo $_POST['height'];

// Set Vertical Resolution parameter
echo '&vr=';
	  	if (isset($_POST['vr'])) {
  			$_POST['vr'] = ( get_magic_quotes_gpc() ) ? $_POST['vr'] : addslashes( $_POST['vr'] )  ;
		} else {
			$_POST['vr'] = 1 ;
		}
		echo $_POST['vr'];

// Set Degree of Trendline parameter
echo '&degree='; 
		if (isset($_POST['degree'])) {
  			$_POST['degree'] = ( get_magic_quotes_gpc() ) ? $_POST['degree'] : addslashes( $_POST['degree'] )  ;
		} else {
			$_POST['degree'] = 8 ;
		}
		echo $_POST['degree'];

// Set up the URL parameter for the shot list

echo '&cc=0&shots=' ;

// Get the shot list

do {

echo 10*$row_rsShotListing['ShotLength']. ',' ;

} while ($row_rsShotListing = mysql_fetch_assoc($rsShotListing));

//echo ' "/> ' ;

?>

"/>  <!--End of image tag-->
      
      
  <br />
  <br /></td>
  </tr>
  <tr>
    <td><p><strong>Current graph settings:</strong></p>
      <p><strong>Step</strong>:
        <?php 
	  	if (isset($_POST['step'])) {
  			$_POST['step'] = ( get_magic_quotes_gpc() ) ? $_POST['step'] : addslashes( $_POST['step'] )  ;
		} else {
			$_POST['step'] = 1 ;
		}
	  	echo $_POST['step'] ?>
        <br />
        <strong>Vertical resolution</strong>:
        <?php 
	  	if (isset($_POST['vr'])) {
  			$_POST['vr'] = ( get_magic_quotes_gpc() ) ? $_POST['vr'] : addslashes( $_POST['vr'] )  ;
		} else {
			$_POST['vr'] = 1 ;
		}
		echo 10*($_POST['vr']) ?>
        pixels for each second of shot length<br />
        <strong>Height of graph</strong>:
        <?php 
		if (isset($_POST['height'])) {
  			$_POST['height'] = ( get_magic_quotes_gpc() ) ? $_POST['height'] : addslashes( $_POST['height'] )  ;
		} else {
			$_POST['height'] = 200 ;
		}
		echo $_POST['height'] ?>
        pixels<br />
        <strong>Degree of trendline</strong>:
        <?php 
		if (isset($_POST['degree'])) {
  			$_POST['degree'] = ( get_magic_quotes_gpc() ) ? $_POST['degree'] : addslashes( $_POST['degree'] )  ;
		} else {
			$_POST['degree'] = 8 ;
		}
		echo $_POST['degree'] ?>
        <br />
        <!--        Color code: <?php echo $_POST['cc'] ?>-->
        </p>
      </p>
      <p><em>Change the graph's settings: </em></p>
      <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>?recordID=<?php echo $_GET['recordID'] ?>" method="post" name="redraw" class="bodyText" id="redraw">
        <!-- 

Form details from CineMetrics http://www.cinemetrics.lv/movie.php?movie_ID=565 

<form action="" method="post" name="form2" class="bodyText" id="form2"> 

-->
        <p>
          <strong>Step</strong>:
          <select name="step" class="bodyText">
            <option value="1" selected="selected">1</option>
            <option value="2" >2</option>
            <option value="3" >3</option>
            <option value="4" >4</option>
            <option value="5" >5</option>
            <option value="6" >6</option>
            <option value="7" >7</option>
            <option value="8" >8</option>
            <option value="9" >9</option>
            <option value="10" >10</option>
            </select>
          <br />
          <strong>Vertical resolution</strong>:
          <select name="vr" class="bodyText">
            <option value=".1">1 pixel/sec</option>
            <option value=".2">2 pixels/sec</option>
            <option value=".3">3 pixels/sec</option>
            <option value=".5">5 pixels/sec</option>
            <option value="1" selected="selected">10 pixels/sec</option>
            <option value="1.5">15 pixels/sec</option>
            <option value="2">20 pixels/sec</option>
            <option value="3">30 pixels/sec</option>
            <option value="5">50 pixels/sec</option>
            </select>
          <br />
          <strong>Height</strong>:
          <select name="height" class="bodyText">
            <option value="10">10 pix</option>
            <option value="50">50 pix</option>
            <option value="100">100 pix</option>
            <option value="200" selected="selected">200 pix</option>
            <option value="300">300 pix</option>
            <option value="500">500 pix</option>
            <option value="750">750 pix</option>
            <option value="1000">1000 pix</option>
            </select>
          <br />
          <strong>Degree of the trendline</strong>:
          <select name="degree" class="bodyText">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8" selected="selected">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            </select>
          <br />
          <strong>        Moving average</strong> (The range over which the average is computed. If set to 10, the average will be computed for 11 shots: the current one, 5 before it, and 5 ahead of it):
          <select name="period" class="bodyText">
            <option value="0" selected="selected">0</option>
            <option value="6">6</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="30">30</option>
            <option value="40">40</option>
            <option value="50">50</option>
            <option value="60">60</option>
            <option value="70">70</option>
            <option value="80">80</option>
            <option value="90">90</option>
            <option value="100">100</option>
            </select>
          <!--           Color code? 
           <select name="cc" class="bodyText" id="cc"> 
             <option value="0" selected="selected">No</option> 
             <option value="1">Yes</option> 
          </select>            
-->
          <br />
          <!--Redraw button -- replace with link to new file? 
          <input name="redraw" type="button" class="navText" id="redraw" onclick="Redraw(this.form);" value="Redraw" /> 
          <input name="movie" type="hidden" id="movie" value="565" /> 
-->
          <!--Show trendline equation button

          <input name="button" type="button" class="navText" id="button" value="Show trendline equation" onClick="window.open('equation.php','graph', 'width=500,height=200,scrollbars=no,resizable=1,scrolling=no,location=no,toolbar=no');"
/> 
-->
          <!--Show raw data button

          <input name="button2" type="button" class="navText" id="button2" value="Show raw data" onclick="window.open('data.php?movie_ID=565','rawdata', 'width=203,height=600,scrollbars=yes,resizable=1,scrolling=yes,location=no,toolbar=no');"
/> -->
          <input name="submit" type="submit" value="draw new graph" />
          </p>
        </form>
      <!-- End Cinemetrics form -->
      <p>Graph created by <a href="http://www.cinemetrics.lv" target="_blank">CineMetrics</a>. For help interpeting this graph, please see &quot;<a href="http://www.cinemetrics.lv/dbhelp.php" target="_blank">Using the database</a>.&quot;</p> </td>
    </tr>
</table>

<?php 
include ('includes/footerV2.php') ;
?>
<?php
mysql_free_result($DetailRS1);
mysql_free_result($rsShotListing);
?>