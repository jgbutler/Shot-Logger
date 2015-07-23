<?php
# FileName="ShotLoggerVM.php"
# Type="MYSQL"
# HTTP="true"
$hostname_ShotLoggerVM = " ";
$database_ShotLoggerVM = " ";
$username_ShotLoggerVM = " ";
$password_ShotLoggerVM = " ";
$ShotLoggerVM = mysql_pconnect($hostname_ShotLoggerVM, $username_ShotLoggerVM, $password_ShotLoggerVM) or trigger_error(mysql_error(),E_USER_ERROR); 

// Shot Logger login

// Administrator username and password. Required only for adding data.
$username = " ";
$password = " ";
// Password hash (any random text string will do)
$nonsense = " ";

?>
