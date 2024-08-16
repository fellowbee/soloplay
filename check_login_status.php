<?php
session_start();
header('Content-Type: application/json');

$response = ['loggedIn' => isset($_SESSION['user'])];
echo json_encode($response);
?>
