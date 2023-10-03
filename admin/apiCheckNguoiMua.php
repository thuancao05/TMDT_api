<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
include_once('../dbConnection.php');
session_id('TMDT');
session_start();
$email = $_POST['userEmail'];

$method = $_SERVER['REQUEST_METHOD'];
$obj = json_decode(file_get_contents('php://input'));   
echo json_encode($email);

// $sql = "SELECT * FROM nguoiMua WHERE nm_email = '" . $email . "' ";
// $result = $conn->query($sql);
// if ($result->num_rows > 0) {
//     echo json_encode("Email already exists");
// } else {
//     echo json_encode("FindNotUser");
// }
