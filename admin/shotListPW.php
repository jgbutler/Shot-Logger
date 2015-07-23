<?php // include configuration data for MySQL and Shot Logger login.
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
// Check to see if form has been submitted
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	// If it has, then process these data

	$updateSQL = sprintf("UPDATE sl_Title2 SET `Title`=%s, `IMDbID`=%s, `EpisodeDate`=%s, `MovieDate`=%s, `Comments`=%s, `Keywords`=%s, `Length`=%s, `ShotTotal`=%s, `AverageShotLength`=%s, `MedianShotLength`=%s, `MSL_ASL`=%s, `Mode`=%s, `MinimumMode`=%s, `MaximumMode`=%s, `MinimumSL`=%s, `MaximumSL`=%s, `Range`=%s, `StandardDeviation`=%s, `CV`=%s, `Skewness`=%s, `Kurtosis`=%s, `Q1`=%s, `Q3`=%s, `IQR`=%s, `Variance`=%s, `LastModified`=%s WHERE slTitleID=%s",
                       GetSQLValueString($_POST['Title'], "text"),
                       GetSQLValueString($_POST['IMDbID'], "text"),
                       GetSQLValueString($_POST['EpisodeDate'], "date"),
                       GetSQLValueString($_POST['MovieDate'], "text"),
                       GetSQLValueString($_POST['Comments'], "text"),
                       GetSQLValueString($_POST['Keywords'], "text"),
                       GetSQLValueString($_POST['Length'], "int"),
                       GetSQLValueString($_POST['ShotTotal'], "int"),
                       GetSQLValueString($_POST['AverageShotLength'], "double"),
                       GetSQLValueString($_POST['MedianShotLength'], "double"),
                       GetSQLValueString($_POST['MSL_ASL'], "double"),
                       GetSQLValueString($_POST['Mode'], "double"),
                       GetSQLValueString($_POST['MinimumMode'], "double"),
                       GetSQLValueString($_POST['MaximumMode'], "double"),
                       GetSQLValueString($_POST['MinimumSL'], "int"),
                       GetSQLValueString($_POST['MaximumSL'], "int"),
                       GetSQLValueString($_POST['Range'], "int"),
                       GetSQLValueString($_POST['StandardDeviation'], "double"),
                       GetSQLValueString($_POST['CV'], "double"),
                       GetSQLValueString($_POST['Skewness'], "double"),
                       GetSQLValueString($_POST['Kurtosis'], "double"),
                       GetSQLValueString($_POST['Q1'], "double"),
                       GetSQLValueString($_POST['Q3'], "double"),
                       GetSQLValueString($_POST['IQR'], "double"),
                       GetSQLValueString($_POST['Variance'], "double"),
                       GetSQLValueString($_POST['LastModified'], "int"),
                       GetSQLValueString($_POST['slTitleID'], "int"));

	mysql_select_db($database_ShotLoggerVM, $ShotLoggerVM);
	echo $updateSQL . '<p>';
	$Result1 = mysql_query($updateSQL, $ShotLoggerVM) or die(mysql_error());

	// ANNOUNCE NEW DATA ON TWITTER
	// IFTTT recipe posts to Twitter

	//Build the IFTTT email 
		// $out .= date("g:i"); 
		$out .= "New data! ";
		$out .= stripslashes(urldecode($_POST["Title"]));
		$out .= " clocks in: ";
		$out .= stripslashes(urldecode($_POST["AverageShotLength"]));
		$out .= " ASL and ";
		$out .= stripslashes(urldecode($_POST["MedianShotLength"]));
		$out .= " MSL. More stats: http://shotlogger.org/TitleListDetail.php?recordID=";
		$out .= stripslashes(urldecode($_POST["slTitleID"]));

    // Start by setting up the "to" address
	// multiple recipients
	// Example from http://us3.php.net/manual/en/function.mail.php
	// IFTTT email address changed from trigger@ifttt.com in October 2014.
		$to  = 'trigger@recipe.ifttt.com'; 
	//$to  = 'jgbutler@gmail.com '; 
    // Now, set up the "subject" line to trigger IFTTT.com
		$subject .= "#ShotLoggerUpdate";

    // And, last (before we build the email), set up some mail headers
		$headers  = "From: Jeremy Butler <jbutler@ua.edu>\n";
		$headers .= "X-Sender: <jbutler@ua.edu>\n"; 
		$headers .= "X-Priority: 1\n"; 
		$headers .= "Return-Path: <jbutler@ua.edu>\n";
		//    $headers .= "bcc: <jbutler@ua.edu>\n";
    	$headers .= "X-Mailer: PHP/" . phpversion(); 


