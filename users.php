<?php 

require_once "clases/respuestas.class.php";
require_once "clases/users.class.php";

$_respuestas = new respuestas;
$_users = new users;

if($_SERVER['REQUEST_METHOD']=="GET"){

    
    if(isset($_GET['id'])){
        $userId = $_GET['id'];
        $datosUser = $_users -> obtenerUser($userId);
        header("Content-Type: application/json");
        echo json_encode($datosUser);
        
        http_response_code(200);
    }
    

}else if($_SERVER['REQUEST_METHOD'] == "POST"){

    

    $postBody = file_get_contents("php://input");
    $datosArray = $_users -> post($postBody);
    header("Content-Type: application/json");
    if (isset($datosArray["result"]["error_id"])){
        $resposeCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);
    
    
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){

    $postBody = file_get_contents("php://input");
    $datosArray = $_users -> put($postBody);
    header('Content-Type: application/jason');

    if(isset($datosArray["result"]["error_id"])){

        $responseCode= $datosArray["result"]["error_id"];
        http_response_code($responseCode);
 
     }else{
        http_response_code(200);
     }
     echo json_encode($datosArray);
     
     

}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){

    $postBody = file_get_contents("php://input");
    $datosArray = $_users -> delete($postBody);
    
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
    $datosArray = $_respuestas -> error_400();
    echo json_encode($datosArray);
}

?>