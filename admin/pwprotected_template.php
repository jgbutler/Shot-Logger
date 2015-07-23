<?php // include configuration data for MySQL and Shot Logger login.
require_once('../Connections/ShotLoggerVM.php'); 

// Check to see if user is logged in.

if (isset($_COOKIE['PrivatePageLogin'])) {
   if ($_COOKIE['PrivatePageLogin'] == md5($password.$nonsense)) {

// Insert content below.

?>

<!-- BEGIN PASSWORD-PROTECTED CONTENT HERE -->

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
