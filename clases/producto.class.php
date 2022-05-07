<?php

require_once "respuestas.class.php";
require_once "clases/conexion/conexion.php";

class producto extends conexion{

    public $table = "producto";
    public $id = "";
    public $categoria = "";
    public $nit_proveedor = "";
    public $nombre = "";
    public $precio_costo = "";
    public $precio_pulico = "";
    public $iva = "";
    public $fecha_entrada = "0000-00-00";
    public $fecha_vencimiento = "0000-00-00";

    public function listaProductos($productos){
        $_respuestas = new respuestas;
        if($productos == "allProducts"){
            
            $query = "SELECT  * , (precio_publico-precio_costo) as rentabilidad FROM producto";
            $resp = parent::obtenerDatos($query);
            
            if($resp){
                return $resp;
            }else{
                $_respuestas -> error_500();
            }
        }
    }

    public function obtenerProducto($name){
        $_respuestas = new respuestas;
        $query = "SELECT  * , (precio_publico-precio_costo) as rentabilidad FROM producto WHERE nombre = '$name'";
        $resp = parent::obtenerDatos($query);
        if($resp){
            return $resp;
        }else{
            $_respuestas -> error_500();
        }
    }



    public function post($json){

        $_respuestas = new respuestas;
        $datos = json_decode($json,true);

        if(!isset($datos['categoria']) || !isset($datos['nit_proveedor']) || !isset($datos['nombre'])   || !isset($datos['precio_costo']) || !isset($datos['precio_publico']) || !isset($datos['fecha_entrada']) || !isset($datos['fecha_vencimiento']) || !isset($datos['iva'])){
            return $_respuestas -> error_400();
        }else {
            $this -> categoria = $datos['categoria'];
            $this -> nit_proveedor = $datos['nit_proveedor'];
            $this -> nombre = $datos['nombre'];
            $this -> iva = $datos['iva'];
            $this -> precio_costo = $datos['precio_costo'];
            $this -> precio_publico = $datos['precio_publico'];
            $this -> fecha_entrada = $datos['fecha_entrada'];
            $this -> fecha_vencimiento = $datos['fecha_vencimiento'];
            $resp = $this->insertarProducto();
            if($resp){
                
                $respuesta = $_respuestas -> response;
                $respuesta["result"] = array(
                    "se ha agregado el producto con ID: " => $resp
                );
                return $respuesta;
            }else{
                return $_respuestas -> error_500();
            }
        }

    }

    private function insertarProducto(){
        $query =  " INSERT INTO " . $this->table . " (categoria, nit_proveedor, nombre, precio_costo, precio_publico, iva, fecha_entrada, fecha_vencimiento)
        values 
        ('" . $this->categoria . "','" . $this->nit_proveedor . "','" . $this->nombre . "','" . $this-> precio_costo . "','" . $this->precio_publico . "','" . $this->iva . "','" . $this->fecha_entrada . "','" . $this->fecha_vencimiento . "')";
        // "INSERT INTO producto (Id_categoria, Id_proveedor, nombre, precio_costo, precio_publico, iva, fecha_entrada, fecha_vencimiento) values ('" . $this->id_categoria . "','" . $this->id_proveedor . "','" . $this->nombre . "','" . $this->precio_costo . "','" . $this->precio_publico "','" . $this->iva . "','" . $this->fecha_entrada . "','" . $this->fecha_vencimiento . "')";  
        echo $query;
        $resp = parent::nonQueryId($query);
        if($resp){
            return $resp;
        }else{
            return 0;
        }
    }


    public function put($json){

        $_respuestas = new respuestas;

        $datos = json_decode($json,True);

        if(!isset($datos['nombre'])){
            return $_respuestas->error_400();
        }else{
            $this -> nombre= $datos['nombre'];
            if(isset($datos['categoria'])){ $this->categoria = $datos['categoria'];}
            if(isset($datos['nit_proveedor'])){$this->nit_proveedor = $datos['nit_proveedor'];}
            if(isset($datos['id'])){$this->id = $datos['id'];}
            if(isset($datos['precio_costo'])){$this->precio_costo = $datos['precio_costo'];}
            if(isset($datos['precio_publico'])){$this->precio_publico = $datos['precio_publico'];}
            if(isset($datos['iva'])){$this->iva = $datos['iva'];}
            if(isset($datos['fecha_entrada'])){$this->fecha_entrada = $datos['fecha_entrada'];}
            if(isset($datos['fecha_vencimiento'])){$this->fecha_vencimiento = $datos['fecha_vencimiento'];}
            $resp = $this -> modificarProduto();
            
            if($resp){
                $respuesta = $_respuestas -> response;
                $resuesta['result'] = array(
                    "El producto ha sido modificado"
                );
                return $respuesta;
            }else{
                return $_respuestas -> error_500();
            }
        }
    }

 

    private function modificarProduto(){
        $query = " UPDATE " . $this->table . " SET categoria ='" . $this->categoria . "', nit_proveedor = '" . $this->nit_proveedor . "', nombre = '" . $this->nombre . "', precio_costo = '" . $this->precio_costo . "', precio_publico = '" . $this->precio_publico . "', iva = '" . $this->iva .
        "', fecha_entrada = '" . $this->fecha_entrada . "', fecha_vencimiento = '" . $this->fecha_vencimiento . "' WHERE nombre= '" . $this->nombre . "'";  
        
        $resp = parent::nonQuery($query);
        echo $resp;
        if($resp) {
            return $resp;
        }else{
            return 0;
        }
    }

    public function delete($json){

        $_respuestas = new respuestas;
        $datos = json_decode($json,true);

        if(!isset($datos['nombre'])){
            return $_respuestas -> error_400();
        }else{
            $this-> nombre = $datos['nombre'];
            $resp = $this->eliminarProducto();
            if ($resp){
                $respuesta = $_respuestas->response;
                $respuesta['result'] = array(
                    "El producto ". $this->nombre . " Fue eliminado"
                );
                return $respuesta;
            }else{
                return $_respuestas -> error_500();
            }
        }

    }

    private function eliminarProducto(){
        $query = "DELETE FROM " . $this->table . " WHERE nombre = '" . $this->nombre . "'";
        $resp = parent::nonQuery($query);
        echo $resp;
            if($resp>=1){
                return $resp;
            }else{
                return 0;
            }
        
    }

}


?>