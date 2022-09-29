<?php 

require_once 'respuestas.class.php';
require_once 'conexion/conexion.php';

class proveedor extends conexion{
    public $Id_proveedor = '';
    public $nombre = '';
    public $nitProveedor = '';
    public $correo = '';
    public $telefono = '';

    public function listaProvee($proveedores, $id){
        $_respuestas = new respuestas;
        if($proveedores == 'Proveedores'){
            $query = "SELECT * FROM proveedor ORDER BY Id_proveedor = $id DESC";
            echo $query;
            $resp = parent::obtenerDatos($query);
            if($resp){
                return $resp;
            }else{
                $_respuestas -> error_500();
            }
        }
    }

    public function proveedorUnico($name){
        $_respuestas = new respuestas;
        $query = "SELECT * FROM proveedor WHERE nombre = '$name'";
        $resp = $resp = parent::obtenerDatos($query);
        if($resp){
            return $resp;
        }else{
            $_respuestas -> error_500();
        }
    }

    public function aggProveedor_POST($datos){
        $_respuestas = new respuestas;
        $datos = json_decode($datos, true);
        if(!isset($datos['nombreProveedor'])){
            $_respuestas->error_400();
        }else{
            $this->nombre = $datos['nombreProveedor'];
            if(isset($datos['nitProveedor'])){$this->nitProveedor = $datos['nitProveedor'];}
            if(isset($datos['correo'])){$this->correo = $datos['correo'];}
            if(isset($datos['telefono'])){$this->telefono = $datos['telefono'];}


            $query = "INSERT INTO categoria(nombre,nit,correo,telefono) VALUES ('"  . $this->nombre . "', '" . $this->nitProveedor . "', '" . $this->correo . "', '" . $this->correo . "')";

            $resp = parent::nonQueryId($query);
            if($resp) {
                $respuesta = $_respuestas -> response;
                $respuesta["result"] = array("se ha agregado el proveedor con ID: " => $resp );
                return $respuesta;
            }else{
                return $_respuestas -> error_500();
            }
        }
    }

    
    public function modProveedor_PUT($datos){
        $datosMod = [];
        $_respuestas = new respuestas;
        $datos = json_decode($datos,true);
        if(!isset($datos['Id_proveedor'])){
            $_respuestas->error_400();
        }else{
            $this-> Id_proveedor = $datos['Id_proveedor'];
            if(isset($datos['nombreProveedor'])){$this->nombre = $datos['nombreProveedor']; $datosMod['nombre'] = $this->nombre;}
            if(isset($datos['nitProveedor'])){$this->nitProveedor = $datos['nitProveedor']; $datosMod['nitProveedor'] = $this->nitProveedor;}
            if(isset($datos['correo'])){$this->correo = $datos['correo']; $datosMod['correo'] = $this->correo;}
            if(isset($datos['telefono'])){$this->telefono = $datos['telefono'];$datosMod['telefono'] = $this->telefono;}


            $query = " UPDATE proveedor SET ";
            foreach ($datosMod as $key => $value) {           
                    $query = $query  . "$key = '" .  $value . "', ";   
            }           
            $query1 = rtrim($query, ", ") .  " WHERE Id_proveedor= '" . $this->Id_proveedor . "'";
            $resp = parent::nonQuery($query1);

            if($resp) {
                $respuesta = $_respuestas -> response;
                $respuesta["result"] = array("Se ha modificado con exito" );
                return $respuesta;
            }else{
                return $_respuestas -> error_200('Modificado con exito');
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