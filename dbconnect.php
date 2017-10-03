<?php
/*
Database connection
*/
$servername = "localhost";
$username = "root";
$password = "amigo123";

try {
    	$dbh = new PDO("mysql:host=$servername;dbname=userdetails", $username, $password);
    	// set the PDO error mode to exception
    	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    }
catch(PDOException $e)
    {
  	  echo "Connection failed: " . $e->getMessage();
    }

function addUserActivty($activity,$userId) {
	global $dbh;
	if(!empty($activity) && !empty($userId)) {
		$query = "INSERT INTO useractivity(userId,activity,time) VALUES('$userId','$activity',now())";
		$sth = $dbh->query($query);
		$sth->execute();
	}
}
function getUserDetails($userId) {
	global $dbh;
	$query ="SELECT * FROM users WHERE userId=".$userId;
	$sth = $dbh->query($query);
	$sth->setFetchMode(PDO::FETCH_ASSOC);
	$data = $sth->fetch();
	//print_r($data);
	if(!empty($data)) {
		return $data;
	}
}

function getUserActivity($userId) {
	global $dbh;
	$query ="SELECT * FROM useractivity WHERE userId=".$userId;
	$sth = $dbh->query($query);
	$sth->setFetchMode(PDO::FETCH_ASSOC);
	while($data = $sth->fetch()) {
		$row[] = $data;
	}
	if(!empty($row)) {
		return $row;
	}
}
