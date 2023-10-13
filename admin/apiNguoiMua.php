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

$email =  $_SESSION['user'];
if ($method == 'GET') {
    if($email == 'admin' ){
    $sql = "SELECT * FROM nguoiMua ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            array_push($arr, $row);
        }
        echo json_encode($arr);
    } else {
        echo json_encode("FindNotUser");
    }}
    else{
        $sql = "SELECT * FROM nguoiMua WHERE nm_email = '" . $email . "' ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
    
            while ($row = $result->fetch_assoc()) {
                array_push($arr, $row);
            }
            echo json_encode($arr);
        } else {
            echo json_encode("FindNotUser");
     }}
    
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
if ($method == 'DELETE') {
    $id = $_GET['id'];
    $sql = "DELETE FROM nguoiMua WHERE nm_id = " . $id;
    if ($conn->query($sql) == TRUE) {
        // echo '<meta http-equiv="refresh" content="0;URL=?deleted">';
        echo ' xoa thanh cong';
    } else {
        http_response_code(400);
        echo "Unable to delete data";
    }
}
