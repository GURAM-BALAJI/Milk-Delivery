<?php
 	
$db_host		= 'localhost';
$db_user		= 'milk2delivery';
$db_pass		= 'milk2delivery';
$db_database	= 'milk2delivery';

$link = new PDO('mysql:host='.$db_host.';dbname='.$db_database, $db_user, $db_pass);
$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>