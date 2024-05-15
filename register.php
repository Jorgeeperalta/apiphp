<?php

require_once 'db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// get posted data
	$data = json_decode(file_get_contents("php://input", true));
	$pass=password_hash($data->password, PASSWORD_DEFAULT);
	$sql = "INSERT INTO user(username, password,phone, fk_localidad) VALUES('" . mysqli_real_escape_string($dbConn, $data->username) . "', '" . mysqli_real_escape_string($dbConn, $pass) . "','" . mysqli_real_escape_string($dbConn, $data->phone) . "','" . mysqli_real_escape_string($dbConn, $data->fk_localidad) . "')";
	
	$result = dbQuery($sql);
	
	if($result) {
		echo json_encode(array('success' => 'You registered successfully'));
	} else {
		echo json_encode(array('error' => 'Something went wrong, please contact administrator'));
	}
}