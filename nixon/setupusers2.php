<?php //setupusers.php
  require_once 'login.php';
  $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

  if ($connection->connect_error) die($connection->connect_error);

  $query = "CREATE TABLE user_creds (
    forename VARCHAR(32) NOT NULL,
    surname  VARCHAR(32) NOT NULL,
    username VARCHAR(32) NOT NULL UNIQUE,
    password VARCHAR(32) NOT NULL
  )";
  $result = $connection->query($query);
  if (!$result) die($connection->error);

  $salt1    = "qm&h*";
  $salt2    = "pg!@";

  $forename = 'Jay';
  $surname  = 'Sprout';
  $username = 'jaysprout';
  $password = 'We2CanFly!';
  $token    = hash('ripemd128', "$salt1$password$salt2");

  add_user($connection, $forename, $surname, $username, $token);

  function add_user($connection, $fn, $sn, $un, $pw)
  {
    $query  = "INSERT INTO user_creds VALUES('$fn', '$sn', '$un', '$pw')";
    $result = $connection->query($query);
    if (!$result) die($connection->error);
  }
?>