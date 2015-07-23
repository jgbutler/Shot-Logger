<?php 
/*
    Shot Logger facilitates the analysis of visual style in film and television 
	through frame captures and editing statistics.
    Copyright (C) 2008-2011 Jeremy Butler

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
   <head>
<title>Shot Logger 2.0: <?php echo $pageTitle ?></title>
<link href="../twoColFixLtHdr_liquidcolors.css" rel="stylesheet" type="text/css" />
<!--<link href="../twoColLiqLtHdr.css" rel="stylesheet" type="text/css" />-->
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
$files = listdir('../images'); 

// Function to select a random item from an array
function getRandomFromArray($ar) { 
    mt_srand( (double)microtime() * 1000000 ); 
    $num = array_rand($ar); 
    return $ar[$num]; 
} 
// Get a random image from the $files array

?>
      <!-- saved from url=(0025)http://www.techsmith.com/ -->
      <meta name="DC.date" content="Wednesday, September 12, 2007" />
      <meta name="DC.language" content="ENU" />

      <title>Shot Logger 2.0: Downlaoding VLC</title>
      <script type="text/javascript" src="swfobject.js"></script>
      <script type="text/javascript" src="cam_embed.js"></script>
      
      <style type="text/css">
        #cs_flashBody {
        	background-color: white;
        	font-size: 12pt;
        	font-family: verdana,arial,helvetica,sans-serif;
        	/*text-align: center;*/
        }
        #cs_noexpressUpdate {
        	margin: 0 auto;
        	font-family:Arial, Helvetica, sans-serif;
        	font-size: x-small;
        	color: #003300;
        	text-align: left;
        	background-image: url(small_short_nofp_bg.gif);
        	background-repeat: no-repeat;
        	width: 210px; 
        	height: 200px;	
        	padding: 40px;
        }
      </style>
   </head>
   <body id="cs_flashBody" >


<!-- start .header -->
<div class="container">
  <div class="header"><a href="/shotlogger2/index.php"><img src="../images_site/LogoV2.png" name="Insert_logo" width="400" height="80" border="0" align="left" id="Insert_logo" style="display:block;" /><img src="
  <?php 
  // Insert a random image 
$img4 = getRandomFromArray($files);
  echo $img4 ; ?>
  " alt="Shot Logger Logo" name="Insert_logo" height="80" align="left" class="image_framed" id="Insert_logo" style="background: #FFFFFF; display:block;" /></a>
  <a href="/shotlogger2/index.php"><img src="
  <?php 
  // Insert a random image 
$img4 = getRandomFromArray($files);
  echo $img4 ; ?>
  " alt="Shot Logger Logo" name="Insert_logo" height="80" align="left" class="image_framed" id="Insert_logo" style="background: #FFFFFF; display:block;" /></a> <a href="/shotlogger2/index.php"><img src="
  <?php 
  // Insert a random image 
$img4 = getRandomFromArray($files);
  echo $img4 ; ?>
  " alt="Shot Logger Logo" name="Insert_logo" height="80" align="left" class="image_framed" id="Insert_logo" style="background: #FFFFFF; display:block;" /></a>   <!-- end .header --></div>
  <!-- start .sidebar1 -->
  <div class="sidebar1">
    <ul class="nav">
<!--      <li><a href="/shotlogger2/index.php">overview</a></li>-->
      <li><a href="../dataV2.php">data</a></li>
      <li><a href="../images/index.php">image gallery</a></li>
      <li><a href="../aboutusV2.php">about us</a></li>
      <li><a href="../documentationV2.php">documentation</a></li>
      <li><a href="../notesV2.php">to-do list</a></li>
      <li><a href="../contactV2.php">contact</a></li>
      <li><a href="../copyrightV2.php">copyright</a></li>
      <li><a href="../downloadV2.php">download</a></li>
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
<h1>Downloading VLC</h1>
<p>Much as we love VLC, we have to acknolwedge one occasional problem with it. Sometimes updates to VLC manage to break a key function that Shot Logger requires. At least twice during our use of VLC, the ability to insert time-code data into the names of &quot;screen shots&quot; has been busted. </p>
<p>As a safeguard against the problem, we provide (below) the most recent versions of VLC.</p>
<p>Also, although VLC contains no malware, it will take over the playing of <em>all</em> of your audio and video files if you do not un-check certain boxes during installation. Specifically, VLC will give you this choice during installation:</p>
<p><img src="VLC2.0.8Setup_01.jpg" width="513" height="399" alt="VLC set-up screen 1" /></p>
<p>If you do <em>not</em> want VLC to be your computer's default media-playing software, then scroll down in the display box until you see this:</p>
<p><img src="VLC2.0.8Setup_02.jpg" width="513" height="399" alt="VLC setup 2" /></p>
<p>Un-check all the boxes under &quot;File Type Associations.&quot; It will then look like this:</p>
<p><img src="VLC2.0.8Setup_03.jpg" width="513" height="399" alt="VLC setup 3" /></p>
<h2>Download VLC</h2>
<p>Right-click the name of your operating system and then choose to &quot;Save Link as...&quot; or &quot;Save Target...&quot; or something similar. Save the file somewhere you can find later. Then run the file to install VLC.</p>
<ul>
  <li><a href="vlc-2.0.8-win32.exe">Windows (32-bit)</a>; if you don't know what type of Windows you have, choose this one</li>
  <li><a href="vlc-2.0.8-win64.exe">Windows (64-bit)</a></li>
  <li><a href="vlc-2.0.8.dmg">Mac OS</a></li>
</ul>
<?php 
include ('../includes/footerV2.php');
?>
