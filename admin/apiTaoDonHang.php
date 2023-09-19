<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
include_once('../dbConnection.php');
// $conn=connectdb();

$method = $_SERVER['REQUEST_METHOD'];
session_id('TMDT');
session_start();
$nm_email =  $_SESSION['user'];
$nm_id = $_SESSION['user_id'];


$postData = file_get_contents("php://input");
// Decode the JSON data sent in the request
$requestData = json_decode($postData, true);
$tongDonHang = $requestData['tongtien'];
$soLuongSanPham = $requestData['tongSL'];
$ghiChu = $requestData['ghichu'];

// echo json_encode($requestData);
$tt_id = 1;
$pttt = 1;
$dh_ngayDat = date('Y/m/d');
$sql = "INSERT INTO donhang (dh_tongThanhToan, dh_pttt, nm_id, dh_soLuong, dh_ghiChu, tt_id, dh_ngayDat)
               VALUE ('$tongDonHang', '$pttt', '$nm_id', '$soLuongSanPham', '$ghiChu', '$tt_id', '$dh_ngayDat')";


if($conn -> query($sql) == TRUE){
    // echo json_encode("Ordered successfully !");

$sql_lastid = "SELECT dh_id FROM donHang 
ORDER BY dh_id DESC 
LIMIT 1;";
$result = $conn->query($sql_lastid);
$row = $result->fetch_assoc();
$last_id = $row['dh_id'];


foreach ($_SESSION['cart'] as $sanpham){
    $sql1 = "INSERT INTO giohang (dh_id, sp_id, gh_tenSanPham, gh_img, gh_donGia, gh_soLuong, nm_id)
    VALUE ('".$last_id."', '".$sanpham[0]."', '".$sanpham[1]."', '".$sanpham[2]."', '".$sanpham[3]."', '".$sanpham[4]."', ".$nm_id.")";
    $conn -> query($sql1); 
}

echo json_encode($last_id);

// Xóa giỏ hàng sau khi đặt
 unset($_SESSION['cart']);

//  echo json_encode("Thanh cong");

}