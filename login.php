<?php 

require_once "clases/respuestas.class.php";
require_once "clases/login.class.php";


$_respuestas = new respuestas;
$_login = new login;


if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $postBody = file_get_contents('php://input');
    $datosArray = $_login -> logins($postBody);

    header('content-Type: application/jason');
    
    if(isset($datosArray["result"]["error_id"])){

        $responseCode= $datosArray["result"]["error_id"];
        http_response_code($responseCode);

    }else{
        http_response_code(200);
    }

    echo json_encode($datosArray);

}else{
    header('content-Type: application/jason');
    $datosArray = $_respuestas -> error_405();
    echo json_encode($datosArray);
}




?>