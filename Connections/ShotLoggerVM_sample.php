<?php
/*
    Shot Logger facilitates the analysis of visual style in film and television 
	through screen shots and editing statistics.
    Copyright (C) 2007-2023 Jeremy Butler, professor emeritus, Film and TV Studies,
	The University of Alabama.

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

# FileName="ShotLoggerVM.php"
# Type="MYSQL"
# HTTP="true"
# 
# Fill in specifics for your MySQL database below:

$hostname = " ";
$database = " ";
$username = " ";
$password = " ";

// "The Data Source Name, or DSN, contains the information required to connect to the database."
// http://php.net/manual/en/pdo.construct.php
$dsn = 'mysql:host=' . $hostname . ';dbname=' . $database;
// Initiate a new database connection, with the username and password
// Added line about utf8 after results had missing characters.
$db = new PDO($dsn, $username, $password,
	 array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

// Shot Logger login

// Fill in administrator username and password. Required only for adding data.
$username = " ";
$password = " ";
// Password hash (any random string will do)
$nonsense = " ";

?>
