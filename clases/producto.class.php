<?php

require_once "respuestas.class.php";
require_once "clases/conexion/conexion.php";

class producto extends conexion{

    public $table = "producto";
    public $id = "";
    public $id_categoria = "";
    public $nit_proveedor = "";
    public $nombre = "";
    public $precio_costo = "";
    public $precio_pulico = "";
    public $iva = "";
    public $fecha_entrada = "0000-00-00";
    public $fecha_vencimiento = "0000-00-00";
    public $descripcion = '';
    public $id_proveedor = '';
    

    public function listaProductos($productos){
        $_respuestas = new respuestas;
        if($productos == "allProducts"){
            $query = "SELECT p.Id_producto,p.nombre as NombreProducto, p.upload, p.precio_costo, p.precio_publico, p.iva, p.fecha_entrada, p.fecha_vencimiento, p.descripcion,   c.nombre  as NombreCategoria, c.descripcionCat, pr.nombre as NombreProveedor, pr.nit as NitProveedor, (p.precio_publico-p.precio_costo) as rentabilidad
                    from producto p 
                    inner join categoria c on p.Id_categoria = c.Id_categoria
                    inner join proveedor pr on p.Id_proveedor = pr.Id_proveedor
                    order by p.Id_producto desc";
           // $query = "SELECT  * , (precio_publico-precio_costo) as rentabilidad FROM producto";
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
    public function obtenerProductoId($idProducto){
        $_respuestas = new respuestas;
        $query = "SELECT p.Id_producto,p.nombre as NombreProducto, p.upload, p.precio_costo, p.precio_publico, p.iva, p.fecha_entrada, p.fecha_vencimiento, p.descripcion, c.Id_categoria, c.nombre  as NombreCategoria, c.descripcionCat,p.Id_proveedor, pr.nombre as NombreProveedor, pr.nit as NitProveedor, (p.precio_publico-p.precio_costo) as rentabilidad
        from producto p 
        inner join categoria c on p.Id_categoria = c.Id_categoria
        inner join proveedor pr on p.Id_proveedor = pr.Id_proveedor WHERE Id_producto = '$idProducto'";
        
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

        if(!isset($datos['Id_categoria']) || !isset($datos['Id_proveedor']) || !isset($datos['nombre'])   || !isset($datos['precio_costo']) || !isset($datos['precio_publico']) || !isset($datos['fecha_entrada']) || !isset($datos['fecha_vencimiento']) || !isset($datos['iva'])){
            
            return $_respuestas -> error_400();
        }else {
            $this -> id_categoria = $datos['Id_categoria'];
            $this -> id_proveedor = $datos['Id_proveedor'];
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
        
        $query =  "INSERT INTO " . $this->table . " (Id_categoria, Id_proveedor, nombre, precio_costo, precio_publico, iva, fecha_entrada, fecha_vencimiento, descripcion)
        values 
        ('" . $this->id_categoria . "','" . $this->id_proveedor . "','" . $this->nombre . "','" . $this-> precio_costo . "','" . $this->precio_publico . "','" . $this->iva . "','" . $this->fecha_entrada . "','" . $this->fecha_vencimiento . "','" . $this->descripcion . "')";
        // "INSERT INTO producto (Id_categoria, Id_proveedor, nombre, precio_costo, precio_publico, iva, fecha_entrada, fecha_vencimiento) values ('" . $this->id_categoria . "','" . $this->id_proveedor . "','" . $this->nombre . "','" . $this->precio_costo . "','" . $this->precio_publico "','" . $this->iva . "','" . $this->fecha_entrada . "','" . $this->fecha_vencimiento . "')";  

        $resp = parent::nonQueryId($query);
        if($resp){
            return $resp;
        }else{
            return 0;
        }
    }


    public function put($json){
        $datosMod = [];
        $_respuestas = new respuestas;

        $datos = json_decode($json,True);

        if(!isset($datos['Id_producto'])){
            echo 'holaaa';
            return $_respuestas->error_400();
        }else{
            $this -> id = $datos['Id_producto'];
            if(isset($datos['nombre'])){$this -> nombre= $datos['nombre']; $datosMod['nombre'] = $this -> nombre; }
            if(isset($datos['Id_categoria'])){ $this->categoria = $datos['Id_categoria'];$datosMod['Id_categoria'] = $this -> categoria;}
            if(isset($datos['Id_proveedor'])){$this->nit_proveedor = $datos['Id_proveedor']; $datosMod['Id_proveedor'] = $this -> nit_proveedor;}
            if(isset($datos['precio_costo'])){$this->precio_costo = $datos['precio_costo']; $datosMod['precio_costo'] = $this -> precio_costo;}
            if(isset($datos['precio_publico'])){$this->precio_publico = $datos['precio_publico'];$datosMod['precio_publico'] = $this -> precio_publico;}
            if(isset($datos['iva'])){$this->iva = $datos['iva'];$datosMod['iva'] = $this -> iva;}
            if(isset($datos['fecha_entrada'])){$this->fecha_entrada = $datos['fecha_entrada']; $datosMod['fecha_entrada'] = $this -> fecha_entrada;}
            if(isset($datos['fecha_vencimiento'])){$this->fecha_vencimiento = $datos['fecha_vencimiento']; $datosMod['fecha_vencimiento'] = $this -> fecha_vencimiento; }
            if(isset($datos['descripcion'])){$this->descripcion = $datos['descripcion']; $datosMod['descripcion'] = $this -> descripcion; }
            $resp = $this -> modificarProduto($datosMod);
            
            if($resp){
                $respuesta = $_respuestas -> response;
                $respuesta["result"] = array(
                    "se ha modificado el producto"
                );
                return $respuesta;
            }{
                return $_respuestas -> error_200('No se ha realizado ningun cambio');
            }
        }
    }

 

    private function modificarProduto($datosMod){
        
        $query = " UPDATE producto SET ";
        foreach ($datosMod as $key => $value) {           
                $query = $query  . "$key = '" .  $value . "', ";   
        }
        
        $query1 = rtrim($query, ", ") .  " WHERE Id_producto= '" . $this->id . "'";
        $resp = parent::nonQuery($query1);
        //echo $query1;
        //echo $resp;
        if($resp) {
            return $resp;
        }else{
            return 0;
        }
    }

   /*  public function delete($dato){

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

    } */

    public function eliminarProducto($dato){
        $query = "DELETE FROM " . $this->table . " WHERE Id_producto = '" . $dato . "'";
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