<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
include_once('../dbConnection.php');

$method = $_SERVER['REQUEST_METHOD'];
//  echo $method;
if ($method == 'DELETE') {
    $id = $_GET['id'];
    $sql = "DELETE FROM sanPham WHERE sp_id = " . $id;
    if ($conn->query($sql) == TRUE) {
        // echo '<meta http-equiv="refresh" content="0;URL=?deleted">';
        echo ' xoa thanh cong';
    } else {
        http_response_code(400);
        echo "Unable to delete data";
    }
}
 else if ($method == 'POST'){
$obj = json_decode(file_get_contents('php://input'));   
//   echo json_encode($obj);

        $dm_id = $obj->category_id;
        $sp_ten = $obj->name;
        $sp_soLuong = $obj->quantity;
        $sp_moTa = $obj->describe;
        $sp_giaGoc = $obj->price;
        $sp_gia = $obj->price;
        $sp_nsx = $obj->date_of_manufacture;

        $link_folder = $obj->thumbUrl;
         $sql = "INSERT INTO sanPham (sp_id, sp_ten, sp_soLuong, sp_moTa, sp_giaGoc,sp_gia, sp_nsx, sp_hinhAnh,dm_id)
                 VALUES (NULL, '$sp_ten', '$sp_soLuong', '$sp_moTa', '$sp_giaGoc', '$sp_gia', '$sp_nsx', '$link_folder', '$dm_id');";

         if($conn -> query($sql) == TRUE){
             echo"Them thanh cong";
         }
         else{
            http_response_code(400);

         }
        }
?>