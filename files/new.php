<?php

// Get the 'id' parameter from the URL
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Check if the id is provided
if (!$id) {
    header('Content-Type: application/json', true, 400);
    echo json_encode(['error' => 'Missing id parameter']);
    exit;
}

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://axstream.vercel.app/getStream?id=' . urlencode($id) . '&uid=svYiu9E_S2bl0aaLW0&token=dOweSI7QmWPTKtHG0EYoSKBd1lE%3D&authToken=E6sB%2FGzpUQeLBMXhinXjTyiLl25zVFSQZEMw4rsPOSLX4b34TxuMICZSSyvccnXz&did=86f26b76-66e6-49c0-808a-aad7bedbf4cc',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
));

$response = curl_exec($curl);

curl_close($curl);

// Decode the response to check if it's valid JSON
$responseData = json_decode($response, true);

if (json_last_error() === JSON_ERROR_NONE) {
    // Set header for JSON response
    header('Content-Type: application/json');
    echo json_encode($responseData, JSON_PRETTY_PRINT);
} else {
    // Handle error case
    header('Content-Type: application/json', true, 500);
    echo json_encode(['error' => 'Invalid JSON response from API']);
}
