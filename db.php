<?php

// Se recomienda utilizar variables de entorno para almacenar información sensible como las credenciales de la base de datos
$host = 'localhost';
$username = 'root';
$password = 'root';
$database = 'ejemplo';

// Conexión a la base de datos utilizando el método orientado a objetos
$dbConn = new mysqli($host, $username, $password, $database);

if ($dbConn->connect_error) {
    throw new Exception("MySQL connect failed: " . $dbConn->connect_error);
}
function dbQuery($sql) {
	global $dbConn;
	$result = mysqli_query($dbConn, $sql) or die(mysqli_error($dbConn));
	return $result;
}

function dbFetchAssoc($result) {
	return mysqli_fetch_assoc($result);
}

function dbNumRows($result) {
    return mysqli_num_rows($result);
}

function closeConn() {
	global $dbConn;
	mysqli_close($dbConn);
}
	
//End of file