<?php require_once('../../Connections/ShotLogger2.php'); ?><?php
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
mysql_select_db($database_ShotLogger2, $ShotLogger2);
$query_DetailRS1 = sprintf("SELECT * FROM sl_Title WHERE slTitleID = %s ORDER BY Title ASC", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysql_query($query_DetailRS1, $ShotLogger2) or die(mysql_error());
$row_DetailRS1 = mysql_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysql_num_rows($DetailRS1);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shot Logger Title Detail</title>
</head>

<body>

<table border="1" align="center">
  <tr>
    <td>slTitleID</td>
    <td><?php echo $row_DetailRS1['slTitleID']; ?></td>
  </tr>
  <tr>
    <td>Title</td>
    <td><?php echo $row_DetailRS1['Title']; ?></td>
  </tr>
  <tr>
    <td>g_parentid</td>
    <td><?php echo $row_DetailRS1['g_parentid']; ?></td>
  </tr>
  <tr>
    <td>IMDbID</td>
    <td><?php echo $row_DetailRS1['IMDbID']; ?></td>
  </tr>
  <tr>
    <td>EpisodeDate</td>
    <td><?php echo $row_DetailRS1['EpisodeDate']; ?></td>
  </tr>
  <tr>
    <td>MovieDate</td>
    <td><?php echo $row_DetailRS1['MovieDate']; ?></td>
  </tr>
  <tr>
    <td>Comments</td>
    <td><?php echo $row_DetailRS1['Comments']; ?></td>
  </tr>
  <tr>
    <td>Keywords</td>
    <td><?php echo $row_DetailRS1['Keywords']; ?></td>
  </tr>
  <tr>
    <td>Length</td>
    <td><?php echo $row_DetailRS1['Length']; ?></td>
  </tr>
  <tr>
    <td>ShotTotal</td>
    <td><?php echo $row_DetailRS1['ShotTotal']; ?></td>
  </tr>
  <tr>
    <td>AverageShotLength</td>
    <td><?php echo $row_DetailRS1['AverageShotLength']; ?></td>
  </tr>
  <tr>
    <td>MinimumSL</td>
    <td><?php echo $row_DetailRS1['MinimumSL']; ?></td>
  </tr>
  <tr>
    <td>MaximumSL</td>
    <td><?php echo $row_DetailRS1['MaximumSL']; ?></td>
  </tr>
  <tr>
    <td>Range</td>
    <td><?php echo $row_DetailRS1['Range']; ?></td>
  </tr>
  <tr>
    <td>StandardDeviation</td>
    <td><?php echo $row_DetailRS1['StandardDeviation']; ?></td>
  </tr>
  <tr>
    <td>SubmittedBy</td>
    <td><?php echo $row_DetailRS1['SubmittedBy']; ?></td>
  </tr>
  <tr>
    <td>DateSubmitted</td>
    <td><?php echo $row_DetailRS1['DateSubmitted']; ?></td>
  </tr>
  <tr>
    <td>LastModified</td>
    <td><?php echo $row_DetailRS1['LastModified']; ?></td>
  </tr>
</table>
</body>
</html><?php
mysql_free_result($DetailRS1);
?>