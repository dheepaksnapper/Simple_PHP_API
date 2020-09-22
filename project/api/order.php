<?php

$request_method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

header('Content-Type: application/json');

if (!isset($input['jwt'])) {
    echo json_encode(array(
        'responce_code' => 401,
        'message' => 'no token provided for authorization',
    ));
    die();
}


require_once('../model/TokenAuth.php');
$auth = new TokenAuth();

if (!$auth->verify_token($input['jwt'])) {
    echo json_encode(array(
        'responce_code' => 401,
        'message' => 'invalid Totken',
    ));
    die();
}

require_once('../model/Order.php');

switch ($request_method) {
    case 'GET':
        $order = new Order();
        $data = $order->read_orders();
        if ($data) {
            echo json_encode(array(
                'responce_code' => 200,
                'message' => 'success!',
                'data' => $data
            ));
        }
        break;

    case 'POST':
        if (isset($input['date']) && isset($input['item']) && isset($input['employee'])) {
            $order  = new Order();
            $order->date = $input['date'];
            $order->item = $input['item'];
            $order->employee = $input['employee'];
            if ($order->write_order()) {
                echo json_encode(array(
                    'responce_code' => 200,
                    'message' => 'order created!',
                ));
            }
            else {
                echo json_encode(array(
                    'responce_code' => 401,
                    'message' => 'cannot create order',
                ));
            }
        }
        else {
            echo json_encode(array(
                'responce_code' => 401,
                'message' => 'inputs invalid to create order',
            ));
        }

       break;
    default:
        echo json_encode(array(
            'responce_code' => 404,
            'message' => 'invalid request method',
        ));
        break;
}
