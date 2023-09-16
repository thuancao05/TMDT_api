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

$method = $_SERVER['REQUEST_METHOD'];

//  echo $method;
$arr = array();

// $id = $_GET['id'];
// $obj = json_decode(file_get_contents('php://input'));   
// echo json_encode($obj);

$email =  $_SESSION['user'];
if ($method == 'GET') {
    $sql = "SELECT * FROM nguoiMua WHERE nm_email = '" . $email . "' ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            array_push($arr, $row);
        }
        echo json_encode($arr);
    } else {
        echo "0 Result";
    }
} else if ($method == 'POST') {
    // $obj = json_decode(file_get_contents('php://input'));
    // echo json_encode($obj);

    $postData = file_get_contents("php://input");
    // Decode the JSON data sent in the request
    $requestData = json_decode($postData, true);

    $nm_hinhAnh = $requestData['avatar'];
    $nm_ten = $requestData['name'];
    $nm_sdt = $requestData['phone'];
    $nm_matKhau = $requestData['password'];

    $sql = "UPDATE nguoiMua SET nm_ten = '$nm_ten', nm_hinhAnh = '$nm_hinhAnh', nm_sdt = '$nm_sdt'
            , nm_matKhau = '$nm_matKhau' WHERE nm_email = '$email';";

    if ($conn->query($sql) == TRUE) {
        echo json_encode("Sua thanh cong");
    } else {
        echo json_encode("Sua that bai");
    }
}