if($out != "")
	{
		// If message exists, then send mail to IFTTT (to be forwarded to Twitter)
		mail($to, $subject, $out, $headers) ;
	} else{
		echo "<P>We not cool. Email not sent to " . $to . "!";
	}








	// UPDATE SHOT LOGGER STATISTICS
	
	// MySQL query pulls most recent data from sl_Title2
	mysql_select_db($database_ShotLoggerVM, $ShotLoggerVM);
	$query_rsSLStats = "SELECT * FROM sl_Title2";
	$rsSLStats = mysql_query($query_rsSLStats, $ShotLoggerVM) or die(mysql_error());
	$row_rsSLStats = mysql_fetch_assoc($rsSLStats);
	$totalRows_rsSLStats = mysql_num_rows($rsSLStats);
	
	// Calculation of latest data
	do { // Create arrays
		$CumeShotTotal[] = $row_rsSLStats['ShotTotal'] ;
		$CumeTitleLength[] = $row_rsSLStats['Length'] ;
		} while ($row_rsSLStats = mysql_fetch_assoc($rsSLStats)); 
	
	// Calculate sum of titles' shot totals 
	while(list($key,$val) = each($CumeShotTotal)) {
		$total += $val;
		}
	// Calculate the mean of title's shot totals
	$mean = number_format($total/count($CumeShotTotal), 2) ;
	$total_formatted = number_format($total) ;
	
	// Calculate sum of titles' shot totals 
	while(list($key,$val) = each($CumeTitleLength)) {
		$totalTitleLength += $val;
		}
	// Calculate the mean of title's shot totals
	$meanShotLength = number_format($totalTitleLength/$total, 2) ;
	$totalTitleLength_formatted = number_format($totalTitleLength) ;
	
	// MySQL queries to enable updating of data
	mysql_select_db($database_ShotLoggerVM, $ShotLoggerVM);
	$query_rsSLStatsUpdate = "SELECT * FROM sl_Statistics";
	$rsSLStatsUpdate = mysql_query($query_rsSLStatsUpdate, $ShotLoggerVM) or die(mysql_error());
	$row_rsSLStatsUpdate = mysql_fetch_assoc($rsSLStatsUpdate);
	$totalRows_rsSLStatsUpdate = mysql_num_rows($rsSLStatsUpdate);

	mysql_select_db($database_ShotLoggerVM, $ShotLoggerVM);
	$query_rsIMDbTitles = "SELECT ImdbTitle FROM `sl_ImdbMap`";
	$rsIMDbTitles = mysql_query($query_rsIMDbTitles, $ShotLoggerVM) or die(mysql_error());
	$row_rsIMDbTitles = mysql_fetch_assoc($rsIMDbTitles);
	$totalRows_rsIMDbTitles = mysql_num_rows($rsIMDbTitles);
	
	// Update variables
		// this always equals 1
		$StatsID = 1 ;
		// $_POST['LastModified'] also works as "last updated"

	// Run Update process!!!!    IMDBTitlesCount
	$updateSQL = sprintf("UPDATE sl_Statistics SET TitlesCount=%s, IMDBTitlesCount=%s, ShotsSum=%s, ShotsCount=%s, ShotsSumMean=%s, ShotsCountMean=%s, LastUpdated=%s WHERE statsID=%s",
					   GetSQLValueString($totalRows_rsSLStats, "int"),
					   GetSQLValueString($totalRows_rsIMDbTitles, "int"),
					   GetSQLValueString($totalTitleLength, "int"),
					   GetSQLValueString($total, "int"),
					   GetSQLValueString($meanShotLength, "double"),
					   GetSQLValueString($mean, "double"),
					   GetSQLValueString($_POST['LastModified'], "int"),
					   GetSQLValueString($StatsID, "int"));
	
	mysql_select_db($database_ShotLoggerVM, $ShotLoggerVM);
	$Result2 = mysql_query($updateSQL, $ShotLoggerVM) or die(mysql_error());

  // after update go to Administration index page
