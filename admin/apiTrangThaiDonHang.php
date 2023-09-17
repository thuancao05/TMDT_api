<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
include_once('../dbConnection.php');

$method = $_SERVER['REQUEST_METHOD'];

$arr = array();
$sql = "SELECT tt_id AS value
                    ,tt_ten AS label
                         FROM trangThai";
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