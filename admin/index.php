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

// include configuration data for MySQL and Shot Logger login.

require_once('../Connections/ShotLoggerVM.php'); 

// Check to see if user is logged in.

if (isset($_COOKIE['PrivatePageLogin'])) {
   if ($_COOKIE['PrivatePageLogin'] == md5($password.$nonsense)) {

// Insert content below.

?>

<!-- BEGIN PASSWORD-PROTECTED CONTENT HERE -->

<?php // require_once('../Connections/ShotLoggerVM.php'); ?>
<?php
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

mysql_select_db($database_ShotLoggerVM, $ShotLoggerVM);
$query_rsSLTitle = "SELECT * FROM sl_Title2 ORDER BY slTitleID DESC";
$rsSLTitle = mysql_query($query_rsSLTitle, $ShotLoggerVM) or die(mysql_error());
$row_rsSLTitle = mysql_fetch_assoc($rsSLTitle);
$totalRows_rsSLTitle = mysql_num_rows($rsSLTitle);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Shot Logger 2.1: Administration</title>
<link href="admin.css" rel="stylesheet" type="text/css" />
</head>

<body>

<?php 
// Include function to convert BBCode to regular HTML
// Includes CSS for converting BBCode to CSS
// include_once("../../slgallery/shotlogger/includes/BBCodeToHTML.php");
?>

<h1 align="center">Shot Logger 2.1: Administration </h1>
<table border="1" align="center">
  <tr>
    <td valign="top"><strong>Stats</strong></td>
  </tr>
  <tr>
    <td valign="top"><ul>
      <li><a href="../images/indexAdminPW.php">View listing of uploaded files</a>, for importing data. After uploading a batch of files, <strong>be sure to update XML and downloadable files</strong>.</li>
      <li><a href="../index.php">Go to Shot Logger Home</a></li>
      <li><strong>Update Data</strong>
        <ul>
          <li><a href="datadownloadPW.php">Update downloadable files!</a></li>
          <li><a href="SLStatsPW.php" target="_blank">Calculate cumulative stats!</a></li>
          <li><em><strong>Manually</strong></em><strong> update the MySQL dump of the entire database (tcf-shotlogger.sql.gz)</strong></li>
          </ul>
        </li>
    </ul></td>
  </tr>
</table>
<table border="1" class="small" align="center">
  <thead>
  <tr>
    <th width="50%" valign="top" nowrap="nowrap" scope="col">Shot Logger Titles -- Reverse Order<br />
      (<a href="TitleList.php">detailed title list</a>)</th>
    <th width="50%" valign="top" nowrap="nowrap" scope="col">Uploaded Image Directories<br />
      (<a href="../images/indexAdminPW.php">details</a>)</th>
  </tr>
  </thead>
  <tr>
    <td width="50%" valign="top"><ul>
      <?php do { 
	  		$ID = $row_rsSLTitle['IMDbID'];
			mysql_select_db($database_ShotLoggerVM, $ShotLoggerVM);
			$query_rsIMDbTitle = "SELECT * FROM sl_ImdbMap WHERE IMDbID = '$ID' ";
			$rsIMDbTitle = mysql_query($query_rsIMDbTitle, $ShotLoggerVM) or die(mysql_error());
			$row_rsIMDbTitle = mysql_fetch_assoc($rsIMDbTitle);
	  ?>
      <li><a href="shotListPW.php?slTitleID=<?php echo $row_rsSLTitle['slTitleID']; ?>"><?php echo $row_rsSLTitle['slTitleID']; ?></a>: <?php if ($row_rsSLTitle['EpisodeDate']) { // Show if recordset not empty ?> <em><?php echo $row_rsIMDbTitle['ImdbTitle'] ?></em>: <?php } // Show if recordset not empty ?><?php echo $row_rsSLTitle['Title']; ?>
  </li>
      <?php } while ($row_rsSLTitle = mysql_fetch_assoc($rsSLTitle)); ?></ul></td>
    <td width="50%" valign="top">
	<ul>
<?php     
//	echo '<pre>';
	$dir =  '../images' ;
	while($dirs = glob($dir . '/*', GLOB_ONLYDIR)) {
		$dir .= '/*';
		if(!$d) {
			$d=$dirs;
		} else {
			$d=array_merge($d,$dirs);
		}
	}
//	print_r($d);
	natcasesort($d);
	foreach($d as $file)  
	{  
//		echo "$file : filetype: " . filetype($file) . "<br />";  
		echo "<li><strong>$file</strong> - " . date ("F d Y", filemtime($file)) . "</li>";
	} 

//	echo '</pre>';
?>    
	</ul>
    </td>
  </tr>
</table>
<?php 
include ('../includes/footerV2.php'); // Include the footer
?>
<?php
mysql_free_result($rsIMDbTitle);
mysql_free_result($rsSLTitle);
mysql_free_result($rsAlbums);
mysql_free_result($rsAlbumOfAlbums);
?>

<!-- END PASSWORD-PROTECTED CONTENT HERE -->

<?php

// Resume checking to see if user is logged in.

   exit;
   } else {
      echo "Bad cookie.";
      exit;
   }
}

if (isset($_GET['p']) && $_GET['p'] == "login") {
	echo "<!doctype html>
		<html>
		<head>
		<meta charset=\"utf-8\">
		<link href=\"../shotloggerV2_datatable.css\" rel=\"stylesheet\" type=\"text/css\" />
		<title>Shot Logger: Login Problem</title>
		<h1>Shot Logger: Login Problem</h1>";
   if ($_POST['user'] != $username) {
      echo "<strong>Sorry. I don't recognize that username.</strong><br />
		<h2>Return to the previous page to try again.</h2>";
      exit;
   } else if ($_POST['keypass'] != $password) {
      echo "<strong>Sorry. Invalid password.</strong>
		<h2>Return to the previous page to try again.</h2>";
      exit;
   } else if ($_POST['user'] == $username && $_POST['keypass'] == $password) {
      setcookie('PrivatePageLogin', md5($_POST['keypass'].$nonsense));
      header("Location: $_SERVER[PHP_SELF]");
   } else {
      echo "<strong>Sorry. You could not be logged in at this time.</strong>";
   }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Shot Logger 2.1: Login</title>
<link href="admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>Shot Logger: Administrator Login</h1>

<!-- Begin password form -->

<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=login" method="post">
<label><strong>Username:</strong> <br />
<input type="text" name="user" id="user" /></label><br />
<label><strong>Password:</strong> <br />
<input type="password" name="keypass" id="keypass" /></label>
<p><input type="submit" id="submit" value="Login" /></p>
</form>

<!-- End password form -->

<?php 
include ('../includes/footerV2.php'); // Include the footer
?>
