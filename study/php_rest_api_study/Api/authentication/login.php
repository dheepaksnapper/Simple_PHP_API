<?php

    ini_set("display_errors", 1);

    require '../../vendor/autoload.php';
    header('Access-Control-Allow-Orgin: *'); // we can authendicate it wit the Json tokens Also currently studying on that sir!
    header('Content-Type: application/json');

    include_once '../../Database/Database.php';
    include_once '../../Handler/User.php';

    $database = new Database();
    $db_con = $database->connect();

    // user handler
    
    $data = json_decode(file_get_contents("php://input"));
    $user = new User($db_con,$data->email,$data->password);

    if(!empty($data->email) && !empty($data->password)) {
        if($user->login_user()) {
            echo json_encode(array(
                'status' => 200,
                'message' => 'Login Succesfull',
                'token' => $user->generate_token()
            ));
        } else {
            echo json_encode(array(
                'status' => 201,
                'message' => 'Login Failed',
            ));
        }

    } else {
        http_response_code(404);
        echo json_encode(array(
            'status' => 0,
            'message' => 'needed credentials'
        ));
    }

?>
