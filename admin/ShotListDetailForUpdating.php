<?php require_once('../Connections/ShotLoggerVM.php'); ?>
<?php 
/*
    Shot Logger facilitates the analysis of visual style in film and television 
	through frame captures and editing statistics.
    Copyright (C) 2008-2013 Jeremy Butler

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
?>
<?php
$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysql_select_db($database_ShotLoggerVM, $ShotLoggerVM);
$query_DetailRS1 = sprintf("SELECT * FROM sl_ShotData  WHERE shotID = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysql_query($query_DetailRS1, $ShotLoggerVM) or die(mysql_error());
$row_DetailRS1 = mysql_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysql_num_rows($DetailRS1);

// Get EXIF data out of image file
$jpegfile = '../images/' . $row_DetailRS1['sl_directory'] . $row_DetailRS1['filename'] ;
$exif = exif_read_data($jpegfile, 0, true);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE sl_ShotData SET ShotNumber=%s, filename=%s, sl_directory=%s, g_parentid=%s, slTitleID=%s, IMDbID=%s, TimeCode=%s, ShotLength=%s, ShotScale=%s, ShotHeight=%s, ShotWidth=%s, ShotRatioToOne=%s, CameraMovement=%s, Comments=%s, Keywords=%s, SubmittedBy=%s, DateSubmitted=%s, `LastModified`=%s WHERE shotID=%s",
                       GetSQLValueString($_POST['ShotNumber'], "int"),
                       GetSQLValueString($_POST['filename'], "text"),
                       GetSQLValueString($_POST['sl_directory'], "text"),
                       GetSQLValueString($_POST['g_parentid'], "int"),
                       GetSQLValueString($_POST['slTitleID'], "int"),
                       GetSQLValueString($_POST['IMDbID'], "text"),
                       GetSQLValueString($_POST['TimeCode'], "int"),
                       GetSQLValueString($_POST['ShotLength'], "int"),
                       GetSQLValueString($_POST['ShotScale'], "int"),
                       GetSQLValueString($_POST['ShotHeight'], "int"),
                       GetSQLValueString($_POST['ShotWidth'], "int"),
                       GetSQLValueString($_POST['ShotRatioToOne'], "double"),
                       GetSQLValueString($_POST['CameraMovement'], "text"),
                       GetSQLValueString($_POST['Comments'], "text"),
                       GetSQLValueString($_POST['Keywords'], "text"),
                       GetSQLValueString($_POST['SubmittedBy'], "int"),
                       GetSQLValueString($_POST['DateSubmitted'], "int"),
                       GetSQLValueString($_POST['LastModified'], "date"),
                       GetSQLValueString($_POST['shotID'], "int"));

  mysql_select_db($database_ShotLoggerVM, $ShotLoggerVM);
  $Result1 = mysql_query($updateSQL, $ShotLoggerVM) or die(mysql_error());

// MySQL call to get the next record, after a record has been updated.

	$NextShotNumber = $_POST['ShotNumber'] + 1 ;
	$PersistentslTitleID = $_POST['slTitleID'] ;
	
	mysql_select_db($database_ShotLoggerVM, $ShotLoggerVM);
	$query_rsNextShot = "SELECT * FROM sl_ShotData WHERE slTitleID = $PersistentslTitleID AND ShotNumber = $NextShotNumber";
	$rsNextShot = mysql_query($query_rsNextShot, $ShotLoggerVM) or die(mysql_error());
	$row_rsNextShot = mysql_fetch_assoc($rsNextShot);
	$totalRows_rsNextShot = mysql_num_rows($rsNextShot);
	
	// Check to see if $NextShotNumber exists. Could be end of episode or a missing shot number in a slTitleID.
	if ($totalRows_rsNextShot == 1) {
		$NextShotNumberRecordID = $row_rsNextShot['shotID'] ;
		  $updateGoTo = "ShotListDetailForUpdating.php";
		  if (isset($_SERVER['QUERY_STRING'])) {
			/*    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
			$updateGoTo .= $_SERVER['QUERY_STRING'];
			*/
			$updateGoTo .= "?recordID=" . $NextShotNumberRecordID ;
		  }
		  header(sprintf("Location: %s", $updateGoTo));
	} else {
		  $updateGoTo = "index.php";
		  header(sprintf("Location: %s", $updateGoTo));
	}





}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shot Logger: Update <?php echo $row_DetailRS1['filename']; ?></title>
<link href="../twoColLiqLtHdr.css" rel="stylesheet" type="text/css" />
</head>
<body onLoad="document.form1.ShotNumber.focus();">

