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
$query_rsNewStats = "SELECT * FROM sl_Title2";
$rsNewStats = mysql_query($query_rsNewStats, $ShotLoggerVM) or die(mysql_error());
$row_rsNewStats = mysql_fetch_assoc($rsNewStats);
$totalRows_rsNewStats = mysql_num_rows($rsNewStats);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shot Logger 2.0: Title List</title>
<link href="admin.css" rel="stylesheet" type="text/css" />

</head>

<body>
<h1>Title List</h1>
<p><?php echo $totalRows_rsNewStats ?> total titles.</p>
<table border="1" align="center" class="datatable">

  <tr>
    <td>slTitleID</td>
    <td>Title</td>
    <td>sl_directory</td>
    <td>IMDbID</td>
    <td>EpisodeDate</td>
    <td>MovieDate</td>
    <td>Comments</td>
    <td>Keywords</td>
    <td>Length</td>
    <td>ShotTotal</td>
    <td>AverageShotLength</td>
    <td>MedianShotLength</td>
    <td>MSL/ASL</td>
    <td>Mode</td>
    <td>MinimumSL</td>
    <td>MaximumSL</td>
    <td>Range</td>
    <td>StandardDeviation</td>
    <td>CV</td>
    <td>Skewness</td>
    <td>Kurtosis</td>
    <td>Q1</td>
    <td>Q3</td>
    <td>IQR</td>
    <td>Variance</td>
    <td>DateSubmittedV2</td>
    <td>LastModified</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="../TitleListDetail.php?recordID=<?php echo $row_rsNewStats['slTitleID']; ?>"> <?php echo $row_rsNewStats['slTitleID']; ?></a></td>
      <td><?php echo $row_rsNewStats['Title']; ?>&nbsp; </td>
      <td><?php echo $row_rsNewStats['sl_directory']; ?>&nbsp; </td>
      <td><?php echo $row_rsNewStats['IMDbID']; ?>&nbsp; </td>
      <td><?php echo $row_rsNewStats['EpisodeDate']; ?>&nbsp; </td>
      <td><?php echo $row_rsNewStats['MovieDate']; ?>&nbsp; </td>
      <td><?php echo $row_rsNewStats['Comments']; ?>&nbsp; </td>
      <td><?php echo $row_rsNewStats['Keywords']; ?>&nbsp; </td>
      <td><?php echo $row_rsNewStats['Length']; ?>&nbsp; </td>
      <td><?php echo $row_rsNewStats['ShotTotal']; ?>&nbsp; </td>
      <td><?php echo $row_rsNewStats['AverageShotLength']; ?>&nbsp; </td>
      <td><?php echo $row_rsNewStats['MedianShotLength']; ?>&nbsp; </td>
      <td><?php echo $row_rsNewStats['MSL_ASL']; ?>&nbsp; </td>
      <td><?php echo $row_rsNewStats['Mode']; ?>&nbsp; </td>
      <td><?php echo $row_rsNewStats['MinimumSL']; ?>&nbsp; </td>
      <td><?php echo $row_rsNewStats['MaximumSL']; ?>&nbsp; </td>
      <td><?php echo $row_rsNewStats['Range']; ?>&nbsp; </td>
      <td><?php echo $row_rsNewStats['StandardDeviation']; ?>&nbsp; </td>
      <td><?php echo $row_rsNewStats['CV']; ?>&nbsp; </td>
      <td><?php echo $row_rsNewStats['Skewness']; ?>&nbsp; </td>
      <td><?php echo $row_rsNewStats['Kurtosis']; ?>&nbsp; </td>
      <td><?php echo $row_rsNewStats['Q1']; ?>&nbsp; </td>
      <td><?php echo $row_rsNewStats['Q3']; ?>&nbsp; </td>
      <td><?php echo $row_rsNewStats['IQR']; ?>&nbsp; </td>
      <td><?php echo $row_rsNewStats['Variance']; ?>&nbsp; </td>
      <td><?php echo $row_rsNewStats['DateSubmittedV2']; ?>&nbsp; </td>
      <td><?php echo $row_rsNewStats['LastModified']; ?>&nbsp; </td>
    </tr>
    <?php } while ($row_rsNewStats = mysql_fetch_assoc($rsNewStats)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($rsNewStats);
?>
