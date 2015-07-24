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

// Set Shot Logger variables based on POST data
// Separate directory prefix from specific directory to shorten $slDir
// $slDir = '/srv/www/shotlogger/images/'. $_POST['slDir'] ;
$slDir = $_POST['slDir'] ;
$slDirPrefix = '/srv/www/shotlogger/images/' ;
// Set PHP scandir's $dir variable based on POST data
$dir = '/srv/www/shotlogger/images/'. $_POST['slDir'] ;

// Update the IMDb map
// Check to see if the IMDb ID number is already mapped.

$colname_rsIMDbMapCheck = "-1";
if (isset($_POST['IMDbID'])) {
  $colname_rsIMDbMapCheck = $_POST['IMDbID'];
}
mysql_select_db($database_ShotLoggerVM, $ShotLoggerVM);
$query_rsIMDbMapCheck = sprintf("SELECT IMDbID FROM sl_ImdbMap WHERE IMDbID = %s", GetSQLValueString($colname_rsIMDbMapCheck, "text"));
$rsIMDbMapCheck = mysql_query($query_rsIMDbMapCheck, $ShotLoggerVM) or die(mysql_error());
$row_rsIMDbMapCheck = mysql_fetch_assoc($rsIMDbMapCheck);
$totalRows_rsIMDbMapCheck = mysql_num_rows($rsIMDbMapCheck);

// If it is NOT mapped, then insert either the TV program title or the theatrical film title

if ( $totalRows_rsIMDbMapCheck < 1 ) {
	if ( $_POST['TV_program'] ) {
		$IMDbTitle = $_POST['TV_program'] ;
	} else {
		$IMDbTitle = $_POST['Film_title'] ;
	}
	// Removed ImdbMapID insert as it's auto-incremented
	$insertSQL = sprintf("INSERT INTO sl_ImdbMap (IMDbID, ImdbTitle) VALUES (%s, %s)",
					   GetSQLValueString($_POST['IMDbID'], "text"),
					   GetSQLValueString($IMDbTitle, "text"));
	
	mysql_select_db($database_ShotLoggerVM, $ShotLoggerVM);
	$Result1 = mysql_query($insertSQL, $ShotLoggerVM) or die(mysql_error());
}

// Set a TV Ep or Film title for importing into sl_Title2
if ( $_POST['TV_episode'] ) {
	$Title = $_POST['TV_episode'] ;
} else {
	$Title = $_POST['Film_title'] ;
}

// Check to see if SL title exists

$colname_rsCheckSLDir = "-1";
if (isset($_POST['slDir'])) {
  $colname_rsCheckSLDir = $_POST['slDir'];
}
mysql_select_db($database_ShotLoggerVM, $ShotLoggerVM);
$query_rsCheckSLDir = sprintf("SELECT sl_directory FROM sl_Title2 WHERE sl_directory = %s", GetSQLValueString($colname_rsCheckSLDir, "text"));
$rsCheckSLDir = mysql_query($query_rsCheckSLDir, $ShotLoggerVM) or die(mysql_error());
$row_rsCheckSLDir = mysql_fetch_assoc($rsCheckSLDir);
$totalRows_rsCheckSLDir = mysql_num_rows($rsCheckSLDir);

// If a SL title does NOT exist for an SL upload directory, then insert new data into sl_Title2 table
if ($totalRows_rsCheckSLDir == 0 ) {
	// Will timestamp automatically work? No, use this instead to create Unix time:
	$DateSubmitted = time();
	$insertSQL = sprintf("INSERT INTO sl_Title2 (slTitleID, Title, sl_directory, IMDbID, EpisodeDate, MovieDate, `LastModified`) VALUES (%s, %s, %s, %s, %s, %s, %s)",
		GetSQLValueString($_POST['slTitleID'], "int"),
		GetSQLValueString($Title, "text"),
		GetSQLValueString($_POST['slDir'], "text"),
		GetSQLValueString($_POST['IMDbID'], "text"),
		GetSQLValueString($_POST['EpisodeDate'], "date"),
		GetSQLValueString($_POST['MovieDate'], "text"),
		GetSQLValueString($_POST['LastModified'], "int"));
	
	mysql_select_db($database_ShotLoggerVM, $ShotLoggerVM);
	$Result1 = mysql_query($insertSQL, $ShotLoggerVM) or die(mysql_error());
} // end check for SL directory

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shot Logger 2.0: Insert Data</title>
<link href="../shotlogger.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>Insert Data<br />
<?php echo $dir ; ?></h1>
<!--<p><a href="#titlelisting">Skip ahead to bottom of page...</a> </p>-->

<?php
// Get file names by using the PHP scandir function
// http://php.net/manual/en/function.scandir.php
// defaults to alphabetical
// reverse alphabetical
// $files2 = scandir($dir, 1);

// Directories for testing
//$dir    = 'images';
//$dir    = '/srv/www/g2shotloggerdata/albums';
//$dir    = '/srv/www/shotlogger/images/MartinKanePrivateEye/19510000';

$files = scandir($dir);
// Display array of file names, for testing.
// print_r($files);
// print_r($files2);

// Before looping through the array, cancel any $previousTimeCode or $previousG_id variables
$previousTitle = false ;
$previousOriginationTimeStamp = false;
$previousTimeCode = false;
$previousOwnerId = false;

// Automatically count shot numbers
$ShotNumber = 0 ;

// Count number of elements in the $files array
$num_elements = count ($files) ;
echo '<P>Number of images to process = ' . $num_elements . '</P><H2>Commence munching on data...</H2>' ;

