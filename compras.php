<?php 

require_once "clases/compras.class.php";
require_once "clases/respuestas.class.php";

$_respuestas = new respuestas;
$_compras = new compras;

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $postBody = file_get_contents("php://input");
    $datosArray = $_compras -> post($postBody);
    header('content-Type: application/json');

    if(isset($datosArray['result']['error_id'])){

        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);

    }else{
        http_response_code(200);
    }

    echo json_encode($datosArray);
}




?>