<!-- start .content -->
  <div class="content">
<h1>Shot Details for Updating</h1>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td rowspan="18" align="right" valign="top" nowrap="nowrap"><img src="../images/<?php echo $row_DetailRS1['sl_directory'] . $row_DetailRS1['filename']; ?>" <?php echo $exif['COMPUTED']['html'] ?> alt="Frame grab: <?php echo $row_DetailRS1['filename']; ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Shot Number (in ep):</strong></td>
      <td><input type="text" name="ShotNumber" value="<?php echo htmlentities($row_DetailRS1['ShotNumber'], ENT_COMPAT, 'utf-8'); ?>" size="32" /> 
<!--      <br />
      <?php echo 'QUERY_STRING = ' . $_SERVER['QUERY_STRING'] . '<br />' ;
	  echo $updateGoTo. '<br />';
	  echo $NextShotNumber . '<br />';
	  echo $PersistentslTitleID   . '<br />';
		?>
-->
    </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>ShotScale:</strong></td>
      <td>
		<label>
          <input type="radio" name="ShotScale" value="1" id="ShotScale_1" <?php if ($row_DetailRS1['ShotScale'] == '1') echo 'checked="checked"'; ?>/>
          XCU</label>
        <br />
        <label>
          <input name="ShotScale" type="radio" id="ShotScale_2" value="2" <?php if ($row_DetailRS1['ShotScale'] == '2') echo 'checked="checked"'; ?>/>
        CU</label>
        <br />
        <label>
          <input type="radio" name="ShotScale" value="3" id="ShotScale_3" <?php if ($row_DetailRS1['ShotScale'] == '3') echo 'checked="checked"'; ?>/>
        MCU</label>
        <br />
        <label>
          <input type="radio" name="ShotScale" value="4" id="ShotScale_4" <?php if ($row_DetailRS1['ShotScale'] == '4') echo 'checked="checked"'; ?>/>
        MS</label>
        <br />
        <label>
          <input type="radio" name="ShotScale" value="5" id="ShotScale_5" <?php if ($row_DetailRS1['ShotScale'] == '5') echo 'checked="checked"'; ?>/>
        MLS</label>
        <br />
        <label>
          <input type="radio" name="ShotScale" value="6" id="ShotScale_6" <?php if ($row_DetailRS1['ShotScale'] == '6') echo 'checked="checked"'; ?>/>
        LS</label>
        <br />        <label>
          <input type="radio" name="ShotScale" value="7" id="ShotScale_7" <?php if ($row_DetailRS1['ShotScale'] == '7') echo 'checked="checked"'; ?>/>
      XLS</label>
      <br />
      Current value (if any): <?php echo htmlentities($row_DetailRS1['ShotScale'], ENT_COMPAT, 'utf-8'); ?>
      </td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>ShotHeight:</strong></td>
      <td><input type="text" name="ShotHeight" value="<?php 
	  if ($row_DetailRS1['ShotHeight'] > 0) {
		echo htmlentities($row_DetailRS1['ShotHeight'], ENT_COMPAT, 'utf-8'); 
		} else {
		echo htmlentities($exif['COMPUTED']['Height'], ENT_COMPAT, 'utf-8'); 
	  }
	  ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>ShotWidth:</strong></td>
      <td><input type="text" name="ShotWidth" value="<?php 
	  if ($row_DetailRS1['ShotWidth'] > 0) {
		echo htmlentities($row_DetailRS1['ShotWidth'], ENT_COMPAT, 'utf-8'); 
		} else {
		echo htmlentities($exif['COMPUTED']['Width'], ENT_COMPAT, 'utf-8'); 
	  }
	  ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>ShotRatioToOne:</strong></td>
      <td><input type="text" name="ShotRatioToOne" value="<?php 
	  if ($row_DetailRS1['ShotRatioToOne'] > 0) {
		echo htmlentities($row_DetailRS1['ShotRatioToOne'], ENT_COMPAT, 'utf-8'); 
		} else {
		echo round($exif['COMPUTED']['Width']/$exif['COMPUTED']['Height'], 2); 
	  }
	 ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>CameraMovement:</strong></td>
      <td><input type="text" name="CameraMovement" value="<?php echo htmlentities($row_DetailRS1['CameraMovement'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Comments:</strong></td>
      <td><input type="text" name="Comments" value="<?php echo htmlentities($row_DetailRS1['Comments'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Keywords:</strong></td>
      <td><input type="text" name="Keywords" value="<?php echo htmlentities($row_DetailRS1['Keywords'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Filename:</strong></td>
      <td><input type="text" name="filename" value="<?php echo htmlentities($row_DetailRS1['filename'], ENT_COMPAT, 'utf-8'); ?>" size="80" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Sl_directory:</strong></td>
      <td><input type="text" name="sl_directory" value="<?php echo htmlentities($row_DetailRS1['sl_directory'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>SlTitleID:</strong></td>
      <td><input type="text" name="slTitleID" value="<?php echo htmlentities($row_DetailRS1['slTitleID'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>IMDbID:</strong></td>
      <td><input type="text" name="IMDbID" value="<?php echo htmlentities($row_DetailRS1['IMDbID'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>TimeCode:</strong></td>
      <td><input type="text" name="TimeCode" value="<?php echo htmlentities($row_DetailRS1['TimeCode'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
        secs.</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>ShotLength:</strong></td>
      <td><input type="text" name="ShotLength" value="<?php echo htmlentities($row_DetailRS1['ShotLength'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
        secs.</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Date Submitted<br />
      or Created:</strong></td>
      <td><?php // Uses Unix format timestamp, converted to human-readable with strftime
	if ($row_DetailRS1['DateSubmitted']) {
		if ($row_DetailRS1['DateSubmitted'] != '0000-00-00 00:00:00') {
			echo strftime ("%c", $row_DetailRS1['DateSubmitted']); 
		} 
	} else {
		echo strftime ("%F %X", $exif['FILE']['FileDateTime']);		
	}
	?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>LastModified:</strong></td>
      <td><?php // Uses MySQL format timestamp
	if ($row_DetailRS1['LastModified'] != '0000-00-00 00:00:00') {
	  echo htmlentities($row_DetailRS1['LastModified'], ENT_COMPAT, 'utf-8');  
	} 
    ?></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="shotID" value="<?php echo $row_DetailRS1['shotID']; ?>" />
  <input type="hidden" name="LastModified" value="<?php // Uses MySQL format timestamp
	  $CurrentTime = date("Y-m-d H:i:s"); 
	  echo $CurrentTime ;
  ?>" />
  <input type="hidden" name="DateSubmitted" value="<?php // Uses Unix format timestamp
		if ($row_DetailRS1['DateSubmitted'] > 0) {
			echo $row_DetailRS1['DateSubmitted']; 
		} else { // Read from file-creation data
			$FileCreationDate = $exif['FILE']['FileDateTime']; 
			echo $FileCreationDate ;
		}
  ?>" />
</form>
<?php 
include ('../includes/footerV2.php') ;
mysql_free_result($DetailRS1);
mysql_free_result($rsNextShot);
?>
