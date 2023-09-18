<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
include_once('../dbConnection.php');

$method = $_SERVER['REQUEST_METHOD'];
// echo $method;

$arr = array();
if ($method == "GET") {
    $sql = "SELECT * FROM donHang AS dh JOIN trangThai AS tt JOIN nguoiMua AS nm
                    WHERE dh.tt_id = tt.tt_id AND nm.nm_id = dh.nm_id";
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
    //  echo json_encode($obj);

    $id =  $obj;
    $sql = "SELECT * FROM donHang AS dh JOIN trangThai AS tt JOIN nguoiMua AS nm JOIN diaChi AS dc
            WHERE dh_id = '$id' AND dh.tt_id = tt.tt_id AND nm.nm_id = dh.nm_id AND dc.nm_id = nm.nm_id"; 
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
// echo $method;
if ($method == 'DELETE') {
    $id = $_GET['id'];
    $sql = "UPDATE donHang SET tt_id = 5
            WHERE dh_id = " . $id;
    if ($conn->query($sql) == TRUE) {
        // echo '<meta http-equiv="refresh" content="0;URL=?deleted">';
        echo 'huy don thanh cong';
    } else {
        echo "Unable to delete data";
    }
}
if ($method == 'PUT') {
    $postData = file_get_contents("php://input");
    // Decode the JSON data sent in the request
    $requestData = json_decode($postData, true);

    $dh_id = $requestData['id'];
    $tt_id = $requestData['status_id'];
    
    $sql = "UPDATE donHang SET tt_id = '$tt_id'
             WHERE dh_id = '$dh_id';";

    if ($conn->query($sql) == TRUE) {
        echo json_encode("Sua thanh cong");
    } else {
        echo json_encode("Sua that bai");
    }
}
