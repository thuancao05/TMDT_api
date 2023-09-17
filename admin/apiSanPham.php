<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
session_id( 'TMDT' );
session_start();

include_once('../dbConnection.php');
$method = $_SERVER['REQUEST_METHOD'];
// echo $method;
$arr = array();
    if ($method == "GET") {
        $sql = "SELECT * FROM sanPham ORDER BY sp_id DESC";
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

    if ($method == 'POST') {
        // $id = $_GET['id'];
        $obj = json_decode(file_get_contents('php://input'));
        $id =  $obj;
        $sql = "SELECT * FROM sanPham WHERE sp_id = " . $id;
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
    if ($method == 'PUT') {
        $postData = file_get_contents("php://input");
        // Decode the JSON data sent in the request
        $requestData = json_decode($postData, true);
    
        $sp_id = $requestData['id'];
        $dm_id = $requestData['category_id'];
        $sp_ten = $requestData['name'];
        $sp_soLuong = $requestData['quantity'];
        $sp_moTa = $requestData['describe'];
        $sp_giaGoc = $requestData['price'];
        $sp_gia = $requestData['price'];
        $sp_nsx =$requestData['date_of_manufacture'];
        $sp_hinhAnh = $requestData['thumbUrl'];
        $sql = "UPDATE sanPham SET dm_id = '$dm_id', sp_ten = '$sp_ten', sp_soLuong = '$sp_soLuong'
                , sp_moTa = '$sp_moTa', sp_giaGoc = '$sp_giaGoc', sp_gia = '$sp_gia', sp_nsx = '$sp_nsx'
                , sp_hinhAnh = '$sp_hinhAnh'
                 WHERE sp_id = '$sp_id';";
    
        if ($conn->query($sql) == TRUE) {
            echo json_encode("Sua thanh cong");
        } else {
            echo json_encode("Sua that bai");
        }
    }
?>
