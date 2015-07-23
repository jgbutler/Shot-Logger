<?php // require_once('../../Connections/GalleryShotLogger.php'); ?>
<?php require_once('../../Connections/ShotLogger2.php'); ?>
<?php
// Load the XML classes
require_once('../../includes/XMLExport/XMLExport.php');

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
/*
mysql_select_db($database_GalleryShotLogger, $GalleryShotLogger);
$query_rsSLTitles = "SELECT * FROM sl_Title LEFT JOIN `sl_ImdbMap` USING (IMDbID)";
$rsSLTitles = mysql_query($query_rsSLTitles, $GalleryShotLogger) or die(mysql_error());
$row_rsSLTitles = mysql_fetch_assoc($rsSLTitles);
$totalRows_rsSLTitles = mysql_num_rows($rsSLTitles);
*/

mysql_select_db($database_ShotLogger2, $ShotLogger2);
$query_rsSLTitlesV2 = "SELECT * FROM sl_Title LEFT JOIN `sl_ImdbMap` USING (IMDbID)";
$rsSLTitlesV2 = mysql_query($query_rsSLTitlesV2, $ShotLogger2) or die(mysql_error());
$row_rsSLTitlesV2 = mysql_fetch_assoc($rsSLTitlesV2);
$totalRows_rsSLTitlesV2 = mysql_num_rows($rsSLTitlesV2);

// Begin XMLExport rsSLTitles
$xmlExportObj = new XMLExport();
$xmlExportObj->setRecordset($rsSLTitlesV2);
$xmlExportObj->addColumn("slTitleID", "slTitleID");
$xmlExportObj->addColumn("Title", "Title");
$xmlExportObj->addColumn("sl_directory", "sl_directory");
$xmlExportObj->addColumn("g_parentid", "g_parentid");
$xmlExportObj->addColumn("IMDbID", "IMDbID");
$xmlExportObj->addColumn("ImdbTitle", "ImdbTitle");
$xmlExportObj->addColumn("EpisodeDate", "EpisodeDate");
$xmlExportObj->addColumn("MovieDate", "MovieDate");
$xmlExportObj->addColumn("Comments", "Comments");
$xmlExportObj->addColumn("Keywords", "Keywords");
$xmlExportObj->addColumn("Length", "Length");
$xmlExportObj->addColumn("ShotTotal", "ShotTotal");
$xmlExportObj->addColumn("AverageShotLength", "AverageShotLength");
$xmlExportObj->addColumn("MinimumSL", "MinimumSL");
$xmlExportObj->addColumn("MaximumSL", "MaximumSL");
$xmlExportObj->addColumn("Range", "Range");
$xmlExportObj->addColumn("StandardDeviation", "StandardDeviation");
$xmlExportObj->addColumn("SubmittedBy", "SubmittedBy");
$xmlExportObj->addColumn("DateSubmitted", "DateSubmitted");
$xmlExportObj->addColumn("LastModified", "LastModified");
$xmlExportObj->setMaxRecords("ALL");
$xmlExportObj->setDBEncoding("UTF-8");
$xmlExportObj->setXMLEncoding("UTF-8");
$xmlExportObj->setXMLFormat("NODES");
$xmlExportObj->Execute();
// End XMLExport rsSLTitles
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:spry="http://ns.adobe.com/spry">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="../../SpryAssets/xpath.js" type="text/javascript"></script>
<script src="../../SpryAssets/SpryData.js" type="text/javascript"></script>
<script type="text/javascript">
<!--
var ds1 = new Spry.Data.XMLDataSet("sl_Title.xml", "gallery2shotlogger/sl_Title",{sortOnLoad:"Title",sortOrderOnLoad:"ascending"});
ds1.setColumnType("slTitleID", "number");
ds1.setColumnType("g_parentid", "number");
ds1.setColumnType("EpisodeDate", "date");
ds1.setColumnType("Length", "number");
ds1.setColumnType("ShotTotal", "number");
ds1.setColumnType("AverageShotLength", "number");
ds1.setColumnType("MinimumSL", "number");
ds1.setColumnType("MaximumSL", "number");
ds1.setColumnType("Range", "number");
ds1.setColumnType("StandardDeviation", "number");
//-->
</script>
<link href="shotlogger.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div spry:region="ds1">
  <table>
    <tr>
      <th spry:sort="slTitleID">SlTitleID</th>
      <th spry:sort="Title">Title</th>
      <th spry:sort="sl_directory">sl_directory</th>
      <th spry:sort="g_parentid">G_parentid</th>
      <th spry:sort="IMDbID">IMDbID</th>
      <th spry:sort="EpisodeDate">EpisodeDate</th>
      <th spry:sort="Length">Length</th>
      <th spry:sort="ShotTotal">ShotTotal</th>
      <th spry:sort="AverageShotLength">AverageShotLength</th>
      <th spry:sort="MinimumSL">MinimumSL</th>
      <th spry:sort="MaximumSL">MaximumSL</th>
      <th spry:sort="Range">Range</th>
      <th spry:sort="StandardDeviation">StandardDeviation</th>
      <th spry:sort="DateSubmitted">DateSubmitted</th>
      <th spry:sort="LastModified">LastModified</th>
    </tr>
    <tr spry:repeat="ds1" spry:setrow="ds1" spry:odd="footer" spry:even="button" spry:hover="buttonM" spry:select="footer">
      <td>{slTitleID}</td>
      <td>{Title}</td>
      <td>{sl_directory}</td>
      <td>{g_parentid}</td>
      <td>{IMDbID}</td>
      <td>{EpisodeDate}</td>
      <td>{Length}</td>
      <td>{ShotTotal}</td>
      <td>{AverageShotLength}</td>
      <td>{MinimumSL}</td>
      <td>{MaximumSL}</td>
      <td>{Range}</td>
      <td>{StandardDeviation}</td>
      <td>{DateSubmitted}</td>
      <td>{LastModified}</td>
    </tr>
  </table>
</div>
</body>
</html>
<?php
mysql_free_result($rsSLTitles);
mysql_free_result($rsSLTitlesV2);
?>
