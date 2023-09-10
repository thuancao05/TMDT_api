<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
include_once('../dbConnection.php');

$obj = json_decode(file_get_contents('php://input'));
$email = $obj->email;
$password = $obj->password;
// Simulate user authentication (replace this with your actual authentication logic)
if ($email === 'thuan@gmail.com' && $password === 'thuan123') {
    session_id( 'admin' );
    session_start();
    $_SESSION['user'] = 'admin';
    echo json_encode('Login_pass');

} else {
    echo json_encode('Login_fail');
}
