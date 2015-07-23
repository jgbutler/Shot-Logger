<?php require_once('Connections/ShotLoggerVM.php'); ?>
<?php
$pageTitle = 'Overview' ; 
include ('includes/headerV2.php');
?>

<h1>Analyzing Visual Style</h1>

<p>Shot Logger facilitates the analysis of visual style in film and television.</p>

		<p>It contains a <a href="data.php">database</a> of editing statistics for  <?php
		echo number_format($row_rsSLStatsUpdate['TitlesCount']) ; ?> instances of <?php echo number_format($row_rsSLStatsUpdate['IMDBTitlesCount']) ; ?> films and TV programs and a gallery of
<?php 
		echo number_format($row_rsSLStatsUpdate['ShotsCount']); ?> frame captures (individual frames from every shot in those films/TV programs). </p>
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
