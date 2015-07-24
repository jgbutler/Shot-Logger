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

mysql_select_db($database_ShotLogger2, $ShotLogger2);
$query_rsTitleList = "SELECT * FROM sl_Title";
$rsTitleList = mysql_query($query_rsTitleList, $ShotLogger2) or die(mysql_error());
$row_rsTitleList = mysql_fetch_assoc($rsTitleList);
$totalRows_rsTitleList = mysql_num_rows($rsTitleList);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table border="1" align="center">
  <tr>
    <td>slTitleID</td>
    <td>Title</td>
    <td>sl_directory</td>
    <td>g_parentid</td>
    <td>IMDbID</td>
    <td>EpisodeDate</td>
    <td>MovieDate</td>
    <td>Comments</td>
    <td>Keywords</td>
    <td>Length</td>
    <td>ShotTotal</td>
    <td>AverageShotLength</td>
    <td>MinimumSL</td>
    <td>MaximumSL</td>
    <td>Range</td>
    <td>StandardDeviation</td>
    <td>DateSubmittedV2</td>
    <td>SubmittedBy</td>
    <td>DateSubmitted</td>
    <td>LastModified</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="TitleListDetailV2.php?recordID=<?php echo $row_rsTitleList['slTitleID']; ?>"> <?php echo $row_rsTitleList['slTitleID']; ?>&nbsp; </a></td>
      <td><?php echo $row_rsTitleList['Title']; ?>&nbsp; </td>
      <td><?php echo $row_rsTitleList['sl_directory']; ?>&nbsp; </td>
      <td><?php echo $row_rsTitleList['g_parentid']; ?>&nbsp; </td>
      <td><?php echo $row_rsTitleList['IMDbID']; ?>&nbsp; </td>
      <td><?php echo $row_rsTitleList['EpisodeDate']; ?>&nbsp; </td>
      <td><?php echo $row_rsTitleList['MovieDate']; ?>&nbsp; </td>
      <td><?php echo $row_rsTitleList['Comments']; ?>&nbsp; </td>
      <td><?php echo $row_rsTitleList['Keywords']; ?>&nbsp; </td>
      <td><?php echo $row_rsTitleList['Length']; ?>&nbsp; </td>
      <td><?php echo $row_rsTitleList['ShotTotal']; ?>&nbsp; </td>
      <td><?php echo $row_rsTitleList['AverageShotLength']; ?>&nbsp; </td>
      <td><?php echo $row_rsTitleList['MinimumSL']; ?>&nbsp; </td>
      <td><?php echo $row_rsTitleList['MaximumSL']; ?>&nbsp; </td>
      <td><?php echo $row_rsTitleList['Range']; ?>&nbsp; </td>
      <td><?php echo $row_rsTitleList['StandardDeviation']; ?>&nbsp; </td>
      <td><?php echo $row_rsTitleList['DateSubmittedV2']; ?>&nbsp; </td>
      <td><?php echo $row_rsTitleList['SubmittedBy']; ?>&nbsp; </td>
      <td><?php echo $row_rsTitleList['DateSubmitted']; ?>&nbsp; </td>
      <td><?php echo $row_rsTitleList['LastModified']; ?>&nbsp; </td>
    </tr>
    <?php } while ($row_rsTitleList = mysql_fetch_assoc($rsTitleList)); ?>
</table>
<br />
<?php echo $totalRows_rsTitleList ?> Records Total
</body>
</html>
<?php
mysql_free_result($rsTitleList);
?>
