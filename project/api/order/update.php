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

if (isset($input['id']) && isset($input['date']) && isset($input['item']) && isset($input['employee'])) {
    $order  = new Order();
    $order->date = $input['date'];
    $order->item = $input['item'];
    $order->employee = $input['employee'];
    $order->id = $input['id'];
    if ($order->update_order()) {
        
        echo json_encode(array(
            'responce_code' => 200,
            'message' => 'order update!',
        ));
    }
    else {
        echo json_encode(array(
            'responce_code' => 401,
            'message' => 'cannot update order',
        ));
    }
}
else {
    echo json_encode(array(
        'responce_code' => 401,
        'message' => 'inputs invalid to update order',
    ));
}