//  $updateGoTo = "../administration/index.php";
  $updateGoTo = "index.php";
  // The following adds the slTitleID to the end of the URL. Is that needed?
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));

} // End form processing

$colname_rsShotListing = "-1";
if (isset($_GET['slTitleID'])) {
  $colname_rsShotListing = $_GET['slTitleID'];
}
mysql_select_db($database_ShotLoggerVM, $ShotLoggerVM);
$query_rsShotListing = sprintf("SELECT * FROM sl_ShotData WHERE slTitleID = %s ORDER BY TimeCode ASC", GetSQLValueString($colname_rsShotListing, "int"));
$rsShotListing = mysql_query($query_rsShotListing, $ShotLoggerVM) or die(mysql_error());
$row_rsShotListing = mysql_fetch_assoc($rsShotListing);
$totalRows_rsShotListing = mysql_num_rows($rsShotListing);

$colname_rsslTitle = "-1";
if (isset($_GET['slTitleID'])) {
  $colname_rsslTitle = $_GET['slTitleID'];
}
mysql_select_db($database_ShotLoggerVM, $ShotLoggerVM);
$query_rsslTitle = sprintf("SELECT * FROM sl_Title2 WHERE slTitleID = %s", GetSQLValueString($colname_rsslTitle, "int"));
$rsslTitle = mysql_query($query_rsslTitle, $ShotLoggerVM) or die(mysql_error());
$row_rsslTitle = mysql_fetch_assoc($rsslTitle);
$totalRows_rsslTitle = mysql_num_rows($rsslTitle);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shot Logger 2.0 Admin: Import Results</title>
<link href="admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>Import Results</h1>
<h2>Shot List for Title #<?php echo $row_rsShotListing['slTitleID']; ?> <em><?php echo $row_rsslTitle['Title']; ?></em></h2>
<p>  <?php echo $totalRows_rsShotListing ?> records total. To finalize shot statistics, <a href="#update">skip ahead to this form</a>. </p>
<!--<p>sl_directory = <?php // echo $row_rsslTitle['sl_directory']; ?></p>-->

<table border="1" align="center">
  <thead>
  <tr>
    <th>Shot #</th>
    <th>Filename</th>
    <th>Image</th>
    <th>SL Image Directory</th>
    <th>IMDb ID</th>
    <th>TimeCode</th>
    <th>Shot Length</th>
    <th>Shot Scale</th>
    <th>Camera Movement</th>
    <th>Comments</th>
    <th>Keywords</th>
    <th>Submitted By</th>
    <th>Date Submitted</th>
    <th>Last Modified</th>
  </tr>
  </thead>
  <?php 
  
  	// Zero out the shot length array
	$shotLengths = array();

  do { ?>
    <tr>
      <td><a href="ShotDetail.php?recordID=<?php echo $row_rsShotListing['shotID']; ?>"><?php echo $row_rsShotListing['ShotNumber']; ?></a><br />
		<strong><a href="ShotListDetailForUpdating.php?recordID=<?php echo $row_rsShotListing['shotID']; ?>">Update</a></strong></td>
      <td><a href="ShotDetail.php?recordID=<?php echo $row_rsShotListing['shotID']; ?>"><?php echo $row_rsShotListing['filename']; ?></a></td>
      <td><a href="../images/<?php echo $row_rsShotListing['sl_directory']; ?><?php echo $row_rsShotListing['filename']; ?>" target="_blank">Click to view</a>
      
        <!-- Commented out the display of thumbnails. Too slow
      <a href="../images/<?php // echo $row_rsShotListing['sl_directory']; ?><?php //echo $row_rsShotListing['filename']; ?>" target="_blank"><img src="../images/<?php // echo $row_rsShotListing['sl_directory']; ?><?php // echo $row_rsShotListing['filename']; ?>" alt="Image thumbnail" width="150" border="0" /></a>
      -->
      
      </td>
      <td><?php echo $row_rsslTitle['sl_directory']; ?></td>
      <td><?php echo $row_rsShotListing['IMDbID']; ?> </td>
      <td><?php echo gmdate("H:i:s", $row_rsShotListing['TimeCode']) . '<br>' ;
	  
	  
	  echo '(' . $row_rsShotListing['TimeCode']; ?> seconds)</td>
      <td><?php echo $row_rsShotListing['ShotLength']; 
	  	// push the shot length values into an array
		//array_push($shotLengths, $row_rsShotListing['ShotLength']);
		// This can be done without a function: 
		$shotLengths[] = $row_rsShotListing['ShotLength'] ;
	  ?> </td>
      <td><?php echo $row_rsShotListing['ShotScale']; ?> </td>
      <td><?php echo $row_rsShotListing['CameraMovement']; ?> </td>
      <td><?php echo $row_rsShotListing['Comments']; ?> </td>
      <td><?php echo $row_rsShotListing['Keywords']; ?> </td>
      <td><?php echo $row_rsShotListing['SubmittedBy']; ?> </td>
      <td><?php 
	  if ($row_rsShotListing['DateSubmitted']) echo strftime ("%c", $row_rsShotListing['DateSubmitted']); ?></td>
      <td><?php 
	  if ($row_rsShotListing['LastModified']) echo strftime ("%c", $row_rsShotListing['LastModified']); ?></td>
    </tr>
    <?php } while ($row_rsShotListing = mysql_fetch_assoc($rsShotListing)); ?>
