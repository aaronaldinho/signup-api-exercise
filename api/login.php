<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$data = json_decode(file_get_contents("php://input"));

$username = '';
$email = '';
$normalPassword = '';
$confirmPassword = '';

// check data
if(!empty($data->username) && !empty($data->email) && !empty($data->normalPassword) && !empty($data->confirmPassword)) {
$username = $data->username;
$email= $data->email;
$normalPassword = $data->normalPassword;
$confirmPassword = $data->confirmPassword;
}


if (!$username || $username === '' || !$email || $email === '' || !$normalPassword || !$normalPassword === '' || !$confirmPassword || $confirmPassword === ''){
	echo json_encode([
		'success' => false, 
		'message' => "what are u doin man",
	]);
	exit;
}
if ( $normalPassword !== $confirmPassword){
	echo json_encode([
		'success' => false, 
		'message' => "your passwords are not identical",
	]);
	exit;
}
if(isset($_POST['checkbox']) && $_POST['checkbox']!="")
{
    echo 'checkbox is checked'; 
}

// ....INSERT INTO DATABASE

$response = json_encode([
    'success' => true, 
    'user' => [
		'username' => $username,
		'email' => $email,
		'normalPassword' => $normalPassword,
		'confirmPassword' => $confirmPassword,
	],
]);


// database connection credentials
$user = 'root';
$password = 'root';
$dbname = 'supercode';
$host = '127.0.0.1';
$port = 8889;

// Create connection
$conn = mysqli_connect($host, $user, $password, $dbname, $port);

// Check connection
if (!$conn) {
	echo json_encode([
		'success' => false, 
		'message' => mysqli_connect_error(),
	]);
	echo $response;
	exit;
}

// MySQL INSERT Statement -> https://www.w3schools.com/sql/sql_insert.asp
$sql = "INSERT INTO user (username, email, password)
VALUES ( '$username', '$email', '$normalPassword', 'checkbox')";

if (mysqli_query($conn, $sql)) {
	$response = json_encode([
		'success' => true, 
	]);
} else {
  	$response = json_encode([
		'success' => false, 
		'message' => "Error: " . $sql . "<br>" . mysqli_error($conn),
	]);
}
mysqli_close($conn);

echo $response;
// $name = $_POST['inp_name'];
// $passwords = $_POST['inp_password'];
// var_dump($_POST);
?>