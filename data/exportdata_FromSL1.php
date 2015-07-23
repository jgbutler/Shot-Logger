<?php require_once('../../../Connections/GalleryShotLogger.php'); ?>
<?php
// Load the XML classes
require_once('../../../includes/XMLExport/XMLExport.php');

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

mysql_select_db($database_GalleryShotLogger, $GalleryShotLogger);
//$query_rsSLTitles = "SELECT * FROM sl_Title";
$query_rsSLTitles = "SELECT * FROM sl_Title LEFT JOIN `sl_ImdbMap` USING (IMDbID)";
$rsSLTitles = mysql_query($query_rsSLTitles, $GalleryShotLogger) or die(mysql_error());
$row_rsSLTitles = mysql_fetch_assoc($rsSLTitles);
$totalRows_rsSLTitles = mysql_num_rows($rsSLTitles);

// Begin XMLExport rsSLTitles
$xmlExportObj = new XMLExport();
$xmlExportObj->setRecordset($rsSLTitles);
$xmlExportObj->addColumn("slTitleID", "slTitleID");
$xmlExportObj->addColumn("Title", "Title");
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
$xmlExportObj->setRootNode("gallery2shotlogger");
$xmlExportObj->setRowNode("sl_Title");
$xmlExportObj->Execute();
// End XMLExport rsSLTitles

mysql_free_result($rsSLTitles);
?>
