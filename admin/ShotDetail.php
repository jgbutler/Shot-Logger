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

require_once('../../Connections/ShotLogger2.php'); 

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

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
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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
mysql_select_db($database_ShotLogger2, $ShotLogger2);
$query_DetailRS1 = sprintf("SELECT * FROM sl_ShotData  WHERE shotID = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysql_query($query_DetailRS1, $ShotLogger2) or die(mysql_error());
$row_DetailRS1 = mysql_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysql_num_rows($DetailRS1);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shot Logger 2: Shot Details</title>
<!--<link href="../../slgallery/shotlogger/shotlogger.css" rel="stylesheet" type="text/css" />-->
<link href="admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1 align="center">Shot Details</h1>
<table border="1" align="center">
  <tr>
    <td colspan="2"><img src="../images/<?php echo $row_DetailRS1['sl_directory']; ?><?php echo $row_DetailRS1['filename']; ?>" alt="Frame Capture" />
    </td>
  </tr>
  <tr>
    <td>Shot Logger shotID</td>
    <td><?php echo $row_DetailRS1['shotID']; ?> </td>
  </tr>
  <tr>
    <td>ShotNumber</td>
    <td><?php echo $row_DetailRS1['ShotNumber']; ?> </td>
  </tr>
  <tr>
    <td>g_id</td>
    <td><?php echo $row_DetailRS1['g_id']; ?> </td>
  </tr>
  <tr>
    <td>filename</td>
    <td><?php echo $row_DetailRS1['filename']; ?> </td>
  </tr>
  <tr>
    <td>sl_directory</td>
    <td><?php echo $row_DetailRS1['sl_directory']; ?> </td>
  </tr>
  <tr>
    <td>g_idOfThumbnail</td>
    <td><?php echo $row_DetailRS1['g_idOfThumbnail']; ?> </td>
  </tr>
  <tr>
    <td>g_parentid</td>
    <td><?php echo $row_DetailRS1['g_parentid']; ?> </td>
  </tr>
  <tr>
    <td>slTitleID</td>
    <td><?php echo $row_DetailRS1['slTitleID']; ?> </td>
  </tr>
  <tr>
    <td>IMDbID</td>
    <td><?php echo $row_DetailRS1['IMDbID']; ?> </td>
  </tr>
  <tr>
    <td>TimeCode</td>
    <td><?php echo $row_DetailRS1['TimeCode']; ?> </td>
  </tr>
  <tr>
    <td>ShotLength</td>
    <td><?php echo $row_DetailRS1['ShotLength']; ?> </td>
  </tr>
  <tr>
    <td>ShotScale</td>
    <td><?php echo $row_DetailRS1['ShotScale']; ?> </td>
  </tr>
  <tr>
    <td>CameraMovement</td>
    <td><?php echo $row_DetailRS1['CameraMovement']; ?> </td>
  </tr>
  <tr>
    <td>Comments</td>
    <td><?php echo $row_DetailRS1['Comments']; ?> </td>
  </tr>
  <tr>
    <td>Keywords</td>
    <td><?php echo $row_DetailRS1['Keywords']; ?> </td>
  </tr>
  <tr>
    <td>SubmittedBy</td>
    <td><?php echo $row_DetailRS1['SubmittedBy']; ?> </td>
  </tr>
  <tr>
    <td>DateSubmitted</td>
    <td><?php echo $row_DetailRS1['DateSubmitted']; ?> </td>
  </tr>
  <tr>
    <td>LastModified</td>
    <td><?php echo $row_DetailRS1['LastModified']; ?> </td>
  </tr>
</table>

<?php 
include ('../includes/footerV2.php'); // Include the footer
?>
<?php
mysql_free_result($DetailRS1);
?>
