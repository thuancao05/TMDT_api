<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
include_once('../dbConnection.php');

$method = $_SERVER['REQUEST_METHOD'];

$arr = array();

if ($method == 'POST') {
    // $id = $_GET['id'];
    $obj = json_decode(file_get_contents('php://input'));
    //  echo json_encode($obj);

    $id =  $obj;
    $sql = "SELECT * FROM gioHang AS gh JOIN sanPham AS sp
            WHERE dh_id = '$id' AND sp.sp_id = gh.sp_id"; 
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            array_push($arr, $row);
        }
        echo json_encode($arr);
    } else {
        echo "0 Result";
    }
}