<?php
session_start();

$response = [
    'loggedIn' => false,
    'userInitial' => ''
];

if (isset($_SESSION['logged_in'])) {
    $response['loggedIn'] = true;
    $response['userInitial'] = strtoupper(substr($_SESSION['user_name'], 0, 1));
}

header('Content-Type: application/json');
echo json_encode($response);
?>