</table>

<?php 
/*
// Testing: display $shotLengths array values
echo "<br />" ;
// var_dump ($shotLengths);
echo "<br />" ;
print_r($shotLengths);
echo "<br />" ;
echo "Sum = " . array_sum($shotLengths) . ' (same as Episode/movie length?)<br />';
//echo "Episode/movie length = " . $row_rsShotListing['ShotLength'] . '<br />';
echo "Number of shots =  " . $totalRows_rsShotListing . '<br />';
echo "ASL = " . ( array_sum($shotLengths) / $totalRows_rsShotListing ) . '<br />';
echo "Standard deviation = " . standard_deviation($shotLengths) . '<br />';
*/

// echo "<PRE>";

















// Calculate stats 

// Include PHP stats classes
	include_once("../includes/basic-statistics/statistics.class.php");
	require('../includes/kashi.php'); 

// Function for displaying modes nicely
function pc_array_to_comma_string($array) {
	switch (count($array)) {
		case 0:
			return '';
			
		case 1:
			return reset($array);
			
		case 2:
			return join(' and ', $array);
		
		default:
			$last = array_pop($array);
			return join(', ', $array) . ", and $last";
	}
}

// "Basic Statistics" class configuration settings
    ini_set("display_errors","1");
    error_reporting(E_ALL);
    define("EXEC",TRUE);

echo '<h2>Title ' . $colname_rsslTitle . ' (' . $row_rsslTitle['Title'] . ') is being updated: </h2>' ; 

// FIRST, calculate stats based on slTitleID and set their variables.

// Get shot lengths for a specific title

// Connect to database to suck out a shot list, with shot lengths

/*
	$colname_rsShotListing = "-1";
	if (isset($row_rsNewStats['slTitleID'])) {
	  $colname_rsShotListing = $row_rsShotListing['slTitleID'];
	}
*/

$colname_rsShotListing = "-1";
if (isset($_GET['slTitleID'])) {
  $colname_rsShotListing = $_GET['slTitleID'];
}
	
	mysql_select_db($database_ShotLoggerVM, $ShotLoggerVM);
	$query_rsShotListing = sprintf("SELECT * FROM sl_ShotData WHERE slTitleID = %s ORDER BY TimeCode ASC", GetSQLValueString($colname_rsShotListing, "int"));
	$rsShotListing = mysql_query($query_rsShotListing, $ShotLoggerVM) or die(mysql_error());
	$row_rsShotListing = mysql_fetch_assoc($rsShotListing);
	$totalRows_rsShotListing = mysql_num_rows($rsShotListing);

// Zero out the shot-length array
	$shotLengths = array();

