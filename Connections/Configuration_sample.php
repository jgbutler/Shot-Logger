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

# FileName="ShotLoggerVM.php"
# Type="MYSQL"
# HTTP="true"
# MySQL database required. See /data/download/tcf-shotlogger_Table_Structure_Only.sql.gz for table structure.
# Fill in specifics for your MySQL database below:
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
