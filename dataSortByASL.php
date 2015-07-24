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

mysql_select_db($database_ShotLoggerVM, $ShotLoggerVM);
$query_rsTitleListing = "SELECT * FROM sl_Title2  LEFT JOIN `sl_ImdbMap`  USING (IMDbID)  ORDER BY `AverageShotLength` ASC";
$rsTitleListing = mysql_query($query_rsTitleListing, $ShotLoggerVM) or die(mysql_error());
$row_rsTitleListing = mysql_fetch_assoc($rsTitleListing);
$totalRows_rsTitleListing = mysql_num_rows($rsTitleListing);

mysql_select_db($database_ShotLoggerVM, $ShotLoggerVM);
// WORKS: $query_rsNewStats = "SELECT * FROM sl_Title2";
$query_rsNewStats = "SELECT * FROM sl_Title2 LEFT JOIN `sl_ImdbMap` USING (IMDbID) ORDER BY `slTitleID` DESC";
$rsNewStats = mysql_query($query_rsNewStats, $ShotLoggerVM) or die(mysql_error());
$row_rsNewStats = mysql_fetch_assoc($rsNewStats);
$totalRows_rsNewStats = mysql_num_rows($rsNewStats);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:spry="http://ns.adobe.com/spry">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shot Logger 2.0: Data Table</title>
<link href="twoColLiqLtHdr.css" rel="stylesheet" type="text/css" />
<?php 
// Function by frasq at frasq dot org, http://php.net/manual/en/function.readdir.php
function listdir($dir='.') { 
    if (!is_dir($dir)) { 
        return false; 
    } 
    
    $files = array(); 
    listdiraux($dir, $files); 

    return $files; 
} 

function listdiraux($dir, &$files) { 
    $handle = opendir($dir); 
    while (($file = readdir($handle)) !== false) { 
        if ($file == '.' || $file == '..') { 
            continue; 
        } 
        $filepath = $dir == '.' ? $file : $dir . '/' . $file; 
        if (is_link($filepath)) 
            continue; 
        if (is_file($filepath)) 
            $files[] = $filepath; 
        else if (is_dir($filepath)) 
            listdiraux($filepath, $files); 
    } 
    closedir($handle); 
} 

// Set directory to list files from
$files = listdir('images'); 

// Function to select a random item from an array
function getRandomFromArray($ar) { 
    mt_srand( (double)microtime() * 1000000 ); 
    $num = array_rand($ar); 
    return $ar[$num]; 
} 
// Get a random image from the $files array

?>
<!-- Load JavaScript for Google chart visualization. -->
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
  google.load('visualization', '1', {packages: ['table']});
</script>
<script type="text/javascript">
    function drawVisualization() {
      // Create and populate the data table named "data".
      var data = google.visualization.arrayToDataTable([
	  // Set column headers
        ['SL ID #', 'IMDb ID #', 'Movie or TV Program<br>(Click title for IMDb)', 'SL Title<br>(Click title for more data)', 'Episode Date', 'Movie Date', 'Length', 'MSL', 'ASL', 'Max SL'],
		// Enter data
        <?php
        do { // Create rows for data entry. Quotation marks around strings, but not around numbers.
            echo " [ 
			{$row_rsNewStats['slTitleID']}, 
			\"{$row_rsNewStats['IMDbID']}\", 
			\"{$row_rsNewStats['ImdbTitle']}\", 
			\"{$row_rsNewStats['Title']}\", 
			\"{$row_rsNewStats['EpisodeDate']}\", 
			{$row_rsNewStats['MovieDate']}, 
			{$row_rsNewStats['Length']}, 
			{$row_rsNewStats['MedianShotLength']}, 
			{$row_rsNewStats['AverageShotLength']}, 
			{$row_rsNewStats['MaximumSL']} ], 
			\n\t";
        } while ($row_rsNewStats = mysql_fetch_assoc($rsNewStats)); 
        ?>
      ]);

    // Create and draw the visualization.
	var table = new google.visualization.Table(document.getElementById('patternformat_div'));
	
	// apply formatting
	// formatter.format(dataTable, srcColumnIndices, opt_dstColumnIndex)
	// formatter docs are here https://developers.google.com/chart/interactive/docs/reference#formatters
	
	// Important!
	// In the 'var formatter' parameters, the numbers refer to the array numbers in the formatter.format parameter and NOT to the columns in the
	// data table!!! And all the numbers assume zero to be the FIRST number. This is what is meant in the docs, when it says:
	
	// "Embed placeholders in your string to indicate a value from another column to embed. 
	//  The placeholders are {#}, where # is the index of a source column to use. 
	//  The index is an index in the srcColumnIndices array from the format() method below."
	
	// Thus: in the following example, [1, 1] means that the SECOND column from the data table should be used.
	// And the {0} and {1} pull the data from the [1, 1] array -- meaning that the {0} pulls the FIRST number and the {1} pulls the SECOND number!
	
	var formatter = new google.visualization.PatternFormat('<a href="http://www.imdb.com/title/{0}/">{1}</a>');
	formatter.format(data, [1, 2], 2);  // parameters are dataTable, source columns (in square brackets) and destination column
	
	var formatter2 = new google.visualization.PatternFormat('<a href="TitleListDetail.php?recordID={0}">{1}</a>');
	formatter2.format(data, [0, 3], 3); 
	
	// Had to move this formatter to the last position. Otherwise, it changes the data in column zero.
	// Then I realized it was irrelevant and I commented it out.
	
	//var formatter3 = new google.visualization.PatternFormat('<a href="../TitleListDetailV2.php?recordID={0}">{1}</a>');
	//formatter3.format(data, [0, 0], 0); 
	
	var view = new google.visualization.DataView(data);
	view.setColumns([2,3,4,5,6,7,8,9]); // Create a view without the first and second columns (column zero and one).
	
	table.draw(view, {allowHtml: true}); // allow HTML code to be inserted into table 
    }
    
    google.setOnLoadCallback(drawVisualization);


