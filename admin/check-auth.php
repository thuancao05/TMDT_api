<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');


session_id('admin');
session_start();

if($_SESSION['check-auth'] == 'true'){
  if ($_SESSION['user'] == 'admin') {
    echo json_encode(['authenticated' => true, 'user' => $_SESSION['user']]);
  } else {
      echo json_encode(['authenticated' => true, 'user' => $_SESSION['user']]);
    } 
  
}else {
  http_response_code(401);
  echo json_encode(['authenticated' => false]);
  // echo json_encode("chua dang nhap");
}
