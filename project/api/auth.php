<?php

$request_method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);
var_dump($input);

header('Content-Type: application/json');

if ($request_method != 'POST') {
    die(json_encode(array(
        'responce_code' => 401,
        'message' => 'authentication can be done only with POST request',
    )));
}

if (isset($input['username']) && isset($input['password'])) {
    require_once('../model/User.php');
    $user = new User();
    $user->username = $input['username'];
    $user->password = $input['password'];
    if ($user->login_user()) {
        require_once('../model/TokenAuth.php');
        $tokenauth = new TokenAuth();
        $token = $tokenauth->generate_token($user);
        if ($token) {
            die(json_encode(array(
                'responce_code' => 200,
                'message' => 'authentication succes!',
                'jwt' => $token
            )));
        }
        else {
            die(json_encode(array(
                'responce_code' => 401,
                'message' => 'not a valid user',
            )));
        }
    } 
    else {
        die(json_encode(array(
            'responce_code' => 401,
            'message' => 'authentication falied : invalid credentials',
        )));
    }
}
else {
    die(json_encode(array(
        'responce_code' => 401,
        'message' => 'username and password required for authentication',
    )));
}
