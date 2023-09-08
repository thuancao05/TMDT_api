<?php
header('Access-Control-Allow-Origin: *');
include_once('../dbConnection.php');
    {
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
    }
?>