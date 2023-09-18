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


$postData = file_get_contents("php://input");
// Decode the JSON data sent in the request
$requestData = json_decode($postData, true);
$ID = $requestData['params']['ID'];

$arr = array();
$sql = "SELECT xaid AS value
                    ,name AS label
                         FROM devvn_xaphuongthitran WHERE maqh = '$ID'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        array_push($arr, $row);
    }
    echo json_encode($arr);
} else {
    echo "0 Result";
}
