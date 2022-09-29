<?php 

require_once "clases/respuestas.class.php";
require_once "clases/producto.class.php";


$_respuestas = new respuestas;
$_producto = new producto;

if($_SERVER['REQUEST_METHOD'] == "GET"){

    if(isset($_GET["product"])){
        $productos = $_GET["product"];
        $listaProductos = $_producto -> listaProductos($productos);
        header("Content-Type: application/json");
        echo json_encode($listaProductos);
        http_response_code(200);
    }else if (isset($_GET['Nameproduct'])){
        $productoId = $_GET['Nameproduct'];
    
        $datosProducto = $_producto -> obtenerProducto($productoId);
        header("Content-Type: application/json");
        echo json_encode($datosProducto);
        http_response_code(200);
    }


}else if($_SERVER['REQUEST_METHOD'] == "POST"){

    $postBody = file_get_contents("php://input");
    $datosArray = $_producto -> post($postBody);
    header('content-Type: application/json');

    if(isset($datosArray['result']['error_id'])){

        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);

    }else{
        http_response_code(200);
    }

    echo json_encode($datosArray);


}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    
    $postBody = file_get_contents("php://input");
    $datosArray = $_producto -> put($postBody);
    header('content-Type: application/json');

    if(isset($datosArray['result']['error_id'])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);

    }else{
        http_response_code(200);
    }

    echo json_encode($datosArray);


}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
    if(isset($_GET["Id_producto"])){
        $productos = $_GET["Id_producto"];
        $listaProductos = $_producto -> eliminarProducto($productos);
        header("Content-Type: application/json");
        echo json_encode($listaProductos);
        http_response_code(200);
    }

}else{
    header('content-Type: application/jason');
    $datosArray = $_respuestas -> error_400();
    echo json_encode($datosArray);
}


?>