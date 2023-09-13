<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
include_once('../dbConnection.php');

// $nm_email = json_decode(file_get_contents('php://input'));
// echo json_encode($nm_email);
$method = $_SERVER['REQUEST_METHOD'];

session_id('TMDT');
session_start();
$nm_email =  $_SESSION['user'];
if ($method == "GET") {
    $arr = array();
    // $nm_email = $_GET['email'];

    $sql_diaChi = "SELECT dc_sonha as sonha , dc_thanhpho as tentp, dc_tinh as tentinh, dc_xa as tenxa, dc_sdt as sdt, dc_hoten as hoten
               FROM diachi 
               WHERE nm_email = '$nm_email'";
    $result = $conn->query($sql_diaChi);
    if($result -> num_rows > 0) {    
        while($row = $result -> fetch_assoc()){
               array_push($arr, $row);
           } 
           echo json_encode($arr);
    }
   else{
       echo "0 Result";
   }
}
?>