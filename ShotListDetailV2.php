<?php require_once('../Connections/ShotLogger2.php'); 
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

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysql_select_db($database_ShotLogger2, $ShotLogger2);
$query_DetailRS1 = sprintf("SELECT * FROM sl_ShotData  WHERE shotID = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysql_query($query_DetailRS1, $ShotLogger2) or die(mysql_error());
$row_DetailRS1 = mysql_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysql_num_rows($DetailRS1);

// Get EXIF data out of image file
$jpegfile = 'images/' . $row_DetailRS1['sl_directory'] . $row_DetailRS1['filename'] ;
$exif = exif_read_data($jpegfile, 0, true);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shot Logger 2.0: <?php echo $row_DetailRS1['filename']; ?></title>
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
    <td colspan="2"><img src="images/<?php echo $row_DetailRS1['sl_directory'] . $row_DetailRS1['filename']; ?>" <?php echo $exif['COMPUTED']['html'] ?> alt="Frame grab: <?php echo $row_DetailRS1['filename']; ?>" /></td>
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
  <tr>
    <td><strong>Image Size (pixels) &amp;<br />
      Aspect Ratio
    </strong></td>
    <td><?php 
	echo  $exif['COMPUTED']['Width'] . ' x ' . $exif['COMPUTED']['Height'] . ' pixels<br />' . round($exif['COMPUTED']['Width']/$exif['COMPUTED']['Height'], 2) . ' to 1';
	?>
    </td>
  </tr>
  <tr>
    <td><strong>Image Captured On</strong></td>
    <td><?php echo $exif['IFD0']['DateTime']  ;
	 ?>
    </td>
  </tr>
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
  <tr>
    <td><strong>EXIF data</strong></td>
    <td><?php 
//	$jpegfile = 'images/' . $row_DetailRS1['sl_directory'] . $row_DetailRS1['filename'] ;
//	echo $jpegfile ;
//	$exif = exif_read_data($jpegfile, 'IFD0');
//echo $exif===false ? "No header data found.<br />\n" : "Image contains headers<br />\n";
//	$exif = exif_read_data($jpegfile, 0, true);

//	echo 'A single EXIF datum = '. $exif['COMPUTED']['html'] . '<br>';

	foreach ($exif as $key => $section) {
		foreach ($section as $name => $val) {
			echo "$key.$name: $val<br />\n";
//			echo "$name: $val<br />\n";		}
		}
	}
	?>
	</td>
  </tr>
</table>
<?php 
include ('includes/footerV2.php') ;
mysql_free_result($DetailRS1);
?>