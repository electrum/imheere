<?php

$hostname = 'localhost';
$username = 'root';
$password = '';

$dbh;

try {
  $dbh = new PDO("mysql:host=$hostname;dbname=sweetgeo", $username, $password);
  echo 'Connected to database';
}
catch(PDOException $e) {
  echo $e->getMessage();
}

/*
$user_id = 2;
$location_id = 88;
$status = "test";
insert_user_at_location($dbh,$user_id,$location_id,$status);
*/
function insert_user_at_location($dbh,$user_id,$location_id,$status) {
  try {
    $stmt = $dbh->prepare('INSERT INTO user_at_location(user_id, location_id, status) VALUES ( ? , ? , ? )');
    $res = $stmt->execute(array($user_id,$location_id,$status));
    print $res; 
  }
  catch(PDOException $e)
  {
    echo $e->getMessage();
  }
}


/*select
$location_id = 88;
select_user_at_location($dbh,$location_id);
*/
function select_user_at_location($dbh,$location_id) {
  try {
    $stmt = $dbh->prepare('SELECT user_id, location_id, status FROM user_at_location WHERE location_id = ? ORDER BY create_dt DESC');
    $stmt->execute(array($location_id));

    /* Bind by column number */
    $stmt->bindColumn(1, $user_id);
    $stmt->bindColumn(2, $location_id);
    $stmt->bindColumn(3, $status);
    
    while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
      $data = $user_id . "\t" . $location_id . "\t" . $status . "\n";
      print $data;
    }
  }
  catch(PDOException $e)
  {
    echo $e->getMessage();
  }
}


/*
$user_id = 2;
$from_id = 3;
$message = "test";
insert_user_comment($dbh,$user_id,$from_id,$message);
*/
function insert_user_comment($dbh,$user_id,$from_id,$message) {
  try {
    $stmt = $dbh->prepare('INSERT INTO user_comment(user_id,from_id,message) VALUES ( ? , ? , ? )');
    $res = $stmt->execute(array($user_id,$from_id,$message));
    print $res;
  }
  catch(PDOException $e)
  {
    echo $e->getMessage();
  }
}

/*
$user_id = 2;
select_user_comment($dbh,$user_id);
*/
function select_user_comment($dbh,$user_id) {
  try {
    $stmt = $dbh->prepare('SELECT user_id, from_id, message FROM user_comment WHERE user_id = ? ORDER BY create_dt DESC');
    $stmt->execute(array($user_id));

    /* Bind by column number */
    $stmt->bindColumn(1, $user_id);
    $stmt->bindColumn(2, $from_id);
    $stmt->bindColumn(3, $message);
	
    while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
      $data = $user_id . "\t" . $from_id . "\t" . $message . "\n";
      print $data;
    }
  }
  catch(PDOException $e)
  {
    echo $e->getMessage();
  }
}
