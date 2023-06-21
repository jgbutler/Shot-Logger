<?php 
try {
	//Open a connection to the database
    require_once '../LaughLogger/Connections/llconnectPDO.php';
	//The following two lines count the number of results in a manner that works across all database platforms.
	$count = $db->query('SELECT COUNT(*) FROM sl_Title2');
	$totalRows_rsSLTitle = $count->fetchColumn();
	// IF conditional statement prevents the running of the next query if it's been found to be empty in the $count query.
	if ($totalRows_rsSLTitle) {
		// Connect to the database and run a query to return a record set (rs)
		$sql = 'SELECT * FROM sl_Title2 LEFT JOIN `sl_ImdbMap` USING (IMDbID) ORDER BY slTitleID DESC';
		$rsSLTitle = $db->query($sql);
		// Capturing SQL errors
		// Capture an array of errorInfo from the $db object
		$errorInfo = $db->errorInfo();
		// If errorInfo exists, put it in a variable. The THIRD bit of info in the error array [2] is the message.
		if (isset($errorInfo[2])) {
			$error = $errorInfo[2];
		}
	}
// Catch PHP errors
} catch (Exception $e) {
    $error = $e->getMessage();
}

?>
<!-- BEGIN PASSWORD-PROTECTED CONTENT HERE -->
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Shot Logger 2.2: Administration</title>
<link href="admin.css" rel="stylesheet" type="text/css" />
</head>

<body>

<h1 align="center">Shot Logger 2.2: Administration</h1>
<table border="1" align="center">
  <tr>
    <td valign="top"><strong>Stats</strong></td>
  </tr>
  <tr>
    <td valign="top"><ul>
      <li><a href="../images/indexAdmin.php">View listing of uploaded files</a>, for importing data. After uploading a batch of files, <strong>be sure to update XML and downloadable files</strong>.</li>
      <li><a href="../index.php">Go to Shot Logger v2 Home.</a></li>
      <li><strong>Update Data</strong>
        <ul>
          <li><strong><a href="PHPgenerator/index.php" target="_blank">Modify Shot Logger data tables</a></strong> (PHPGenerator LITE--very limited data searching)</li>
          <li><a href="">Update downloadable files!</a></li>
          <li><a href="LLStats.php" target="_blank">Calculate cumulative stats!</a></li>
          <li><em><strong>Manually</strong></em><strong> update the MySQL dump of the entire database</strong></li>
          </ul>
        </li>
    </ul></td>
  </tr>
</table>
<table border="1" class="small" align="center">
  <thead>
  <tr>
    <th width="50%" valign="top" nowrap="nowrap" scope="col">Shot Logger Titles -- Reverse Order<br>
<?php echo $totalRows_rsSLTitle . ' total records.' ; ?>
</th>
    <th width="50%" valign="top" nowrap="nowrap" scope="col">Uploaded Image Directories<br />
      (<a href="../images/indexAdmin.php">details</a>)</th>
  </tr>
  </thead>
  <tr>
    <td width="50%" valign="top"><ul>


		<?php if (isset($error)) { // Check for SQL errors and display them
    		echo "<h2>SQL error: " . $error . ".</h2><hr>";
		}

		while($row_rsSLTitle = $rsSLTitle->fetch()) { ; // WHILE loop
		?>
		<li>
          <a href="FinalizeData.php?slTitleID=<?php echo $row_rsSLTitle['slTitleID']; ?>"><?php echo $row_rsSLTitle['slTitleID']; ?></a>: 
          <em><?php echo $row_rsSLTitle['ImdbTitle'] ?></em>: 
		  <?php echo $row_rsSLTitle['Title']; ?>
		</li>
		<?php } 
		//while ($row_rsLLTitle = mysql_fetch_assoc($rsLLTitle)); ?>
        </ul>

	</td>


    <td width="50%" valign="top">
	<ul>
<?php     
	// Get list of uploaded image directories
	$dir =  '../images' ;
	while($dirs = glob($dir . '/*', GLOB_ONLYDIR)) {
		$dir .= '/*';
		if(!$d) {
			$d=$dirs;
		} else {
			$d=array_merge($d,$dirs);
		}
	}
	//	print_r($d);
	natcasesort($d);
	foreach($d as $file)  
	{  
		echo "<li><strong>$file</strong> - " . date ("F d Y", filemtime($file)) . "</li>";
	} 
?>    
	</ul>
    </td>
  </tr>
</table>

<!-- END PASSWORD-PROTECTED CONTENT HERE -->


<?php 
include ('../includes/footerV2.php'); // Include the footer
?>
