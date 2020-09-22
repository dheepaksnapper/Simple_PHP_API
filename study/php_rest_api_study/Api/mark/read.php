<?php

    // require '../../vendor/autoload.php';
    // use \Firebase\JWT\JWT;
    

    // allow access to all 
    header('Access-Control-Allow-Orgin: *'); // we can authendicate it wit the Json tokens Also currently studying on that sir!
    header('Content-Type: application/json');

    // include the dbclass and data handler class 
    include_once '../../Database/Database.php';
    include_once '../../Handler/Mark.php';
    // db connection 
    $database = new Database();
    $db_con = $database->connect();

    // Mark data Handler Instance
    $mark = new Mark($db_con);
    $result_Set = $mark->read_marks();

    // return the marks data as json 
    $marks_count = $result_Set->rowCount();
    $marks_array = array();

    if($marks_count > 0) {
        while ($row = $result_Set->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $marks_row = array(
                'id' => $id,
                'name' => $name,
                'technical' => $technical,
                'non-technical' => $nontechnical
            );
            array_push($marks_array,$marks_row);
        }
        echo json_encode($marks_array);
    } else {
        echo json_encode(
            array(
                'message' => 'No Marks Entry : ('
            )
        );
    }
?>
