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

// Retrieve statistics for a Shot Logger title, based on $_GET['recordID']
// Parametized code prevents SQL injections.
// See "Fetching data using prepared statements": https://www.php.net/manual/en/pdo.prepared-statements.php

$stmt = $db->prepare("SELECT * FROM sl_Title2 WHERE slTitleID = ?");
if ($stmt->execute(array($_GET['recordID']))) {
  $row_DetailRS1 = $stmt->fetch();
}

// Retrieve list of shots for a Shot Logger title, based on $_GET['recordID']

$stmt = $db->prepare("SELECT * FROM sl_ShotData WHERE slTitleID = ? ORDER BY TimeCode ASC");
if ($stmt->execute(array($_GET['recordID']))) {
  $row_ShotListing = $stmt->fetch();
//  echo $row_rsShotListing['sl_directory'] ;
}

// ListDir function by frasq at frasq dot org, http://php.net/manual/en/function.readdir.php
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

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shot Logger 2.0: <?php echo $row_DetailRS1['Title']; ?></title>
<link href="twoColLiqLtHdr.css" rel="stylesheet" type="text/css" />
</head>

<body>
<!-- start .header -->
<div class="container">
  <div class="header"><a href="/index.php"><img src="images_site/LogoV2.png" name="Insert_logo" width="400" height="80" border="0" align="left" id="Insert_logo" style="display:block;" /><img src="
  <?php 
  // Insert a random image from the $files array
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
    <p>Formerly a service of the Telecommunication and Film Department, <a href="https://cis.ua.edu/" target="_blank">the  College of Communication and Information Sciences</a>, at <a href="https://ua.edu/" target="_blank">the University of Alabama</a>.</p>
    <p><strong>Related sites:</strong><br />
      <a href="http://laughlogger.org/" target="_blank">Laugh Logger</a><br />
      <a href="http://cinemetrics.lv/" target="_blank">CineMetrics</a><br />
      <a href="http://tvcrit.com/" target="_blank">TVCrit.com</a><br />
      <a href="http://screensite.org/" target="_blank">ScreenSite</a></p>
    <p><strong>Related Software:</strong><br />
  <a href="http://www.videolan.org/vlc/" target="_blank"> VLC Media Player</a><br />
  <a href="http://gallery.menalto.com/" target="_blank">Gallery 2</a></p>
    <!-- end .sidebar1 --></div>
  <!-- start .content -->
<div class="content">

<!--<div class="content_wide">-->

<h1>Title Detail - <em><?php echo $row_DetailRS1['Title'];  ?></em></h1>
<table width="600">

<!-- Extraneous table cells...
  <tr>
    <td>slTitleID</td>
    <td><?php echo $row_DetailRS1['slTitleID']; ?></td>
  </tr>
  <tr>
    <td>sl_directory</td>
    <td><?php echo $row_DetailRS1['sl_directory']; ?></td>
  </tr>
  <tr>
    <td>IMDbID</td>
    <td><?php echo $row_DetailRS1['IMDbID']; ?></td>
  </tr>
  <tr>
    <td>EpisodeDate</td>
    <td><?php echo $row_DetailRS1['EpisodeDate']; ?></td>
  </tr>
  <tr>
    <td>MovieDate</td>
    <td><?php echo $row_DetailRS1['MovieDate']; ?></td>
  </tr>
