<?php

define('SITE_URL','http://localhost/webshop1/webshop/');

function getConnection() {

	$dbhost="localhost";

	$dbuser="root";

	$dbpass="root";

	$dbname="webshop";

	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
// print_r($dbh);
// exit;
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	return $dbh;

}
//sp


?>