// push the shot-length values into the $shotLengths array
	do { 
		$shotLengths[] = $row_rsShotListing['ShotLength'] ;
	} while ($row_rsShotListing = mysql_fetch_assoc($rsShotListing)); 
	// Testing array creation
	/*
	
	echo 'Array of shot lengths for title ' . $row_rsNewStats['slTitleID'] . '<br/>';
	print_r($shotLengths); 
	echo '<br/>';
	
	*/


// Calculate some stats with "Basic Statistics" class
//    ini_set("display_errors","1");
//    error_reporting(E_ALL);
//    define("EXEC",TRUE);
		//Create new instance of $stats class
            $stats = new Statistics($shotLengths,5);

            $stats->q = $stats->Find_Q();
            $stats->max = $stats->Find_Max();
            $stats->min = $stats->Find_Min();
//            $stats->fx = $stats->Calculate_FX();
            $stats->mean = $stats->Find_Mean();
            $stats->median = $stats->Find_Median();
            $stats->mode = $stats->Find_Mode();
            $stats->range = $stats->Find_Range();
            $stats->iqr = $stats->Find_IQR();
//            $stats->pv = $stats->Find_V('p');
//            $stats->sv = $stats->Find_V('s');
//            $stats->psd = $stats->Find_SD('p');
//            $stats->ssd = $stats->Find_SD('s');
//            $stats->XminA = $stats->Calculate_XminAvg(false);
//            $stats->XminAsqr = $stats->Calculate_XminAvg(true);
//            $stats->rf = $stats->Calculate_RF();
//            $stats->rfp = $stats->Calculate_RFP();
//            $stats->cf = $stats->Calculate_CF();

//            echo "<pre>";
//            print_r($stats);

// Calculate sum of $shotLengths
	echo 'Sum of array, calculated with simple PHP function: ' . array_sum($shotLengths) . '<br/>' ;

//            echo "</pre>";



// Calculate more stats with Kashi class

	//Create new instance of Kashi
	$kashi = new Kashi(); 
	
	// Use $shotLengths data set to calculate stats
	echo 'Mean: ' . $kashi->mean($shotLengths) . '<br />'; 
	echo 'Number of shots: ' . (count($shotLengths) - 1 ) . '<br />'; 
	
	// Kashi will use previous data set if you don't provide one as an argument to the method 
	
	echo 'Mode: ';
	print_r($kashi->mode()); 
	echo '<br />';
	asort($kashi->mode());
	$kashi->m = $kashi->mode();
	//echo 'Testing mode calculation ' . $kashi->m[0] . ' ' . $kashi->m[1] . ' ' . $kashi->m[2] . ' ' . $kashi->m[3] . ' ' . $kashi->m[4] . '<br />' ;
	//$AllModes =  $kashi->m[0] . ' ' . $kashi->m[1] . ' ' . $kashi->m[2] . ' ' . $kashi->m[3] . ' ' . $kashi->m[4];

	reset ($kashi->m);
	$AllModes = '';
	asort($kashi->m);
	$MinimumMode = min($kashi->m) ;
	$MaximumMode = max($kashi->m) ;
	/* Displays values in a comma-ed list, but leaves a comma at the end
		while ($array_cell = each($kashi->m))
		{
			$current_value = $array_cell['value'];
			$current_key = $array_cell['key'];
			print("Current Key: $current_key; Current Value: $current_value<BR>");
			$AllModes .= $current_value ;
			$AllModes .= ', ' ;
		}
	
	*/
	// List the values in the array as a neat, comma-ed list
	$AllModes = pc_array_to_comma_string($kashi->m) ;
	echo 'AllModes = ' . $AllModes  . '<br />' ;
	echo 'Minimum mode value = ' . $MinimumMode . '<br />';
	echo 'Maximum mode value = ' . $MaximumMode . '<br />';
	echo 'Median: '   . $kashi->median()   . '<br />'; 
	$MeanMedianRatio = $kashi->median() / $kashi->mean() ;
	echo 'Mean/Median: '   . $MeanMedianRatio   . '<br />'; 
	echo 'Variance (sample): ' . $kashi->variance() . '<br />'; 
	echo 'Standard Deviation (sample): '       . $kashi->sd()       . '<br />'; 
	echo '%CV (coefficients of variation): '      . $kashi->cv()       . '<br />'; 
	echo 'Skewness: ' . $kashi->skew()     . '<br />'; 
	echo 'Kurtosis: ' . $kashi->kurt()     . '<br />'; 
	
	// Shannon diversity may be calculated with shot-lengths array from Basic Stats
	// Array of shot-length frequency created by basic stats class
	//echo 'Array of shot-lengths frequency (Basic Stats).<br/>';
	//print_r($stats->frequency) ;
	//echo '<br/>Shannon diversity index for shot-lengths array: ' . $kashi->diversity($stats->frequency)  . '<br /><br />'; 
















