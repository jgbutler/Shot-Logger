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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shot Logger 2.0</title>
<!--<link href="twoColFixLtHdr.css" rel="stylesheet" type="text/css" />
-->
<link href="twoColFixLtHdr_liquidcolors.css" rel="stylesheet" type="text/css" />
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

</head>
<body>

<div class="container">
  <div class="header"><a href="#"><img src="
  <?php 
  // Insert a random image 
$img4 = getRandomFromArray($files);
  echo $img4 ; ?>
  " alt="Shot Logger Logo" name="Insert_logo" height="80" align="left" id="Insert_logo" style="background: #FFFFFF; display:block;" /></a>
  <a href="#"><img src="
  <?php 
  // Insert a random image 
$img4 = getRandomFromArray($files);
  echo $img4 ; ?>
  " alt="Shot Logger Logo" name="Insert_logo" height="80" align="left" id="Insert_logo" style="background: #FFFFFF; display:block;" /></a> <a href="#"><img src="
  <?php 
  // Insert a random image 
$img4 = getRandomFromArray($files);
  echo $img4 ; ?>
  " alt="Shot Logger Logo" name="Insert_logo" height="80" align="left" id="Insert_logo" style="background: #FFFFFF; display:block;" /></a> <a href="#"><img src="
  <?php 
  // Insert a random image 
$img4 = getRandomFromArray($files);
  echo $img4 ; ?>
  " alt="Shot Logger Logo" name="Insert_logo" height="80" align="left" id="Insert_logo" style="background: #FFFFFF; display:block;" /></a>
  <h1 align="right">Shot Logger v2.0</h1>
  <!-- end .header --></div>
  <div class="sidebar1">
    <ul class="nav">
      <li><a href="index.php">overview</a></li>
      <li><a href="data.php">data</a></li>
      <li><a href="documentation.php">documentation</a></li>
      <li><a href="contact.php">contact</a></li>
      <li><a href="copyright.php">copyright</a></li>
      <li><a href="download.php">download</a></li>
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
  <div class="content">
    <h1>Analyzing Visual Style</h1>

<p>Shot Logger facilitates the analysis of visual style in film and television.</p>

		<p>It contains a gallery of frame captures (individual frames from films and TV programs) and a <a href="data.php">database</a> of editing statistics.</p>

<?php 
//shuffle array
shuffle($files);
 
//select first 20 images in randomized array
$files = array_slice($files, 0, 12);
 
//display images
foreach ($files as $img) {
	// Only include JPEGs. PNGs load too slowly (and they shouldn't be there anwyay).
//	if ( preg_match("/(\.jpg)$/", $img) ) { 
    	echo "<a href=\"$img\" target=\"_blank\"><img src=\"$img\" alt=\"Random thumbnail\" border=\"0\" height=\"100\" /></a> ";
//            } 
}
?>
    <!-- end .content --></div>
  <div class="footer">
    <p>copyright &copy;<?php echo date("Y") ; ?> jeremy butler | tcf department | the university of alabama <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/us/">
<img src="http://i.creativecommons.org/l/by-nc-sa/3.0/us/80x15.png" alt="Creative Commons License" align="absmiddle" style="border-width:0" />
</a></p>
    <!-- end .footer --></div>
  <!-- end .container --></div>
</body>
</html>