-->
  <?php if ($row_DetailRS1['MovieDate'] < 1 ) { // Show if this title does not have a movie date and thus is likely a TV ep 
	?>
  <tr>
    <td align="right" valign="top"><strong>Date (YYYY-MM-DD)</strong></td>
    <td><?php echo $row_DetailRS1['EpisodeDate']; ?> <br />
      (original broadcast)</td>
	<td>&nbsp;</td>
    </tr>
  <?php } else { // End show if recordset not empty ?>
  <tr>
    <td align="right" valign="top"><strong>Date</strong></td>
    <td><?php echo $row_DetailRS1['MovieDate']; ?></td>
	<td>&nbsp;</td>
    </tr>
  <?php } // End show if recordset not empty ?>
  <tr>
    <td align="right"><strong>Length</strong></td>
    <td><?php echo $row_DetailRS1['Length']; ?></td>
    <td rowspan="23" valign="top"><a href="ShotListV2.php?recordID=<?php echo $_GET['recordID'] ?>">View list of all shots.</a><br />
      <?php 
        //display sample images
		if ($row_DetailRS1['sl_directory'] != NULL) {
			$SLdir = 'images/' . $row_DetailRS1['sl_directory'] ;
			$files = listdir($SLdir); 
			
				if  ( is_array($files) ) {

					//shuffle array
					shuffle($files);
					//select first 20 images in randomized array
					$files = array_slice($files, 0, 5);

					foreach ($files as $img) {
		//					Attempted to link from random image to its ShotListDetailV2.php page, but it doesn't work as $shotID is not unique
							echo "<a href=\"$img\" target=\"_blank\"><img src=\"$img\" alt=\"Random thumbnail\" border=\"0\" class=\"image_framed\" height=\"100\" /></a> <br> ";
							}

				} else {

					echo '$ files is not an array';

				}
			
		}
        ?></td>
    </tr>
  <tr>
    <td align="right"><strong>Number of Shots</strong></td>
    <td><?php echo $row_DetailRS1['ShotTotal']; ?></td>
    </tr>
  <tr>
    <td align="right"><strong><a href="http://en.wikipedia.org/wiki/Average" target="_blank">Average Shot Length (ASL)</a></strong></td>
    <td><?php echo $row_DetailRS1['AverageShotLength']; ?></td>
    </tr>
  <tr>
    <td align="right"><strong><a href="http://en.wikipedia.org/wiki/Median" target="_blank">Median Shot Length (MSL)</a></strong></td>
    <td><?php echo $row_DetailRS1['MedianShotLength']; ?></td>
    </tr>
  <tr>
    <td align="right"><strong>MSL/ASL</strong></td>
    <td><?php echo $row_DetailRS1['MSL_ASL']; ?></td>
    </tr>
  <tr>
    <td align="right"><strong><a href="http://en.wikipedia.org/wiki/Mode_(statistics)" target="_blank">Mode(s)</a></strong></td>
    <td><?php echo $row_DetailRS1['Mode']; ?></td>
    </tr>
  <tr>
    <td align="right"><strong>MinimumShot Length</strong></td>
    <td><?php echo $row_DetailRS1['MinimumSL']; ?></td>
    </tr>
  <tr>
    <td align="right"><strong>MaximumShot Length</strong></td>
    <td><?php echo $row_DetailRS1['MaximumSL']; ?></td>
    </tr>
  <tr>
    <td align="right"><strong>Range</strong></td>
    <td><?php echo $row_DetailRS1['Range']; ?></td>
  </tr>
  <tr>
    <td align="right"><strong><a href="http://en.wikipedia.org/wiki/Standard_deviation" target="_blank">Standard Deviation</a></strong></td>
    <td><?php echo $row_DetailRS1['StandardDeviation']; ?></td>
  </tr>
  <tr>
    <td align="right"><strong><a href="http://en.wikipedia.org/wiki/Coefficient_of_variation" target="_blank">Coefficient of Variation (CV)</a></strong></td>
    <td><?php echo $row_DetailRS1['CV']; ?></td>
    </tr>
  <tr>
    <td align="right"><strong><a href="http://en.wikipedia.org/wiki/Skewness" target="_blank">Skewness</a></strong></td>
    <td><?php echo $row_DetailRS1['Skewness']; ?></td>
    </tr>
  <tr>
    <td align="right"><strong><a href="http://en.wikipedia.org/wiki/Kurtosis" target="_blank">Kurtosis</a></strong></td>
    <td><?php echo $row_DetailRS1['Kurtosis']; ?></td>
    </tr>
  <tr>
    <td align="right"><strong><a href="http://en.wikipedia.org/wiki/Quartile" target="_blank">First Quartile</a></strong></td>
    <td><?php echo $row_DetailRS1['Q1']; ?></td>
    </tr>
  <tr>
    <td align="right"><strong><a href="http://en.wikipedia.org/wiki/Quartile" target="_blank">Second Quartile</a></strong></td>
    <td><?php echo $row_DetailRS1['MedianShotLength']; ?></td>
    </tr>
  <tr>
  <tr>
    <td align="right"><strong><a href="http://en.wikipedia.org/wiki/Quartile" target="_blank">Third Quartile</a></strong></td>
    <td><?php echo $row_DetailRS1['Q3']; ?></td>
    </tr>
  <tr>
    <td align="right"><strong><a href="http://en.wikipedia.org/wiki/Interquartile_range" target="_blank">Interquartile Range (IQR)</a></strong></td>
    <td><?php echo $row_DetailRS1['IQR']; ?></td>
    </tr>
  <tr>
    <td align="right"><strong><a href="http://en.wikipedia.org/wiki/Variance" target="_blank">Variance</a></strong></td>
    <td><?php echo $row_DetailRS1['Variance']; ?></td>
    </tr>
  <tr>
    <td align="right"><strong>Comments</strong></td>
    <td><?php echo $row_DetailRS1['Comments']; ?></td>
    </tr>
  <tr>
    <td align="right"><strong>Keywords</strong></td>
    <td><?php echo $row_DetailRS1['Keywords']; ?></td>
    </tr>
  <tr>
    <td align="right" valign="top"><strong>IMDb Title</strong></td>
    <td>
	<?php // Find IMDb title and link to it
	$stmt = $db->prepare("SELECT * FROM sl_ImdbMap WHERE IMDbID = ?");
	if ($stmt->execute(array($row_DetailRS1['IMDbID']))) {
		do { ?>
			<a href="http://us.imdb.com/title/<?php echo $row_DetailRS1['IMDbID']; ?>" target="_blank"><em><?php echo $row_rsIMDbTitle['ImdbTitle'] ?></em></a>
			<?php
		} while ($row_rsIMDbTitle = $stmt->fetch()) ;
	}
	?>
	</td>
  </tr>
  <tr>
    <td align="right" valign="top"><strong>Date Submitted</strong></td>
    <td><?php 
	if ($row_DetailRS1['DateSubmitted']) {
		echo date("Y-m-d H:i", $row_DetailRS1['DateSubmitted']) ;
	} else {
		echo date("Y-m-d H:i", $row_DetailRS1['LastModified']) ;
	}
		?></td>
  </tr>
  </table>
<p></p>

<!--Display Cinemetics Chart-->

<table width="600" border="0">
  <tr>
    <td align="center"><p><strong><s>Shot-Length Graph</s><br />
	Removed on 13 June 2023 due to incompatibility with current PHP version.</strong></p></td>
  </tr>
</table>

<?php 
include ('includes/footerV2.php') ;
?>
