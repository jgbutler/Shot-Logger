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

$stmt = $db->prepare("SELECT Title FROM sl_Title2 WHERE slTitleID = ?");
if ($stmt->execute(array($_GET['recordID']))) {
  $row_rsSLTitle = $stmt->fetch();
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Shot Logger 2.2: <?php echo $row_rsSLTitle['Title']; ?></title>
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
<h2>Shot List for <em><?php echo $row_rsSLTitle['Title']; ?></em> </h2>
<p><?php 
// Query to count the number of rows in an array

$stmt = $db->prepare("SELECT * FROM sl_ShotData WHERE slTitleID = ? ORDER BY TimeCode ASC");
if ($stmt->execute(array($_GET['recordID']))) {
	$rows = $stmt->fetchAll();
	$totalRows_rsShotList = count($rows);
}
echo $totalRows_rsShotList ?> shots total.</p>

<table width="600" border="1" align="center">
  <tr>
    <td><strong>Shot #</strong></td>
    <td><strong>Time Code</strong></td>
    <td><strong>Click to view details</strong></td>
    <td><strong>Shot Length</strong></td>
    <td><strong>Shot Scale</strong></td>
    <td><strong>Camera Movement</strong></td>
    <td><strong>Comments</strong></td>
  </tr>
  <?php 
  // Query to SELECT all shot data from sl_ShotData

$stmt = $db->prepare("SELECT * FROM sl_ShotData WHERE slTitleID = ? ORDER BY TimeCode ASC");
	if ($stmt->execute(array($_GET['recordID']))) {
		$row_rsShotList = $stmt->fetch();
}

// Loop through all the shots.
  $ShotNumber = 1 ;
do { ?>
    <tr>
		<td align="center"><?php 
		if  ($row_rsShotList['ShotNumber']) {
			echo $row_rsShotList['ShotNumber'] ;
		}
		else {

			// ROUTINE TO ADD SHOT NUMBERS TO DATABASE
			// COMMENTED OUT
			// $ShotNumber IS ALREADY ADDED DURING THE IMPORT PROCESS, IN InsertShotDataPW.php
			
			/*
			echo $ShotNumber ; 

			// UPDATE SHOT NUMBER IN DATABASE
			$updateSQL = sprintf("UPDATE sl_ShotData SET ShotNumber=%s WHERE shotID=%s",
							   GetSQLValueString($ShotNumber, "int"),
							   GetSQLValueString($row_rsShotList['shotID'], "int"));
			
			mysql_select_db($database_ShotLogger2, $ShotLogger2);
			$Result2 = mysql_query($updateSQL, $ShotLogger2) or die(mysql_error());

			// Increment shot number
			$ShotNumber = $ShotNumber + 1 ;


*/
}
		?></td>
      <td><b><?php echo gmdate("H:i:s", $row_rsShotList['TimeCode']) . '</b><br>' ;
	  echo '(' . $row_rsShotList['TimeCode']; ?> seconds)</td>
      <td><a href="ShotListDetailV2.php?recordID=<?php echo $row_rsShotList['shotID']; ?>">
        <img src="images/<?php echo $row_rsShotList['sl_directory'] . $row_rsShotList['filename']; ?>" alt="Frame grab: <?php echo $row_rsShotList['filename']; ?>" height="150" border="0" /> </a>
      </td>
      <td><?php echo $row_rsShotList['ShotLength']; ?> secs.</td>
      <td><?php echo $row_rsShotList['ShotScale']; ?></td>
      <td><?php echo $row_rsShotList['CameraMovement']; ?></td>
      <td><?php echo $row_rsShotList['Comments']; ?></td>
    </tr>
    <?php } while ($row_rsShotList = $stmt->fetch()) ;	?>


</table>
<?php 
include ('includes/footerV2.php') ;
?>
