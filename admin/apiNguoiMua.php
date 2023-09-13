<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
include_once('../dbConnection.php');
session_id('TMDT');
session_start();

$method = $_SERVER['REQUEST_METHOD'];

//  echo $method;
$arr = array();

    // $id = $_GET['id'];
    // $obj = json_decode(file_get_contents('php://input'));   
    // echo json_encode($obj);

    $email =  $_SESSION['user'];
    $sql = "SELECT nm_email,nm_sdt,nm_ten FROM nguoiMua WHERE nm_email = '".$email."' ";
    $result = $conn->query($sql);
    if($result -> num_rows > 0) {    
    
        while($row = $result -> fetch_assoc()){
               array_push($arr, $row);
           } 
           echo json_encode($arr);
           
    }

   else{
       echo "0 Result";
   }
