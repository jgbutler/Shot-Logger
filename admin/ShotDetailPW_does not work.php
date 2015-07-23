<?php // include configuration data for MySQL and Shot Logger login.
require_once('../Connections/ShotLoggerVM.php'); 

// Check to see if user is logged in.

if (isset($_COOKIE['PrivatePageLogin'])) {
   if ($_COOKIE['PrivatePageLogin'] == md5($password.$nonsense)) {

// Insert content below.

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}

?>

<!-- BEGIN PASSWORD-PROTECTED CONTENT HERE -->

<?php
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

mysql_select_db($database_ShotLogger2, $ShotLogger2);
$query_DetailRS1 = sprintf("SELECT * FROM sl_ShotData  WHERE shotID = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysql_query($query_DetailRS1, $ShotLogger2) or die(mysql_error());
$row_DetailRS1 = mysql_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysql_num_rows($DetailRS1);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shot Logger 2: Shot Details</title>
<!--<link href="../../slgallery/shotlogger/shotlogger.css" rel="stylesheet" type="text/css" />-->
<link href="admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1 align="center">Shot Details</h1>
<table border="1" align="center">
  <tr>
    <td colspan="2"><img src="../images/<?php echo $row_DetailRS1['sl_directory']; ?><?php echo $row_DetailRS1['filename']; ?>" alt="Frame Capture" />
    </td>
  </tr>
  <tr>
    <td>Shot Logger shotID</td>
    <td><?php echo $row_DetailRS1['shotID']; ?> </td>
  </tr>
  <tr>
    <td>ShotNumber</td>
    <td><?php echo $row_DetailRS1['ShotNumber']; ?> </td>
  </tr>
  <tr>
    <td>g_id</td>
    <td><?php echo $row_DetailRS1['g_id']; ?> </td>
  </tr>
  <tr>
    <td>filename</td>
    <td><?php echo $row_DetailRS1['filename']; ?> </td>
  </tr>
  <tr>
    <td>sl_directory</td>
    <td><?php echo $row_DetailRS1['sl_directory']; ?> </td>
  </tr>
  <tr>
    <td>g_idOfThumbnail</td>
    <td><?php echo $row_DetailRS1['g_idOfThumbnail']; ?> </td>
  </tr>
  <tr>
    <td>g_parentid</td>
    <td><?php echo $row_DetailRS1['g_parentid']; ?> </td>
  </tr>
  <tr>
    <td>slTitleID</td>
    <td><?php echo $row_DetailRS1['slTitleID']; ?> </td>
  </tr>
  <tr>
    <td>IMDbID</td>
    <td><?php echo $row_DetailRS1['IMDbID']; ?> </td>
  </tr>
  <tr>
    <td>TimeCode</td>
    <td><?php echo $row_DetailRS1['TimeCode']; ?> </td>
  </tr>
  <tr>
    <td>ShotLength</td>
    <td><?php echo $row_DetailRS1['ShotLength']; ?> </td>
  </tr>
  <tr>
    <td>ShotScale</td>
    <td><?php echo $row_DetailRS1['ShotScale']; ?> </td>
  </tr>
  <tr>
    <td>CameraMovement</td>
    <td><?php echo $row_DetailRS1['CameraMovement']; ?> </td>
  </tr>
  <tr>
    <td>Comments</td>
    <td><?php echo $row_DetailRS1['Comments']; ?> </td>
  </tr>
  <tr>
    <td>Keywords</td>
    <td><?php echo $row_DetailRS1['Keywords']; ?> </td>
  </tr>
  <tr>
    <td>SubmittedBy</td>
    <td><?php echo $row_DetailRS1['SubmittedBy']; ?> </td>
  </tr>
  <tr>
    <td>DateSubmitted</td>
    <td><?php echo $row_DetailRS1['DateSubmitted']; ?> </td>
  </tr>
  <tr>
    <td>LastModified</td>
    <td><?php echo $row_DetailRS1['LastModified']; ?> </td>
  </tr>
</table>

<?php 
include ('../includes/footerV2.php'); // Include the footer
?>
<?php
mysql_free_result($DetailRS1);
?>
<!-- END PASSWORD-PROTECTED CONTENT -->

<?php

// Resume checking to see if user is logged in.

   exit;
   } else {
      echo "Bad cookie.";
      exit;
   }
}

if (isset($_GET['p']) && $_GET['p'] == "login") {
	echo "<!doctype html>
		<html>
		<head>
		<meta charset=\"utf-8\">
		<link href=\"../shotloggerV2_datatable.css\" rel=\"stylesheet\" type=\"text/css\" />
		<title>Shot Logger: Login Problem</title>
		<h1>Shot Logger: Login Problem</h1>";
   if ($_POST['user'] != $username) {
      echo "<strong>Sorry. I don't recognize that username.</strong><br />
		<h2>Return to the previous page to try again.</h2>";
      exit;
   } else if ($_POST['keypass'] != $password) {
      echo "<strong>Sorry. Invalid password.</strong>
		<h2>Return to the previous page to try again.</h2>";
      exit;
   } else if ($_POST['user'] == $username && $_POST['keypass'] == $password) {
      setcookie('PrivatePageLogin', md5($_POST['keypass'].$nonsense));
      header("Location: $_SERVER[PHP_SELF]");
   } else {
      echo "<strong>Sorry. You could not be logged in at this time.</strong>";
   }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Shot Logger: Login</title>
<link href="../shotloggerV2_datatable.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>Shot Logger: Administrator Login</h1>

<!-- Begin password form -->

<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=login" method="post">
<label><strong>Username:</strong> <br />
<input type="text" name="user" id="user" /></label><br />
<label><strong>Password:</strong> <br />
<input type="password" name="keypass" id="keypass" /></label>
<p><input type="submit" id="submit" value="Login" /></p>
</form>

<!-- End password form -->

<?php 
include ('../includes/footerV2.php'); // Include the footer
?>
