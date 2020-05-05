<?php

/*
CREATE TABLE login_storage (
  name char(64),
  secret char(64),
  message varchar(512)
);
INSERT INTO products VALUES('admin'...);
*/
error_reporting(0);
require_once("config.php"); // DB config

$db = new mysqli($MYSQL_HOST, $MYSQL_USERNAME, $MYSQL_PASSWORD, $MYSQL_DBNAME);

if ($db->connect_error) {
  die("Connection failed: " . $db->connect_error);
}

function check_errors($var) {
  if ($var === false) {
    die("Error. Please contact administrator.");
  }
}



function get_message($name) {
  global $db;
  $statement = $db->prepare(
    "SELECT message FROM login_storage WHERE name = ?"
  );
  check_errors($statement);
  $statement->bind_param("s", $name);
  check_errors($statement->execute());
  $res = $statement->get_result();
  check_errors($res);
  $message = $res->fetch_assoc();
  $statement->close();
  return $message;
}

function insert_user($name, $secret, $message) {
  global $db;
  $statement = $db->prepare(
    "INSERT INTO login_storage (name, secret, message) VALUES (?, ?, ?)"
  );
  check_errors($statement);
  $statement->bind_param("sss", $name, $secret, $message);
  check_errors($statement->execute());
  $statement->close();
}

function check_name_secret($name, $secret) {
  global $db;
  $valid = false;
  $statement = $db->prepare(
    "SELECT name FROM login_storage WHERE name = ? AND secret = ?"
  );
  check_errors($statement);
  $statement->bind_param("ss", $name, $secret);
  check_errors($statement->execute());
  $res = $statement->get_result();
  check_errors($res);
  if ($res->fetch_assoc() !== null) {
    $valid = true;
  }
  $statement->close();
  return $valid;
}