?>

<a name="update" id="update"><h3>Finalize Data</h3></a>

<!--NEW FORM WITH EXTENDED STATS -->

<!--<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">-->
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">

  <table align="center">
  <thead>
    <tr valign="baseline">
      <th colspan="2" align="right" nowrap><div align="center">Data for SL Title  # <?php echo $row_rsslTitle['slTitleID']; ?></div></th>
      </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap">&nbsp;</td>
      <td valign="top"><input type="submit" value="Update record" /></td>
    </tr>
	</thead>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Title:</strong></td>
      <td valign="top"><input type="text" name="Title" value="<?php echo $row_rsslTitle['Title'] ;?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>IMDbID:</strong></td>
      <td valign="top"><input type="text" name="IMDbID" value="<?php echo $row_rsslTitle['IMDbID']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>TV Episode Date or<br />
      Film Year:</strong></td>
      <td valign="top">TV:
        <input type="text" name="EpisodeDate" value="<?php echo $row_rsslTitle['EpisodeDate']; ?>" size="32" /><br />
		Film:
	  <input type="text" name="MovieDate" value="<?php echo $row_rsslTitle['MovieDate']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>Keywords:</strong></td>
      <td valign="top"><input type="text" name="Keywords" value="<?php echo $row_rsslTitle['Keywords']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>Length<br />
      (sum of shots):</strong></td>
      <td valign="top"><input type="text" name="Length" value="<?php echo array_sum($shotLengths) ?>" size="32" /><br />
old: <?php echo $row_rsslTitle['Length']; ?></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>Number of Shots:</strong></td>
      <td valign="top"><input type="text" name="ShotTotal" value="<?php echo $totalRows_rsShotListing ?>" size="32" /><br />
old: <?php echo $row_rsslTitle['ShotTotal']; ?></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>Average Shot Length:</strong></td>
      <td valign="top"><input type="text" name="AverageShotLength" value="<?php echo $stats->mean ?>" size="32" /><br />
old: <?php echo $row_rsslTitle['AverageShotLength']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>MedianShotLength:</strong></td>
      <td valign="top"><input type="text" name="MedianShotLength" value="<?php echo $kashi->median() ?>" size="32" /><br />
old: <?php echo $row_rsslTitle['MedianShotLength']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>MSL/ASL:</strong></td>
      <td valign="top"><input type="text" name="MSL_ASL" value="<?php echo $MeanMedianRatio ?>" size="32" /><br />
old: <?php echo $row_rsslTitle['MSL_ASL']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Mode(s):</strong></td>
      <td valign="top"><input type="text" name="Mode" value="<?php echo $AllModes ?>" size="32" /><br />
old: <?php echo $row_rsslTitle['Mode']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>MinimumMode:</strong></td>
      <td valign="top"><input type="text" name="MinimumMode" value="<?php echo $MinimumMode ?>" size="32" /><br />
old: <?php echo $row_rsslTitle['MinimumMode']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>MaximumMode:</strong></td>
      <td valign="top"><input type="text" name="MaximumMode" value="<?php echo $MaximumMode ?>" size="32" /><br />
old: <?php echo $row_rsslTitle['MaximumMode']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>MinimumSL:</strong></td>
      <td valign="top"><input type="text" name="MinimumSL" value="<?php echo $stats->min ?>" size="32" /><br />
old: <?php echo $row_rsslTitle['MinimumSL']; ?></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>MaximumSL:</strong></td>
      <td valign="top"><input type="text" name="MaximumSL" value="<?php echo $stats->max ?>" size="32" /><br />
