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

$stmt = $db->prepare("SELECT * FROM sl_ShotData  WHERE shotID = ?");
	if ($stmt->execute(array($_GET['recordID']))) {
		$row_DetailRS1 = $stmt->fetch();
}

// Get EXIF data out of image file

// This ONLY works with certain formats, such as JPEG.
// PNG files will cause an error to be thrown.
// Commenting out these lines. If the format were checked before these lines, then it might not cause error messages.
// All references to $exif below are commented out.

// $jpegfile = 'images/' . $row_DetailRS1['sl_directory'] . $row_DetailRS1['filename'] ;
// $exif = exif_read_data($jpegfile, 0, true);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Shot Logger 2.2: <?php echo $row_DetailRS1['filename']; ?></title>
<link href="twoColLiqLtHdr.css" rel="stylesheet" type="text/css" />
</head>
<body>

<!-- start .header -->
<div class="container">
  <div class="header"><a href="/index.php"><img src="images_site/LogoV2.png" name="Insert_logo" width="400" height="80" border="0" align="left" id="Insert_logo" style="display:block;" /></a> 
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
<h1>Shot Details</h1>
<table border="1" align="center">
  <tr>
    <td colspan="2"><img src="images/<?php echo $row_DetailRS1['sl_directory'] . $row_DetailRS1['filename']; ?>" <?php // echo $exif['COMPUTED']['html'] ?> alt="Frame grab: <?php echo $row_DetailRS1['filename']; ?>" /></td>
  </tr>
  <tr>
    <td><strong>shotID</strong></td>
    <td><?php echo $row_DetailRS1['shotID']; ?></td>
  </tr>
  <tr>
    <td><strong>shot number</strong></td>
    <td><?php echo $row_DetailRS1['ShotNumber']; ?></td>
  </tr>
  <tr>
    <td><strong>filename</strong></td>
    <td><?php echo $row_DetailRS1['filename']; ?></td>
  </tr>
  <tr>
    <td><strong>sl_directory</strong></td>
    <td><?php echo $row_DetailRS1['sl_directory']; ?></td>
  </tr>
  <tr>
    <td><strong>slTitleID</strong></td>
    <td><?php echo $row_DetailRS1['slTitleID']; ?></td>
  </tr>
  <tr>
    <td><strong>IMDbID</strong></td>
    <td><?php echo $row_DetailRS1['IMDbID']; ?></td>
  </tr>
  <tr>
    <td><strong>TimeCode</strong></td>
    <td><?php echo $row_DetailRS1['TimeCode']; ?> secs.</td>
  </tr>
  <tr>
    <td><strong>ShotLength</strong></td>
    <td><?php echo $row_DetailRS1['ShotLength']; ?></td>
  </tr>
  <tr>
    <td><strong>ShotScale</strong></td>
    <td><?php echo $row_DetailRS1['ShotScale']; ?></td>
  </tr>
  <tr>
    <td><strong>CameraMovement</strong></td>
    <td><?php echo $row_DetailRS1['CameraMovement']; ?></td>
  </tr>
  <!--  Commented out this row due to issues with $exif (see above). 6/13/23
	<tr>
    <td><strong>Image Size (pixels) &amp;<br />
      Aspect Ratio
    </strong></td>
    <td><?php 
	// Separate row for PHP had to be commented on 6/14/2023.
	// echo  $exif['COMPUTED']['Width'] . ' x ' . $exif['COMPUTED']['Height'] . ' pixels<br />' . round($exif['COMPUTED']['Width']/$exif['COMPUTED']['Height'], 2) . ' to 1';
	?>
    </td>
  </tr>
  <tr>
    <td><strong>Image Captured On</strong></td>
    <td><?php echo $exif['IFD0']['DateTime']  ;
	 ?>
    </td>
  </tr>-->
  <tr>
    <td><strong>Comments</strong></td>
    <td><?php echo $row_DetailRS1['Comments']; ?></td>
  </tr>
  <tr>
    <td><strong>Keywords</strong></td>
    <td><?php echo $row_DetailRS1['Keywords']; ?></td>
  </tr>
  <tr>
    <td><strong>SubmittedBy</strong></td>
    <td><?php echo $row_DetailRS1['SubmittedBy']; ?></td>
  </tr>
  <tr>
    <td><strong>DateSubmitted</strong></td>
    <td><?php if ($row_DetailRS1['DateSubmitted']) {
	if ($row_DetailRS1['DateSubmitted'] != '0000-00-00 00:00:00') {
	echo strftime ("%c", $row_DetailRS1['DateSubmitted']); 
	} 
	}
	?></td>
  </tr>
  <!-- EXIF data was throwing error messages when the file was PNG format.
		Removed these lines on 6/13/2023
	<tr>
    <td><strong>EXIF data</strong></td>
    <td><?php 
/*	foreach ($exif as $key => $section) {
		foreach ($section as $name => $val) {
			echo "$key.$name: $val<br />\n";
		}
	}
*/
	?>
	</td>
  </tr>-->
</table>
<?php 
include ('includes/footerV2.php') ;
?>