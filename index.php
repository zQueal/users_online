<?php

require "flight/Flight.php";

Flight::register('db', 'PDO', ['mysql:host=localhost;port=3306;dbname=usersonline', 'user_name', 'user_password'], function($db) {
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
});

Flight::route('/', function() {
  $conn = Flight::db();
  $timeoutseconds = "300";
  $timestamp = time();
  $timeout = $timestamp-$timeoutseconds;
  $conn->exec("INSERT INTO usersonline VALUES ('$timestamp','$REMOTE_ADDR','$PHP_SELF')");
  $conn->exec("DELETE FROM usersonline WHERE timestamp<'$timeout'");
  $count = $conn->exec("SELECT DISTINCT ip FROM usersonline WHERE file='$PHP_SELF'");
  $users = $count->rowCount();

  if($users == "1") {
    print $users." user online.\n";
  } else {
    print $users." users online.\n";
  }
});

Flight::start();
