<?php  
/*
    Shot Logger facilitates the analysis of visual style in film and television 
	through screen shots and editing statistics.
    Copyright (C) 2007-2020 Jeremy Butler.
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
/*
This header include does NOT work for pages with complicated header
information: data.php and TitleListDetailV2.php
*/

try {
		// Connect to the database and run a query to return a record set (rs)
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


// Get a random image from the $files array
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
        // Check to make sure they're JPEGs and not PNGs, which slow things down
		if ( preg_match("/(\.jpg)$/", $filepath) )
			// Previous code:
			//        if (is_file($filepath)) 
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

// Alternative random-image-selector script
//Function from https://www.dyn-web.com/code/random-image-php/
/*
$root = '';
$path = 'images/2001/';

$imgList = getImagesFromDir($root . $path);
$img = getRandomFromArray($imgList);

function getImagesFromDir($path) {
    $images = array();
    if ( $img_dir = @opendir($path) ) {
        while ( false !== ($img_file = readdir($img_dir)) ) {
            // checks for gif, jpg, png
            if ( preg_match("/(\.gif|\.jpg|\.png)$/", $img_file) ) {
                $images[] = $img_file;
            }
        }
        closedir($img_dir);
    }
    return $images;
}

function getRandomFromArray($ar) {
    $num = array_rand($ar);
    return $ar[$num];
}

*/

// Function to format file sizes
function format_bytes($size) {
    $units = array(' B', ' KB', ' MB', ' GB', ' TB');
    for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
    return round($size, 1).$units[$i];
}
$row_rsSLStatsUpdate = $rsSLStatsUpdate->fetch() ;

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Shot Logger 2.2: <?php echo $pageTitle ?></title>
<link href="twoColFixLtHdr_liquidcolors.css" rel="stylesheet" type="text/css" />

</head>
<body>
<!--Google Analytics-->
<?php // include_once("Connections/GoogleAnalytics.js") ?>

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
  " alt="Shot Logger Logo" name="Insert_logo" height="80" align="left" class="image_framed" id="Insert_logo" style="background: #FFFFFF; display:block;" /></a>   <!-- end .header --></div>
  <!-- start .sidebar1 -->
  <div class="sidebar1">
    <ul class="nav">
<!--      <li><a href="/index.php">overview</a></li>-->
      <li><a href="data.php">data</a></li>
      <li><a href="images/">image gallery</a></li>
      <li><a href="aboutusV2.php">about us</a></li>
      <li><a href="research.php">research</a></li>
      <li><a href="documentationV2.php">documentation</a></li>
      <li><a href="notesV2.php">to-do list</a></li>
      <li><a href="contactV2.php">contact</a></li>
      <li><a href="copyrightV2.php">copyright</a></li>
      <li><a href="downloadV2.php">download</a></li>
    </ul>
    <p>Formerly supported by the Telecommunication and Film Department and <a href="https://cis.ua.edu/" target="_blank">the  College of Communication and Information Sciences</a>, at <a href="https://ua.edu/" target="_blank">the University of Alabama</a>.</p>
<p><strong>Related sites:</strong><br />
<a href="http://laughlogger.org/" target="_blank">Laugh Logger</a><br />
<a href="http://cinemetrics.lv/" target="_blank">CineMetrics</a><br />
<a href="http://tvcrit.com/" target="_blank">TVCrit.com</a><br />
<a href="http://screensite.org/" target="_blank">ScreenSite</a>
      </p>
	<p><strong>Related Software:</strong><br />
<a href="http://www.videolan.org/vlc/" target="_blank"> VLC Media Player</a></p>
    <!-- end .sidebar1 --></div>
  <!-- start .content -->
  <div class="content">
