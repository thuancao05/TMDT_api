<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$apiKey = '3a72216e9b25e1694487a18054cda761'; // Replace with your ImgBB API key

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Set up the ImgBB API endpoint
        $url = 'https://api.imgbb.com/1/upload';
        
        // Create the POST request to ImgBB
        $headers = ['Content-Type: multipart/form-data'];
        $postData = [
            'image' => curl_file_create($_FILES['image']['tmp_name'], $_FILES['image']['type'], $_FILES['image']['name']),
            'key' => $apiKey,
        ];
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        
        if ($response === false) {
            echo json_encode(['error' => 'Error uploading image.']);
        } else {
            echo $response;
        }
        
        curl_close($ch);
    } else {
        echo json_encode(['error' => 'Invalid file upload.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}
?>
