<?php


//$dbConn = mysqli_connect('localhost','root','root','roytuts') or die('MySQL connect failed. ' . mysqli_connect_error());
$dbConn = mysqli_connect('MYSQL5032.site4now.net','a47d48_lavalle','afm123**','db_a47d48_lavalle') or die('MySQL connect failed. ' . mysqli_connect_error());
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