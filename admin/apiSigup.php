<?php 
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
include_once('../dbConnection.php');

$obj = json_decode(file_get_contents('php://input'));
$nm_ten = $obj->name;
$nm_email = $obj->email;
$nm_matKhau = $obj->password;
$nm_sdt = $obj->phone;

$sql = "SELECT * FROM nguoiMua WHERE nm_email = '".$nm_email."' ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo json_encode("Email already exists");
} else if($nm_ten !=''){
    $sql = "INSERT INTO nguoimua (nm_id, nm_ten, nm_email,nm_sdt, nm_matkhau, nm_trangthai) VALUES (NULL, '$nm_ten', '".$nm_email."' , '".$nm_sdt."', '$nm_matKhau', '1');";
    if($conn -> query($sql) == TRUE){
        echo json_encode("Register successfully !");
    }
    else{
        echo json_encode("Register Fail !");
    }
}

