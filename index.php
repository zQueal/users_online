<?php
require "flight/Flight.php";

# Database Setup #
Flight::register('db', 'PDO', array('mysql:host=localhost;port=3306;dbname=usersonline', 'user_name', 'user_password'), function($db) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
});

Flight::route('/', function() {
	# Connect to Database
	$conn = Flight::db();
	# Configuration
	$timeoutseconds = "300";
	$timestamp = time();
	$timeout = $timestamp-$timeoutseconds;

	# Initial Insert
	$conn->exec("INSERT INTO usersonline VALUES ('$timestamp','$REMOTE_ADDR','$PHP_SELF')");
	# Delete From DB
	$conn->exec("DELETE FROM usersonline WHERE timestamp<'$timeout'");
	# Pull Results
	$count = $conn->exec("SELECT DISTINCT ip FROM usersonline WHERE file='$PHP_SELF'");
	# User Count
	$users = $count->rowCount();

	if($users == "1") {
		print $users." user online.\n";
	} else {
		print $users." users online.\n";
	}
});

Flight::start();
?>