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

require_once('Connections/ShotLoggerVM.php'); 
try {
		// Connect to the database and run a query to return a record set (rs)
		/*$sql = "SELECT * FROM `wp_posts` JOIN wp_postmeta ON meta_id=ID WHERE `meta_key` = 'url' ";*/

        $sql = "SELECT * FROM sl_Statistics";

        $rsSLStatsUpdate = $db->query($sql) ;
		// Get record set as an array
		// Capturing SQL errors 
		// Capture an array of errorInfo from the $db object
		$errorInfo = $db->errorInfo();
		// If errorInfo exists, put it in a variable. The THIRD bit of info in the error array [2] is the message.
		if (isset($errorInfo[2])) {
			$error = $errorInfo[2];
		}
// Catch PHP errors
} catch (Exception $e) {
    $error = $e->getMessage();
}

// Query to count the number of rows in an array
        $q = $db->query($sql);
        $rows = $q->fetchAll();
        $rowCount = number_format(count($rows));

$row_rsSLStatsUpdate = $rsSLStatsUpdate->fetch() ;

$pageTitle = 'Home' ; 
//include ('includes/headerA2.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shot Logger 2.0: <?php echo $pageTitle ?></title>
<link href="twoColFixLtHdr_liquidcolors.css" rel="stylesheet" type="text/css" />

</head>
<body>

<h1>Analyzing Visual Style</h1>

<p>Shot Logger facilitates the analysis of visual style in film and television.</p>

		<p>It contains a <a href="data.php">database</a> of editing statistics for  <?php
		echo number_format($row_rsSLStatsUpdate['TitlesCount']) ;
		//echo $rowCount ;
		?> instances of <?php echo $row_rsSLStatsUpdate['IMDBTitlesCount'] ; ?> films and TV programs and a gallery of
<?php 
		echo number_format($row_rsSLStatsUpdate['ShotsCount']); ?>
 screen shots (individual frames from every shot in those films/TV programs). </p>
<p>One statistic Shot Logger generates is average shot length or ASL. As of <?php echo date("d F Y", $row_rsSLStatsUpdate['LastUpdated']); ?>, the ASL of <?php echo number_format($row_rsSLStatsUpdate['ShotsCount']); ?> logged shots is 
		  <?php 
		echo number_format($row_rsSLStatsUpdate['ShotsSumMean'], 2) ; ?> 
  seconds. ASLs of individual films and TV episodes may be found in <a href="data.php">our data table</a>.</p>
		<p>Randomly selected images from the Shot Logger collection...</p>
<p>
<?php 
//shuffle array
shuffle($files);
 
//select first 20 images in randomized array
$files = array_slice($files, 0, 12);
 
//display images
foreach ($files as $img) {
	// Only include JPEGs. PNGs load too slowly (and they shouldn't be there anwyay).
//	if ( preg_match("/(\.jpg)$/", $img) ) { 
    	echo "<a href=\"$img\" target=\"_blank\"><img src=\"$img\" alt=\"Random thumbnail\" border=\"0\" class=\"image_framed\" height=\"100\" /></a> ";
//            } 
}
?>
</p>
<?php 
include ('includes/footerV2.php');

mysql_free_result($rsIMDbTitles);
?>
