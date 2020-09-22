<?php

$request_method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

header('Content-Type: application/json');

if ($request_method != 'POST') {
    die(json_encode(array(
        'responce_code' => 401,
        'message' => 'user api demands only POST method',
    )));
}

require_once('..\..\autoload.php');
if ( isset($input['userid']) && isset($input['username']) && isset($input['email']) && isset($input['password']) ) {
    $user = new User();
    $user->user_id = $input['userid'];
    $user->username = $input['username'];
    $user->email = $input['email'];
    $user->password = $input['password'];
    if ($user->create_user()) {
        die(json_encode(array(
            'responce_code' => 200,
            'message' => 'user succesfully created !',
        )));
    } 
    else {
        die(json_encode(array(
            'responce_code' => 401,
            'message' => 'user creation failed',
        )));
    }
}
else {
    die(json_encode(array(
        'responce_code' => 401,
        'message' => 'field missing for create user',
    )));
}
