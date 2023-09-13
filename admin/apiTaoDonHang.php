<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
include_once('../dbConnection.php');

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
$tt_id = 1;
$pttt = 1;
$dh_ngayDat = date('Y/m/d');
$sql = "INSERT INTO donhang (dh_tongThanhToan, dh_pttt, nm_id, dh_soLuong, dh_ghiChu, tt_id, dh_ngayDat)
               VALUE ('$tongDonHang', '$pttt', '$nm_id', '$soLuongSanPham', '$ghiChu', '$tt_id', '$dh_ngayDat')";

$conn->exec($sql);
$last_id = $conn->lastInsertId(); // Lấy id tự tạo ở table tbl_order trong csdl
return $last_id;

