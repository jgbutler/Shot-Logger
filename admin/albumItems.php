<?php require_once('../Connections/ShotLoggerVM.php'); ?>
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

// Connect to sl_Title2 database table and figure out the highest slTitleID.

mysql_select_db($database_ShotLoggerVM, $ShotLoggerVM);
$query_rsSlTitle = "SELECT slTitleID, MAX(slTitleID) FROM sl_Title2";
//$query_rsNewStats = "SELECT * FROM sl_Title2";
$rsSlTitle = mysql_query($query_rsSlTitle, $ShotLoggerVM) or die(mysql_error());
$row_rsSlTitle = mysql_fetch_assoc($rsSlTitle);
$totalRows_rsSlTitle = mysql_num_rows($rsSlTitle);

// Set Shot Logger variables based on POST data & MySQL query
// Separate directory prefix from specific directory to shorten $slDir
// $slDir = '/srv/www/shotlogger/images/'. $_POST['slDir'] ;
$slDir = $_POST['slDir'] ;
$slDirPrefix = '/srv/www/shotlogger/images/' ;
$slTitleID =  $row_rsSlTitle['MAX(slTitleID)'] + 1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shot Logger 2:  Item Data</title>
<link href="admin.css" rel="stylesheet" type="text/css" />
</head>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<body>
<h1 align="center">Item Data <br />
  Directory: <em><?php echo $slDir ; ?></em> </h1>

<?php
// Get file names by using the PHP scandir function
// http://php.net/manual/en/function.scandir.php

// Set scandir's $dir variable based on prefix and POST data
$dir = $slDirPrefix . $slDir ;
$files = scandir($dir);
// Display array of file names, for testing.
// echo '<pre>' ;
// print_r($files);
// echo '</pre>' ;
?>


<a name="dataform" id="dataform"></a>
<form id="InsertData" name="InsertData" method="post" action="InsertShotData.php">
  <input type="hidden" name="slDir" id="slDir" value="<?php echo $slDir; ?>" />
  <input type="hidden" name="slTitleID" id="slTitleID" value="<?php echo $slTitleID; ?>" />
  <table align="center">
    <thead>
    <tr valign="baseline">
      <th colspan="2" align="right" valign="top" nowrap="nowrap"><div align="center">Shot Logger Title Data: Shot Logger ID #<?php echo $slTitleID; ?><br />
        <?php echo $slDir; ?>
      </div></td>
    </tr>
    </thead>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><em>Television Program</em> Title:</td>
      <td valign="top"><p>
        <input name="TV_program" type="text" id="TV_program" size="32" maxlength="128" />
        <br />
        As standardized by the IMDb.<br />
        Place articles at end. E.g.,<br />
        <em>Adventures of Ozzie &amp; Harriet, The</em></p>
      <p>Link to View previous programs? Drop down list?</p></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><em>Television Episode</em> Title</td>
      <td valign="top"><p>
        <input name="TV_episode" type="text" id="TV_episode" size="32" maxlength="128" />
        <br />
      No quotation marks, please.<br />
      If no title, then use episode date in YYYYMMDD format. E.g., 20070831.<br />
      If a multipart episode, append part number to episode date. E.g., 2007083101 for the first part.</p>      </td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><em>Theatrical Film</em> Title:</td>
      <td valign="top"><p>
        <input name="Film_title" type="text" id="Film_title" value="" size="32" maxlength="128" />
        <br />
      As standardized by the IMDb.<br />
Use film's original language title. E.g.,<br />
      <em>Vivre sa vie: Film en douze tableaux</em></p>
      <p>Link to view previous films?</p></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><a href="http://www.imdb.com/search" target="_blank">IMDb ID</a>:</td>
      <td valign="top"><span id="sprytextfield1">
      <input name="IMDbID" type="text" value="" size="10" maxlength="10" />
      <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Is that a proper IMDb ID number?</span></span><br />
      Two letters, then seven numbers.</td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap">Episode Date:</td>
      <td valign="top"><p><span id="sprytextfield2">
      <input type="text" name="EpisodeDate" value="" size="32" />
      <span class="textfieldInvalidFormatMsg">Please check the format of the date.</span></span><br />
        Date episode was first broadcast, if known. If only year is known, set month and day to 01.<br />
        Format: YYYY-MM-DD. E.g.,<br />
      1957-10-04</p>      </td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap">Movie Date:</td>
      <td valign="top"><p><span id="sprytextfield3">
      <input type="text" name="MovieDate" value="" size="32" />
      <span class="textfieldInvalidFormatMsg">Please use year of release only.</span></span><br />
      Year released.</p>      </td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap">&nbsp;</td>
      <td valign="top"><input type="submit" name="submit" id="submit"  class="buttonM" value="Insert Data Now" /></td>
    </tr>
  </table>
</form>
</p>
<?php 
include ('../includes/footerV2.php'); // Include the footer
?>
<?php

// Given a string TimeCode, return the number of seconds
// Assume hours:minutes:seconds format

// Why is this here??? Commented out on 7/9/12.
/*
function getSeconds($strTimeCode)
{
	$arr = explode(":", $strTimeCode);
	$seconds = $arr[0]*3600 + $arr[1]*60 + $arr[2];
	return $seconds;	
}

*/

?>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "custom", {pattern:"aa0000000", useCharacterMasking:true});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "date", {format:"yyyy-mm-dd", isRequired:false, validateOn:["blur"], hint:"YYYY-MM-DD", useCharacterMasking:true});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "custom", {pattern:"0000", validateOn:["blur"], useCharacterMasking:true, isRequired:false});
//-->
</script>
<?php
mysql_free_result($rsSlTitle);
?>