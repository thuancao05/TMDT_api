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
$nm_id =  $_SESSION['user_id'];

if ($method == "GET") {
    $arr = array();
    // $nm_email = $_GET['email'];

    $sql_diaChi = "SELECT dc_sonha as sonha , dc_thanhpho as tentp, dc_tinh as tentinh, dc_xa as tenxa, dc_sdt as sdt, dc_hoten as hoten
               FROM diachi 
               WHERE nm_email = '$nm_email'";
    $result = $conn->query($sql_diaChi);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($arr, $row);
        }
        echo json_encode($arr);
    } else {
        echo "0 Result";
    }
}

if ($method == "POST") {
    $postData = file_get_contents("php://input");
    // Decode the JSON data sent in the request
    $requestData = json_decode($postData, true);
    $matp = $requestData['matp'];
    $maqh = $requestData['maqh'];
    $maxa = $requestData['maxa'];
    $sonha = $requestData['sonha'];

    $sql = "SELECT name FROM devvn_tinhthanhpho WHERE matp = '$matp'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $tentp = $row['name'];

    $sql = "SELECT name FROM devvn_quanhuyen WHERE maqh = '$maqh'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $tenqh = $row['name'];

    $sql = "SELECT name FROM devvn_xaphuongthitran WHERE xaid = '$maxa'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $tenxa = $row['name'];

    $checkSql = "SELECT nm_email FROM diaChi WHERE nm_email = '$nm_email'";
    $checkResult = $conn->query($checkSql);
    if ($checkResult->num_rows === 0) {
        $dc_hoten = $dc_sdt = $dc_giatrimatdinh = 0;
        $sql = "INSERT INTO diaChi (dc_hoten, dc_sdt, dc_sonha, dc_thanhpho, dc_tinh, dc_xa, dc_giatrimatdinh, nm_id, nm_email)
               VALUE ('$dc_hoten', '$dc_sdt', '$sonha', '$tentp', '$tenqh', '$tenxa', '$dc_giatrimatdinh', '$nm_id', '$nm_email' )";
        if ($conn->query($sql) == TRUE) {
            echo json_encode("Them dia chi thanh cong");
        } else {
            echo json_encode("Them dia chi that bai");
        }
    }else{
        $sql = "UPDATE diaChi SET dc_soNha = '$sonha', dc_thanhpho = '$tentp', dc_tinh='$tenqh', dc_xa='$tenxa'
        WHERE nm_email = '$nm_email';";
    
        $result = $conn->query($sql);
        if ($conn->query($sql) == TRUE) {
            echo json_encode("Sua thanh cong");
        } else {
            
        }

    }



}
