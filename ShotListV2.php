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

require_once('../Connections/ShotLogger2.php'); 

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

$colname_rsShotList = "-1";
if (isset($_GET['recordID'])) {
  $colname_rsShotList = $_GET['recordID'];
}

mysql_select_db($database_ShotLogger2, $ShotLogger2);
$query_rsShotList = sprintf("SELECT * FROM sl_ShotData WHERE slTitleID = %s ORDER BY TimeCode ASC", GetSQLValueString($colname_rsShotList, "int"));
$rsShotList = mysql_query($query_rsShotList, $ShotLogger2) or die(mysql_error());
$row_rsShotList = mysql_fetch_assoc($rsShotList);
$totalRows_rsShotList = mysql_num_rows($rsShotList);

$colname_rsSLTitle = "-1";
if (isset($_GET['recordID'])) {
  $colname_rsSLTitle = $_GET['recordID'];
}
mysql_select_db($database_ShotLogger2, $ShotLogger2);
$query_rsSLTitle = sprintf("SELECT Title FROM sl_Title2 WHERE slTitleID = %s", GetSQLValueString($colname_rsSLTitle, "int"));
$rsSLTitle = mysql_query($query_rsSLTitle, $ShotLogger2) or die(mysql_error());
$row_rsSLTitle = mysql_fetch_assoc($rsSLTitle);
$totalRows_rsSLTitle = mysql_num_rows($rsSLTitle);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shot Logger 2.0: <?php echo $row_rsSLTitle['Title']; ?></title>
<link href="twoColLiqLtHdr.css" rel="stylesheet" type="text/css" />

</head>
<body>

<!-- start .header -->
<div class="container">
  <div class="header"><a href="/index.php"><img src="images_site/LogoV2.png" name="Insert_logo" width="400" height="80" border="0" align="left" id="Insert_logo" style="display:block;" /></a> 
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
    <p>A service of the Telecommunication and Film Department, the University of Alabama.</p>
<p><strong>Related sites:</strong><br />
<a href="http://www.cinemetrics.lv/" target="_blank">CineMetrics<br />
</a><a href="http://www.tvcrit.com/" target="_blank">TVCrit.com<br />
</a><a href="http://www.screensite.org/" target="_blank">ScreenSite</a>
      </p>
	<p><strong>Related Software:</strong><br />
<a href="http://www.videolan.org/vlc/" target="_blank"> VLC Media Player</a><br />
<a href="http://gallery.menalto.com/" target="_blank">Gallery 2</a></p>
    <!-- end .sidebar1 --></div>
  <!-- start .content -->
  <div class="content">
<h2>Shot List for <em><?php echo $row_rsSLTitle['Title']; ?></em> </h2>
<p><?php echo $totalRows_rsShotList ?> shots total.</p>
<table width="600" border="1" align="center">
  <tr>
    <td><strong>Shot #</strong></td>
    <td><strong>Time Code</strong></td>
<!--    <td>shotID</td>-->
    <td><strong>Click to view details</strong></td>
<!--    <td><strong>sl_directory</strong></td>-->
<!--    <td>slTitleID</td>-->
    <td><strong>Shot Length</strong></td>
    <td><strong>Shot Scale</strong></td>
    <td><strong>Camera Movement</strong></td>
    <td><strong>Comments</strong></td>
  </tr>
  <?php // Loop through all the shots.
  $ShotNumber = 1 ;
  do { ?>
    <tr>
		<td align="center"><?php 
		if  ($row_rsShotList['ShotNumber']) {
			echo $row_rsShotList['ShotNumber'] ;
		}
		else {
			echo $ShotNumber ; 

			// UPDATE SHOT NUMBER IN DATABASE
			$updateSQL = sprintf("UPDATE sl_ShotData SET ShotNumber=%s WHERE shotID=%s",
							   GetSQLValueString($ShotNumber, "int"),
							   GetSQLValueString($row_rsShotList['shotID'], "int"));
			
			mysql_select_db($database_ShotLogger2, $ShotLogger2);
			$Result2 = mysql_query($updateSQL, $ShotLogger2) or die(mysql_error());

			// Increment shot number
			$ShotNumber = $ShotNumber + 1 ;
		}
		?></td>
      <td><b><?php echo gmdate("H:i:s", $row_rsShotList['TimeCode']) . '</b><br>' ;
	  echo '(' . $row_rsShotList['TimeCode']; ?> seconds)</td>
<!--      <td><?php echo $row_rsShotList['shotID']; ?>&nbsp; </td>-->
      <td><a href="ShotListDetailV2.php?recordID=<?php echo $row_rsShotList['shotID']; ?>">
        <img src="images/<?php echo $row_rsShotList['sl_directory'] . $row_rsShotList['filename']; ?>" alt="Frame grab: <?php echo $row_rsShotList['filename']; ?>" height="150" border="0" /> </a>
      </td>
<!--      <td><?php echo $row_rsShotList['sl_directory']; ?></td>-->
<!--      <td><?php echo $row_rsShotList['slTitleID']; ?></td>-->
      <td><?php echo $row_rsShotList['ShotLength']; ?> secs.</td>
      <td><?php echo $row_rsShotList['ShotScale']; ?></td>
      <td><?php echo $row_rsShotList['CameraMovement']; ?></td>
      <td><?php echo $row_rsShotList['Comments']; ?></td>
    </tr>
    <?php } while ($row_rsShotList = mysql_fetch_assoc($rsShotList)); ?>
</table>
<?php 
include ('includes/footerV2.php') ;
?>
<?php
mysql_free_result($rsShotList);

mysql_free_result($rsSLTitle);
?>
