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

      <title>Shot Logger 2.0: VLC Tutorial</title>
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
      <li><a href="../data.php">data</a></li>
      <li><a href="../images/index.php">image gallery</a></li>
      <li><a href="../aboutusV2.php">about us</a></li>
      <li><a href="../documentationV2.php">documentation</a></li>
      <li><a href="../notesV2.php">to-do list</a></li>
      <li><a href="../contactV2.php">contact</a></li>
      <li><a href="../copyrightV2.php">copyright</a></li>
      <li><a href="../downloadV2.php">download</a></li>
    </ul>
    <p>A service of <a href="http://www.tcf.ua.edu/" target="_blank">the Telecommunication and Film Department</a>, <a href="http://cis.ua.edu/" target="_blank">the  College of Communication and Information Sciences</a>, at <a href="http://www.ua.edu/" target="_blank">the University of Alabama</a>.</p>
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
<h1>VLC Tutorial</h1>
      <div id="flashcontent" align="center">	   		
			<div id="cs_noexpressUpdate">
			  <p>The Camtasia Studio video content presented here requires JavaScript to be enabled and the  latest version of the Macromedia Flash Player. If you are you using a browser with JavaScript disabled please enable it now. Otherwise, please update your version of the free Flash Player by <a href="http://www.macromedia.com/go/getflashplayer">downloading here</a>. </p>
		    </div>
	   </div>
      <script type="text/javascript"> 
         var fo = new SWFObject( "VLC and Shot Logger_controller.swf", "csSwf", "800", "499", "9", "#FFFFFF" );
         fo.addVariable( "csConfigFile", "VLC and Shot Logger_config.xml" ); 
         fo.addVariable( "csColor"     , "FFFFFF" );
         fo.addVariable( "csPreloader" , "preload.swf" );
         if( args.movie )
         {
            fo.addVariable( "csFilesetBookmark", args.movie );
         }
         fo.write("flashcontent"); 	
      </script>  		        

<?php 
include ('../includes/footerV2.php');
?>
