<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "program_promosi";
mysql_connect ($host,$username,"$password") or die("could not connect to mysql database");
mysql_select_db($database)or die("could not select mysql database");
?>