// Loop through the array
// Index ($idx) set to 2 in order to start at #2 file, thus skipping "dot" files
// Loop auto-increments (++$idx) until it hits the highest index number 
// ($num_elements)
for ($idx = 2; $idx < $num_elements; ++$idx) { // Begin FOR loop.

	// Process the frame title to parse out the timecode		
	// Get filename from array.
	// Step through the nummbered array
	$fgfilename01 = $files[$idx] ;
	
	// Split filename on qq (for "shot logger time code")
	$splitdata = explode('qq', strtolower($fgfilename01) );
	
	// Split time data on _ (underscore)
	$splittimedata = explode('_', $splitdata[1]);
	
	// Split filename further (on . [period]) to reveal shot number -- for possible use later
	$splitshotdata = explode('.', $splitdata[2]);
	
	// Format the split data into HH:MM:SS		
	$timeofframe = "$splittimedata[0]:$splittimedata[1]:$splittimedata[2]";
	
	/*		Testing:
	echo $timeofframe . " (" . strtotime ($timeofframe)  . ") ";
	echo $timeofframe;
	echo "<br />TimeCode of frame = " . $timeofframe . "<br />"; 
	echo "String-to-time formatted TimeCode = " . strtotime ($timeofframe)  . "<br />";
	*/
	// Just for fun...
	/*$timeinseconds = getSeconds($timeofframe) ;
	echo "<br />(" . $timeinseconds   . " seconds)";
	echo "String to time result (formatted with %X) = " . strftime("%X", strtotime ($timeofframe) )  . "<br />";
	echo "String to time result (formatted with %c) = " . strftime("%c", strtotime ($timeofframe) )  . "<br />";*/
	
	// Establish/format $TimeCode to use it to calculate shot length
	// $TimeCode = strtotime ($timeofframe) ;
	// Use total seconds instead of timeSTAMP as stamp causes funkiness later
	$TimeCode = getSeconds($timeofframe) ;

	// Check to make sure that there are BOTH a $previousTimeCode and a $TimeCode (the latter will be missing from non-JPG files)
	if (($previousTimeCode) && ($TimeCode)) 
		{ 
		$length = $TimeCode - $previousTimeCode ;
		
		// These are the data that should be INSERTed into the database.
		
		// COULD USE THIS LIST TO DISPLAY RESULTS OF DATA INSERTION.
		
		// We must go through the data loop once before we're able to calculate shot length.
		// Hence the length of a the first shot is only known after we find the data for the second one.
		
		// If $length is less than one, make it one. Compensates for shots under one second long and potential timecode mess-up.
		// But it has the result of expanding less-than-one-minute shots to one minute.
		if ( $length < 1 ) 
			{
			$length = 1 ;
			}
		
		// Insert data 		
		$DateSubmitted = time();
		$insertSQL = sprintf("INSERT INTO sl_ShotData (ShotNumber, filename, sl_directory, g_parentid, slTitleID, IMDbID, TimeCode, ShotLength, ShotScale, CameraMovement, Comments, Keywords, DateSubmitted, SubmittedBy) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
				GetSQLValueString($ShotNumber, "int"),
				GetSQLValueString($previous_Fgfilename01, "text"),
				GetSQLValueString($_POST['slDir'], "text"),
				GetSQLValueString($_POST['g_parentid'], "int"),
				GetSQLValueString($_POST['slTitleID'], "int"),
				GetSQLValueString($_POST['IMDbID'], "text"),
				GetSQLValueString($previousTimeCode, "int"),
				GetSQLValueString($length, "int"),
				GetSQLValueString($_POST['ShotScale'], "text"),
				GetSQLValueString($_POST['CameraMovement'], "text"),
				GetSQLValueString($_POST['Comments'], "text"),
				GetSQLValueString($_POST['Keywords'], "text"),
				GetSQLValueString($DateSubmitted, "int"),
				GetSQLValueString($_POST['SubmittedBy'], "int"));
		
		mysql_select_db($database_ShotLoggerVM, $ShotLoggerVM);
		$Result1 = mysql_query($insertSQL, $ShotLoggerVM) or die(mysql_error());
		
		//			echo '<br/>MySQL result =' . $Result1 ;
		$progress = 'Munching... ' . $Result1 . ' image inserted.';
		//			echo  $progress ;
		
		}
	// Change variables so that, during the next loop, they'll refer to THIS data.
	$previousTimeCode = $TimeCode;
	$previous_Fgfilename01 = $fgfilename01 ;

	// Increment $ShotNumber
	$ShotNumber = $ShotNumber + 1;
	
} // End FOR loop.

// Function: Given a string TimeCode, return the number of seconds
// Assume hours:minutes:seconds format
function getSeconds($strTimeCode)
{
	$arr = explode(":", $strTimeCode);
	$seconds = $arr[0]*3600 + $arr[1]*60 + $arr[2];
	return $seconds;	
}


// And we're finished...

echo 'DONE!' ;

// after inserting data, AUTOMATICALLY go to shotListPW.php to finalize.

$updateGoTo = "shotListPW.php?slTitleID=" . $_POST['slTitleID'] ;
header(sprintf("Location: %s", $updateGoTo));

?>

<h3><a name="titlelisting" id="titlelisting"></a>To finish the import, <a href="shotListPW.php?slTitleID=<?php 

echo $_POST['slTitleID'] ;

?>">proceed to the listings</a> for Shot Logger Title #<?php 

echo $_POST['slTitleID'] ;

?> in order to run a few calculations on the data.</h3>


</body>
</html>
<?php
mysql_free_result($rsIMDbMap2);
mysql_free_result($rsCheckSLDir);
mysql_free_result($rsIMDbMapCheck);
?>