old: <?php echo $row_rsslTitle['MaximumSL']; ?></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>Range:</strong></td>
      <td valign="top"><input type="text" name="Range" value="<?php echo $stats->range ; ?>" size="32" /><br />
old: <?php echo $row_rsslTitle['Range']; ?></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>Standard Deviation:</strong></td>
      <td valign="top"><input type="text" name="StandardDeviation" value="<?php echo $kashi->sd() ?>" size="32" /><br />
old: <?php echo $row_rsslTitle['StandardDeviation']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>CV:</strong></td>
      <td valign="top"><input type="text" name="CV" value="<?php echo $kashi->cv() ?>" size="32" /><br />
old: <?php echo $row_rsslTitle['CV']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Skewness:</strong></td>
      <td valign="top"><input type="text" name="Skewness" value="<?php echo $kashi->skew() ?>" size="32" /><br />
old: <?php echo $row_rsslTitle['Skewness']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Kurtosis:</strong></td>
      <td valign="top"><input type="text" name="Kurtosis" value="<?php echo $kashi->kurt() ?>" size="32" /><br />
old: <?php echo $row_rsslTitle['Kurtosis']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Q1:</strong></td>
      <td valign="top"><input type="text" name="Q1" value="<?php echo $stats->q[1] ?>" size="32" /><br />
old: <?php echo $row_rsslTitle['Q1']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Q3:</strong></td>
      <td valign="top"><input type="text" name="Q3" value="<?php echo $stats->q[3] ?>" size="32" /><br />
old: <?php echo $row_rsslTitle['Q3']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>IQR:</strong></td>
      <td valign="top"><input type="text" name="IQR" value="<?php echo $stats->iqr ?>" size="32" /><br />
old: <?php echo $row_rsslTitle['IQR']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><strong>Variance:</strong></td>
      <td valign="top"><input type="text" name="Variance" value="<?php echo $kashi->variance() ?>" size="32" /><br />
old: <?php echo $row_rsslTitle['Variance']; ?></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><strong>Comments:</strong></td>
      <td valign="top"><textarea name="Comments" cols="32" rows="3"><?php echo $row_rsslTitle['Comments']; ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><strong>SL image directory:</strong></td>
      <td valign="top"><input name="sl_directory" type="hidden" value="<?php echo $row_rsslTitle['sl_directory']; ?>" />
        <?php echo $row_rsslTitle['sl_directory']; ?></td>
    </tr>



    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>Date Submitted:</strong></td>
      <td valign="top">
      <!--<input type="hidden" name="DateSubmitted" value="<?php // echo time() ; ?>" /> -->
      <input type="hidden" name="DateSubmittedV2" value="<?php echo $row_rsslTitle['DateSubmittedV2']; ?>" /><?php echo $row_rsslTitle['DateSubmittedV2']; ; ?>



    </td>
    </tr>








    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>Last Modified:</strong></td>
      <td valign="top"><?php 
	  if ( $row_rsslTitle['LastModified'] ) {
		  echo strftime ("%c", $row_rsslTitle['LastModified']) ; 
	  }
	  ?>
	  <input type="hidden" name="LastModified" value="<?php echo time(); // insert timestamp automatically ?>" />	  </td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="slTitleID" value="<?php echo $row_rsslTitle['slTitleID']; ?>">
</form>




















<?php 
include ('../includes/footerV2.php'); // Include the footer
?>

<?php
mysql_free_result($rsShotListing);
mysql_free_result($rsslTitle);
// mysql_free_result($rsEntity);
// mysql_free_result($rsSLStats);
// mysql_free_result($rsSLStatsUpdate);

// calculate the standard deviation in an array.

function standard_deviation($array) {
    // From http://www.zend.com/code/codex.php?id=125&single=1
    //Get sum of array values
    while(list($key,$val) = each($array)) {
        $total += $val;
    }
    
    reset($array);
    $mean = $total/count($array);
    
    while(list($key,$val) = each($array)) {
        $sum += pow(($val-$mean),2);
    }
    $var = sqrt($sum/(count($array)-1));
    
    return $var;
}

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
