<?php 
 require_once "clases/respuestas.class.php";
 require_once "clases/conexion/conexion.php";

 $_conexion = new conexion;
 $_respuestas = new respuestas;

 if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_GET["id_prod"])){
        $id_prod = $_GET["id_prod"];
        $folderPath = "upload/productos/"; 
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_ext = strtolower(end(explode('.',$_FILES['file']['name'])));
        $file = $folderPath . 'producto_'.$id_prod. '.'.$file_ext;
        move_uploaded_file($file_tmp, $file);
        $queryUpload = "UPDATE producto SET upload = '". $file ."' WHERE Id_producto = $id_prod";
        $respUpload = $_conexion->nonQuery($queryUpload);
    } else {
        $folderPath = "upload/productos/"; 
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_ext = strtolower(end(explode('.',$_FILES['file']['name'])));
        $queryId = "SELECT Id_producto FROM producto ORDER BY  Id_producto DESC LIMIT 1";
        $respId = $_conexion->obtenerDatos($queryId);    
        if($respId){
            $file = $folderPath . 'producto_'.$respId[0]['Id_producto'] . '.'.$file_ext;
            move_uploaded_file($file_tmp, $file);
            
            $queryUpload = "UPDATE producto SET upload ='". $file ."' WHERE Id_producto = " . $respId[0]['Id_producto'];
            echo $queryUpload;
            $respUpload = $_conexion->nonQuery($queryUpload);
            if($respUpload) {
                return $respUpload;
            }else{
                return 0;
            }
        }else{
            $_respuestas -> error_500();
        }
    }

}
 

?>