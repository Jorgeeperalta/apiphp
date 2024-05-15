
<?php


require_once 'db.php';
require_once 'jwt_utils.php';

// Allow from any origin
if (isset($_SERVER["HTTP_ORIGIN"])) {
    // You can decide if the origin in $_SERVER['HTTP_ORIGIN'] is something you want to allow, or as we do here, just allow all
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
} else {
    //No HTTP_ORIGIN set, so we allow any. You can disallow if needed here
    header("Access-Control-Allow-Origin: *");
}

header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 600");    // cache for 10 minutes

if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"]))
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT"); //Make sure you remove those you do not want to support

    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    //Just exit with 200 OK with the above headers for OPTIONS method
    exit(0);
}


$bearer_token = get_bearer_token();

#echo $bearer_token;

$is_jwt_valid = is_jwt_valid($bearer_token);

// if($is_jwt_valid) {

	if  ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$data = json_decode(file_get_contents("php://input", true));
		if ($data->opcion =='2') {
			$sql = "SELECT * FROM `categorias` WHERE `fkgym` = '" . mysqli_real_escape_string($dbConn, $data->fkgym) . "'";
			$results = dbQuery($sql);

			$rows = array();

			while($row = dbFetchAssoc($results)) {
				$rows[] = $row;
			}

			echo json_encode($rows);
		}  else if ($data->opcion =='1'){

				$data = json_decode(file_get_contents("php://input", true));
				
				$sql = "INSERT INTO categorias (nombre, fkgym )
				VALUES('" . mysqli_real_escape_string($dbConn, $data->nombre) . "' , 
				'" . mysqli_real_escape_string($dbConn, $data->fkgym) . "')";
				
				$result = dbQuery($sql);
				
				if($result) {
					echo json_encode(array('success' => 'SE CREO SATISFACTORIAMENTE'));
				} else {
					echo json_encode(array('error' => 'OCURRIO UN ERROR, POR FAVOR CONTACTESE CON EL ADMINISTRADOR'));
				}
           } 
    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

		$sql = "SELECT * FROM categorias";
		$results = dbQuery($sql);

		$rows = array();

		while($row = dbFetchAssoc($results)) {
			$rows[] = $row;
		}

		echo json_encode($rows);
	} else if ($_SERVER['REQUEST_METHOD'] === 'PUT'){
                $data = json_decode(file_get_contents("php://input", true));
				
				$sql = "UPDATE `categorias` SET `nombre`='" . mysqli_real_escape_string($dbConn, $data->nombre) . "',
				`fkgym`='" . mysqli_real_escape_string($dbConn, $data->fkgym) . "' WHERE `id`= '" . mysqli_real_escape_string($dbConn, $data->id) . "'";

				$result = dbQuery($sql);
				
				if($result) {
					echo json_encode(array('success' => 'SE ACTUALIZO SATISFACTORIAMENTE'));
				} else {
					echo json_encode(array('error' => 'OCURRIO UN ERROR, POR FAVOR CONTACTESE CON EL ADMINISTRADOR'));
				}
    } else if ($_SERVER['REQUEST_METHOD'] === 'DELETE'){


				$data = json_decode(file_get_contents("php://input", true));
				
				$sql = "DELETE FROM `categorias` WHERE `id`= '" . mysqli_real_escape_string($dbConn, $data->id) . "'";

				$result = dbQuery($sql);
				
				if($result) {
					echo json_encode(array('success' => 'SE ELIMINO SATISFACTORIAMENTE'));
				} else {
					echo json_encode(array('error' => 'OCURRIO UN ERROR, POR FAVOR CONTACTESE CON EL ADMINISTRADOR'));
				}
   }

// } else {
// 	echo json_encode(array('error' => 'Access denied'));
// }

//End of file