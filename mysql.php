<?php

define('MYSQL_HOST', '127.0.0.1');
define('MYSQL_USER', 'root');
define('MYSQL_PASS', '');
define('MYSQL_DB', 'sweetgeo');

try {
  $dbh = @new PDO("mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DB, MYSQL_USER, MYSQL_PASS);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
  die("failed connecting to database: " . $e->getMessage());
}

function insert_user_location($user_id, $user_name, $location_id, $status)
{
  global $dbh;
  try {
    $stmt = $dbh->prepare('INSERT INTO user_location(user_id, user_name, location_id, status) VALUES (?, ?, ?, ?)');
    $res = $stmt->execute(array($user_id, $user_name, $location_id, $status));
  }
  catch(PDOException $e) {
    die("database insert failed: " . $e->getMessage());
  }
}

function select_users_at_location($location_id)
{
  global $dbh;
  try {
    $stmt = $dbh->prepare('
        SELECT
          user_id, user_name, location_id, status,
          TIMESTAMPDIFF(SECOND, create_dt, NOW()) delta
        FROM user_location
        WHERE location_id = ?
        ORDER BY create_dt DESC
        LIMIT 50
    ');
    $stmt->execute(array($location_id));
    return $stmt->fetchAll();
  }
  catch(PDOException $e) {
    die("database select failed: " . $e->getMessage());
  }
}

function insert_user_comment($user_id, $from_id, $message)
{
  global $dbh;
  try {
    $stmt = $dbh->prepare('INSERT INTO user_comment(user_id, from_id, message) VALUES (?, ?, ?)');
    $stmt->execute(array($user_id, $from_id, $message));
  }
  catch(PDOException $e) {
    die("database insert failed: " . $e->getMessage());
  }
}

function select_user_comment($user_id) {
  global $dbh;
  try {
    $stmt = $dbh->prepare('SELECT user_id, from_id, message FROM user_comment WHERE user_id = ? ORDER BY create_dt DESC');
    $stmt->execute(array($user_id));
    return $stmt->fetchAll();
  }
  catch(PDOException $e) {
    die("database select failed: " . $e->getMessage());
  }
}
