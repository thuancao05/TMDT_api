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

$sql = "SELECT * FROM nguoiMua WHERE nm_email = '".$nm_email."' ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo json_encode("Email already exists");
} else {
    $sql = "INSERT INTO nguoimua (nm_id, nm_ten, nm_email, nm_matkhau) VALUES (NULL, '$nm_ten', '".$nm_email."', '$nm_matKhau');";
    if($conn -> query($sql) == TRUE){
        echo json_encode("Register successfully !");
    }
    else{
        echo json_encode("Register Fail !");
    }
}

