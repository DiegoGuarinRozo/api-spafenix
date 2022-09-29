<?php 

require_once "clases/respuestas.class.php";
require_once "clases/proveedor.class.php";

$_respuestas = new respuestas;
$_proveedor = new proveedor;

if($_SERVER['REQUEST_METHOD'] == "GET"){

    if(isset($_GET["provee"])){
        $proveedores = $_GET["provee"];
        $listaProveedores = $_proveedor -> listaProvee($proveedores);
        header("Content-Type: application/json");
        echo json_encode($listaProveedores);
        http_response_code(200);
    }else if (isset($_GET['nomProvee'])){
        $proveedorId = $_GET['nomProvee'];
        $datosProveedor = $_proveedor -> proveedorUnico($proveedorId);
        header("Content-Type: application/json");
        echo json_encode($datosProveedor);
        http_response_code(200);
    }


}else if($_SERVER['REQUEST_METHOD'] == "POST"){

    $postBody = file_get_contents("php://input");
    $datosArray = $_proveedor -> aggProveedor_POST($postBody);
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
    $datosArray = $_proveedor -> modProveedor_PUT($postBody);
    header('content-Type: application/json');

    if(isset($datosArray['result']['error_id'])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);

    }else{
        http_response_code(200);
    }

    echo json_encode($datosArray);


}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){

    if(isset($_GET["Id_categoria"])){
        $categoriaId = $_GET["Id_categoria"];
        $respuesta = $_categoria -> deleteCategoria($categoriaId);
        header("Content-Type: application/json");
        echo json_encode($respuesta);
        http_response_code(200);
    }   

}else{
    header('content-Type: application/jason');
    $datosArray = $_respuestas -> error_400();
    echo json_encode($datosArray);
}



?>