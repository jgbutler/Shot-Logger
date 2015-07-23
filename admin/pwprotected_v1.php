<?php

// Divided into pwheader.php and pwfooter.php

$username = "jbutler";
$password = "logging6534";
$nonsense = "bipdiddlybopboombangboingboing";

if (isset($_COOKIE['PrivatePageLogin'])) {
   if ($_COOKIE['PrivatePageLogin'] == md5($password.$nonsense)) {
?>

<!-- LOGGED-IN CONTENT HERE -->
    
Logged in content!

<!-- END LOGGED-IN CONTENT -->

<?php
   exit;
   } else {
      echo "Bad cookie.";
      exit;
   }
}

if (isset($_GET['p']) && $_GET['p'] == "login") {
   if ($_POST['user'] != $username) {
      echo "Sorry, that username does not match.";
      exit;
   } else if ($_POST['keypass'] != $password) {
      echo "Sorry, that password does not match.";
      exit;
   } else if ($_POST['user'] == $username && $_POST['keypass'] == $password) {
      setcookie('PrivatePageLogin', md5($_POST['keypass'].$nonsense));
      header("Location: $_SERVER[PHP_SELF]");
   } else {
      echo "Sorry, you could not be logged in at this time.";
   }
}
?>


<!-- Begin password form -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shot Logger: Login</title>
<link href="admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>Shot Logger: Administrator Login</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=login" method="post">
<label>Username: <input type="text" name="user" id="user" /></label><br />
<label>Password: <input type="password" name="keypass" id="keypass" /></label><br />
<input type="submit" id="submit" value="Login" />
</form>

<!-- End password form -->

<?php 
include ('../includes/footerV2.php'); // Include the footer
?>
