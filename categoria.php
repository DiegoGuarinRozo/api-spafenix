<?php

require_once 'clases/categoria.class.php';
require_once 'clases/respuestas.class.php';


$_respuestas = new respuestas;
$_categoria = new categoria;

if($_SERVER['REQUEST_METHOD'] == "GET"){

    if(isset($_GET["cat"])){
        $categorias = $_GET["cat"];
        $id = $_GET["id"];
        $listaCategorias = $_categoria -> listaCat($categorias, $id);
        header("Content-Type: application/json");
        echo json_encode($listaCategorias);
        http_response_code(200);
    }else if (isset($_GET['nomCat'])){
        $categoriaId = $_GET['nomCat'];
        $datosCategoria = $_categoria -> categoriaUnica($categoriaId);
        header("Content-Type: application/json");
        echo json_encode($datosCategoria);
        http_response_code(200);
    }


}else if($_SERVER['REQUEST_METHOD'] == "POST"){

    $postBody = file_get_contents("php://input");
    $datosArray = $_categoria -> aggCategoria_POST($postBody);
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
    $datosArray = $_categoria -> modCategoria_PUT($postBody);
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