<?php

$request_method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);
header('Content-Type: application/json');

if ($request_method != 'POST') {
    echo json_encode(array(
        'responce_code' => 401,
        'message' => 'demands only post method',
    ));
    die();
}

if (!isset($input['jwt'])) {
    echo json_encode(array(
        'responce_code' => 401,
        'message' => 'no token provided for authorization',
    ));
    die();
}

require_once('..\..\autoload.php');
$auth = new TokenAuth();
if (!$auth->verify_token($input['jwt'])) {
    echo json_encode(array(
        'responce_code' => 401,
        'message' => 'invalid Totken',
    ));
    die();
}

$order = new Order();
$data = $order->read_orders();
if ($data) {
    echo json_encode(array(
        'responce_code' => 200,
        'message' => 'success!',
        'data' => $data
    ));
} else {
    echo json_encode(array(
        'responce_code' => 401,
        'message' => 'error fectching data',
    ));
}
die(); 