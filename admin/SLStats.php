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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
// Check to see if form has been submitted
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	// If it has, then process these data
  $updateSQL = sprintf("UPDATE sl_Statistics SET TitlesCount=%s, ShotsSum=%s, ShotsCount=%s, ShotsSumMean=%s, ShotsCountMean=%s, LastUpdated=%s WHERE statsID=%s",
                       GetSQLValueString($_POST['TitlesCount'], "int"),
                       GetSQLValueString($_POST['ShotsSum'], "int"),
                       GetSQLValueString($_POST['ShotsCount'], "int"),
                       GetSQLValueString($_POST['ShotsSumMean'], "double"),
                       GetSQLValueString($_POST['ShotsCountMean'], "double"),
                       GetSQLValueString($_POST['LastUpdated'], "int"),
                       GetSQLValueString($_POST['statsID'], "int"));

  mysql_select_db($database_ShotLoggerVM, $ShotLoggerVM);
  $Result1 = mysql_query($updateSQL, $ShotLoggerVM) or die(mysql_error());

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_ShotLoggerVM, $ShotLoggerVM);
$query_rsSLStats = "SELECT * FROM sl_Title2";
$rsSLStats = mysql_query($query_rsSLStats, $ShotLoggerVM) or die(mysql_error());
$row_rsSLStats = mysql_fetch_assoc($rsSLStats);
$totalRows_rsSLStats = mysql_num_rows($rsSLStats);

mysql_select_db($database_ShotLoggerVM, $ShotLoggerVM);
$query_rsSLStatsUpdate = "SELECT * FROM sl_Statistics";
$rsSLStatsUpdate = mysql_query($query_rsSLStatsUpdate, $ShotLoggerVM) or die(mysql_error());
$row_rsSLStatsUpdate = mysql_fetch_assoc($rsSLStatsUpdate);
$totalRows_rsSLStatsUpdate = mysql_num_rows($rsSLStatsUpdate);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shot Logger 2.0: Calculate Cumulative Stats</title>
</head>

<body>
<h1>Calculate Cumulative Stats</h1>
<p>
<?php 
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

?>
<p>
  <?php echo $totalRows_rsSLStats ?> Shot Logger titles. </p>
<p>Total, cumulative length of <em>all</em> SL shots = <?php echo $totalTitleLength_formatted ; ?> seconds</p>
<p>Total number of shots measured = <?php echo $total_formatted ?></p>
<p>Average Shot Length of <em>all</em> SL shots (cumulative length / total number of shots) = <?php echo $meanShotLength ; ?> seconds</p>
<p>Mean number of shots in an SL title = <?php echo $mean ; ?></p>
<p>Last updated = <?php echo date("d F Y", $row_rsSLStatsUpdate['LastUpdated'])?> (Unix date: <?php echo $row_rsSLStatsUpdate['LastUpdated'] ; ?>)</p>
<p>Current date = <?php echo date("d F Y", time(now)) ; ?> (Unix date: <?php echo time(now) ; ?>)</p>
<p>
  <?php  
 
  // echo $CumeShotTotal ;
echo '<pre>' ; 
echo 'cume total sum = ' . $total . '<br>' ;
echo 'cume total title length sum = ' . $totalTitleLength . '<br>' ;
echo 'cume mean shot length = ' . $meanShotLength  . '<br>';

print_r($CumeTitleLength);
echo '</pre>' ;


/*
Sample MySQL statements

INSERT INTO `shotlogger2`.`sl_Statistics` (`statsID`, `TitlesCount`, `ShotsSum`, `ShotsCount`, `ShotsSumMean`, `ShotsCountMean`, `ShotLength`, `ShotScale`, `CameraMovement`, `Comments`, `Keywords`, `SubmittedBy`, `LastUpdated`, `LastModified`) VALUES (NULL, '538', '805088', '130204', '6.18', '242.01', '0', NULL, NULL, NULL, '0', '0', NULL, NULL);


UPDATE `shotlogger2`.`sl_Statistics` SET `TitlesCount` = '540', `ShotsSum` = '888777', `ShotsCount` = '123432', `ShotsSumMean` = '7.50', `ShotsCountMean` = '348.89' WHERE `sl_Statistics`.`statsID` = 1;


*/



 ?>
</p>
<p>&nbsp;</p>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">StatsID:</td>
      <td><?php echo $row_rsSLStatsUpdate['statsID']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">TitlesCount:</td>
      <td><input type="text" name="TitlesCount" value="<?php echo htmlentities($row_rsSLStatsUpdate['TitlesCount'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">ShotsSum:</td>
      <td><input type="text" name="ShotsSum" value="<?php echo htmlentities($row_rsSLStatsUpdate['ShotsSum'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">ShotsCount:</td>
      <td><input type="text" name="ShotsCount" value="<?php echo htmlentities($row_rsSLStatsUpdate['ShotsCount'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">ShotsSumMean:</td>
      <td><input type="text" name="ShotsSumMean" value="<?php echo htmlentities($row_rsSLStatsUpdate['ShotsSumMean'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">ShotsCountMean:</td>
      <td><input type="text" name="ShotsCountMean" value="<?php echo htmlentities($row_rsSLStatsUpdate['ShotsCountMean'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Current Date:</td>
<!--      <td><input type="text" name="LastUpdated" value="<?php echo htmlentities($row_rsSLStatsUpdate['LastUpdated'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>-->
      <td><input type="text" name="LastUpdated" value="<?php echo time(now) ; ?>" size="32" /> <?php echo date("d F Y", time(now)) ; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="statsID" value="<?php echo $row_rsSLStatsUpdate['statsID']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsSLStats);

mysql_free_result($rsSLStatsUpdate);
// calculate the standard deviation in an array.

/*
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

*/?>
