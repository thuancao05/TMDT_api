<?php
header('Access-Control-Allow-Origin: *');
include_once('../dbConnection.php');

$method = $_SERVER['REQUEST_METHOD'];
// echo $method;

    $arr = array();
    if($method == "GET" ){
        $sql = "SELECT * FROM sanPham";
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
}

    if($method == 'POST'){
    // $id = $_GET['id'];
    $obj = json_decode(file_get_contents('php://input'));   
    //  echo json_encode($obj);

    $id =  $obj;
    $sql = "SELECT * FROM sanPham WHERE sp_id = " . $id;
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
}
