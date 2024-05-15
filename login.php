<?php

require_once 'db.php';
require_once 'jwt_utils.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// get posted data
	$data = json_decode(file_get_contents("php://input", true));
	// Validar y sanitizar los datos de entrada
    $username = filter_var($data->username, FILTER_SANITIZE_STRING);
    $password = filter_var($data->password, FILTER_SANITIZE_STRING);

	if (!empty($username) && !empty($password)) {
	$sql = "SELECT * FROM user WHERE username = '" . mysqli_real_escape_string($dbConn, $username) . "' LIMIT 1";
	$result = dbQuery($sql);
	
	if(dbNumRows($result) < 1) {
		echo json_encode(array('error' => 'Invalid User'));
	} else {
		$row = dbFetchAssoc($result);
		$verify = password_verify($password, $row['password']); 
		if($verify){
		$username = $row['username'];
		$headers = array('alg'=>'HS256','typ'=>'JWT');
		$payload = array('username'=>$username, 'exp'=>(time() + 36000));
        $jwt = generate_jwt($headers, $payload);
		echo json_encode(array('token' => $jwt, 'username' =>$username));
		}else{
			echo 'error password';
		}
	}
}
}
//End of file