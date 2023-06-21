<?php 
/*
    Shot Logger facilitates the analysis of visual style in film and television 
	through screen shots and editing statistics.
    Copyright (C) 2007-2015 Jeremy Butler.
	Telecommunication and Film Department, The University of Alabama.

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
require_once('Connections/ShotLoggerVM.php'); 

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

try {
		// Connect to the database and run a query to return a record set (rs)
        $sql = "SELECT * FROM sl_Title2  LEFT JOIN `sl_ImdbMap`  USING (IMDbID)  ORDER BY `EpisodeDate` ASC";

	$rsTitleListing = $db->query($sql) ;
		// Get record set as an array
		// Capturing SQL errors 
		// Capture an array of errorInfo from the $db object
		$errorInfo = $db->errorInfo();
		// If errorInfo exists, put it in a variable. The THIRD bit of info in the error array [2] is the message.
		if (isset($errorInfo[2])) {
			$error = $errorInfo[2];
		}
// Catch PHP errors
} catch (Exception $e) {
    $error = $e->getMessage();
}

// Query to count the number of rows in an array
        $q = $db->query($sql);
        $rows = $q->fetchAll();
        $rowCount = number_format(count($rows));

//$row_rsTitleListing = $rsTitleListing->fetch() ;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:spry="http://ns.adobe.com/spry">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shot Logger 2.0: Data Table</title>
<link href="twoColLiqLtHdr.css" rel="stylesheet" type="text/css" />
<?php 
// Function by frasq at frasq dot org, http://php.net/manual/en/function.readdir.php
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
// Get a random image from the $files array

?>
</head>
<body>

<!--Google Analytics-->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36880052-1']);
  _gaq.push(['_setDomainName', 'shotlogger.org']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<!-- start .header -->
<div class="container">
  <div class="header"><a href="/index.php"><img src="images_site/LogoV2.png" name="Insert_logo" width="400" height="80" border="0" align="left" id="Insert_logo" style="display:block;" /><img src="
  <?php 
  // Insert a random image 
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
  <!-- start .sidebar1 -->
  <div class="sidebar1">
    <ul class="nav">
<!--      <li><a href="/index.php">overview</a></li>-->
      <li><a href="data.php">data</a></li>
      <li><a href="images/index.php">image gallery</a></li>
      <li><a href="aboutusV2.php">about us</a></li>
      <li><a href="documentationV2.php">documentation</a></li>
      <li><a href="notesV2.php">to-do list</a></li>
      <li><a href="contactV2.php">contact</a></li>
      <li><a href="copyrightV2.php">copyright</a></li>
      <li><a href="downloadV2.php">download</a></li>
    </ul>
    <p>Formerly a service of the Telecommunication and Film Department, <a href="https://cis.ua.edu/" target="_blank">the  College of Communication and Information Sciences</a>, at <a href="https://ua.edu/" target="_blank">the University of Alabama</a>.</p>
    <p><strong>Related sites:</strong><br />
      <a href="http://laughlogger.org/" target="_blank">Laugh Logger</a><br />
      <a href="http://cinemetrics.lv/" target="_blank">CineMetrics</a><br />
      <a href="http://tvcrit.com/" target="_blank">TVCrit.com</a><br />
      <a href="http://screensite.org/" target="_blank">ScreenSite</a></p>
	<p><strong>Related Software:</strong><br />
<a href="http://www.videolan.org/vlc/" target="_blank"> VLC Media Player</a></p>
    <!-- end .sidebar1 --></div>
  <!-- start .content -->
  <div class="content">
<h1>Summary Data Table<!-- Created by Spry--></h1>
 <p>All time measurements are in seconds. &quot;MSL&quot; = &quot;median shot length&quot; and &quot;ASL&quot; = &quot;average shot length&quot;. Some TV shows are divided into several parts (to cope with commercial breaks). </p>
 <h2><em>Sorted by Episode Date.</em></h2>
 <p><strong>Click a heading to change the sorting order.</strong></p>
 <p><strong>Click an &quot;<em>SL Title</em>&quot; link to see more Shot Logger data about that program or film.</strong></p>

<!--Load data table rom Google.-->
<!--<div id="patternformat_div"></div>-->


<!--Load via Dreamweaver master-detail set.-->


<table border="1" align="center">
  <tr>
    <td valign="top"><strong><a href="data.php">IMDb Title</a></strong><br />
      (click for IMBd info)</td>
    <td valign="top"><a href="dataSortBySLTitle.php"><strong>SL Title</strong></a><br />
      (click for SL data)</td>
    <td valign="top"><a href="dataSortByEpisodeDate.php"><strong>Episode Date</strong></a></td>
    <td valign="top"><a href="dataSortByMovieDate.php"><strong>Movie Date</strong></a></td>
    <td valign="top"><a href="dataSortByASL.php"><strong>ASL</strong></a></td>
    <td valign="top"><a href="dataSortByMSL.php"><strong>MSL</strong></a></td>
  </tr>
	<?php 
	// Use a WHILE loop to iterate through the results.
	while ($row_rsTitleListing = $rsTitleListing->fetch())  {  ?>
    <tr>
      <td><a href="http://www.imdb.com/title/<?php echo $row_rsTitleListing['IMDbID']; ?>" target="_blank"><?php echo $row_rsTitleListing['ImdbTitle']; ?></a></td>
      <td><a href="TitleListDetail.php?recordID=<?php echo $row_rsTitleListing['slTitleID']; ?>"><?php echo $row_rsTitleListing['Title']; ?></a></td>
      <td><?php echo $row_rsTitleListing['EpisodeDate']; ?></td>
      <td><?php echo $row_rsTitleListing['MovieDate']; ?></td>
      <td><?php echo $row_rsTitleListing['AverageShotLength']; ?></td>
      <td><?php echo $row_rsTitleListing['MedianShotLength']; ?></td>
    </tr>
    <?php }  // END WHILE loop	?>
</table>
<br />
<?php echo $rowCount ?> Records Total
<?php 
include ('includes/footerV2.php') ;
?>
