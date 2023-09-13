<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
include_once('../dbConnection.php');

$obj = json_decode(file_get_contents('php://input'));
$email = $obj->email;
$password = $obj->password;


$sql = "SELECT nb_email, nb_matKhau FROM nguoiban WHERE nb_email = '".$email."' AND nb_matKhau = '".$password."' ";
$sql1 = "SELECT nm_id, nm_email, nm_matKhau FROM nguoimua WHERE nm_email = '".$email."' AND nm_matKhau = '".$password."' ";

$result = $conn->query($sql);
$result1 = $conn->query($sql1);

if ($result->num_rows > 0) {
    echo json_encode('Login_pass');
    session_id('TMDT');
    session_start();
    $_SESSION['check-auth'] = 'true';
    $_SESSION['user'] = 'admin';
}else { 
    if ($result1->num_rows > 0) {
        echo json_encode('Login_pass');
        session_id('TMDT');
        session_start();
        $_SESSION['check-auth'] = 'true';
        $_SESSION['user'] = $email;
        $row = $result1->fetch_assoc();
        $_SESSION['user_id'] = $row['nm_id'];

    }else{
        echo json_encode('Login_fail');

    }

}
