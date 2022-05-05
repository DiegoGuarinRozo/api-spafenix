<?php 

require_once "clases/cotizacion.class.php";
require_once "clases/respuestas.class.php";

$_respuestas = new respuestas;
$_cotizacion = new cotizacion;

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $postBody = file_get_contents("php://input");
    $datosArray = $_cotizacion -> post($postBody);
    header('content-Type: application/json');

    if(isset($datosArray['result']['error_id'])){

        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);

    }else{
        http_response_code(200);
    }

    echo json_encode($datosArray);

}else if($_SERVER[('REQUEST_METHOD')] == "GET"){

    if(isset($_GET['cedula'])){
        $cotizacion = $_GET['cedula'];
        $respuesta = $_cotizacion -> obtenerCotizacion($cotizacion);
        echo $respuesta;
        header("Content-Type: application/json");
        http_response_code(200);
    }

    if(isset($_GET['cotizaciones'])){
        $cotizaciones = $_GET['cotizaciones'];
        $respuesta = $_cotizacion ->obtenerCotizaciones($cotizaciones);
        echo json_encode($respuesta);
        header("Content-Type: application/json");
        http_response_code(200);
    }

}else if($_SERVER['REQUEST_METHOD'] == 'PUT'){
    $postBody = file_get_contents('php://input');
    $respuesta = $_cotizacion ->put($postBody);
    header('content-Type: application/json');

    if(!isset($respuesta['result']['error_id'])){
        $responseCode = $respuesta["result"]["error_id"];
        http_response_code($responseCode);

    }else{
        http_response_code(200);
    }

    echo json_encode($respuesta);
}  




?>