</script>
</head>
<body>

<!--Google Analytics-->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36880052-1']);
  _gaq.push(['_setDomainName', 'shotlogger.org']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<!-- start .header -->
<div class="container">
  <div class="header"><a href="/index.php"><img src="images_site/LogoV2.png" name="Insert_logo" width="400" height="80" border="0" align="left" id="Insert_logo" style="display:block;" /><img src="
  <?php 
  // Insert a random image 
$img4 = getRandomFromArray($files);
  echo $img4 ; ?>
  " alt="Shot Logger Logo" name="Insert_logo" height="80" align="left" class="image_framed" id="Insert_logo" style="background: #FFFFFF; display:block;" /></a>
  <a href="/index.php"><img src="
  <?php 
  // Insert a random image 
$img4 = getRandomFromArray($files);
  echo $img4 ; ?>
  " alt="Shot Logger Logo" name="Insert_logo" height="80" align="left" class="image_framed" id="Insert_logo" style="background: #FFFFFF; display:block;" /></a> <a href="/index.php"><img src="
  <?php 
  // Insert a random image 
$img4 = getRandomFromArray($files);
  echo $img4 ; ?>
  " alt="Shot Logger Logo" name="Insert_logo" height="80" align="left" class="image_framed" id="Insert_logo" style="background: #FFFFFF; display:block;" /></a> 
  <!-- end .header --></div>
  <!-- start .sidebar1 -->
  <div class="sidebar1">
    <ul class="nav">
<!--      <li><a href="/index.php">overview</a></li>-->
      <li><a href="data.php">data</a></li>
      <li><a href="images/index.php">image gallery</a></li>
      <li><a href="aboutusV2.php">about us</a></li>
      <li><a href="documentationV2.php">documentation</a></li>
      <li><a href="notesV2.php">to-do list</a></li>
      <li><a href="contactV2.php">contact</a></li>
      <li><a href="copyrightV2.php">copyright</a></li>
      <li><a href="downloadV2.php">download</a></li>
    </ul>
    <p>A service of the Telecommunication and Film Department, the University of Alabama.</p>
<p><strong>Related sites:</strong><br />
<a href="http://www.cinemetrics.lv/" target="_blank">CineMetrics<br />
</a><a href="http://www.tvcrit.com/" target="_blank">TVCrit.com<br />
</a><a href="http://www.screensite.org/" target="_blank">ScreenSite</a>
      </p>
	<p><strong>Related Software:</strong><br />
<a href="http://www.videolan.org/vlc/" target="_blank"> VLC Media Player</a><br />
<a href="http://gallery.menalto.com/" target="_blank">Gallery 2</a></p>
    <!-- end .sidebar1 --></div>
  <!-- start .content -->
  <div class="content">
<h1>Summary Data Table<!-- Created by Spry--></h1>
 <p>All time measurements are in seconds. &quot;MSL&quot; = &quot;median shot length&quot; and &quot;ASL&quot; = &quot;average shot length&quot;. Some TV shows are divided into several parts (to cope with commercial breaks). </p>
 <h2><em>Sorted by ASL (Average Shot Length).</em></h2>
 <p><strong>Click a heading to change the sorting order.</strong></p>
 <p><strong>Click an &quot;<em>SL Title</em>&quot; link to see more Shot Logger data about that program or film.</strong></p>

<!--Load data table rom Google.-->
<!--<div id="patternformat_div"></div>-->


<!--Load via Dreamweaver master-detail set.-->


<table border="1" align="center">
  <tr>
    <td valign="top"><a href="data.php">IMDb Title</a><br />
      (click for IMBd info)</td>
    <td valign="top"><a href="dataSortBySLTitle.php">SL Title</a><br />
      (click for SL data)</td>
    <td valign="top"><a href="dataSortByEpisodeDate.php">Episode Date</a></td>
    <td valign="top"><a href="dataSortByMovieDate.php">Movie Date</a></td>
    <td valign="top"><a href="dataSortByASL.php">ASL</a></td>
    <td valign="top"><a href="dataSortByMSL.php">MSL</a></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="http://www.imdb.com/title/<?php echo $row_rsTitleListing['IMDbID']; ?>" target="_blank"><?php echo $row_rsTitleListing['ImdbTitle']; ?></a></td>
      <td><a href="TitleListDetail.php?recordID=<?php echo $row_rsTitleListing['slTitleID']; ?>"><?php echo $row_rsTitleListing['Title']; ?></td>
      <td><?php echo $row_rsTitleListing['EpisodeDate']; ?></td>
      <td><?php echo $row_rsTitleListing['MovieDate']; ?></td>
      <td><?php echo $row_rsTitleListing['AverageShotLength']; ?></td>
      <td><?php echo $row_rsTitleListing['MedianShotLength']; ?></td>
    </tr>
    <?php } while ($row_rsTitleListing = mysql_fetch_assoc($rsTitleListing)); ?>
</table>
<br />
<?php echo $totalRows_rsTitleListing ?> Records Total
<?php 
include ('includes/footerV2.php') ;
?>
<?php
mysql_free_result($rsTitleListing);
?>
