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

// Gather SL Title data for processing

mysql_select_db($database_ShotLoggerVM, $ShotLoggerVM);
$query_rsSLTitles = "SELECT * FROM sl_Title2 LEFT JOIN `sl_ImdbMap` USING (IMDbID) ORDER BY ImdbTitle ASC";
$rsSLTitles = mysql_query($query_rsSLTitles, $ShotLoggerVM) or die(mysql_error());
$row_rsSLTitles = mysql_fetch_assoc($rsSLTitles);
$totalRows_rsSLTitles = mysql_num_rows($rsSLTitles);

// Start preparing the text to be written in $out
$out .= "TITLE_ID_NUMBER\tTITLE\tIMDB_TITLE\tEPISODE_DATE\tMOVIE_DATE\tLENGTH\tSHOTS_TOTAL\tASL\tMAXIMUM_SL\tSTANDARD_DEVIATION\tCOMMENTS\tDATE_SUBMITTED";
$out .= "\n";

do { // Loop through the data to generate output

	// If missing a DateSubmitted, substitute LastModified
	if ($row_rsSLTitles['DateSubmitted']) {
		$Datesubmitted = date('d F Y', $row_rsSLTitles['DateSubmitted']) ;
	} else {
		$Datesubmitted = date('d F Y', $row_rsSLTitles['LastModified']) ;
	}
	// Continue generating output
	$out .= $row_rsSLTitles['slTitleID'];
	$out .= "\t";
	$out .= $row_rsSLTitles['Title'];
	$out .= "\t";
	$out .= $row_rsSLTitles['ImdbTitle'];
	$out .= "\t";
	$out .= $row_rsSLTitles['EpisodeDate'];
	$out .= "\t";
	$out .= $row_rsSLTitles['MovieDate'];
	$out .= "\t";
	$out .= $row_rsSLTitles['Length'];
	$out .= "\t";
	$out .= $row_rsSLTitles['ShotTotal'];
	$out .= "\t";
	$out .= $row_rsSLTitles['AverageShotLength'];
	$out .= "\t";
	$out .= $row_rsSLTitles['MaximumSL'];
	$out .= "\t";
	$out .= $row_rsSLTitles['StandardDeviation'];
	$out .= "\t";
	$out .= $row_rsSLTitles['Comments'];
	$out .= "\t";
	$out .= $Datesubmitted;
	$out .= "\n";

} while ($row_rsSLTitles = mysql_fetch_assoc($rsSLTitles)); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Download Data</title>
<link href="admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>Download Data</h1>

<h2>Here's what happened: </h2>
<pre>
<?php 

// Display data, for testing
//echo $out; 

echo "<P>Running MySQL query for ShotLogger_TitleData.txt.</P>";

//	$datadownload = "../data/download/ShotLogger_TitleData_" . date("Ymd") . ".txt";
//	$datadownload = "../data/download/ShotLoggerTitleData_" . time() . ".txt";
	$datadownload = "../data/download/ShotLogger_TitleData.txt";

if($out != "") // Check to see if output exists
	{
	// Check for previous export and rename it with a time stamp if necessary
	if (file_exists($datadownload)) {
		//$datadownloadtemp = "../data/download/ShotLogger_TitleData_" . time() . ".txt";
//		rename($datadownload, $datadownloadtemp);
//		echo "<P>The file $datadownload exists and has been renamed $datadownloadtemp .</P>";
		unlink ($datadownload);
		echo "<P>The file $datadownload exists and has been deleted.</P>";
	} 
	//Generate file
	$fh = fopen($datadownload,"w"); // open the file for writing
	if($fh){
		fwrite($fh,$out);  // write data in $out
		fclose($fh); // close the file
		echo "<H2>We cool. <em>". $datadownload . "</em> generated!</H2>";
	}else{ // Problem with the file?
		fclose($fh);
		echo "<P>Could not open file " . $datadownload . " for writing.</P>";
	}
	}

// Process XML data

// Code from "Converting Database queries to XML"
// http://labs.adobe.com/technologies/spry/samples/utils/query2xml.html
// The data {below] are all wrapped in CDATA because it will work with all data types.

// Gather SL Title data for processing, AGAIN

echo "<P>Running MySQL query for ShotLogger_TitleData.xml.</P>";

mysql_select_db($database_ShotLoggerVM, $ShotLoggerVM);
$query_rsSLTitlesXML = "SELECT * FROM sl_Title2 LEFT JOIN `sl_ImdbMap` USING (IMDbID) ORDER BY ImdbTitle ASC";
$rsSLTitlesXML = mysql_query($query_rsSLTitlesXML, $ShotLoggerVM) or die(mysql_error());
$row_rsSLTitlesXML = mysql_fetch_assoc($rsSLTitlesXML);
$totalRows_rsSLTitlesXML = mysql_num_rows($rsSLTitlesXML);

// Start preparing the text to be written in $out

$XMLout .= '<?xml version="1.0" encoding="utf-8"?>';
$XMLout .= "\n";
$XMLout .= "<root>\n";

if ($totalRows_rsSLTitlesXML > 0) { // Do if recordset not empty 
	do { 
	$XMLout .= "    \t<row>\n";
	foreach ($row_rsSLTitlesXML as $column=>$value) { ;
		$XMLout .= "<". $column . "><![CDATA[" . $row_rsSLTitlesXML[$column] . "]]></" . $column . ">\n" ;
		$XMLout .= "        " . $row_rsSLTitlesXML['slTitleID'] . "\t\t";
	}
	$XMLout .= "</row>\n" ;
	} while ($row_rsSLTitlesXML = mysql_fetch_assoc($rsSLTitlesXML));
} // End: Do if recordset not empty

$XMLout .= "</root>";

$datadownload = "../data/download/ShotLogger_TitleData.xml";

if($XMLout != "") // Check to see if output exists
	{
	// Check for previous export and rename it with a time stamp if necessary
	if (file_exists($datadownload)) {
//		$datadownloadtemp = "../data/download/ShotLogger_TitleData_" . time() . ".xml";
//		rename($datadownload, $datadownloadtemp);
//		echo "<P>The file $datadownload exists and has been renamed $datadownloadtemp .</P>";
		unlink ($datadownload);
		echo "<P>The file " . $datadownload . "existed and has been deleted.</P>";
	} 
	//Generate file
	$fh = fopen($datadownload,"w"); // open the file for writing
	if($fh){
		fwrite($fh,$XMLout);  // write data in $XMLout
		fclose($fh); // close the file
		echo "<H2>We cool. <em>". $datadownload . "</em> generated!</H2>";
	}else{ // Problem with the file?
		fclose($fh);
		echo "<P>Could not open file " . $datadownload . " for writing.</P>";
	}
	}


// For testing

//echo "\$XMLout looks like this: " . $XMLout ;
//echo "\$datadownload looks like this: " . $datadownload ;


// Display data, for testing
//echo $output; 



?>
</pre>
<p><a href="index.php">Return to Shot Logger Administration.</a></p>
</body>
</html>
<?php 
mysql_free_result($rsSLTitles);
mysql_free_result($rsSLShots);
mysql_free_result($rsSLTitlesXML);
?>


<!-- END PASSWORD-PROTECTED CONTENT -->

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
<title>Shot Logger: Login</title>
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
