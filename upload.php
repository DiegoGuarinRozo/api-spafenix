<?php 
 header('Access-Control-Allow-Origin: *');
 header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
 header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
 header("Allow: GET, POST, OPTIONS, PUT, DELETE");

 require_once "clases/respuestas.class.php";
 require_once "clases/conexion/conexion.php";

 $_conexion = new conexion;
 $_respuestas = new respuestas;

 if($_SERVER['REQUEST_METHOD'] == "POST"){

    $folderPath = "upload/productos/"; 
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_ext = strtolower(end(explode('.',$_FILES['file']['name'])));
    $queryId = "SELECT Id_producto FROM producto ORDER BY  Id_producto DESC ";
    $respId = $_conexion->obtenerDatos($queryId);    
    if($respId){
        $file = $folderPath . 'producto_'.$respId[1]['Id_producto'] . '.'.$file_ext;
        echo $file;
        move_uploaded_file($file_tmp, $file);
    }else{
        $_respuestas -> error_500();
    }

    $queryUpload = "UPDATE producto SET upload = '".$file."' WHERE Id_producto = " . $respId[1]['Id_producto'];
    echo $queryUpload;
    $resp = $_conexion->nonQuery($queryUpload);
    if($resp) {
        return $resp;
    }else{
        return 0;
    }
 
}


?>