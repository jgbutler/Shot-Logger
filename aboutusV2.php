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
$pageTitle = 'About Us' ; 
include ('includes/headerV2.php') ;
?>
<h1>About Us</h1>
<p>Shot Logger is a service of <a href="http://www.tcf.ua.edu/" target="_blank">the Telecommunication and Film Department</a>, <a href="http://cis.ua.edu/" target="_blank">the College of Communication and Information Sciences</a>, <a href="http://www.ua.edu/" target="_blank">the University of Alabama</a>. It is coded, maintained, and administered by <a href="http://www.tcf.ua.edu/jbutler/" target="_blank">Jeremy Butler</a>, a TCF professor. Shot Logger has been munching on editing data since 16:11 CDT on August 8, 2007, when <a href="TitleListDetailV2.php?recordID=1" target="_blank">shot data from a <em>Friends</em> episode</a> were input into the system. </p>
<p>Version 2.0 of Shot Logger, a major rewrite of its code, went beta on November 1, 2011.</p>

<h2>Current Data</h2>
<ul>
  <li>Films and TV programs logged: 
    <?php
		$TitleCount = number_format($row_rsSLStatsUpdate['TitlesCount']);
		echo $TitleCount; ?> 
  </li>
  <li>Frames captured and individual shots logged: 
    <?php 
		$ShotCount = number_format($row_rsSLStatsUpdate['ShotsCount']);
		//echo $ShotCount; 
		echo number_format($row_rsSLStatsUpdate['ShotsCount'])
		?> 
  </li>
  <li>Average  length of <em>all</em> shots: 
    <?php 
		$meanShotLength = number_format($row_rsSLStatsUpdate['ShotsSumMean'], 2) ;
		echo $meanShotLength; ?> seconds</li>
  <li>Data last updated: <?php echo date("d F Y", $row_rsSLStatsUpdate['LastUpdated']); ?></li>
</ul>
<br />
<h2>The Software</h2>
<p><a href="http://www.cinemetrics.lv/" target="_blank"><img src="images_site/CinemetricsHomepage.jpg" alt="CineMetrics home page" height="200" border="0" /></a><a href="http://www.videolan.org/vlc/" target="_blank"><img src="images_site/VLClogo.png" alt="VLC logo" width="200" height="200" border="0" /></a><br />
Shot Logger was inspired by <a href="http://www.cinemetrics.lv/" target="_blank">CineMetrics</a>, which generously provides the charts displayed here. And it relies heavily on the <a href="http://www.videolan.org/vlc/" target="_blank">VLC Media Player</a>'s ability to capture images from video.</p>
<p>Shot Logger is written in <a href="http://www.php.net/" target="_blank">the PHP scripting language</a> and is powered by <a href="http://www.mysql.com/" target="_blank">a MySQL database</a> and <a href="http://httpd.apache.org/" target="_blank">the Apache Web server</a> -- all of which runs on <a href="http://en.wikipedia.org/wiki/Linux" target="_blank">Linux</a>.</p>
<p><a href="http://www.gnu.org/licenses/gpl.html" target="_blank"><img src="images_site/gplv3-127x51.png" width="127" style="float: left; margin: 0px 15px 15px 0px;" height="51" alt="GNU GPL 3 logo"/></a>Shot Logger is an open-source project and the images stored here are intended for non-commercial, critical, teaching, and scholarship purposes (see our <a href="copyrightV2.php" target="_blank">copyright statement</a>). The Shot Logger code and data are copyrighted &copy;2007-<?php echo date("Y") ; ?> by Jeremy Butler, but they are distributed under <a href="http://www.gnu.org/licenses/gpl.html" target="_blank">the GNU General Public License, Version 3</a>&#8212;meaning that you may make non-commerical use of them as long as you attribute Shot Logger and agree to share your own work under a similar license. </p>
<p>No programming code, data, text, images, or video/sound on ShotLogger.org may be reproduced for commercial purposes. However, educational and other non-commercial uses are permitted, if proper attribution is given.</p>

<?php 
include ('includes/footerV2.php'); // Include the footer
?>
