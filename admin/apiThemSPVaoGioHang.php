<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
include_once('../dbConnection.php');

$obj = json_decode(file_get_contents('php://input'));
$method = $_SERVER['REQUEST_METHOD'];

// echo json_encode($obj);

session_id('TMDT');
session_start();
if ($method == 'POST') {
    $sp_id = $obj->product_id;
    $soLuong = $obj->quantity;
    $sql = "SELECT * FROM sanPham WHERE sp_id = " . $sp_id;
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    // echo json_encode($row);
    $sp_ten = $row['sp_ten'];
    $sp_gia = $row['sp_gia'];
    $sp_hinhAnh = $row['sp_hinhAnh'];
    // echo json_encode($row->sp_hinhAnh);


    if (!isset($_SESSION['cart'])) { // Nếu chưa có giỏ hàng thì tạo (Mảng)
        $_SESSION['cart'] = array();
    }

    $i = 0;
    $fg = 0;
    // Tìm và so sánh một sản phẩm trong giỏ hàng, có rồi thì chỉ cập nhật số lượng (trùng id)
    if (isset($_SESSION['cart']) && (count($_SESSION['cart']) > 0)) {
        foreach ($_SESSION['cart'] as $sanpham) {
            if ($sanpham[0] == $sp_id) {
                // Cập nhật số lượng
                $soLuong += $sanpham[4];
                $fg = 1;
                // Cập nhật số lượng mới dô giỏ hàng
                $_SESSION['cart'][$i][4] = $soLuong; // Cập nhật cột thứ 4(Số lượng) trong tại vị trí $i trong giỏ hàng
                break;
            }
            $i++;
        }
    }
    // Khi số lượng ban đầu không đổi => thêm mới sp vào giỏ hàng
    if ($fg == 0) {
        // Tạo mảng con trước khi đưa vào giỏ hàng
        $sanpham = array($sp_id, $sp_ten, $sp_hinhAnh, $sp_gia, $soLuong);
        // Đưa mảng vừa tạo vào session
        array_push($_SESSION['cart'], $sanpham);
    }
} else if ($method == "GET") {
    $arr = array();
    if (isset($_SESSION['cart']) && (count($_SESSION['cart']) > 0)) {
        $tongTien = 0;
        $i = 0;
        foreach ($_SESSION['cart'] as $sanpham) {
            $thanhTien = $sanpham[3] * $sanpham[4];
            $tongTien += $thanhTien;
            array_push($arr, $sanpham);
        }
        $reversedArray = array_reverse($arr);
        echo json_encode($reversedArray);
    }
} else if ($method == 'DELETE') {
    // echo json_encode($obj);
    $id = $_GET['id'];

    if (isset($_SESSION['cart'])  && (count($_SESSION['cart']) > 0)) {

        try {
            array_splice($_SESSION['cart'], $id, 1); // Xóa phần tử có id tại giỏ hàng
            echo json_encode("unchoose success");
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode("unchoose fail");
        }
    }
}
