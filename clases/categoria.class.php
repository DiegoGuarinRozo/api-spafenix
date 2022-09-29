<?php 

require_once 'respuestas.class.php';
require_once 'conexion/conexion.php';

class categoria extends conexion{
    public $Id_categoria = '';
    public $nombre = '';
    public $descripcionCat = '';

    public function listaCat($categorias){
        $_respuestas = new respuestas;
        if($categorias == 'Categorias'){
            $query = "SELECT * FROM categoria";
            $resp = parent::obtenerDatos($query);
            if($resp){
                return $resp;
            }else{
                $_respuestas -> error_500();
            }
        }
    }

    public function categoriaUnica($name){
        $_respuestas = new respuestas;
        $query = "SELECT * FROM categoria WHERE nombre = '$name'";
        $resp = $resp = parent::obtenerDatos($query);
        if($resp){
            return $resp;
        }else{
            $_respuestas -> error_500();
        }
    }


    public function aggCategoria_POST($datos){
        $_respuestas = new respuestas;
        $datos = json_decode($datos, true);
        if(!isset($datos['nombreCategoria'])){
            $_respuestas->error_400();
        }else{
            $this->nombre = $datos['nombreCategoria'];
            if(isset($datos['descripcionCat'])){$this->descripcionCat = $datos['descripcionCat'];}
            $query = "INSERT INTO categoria(nombre, descripcionCat) VALUES ('"  . $this->nombre . "', '" . $this->descripcionCat . "')";
            $resp = parent::nonQueryId($query);
            if($resp) {
                $respuesta = $_respuestas -> response;
                $respuesta["result"] = array("se ha agregado la categoria con ID: " => $resp );
                return $respuesta;
            }else{
                return $_respuestas -> error_500();
            }
        }
    }

    
    public function modCategoria_PUT($datos){
        $_respuestas = new respuestas;
        
        $datos = json_decode($datos,true);
        if(!isset($datos['Id_categoria'])){
            $_respuestas->error_400();
        }else{
            $this-> Id_categoria = $datos['Id_categoria'];
            if(isset($datos['nombreCategoria'])){$this->nombre = $datos['nombreCategoria']; }
            if(isset($datos['descripcionCat'])){$this->descripcionCat = $datos['descripcionCat']; }

            $query = "UPDATE categoria SET nombre = '" . $this->nombre . "', descripcionCat = '" . $this->descripcionCat . "' WHERE Id_categoria = '" . $this->Id_categoria . "'";
            
            $resp = parent::nonQuery($query);
            if($resp) {
                $respuesta = $_respuestas -> response;
                $respuesta["result"] = array("Se ha modificado con exito" );
                return $respuesta;
            }else{
                return $_respuestas -> error_500();
            }
        }
    }

    public function deleteCategoria($dato){
        $_respuestas = new respuestas;
        $query = "DELETE FROM categoria WHERE Id_categoria = " . $dato;
        $resp = parent::nonQuery($query);    
        if($resp>=1){
            $respuesta = $_respuestas -> response;
            $respuesta["result"] = array("La categoria fue eliminada");
            return $respuesta;
        }else{
            return $_respuestas ->error_500();
        }
    }
    
}


?>