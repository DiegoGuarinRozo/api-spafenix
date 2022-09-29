<?php 

require_once "clases/conexion/conexion.php";
require_once "respuestas.class.php";
require_once "producto.class.php";

class cotizacion extends conexion{
    

    private $nombreCliente = ""; 
    private $fecha_cotizacion = "0000-00-00";
    private $cantidad = "";
    private $id_producto = "";
    private $nombreProducto = "";
    private $precioCosto = "";
    private $precioPublico = "";
    private $rentabilidad = "";
    private $cedulaCliente = "";
    private $Id_cotizacion = "";
    private $Id_producto = "";
   

    public function post($json){

        $_respuestas = new respuestas;
        $_producto = new producto;

        $datos = json_decode($json,true);

        if(!isset($datos['cantidad']) || !isset($datos['Id_producto']) || !isset($datos['fecha_cotizacion']) || !isset($datos['cedulaCliente']) ){
            return $_respuestas -> error_400();

        }else{
            $this -> cedulaCliente = $datos['cedulaCliente'];
            $this -> cantidad = $datos['cantidad'];
            $this -> id_producto = $datos['Id_producto'];
            $this -> fecha_cotizacion = $datos['fecha_cotizacion'];

            $datosProducto = $_producto -> obtenerProductoId($this->id_producto);
            echo json_encode($datosProducto);

            foreach ($datosProducto as $key => $value) {
                
                $this-> nombreProducto = $value['nombre'] ;
                $this-> precioCosto = $value['precio_costo'] ;
                $this-> precioPublico =  $value['precio_publico'];
            } 

               
            $resp = $this-> registrarCotProducto();
            $registroCot = $this->registroCotizacion();

            echo json_encode($registroCot);
            if($resp && $registroCot){
                $respuesta = $_respuestas -> response;
                $respuesta['result'] = array(
                    "la cotizacion fue registrada"
                );
                return $respuesta;
            }else{
                $_respuestas -> error_500();
            }        
        }
    }

    private function registrarCotProducto(){

        $query = " INSERT INTO cot_vent_fact (Id_producto, cedulaCliente, nombreProducto, nombreCliente, cantidad, precioPublico, precioCosto, fecha_cotizacion)
        values 
        ('" . $this->id_producto . "','" . $this->cedulaCliente . "','" . $this->nombreProducto . "','" .  $this->nombreCliente . "','" . $this->cantidad . "','" . $this-> precioPublico . "','" . $this->precioCosto . "','" . $this->fecha_cotizacion . "')";

        $resp = parent::nonQueryId($query);       
        if($resp){
            return $resp;
        }else{
            return 0;
        }
    }

    private function registroCotizacion(){
        $query = "SELECT sum(cantidad*precioPublico) as total, sum(cantidad*precioCosto) as inversion, sum(cantidad*precioPublico)-sum(cantidad*precioCosto) as ganancia FROM cotizaciones WHERE cedulaCliente = '" . $this->cedulaCliente . "'" ;  
        $resp = parent::obtenerDatos($query);

        if($resp){
            return $resp;
        }else{
            return 0;
        }

    }


    public function obtenerCotizacion($numFactura){ // ----------GET: OBTENER COTIZACION--------------
        
        $_respuestas = new respuestas;
        $query = "SELECT prod.Id_producto, prod.nombre, prod.precio_publico as ValorUnitario, cot.cantidad, prod.precio_publico* cot.cantidad as ValorTotal from producto prod inner join cot_vent_fact cot on (prod.Id_producto = cot.Id_producto) WHERE cot.mumFactura = $numFactura";

        $query2 = "SELECT sum(prod.precio_publico*cot.cantidad) as TOTAL from producto prod inner join cot_vent_fact cot on (prod.Id_producto = cot.Id_producto) WHERE cot.mumFactura = $numFactura"; 

        $resp1 = parent::nonQuery($query);
        $resp1_datos = parent:: obtenerDatos($query);
        $resp2 = parent::nonQuery($query2);
        $resp2_datos = parent:: obtenerDatos($query2);

        $respuestaCompleta = ['ProductosFactura' => $resp1_datos, 'TotalFactura' => $resp2_datos];

        if ($resp1>=1){
            if($resp2>=1){
                return json_encode($respuestaCompleta);
            }else{
                return json_encode( $_respuestas-> error_200("No se encontraron resultados"));
            }
        }else{
            return  json_encode( $_respuestas-> error_200("No se encontraron resultados"));
        }
        
    }

    public function obtenerCotizaciones($cotizaciones){
        $_respuestas = new respuestas;
        if($cotizaciones != null){ 
            $query = "SELECT cli.cedula, cli.nombre, sum(cot.cantidad * prod.precio_publico) AS TOTAL, cot.mumFactura, cot.fecha_cotizacion FROM clientes cli INNER JOIN cot_vent_fact cot ON (cli.Id_cliente = cot.Id_Cliente) INNER JOIN producto prod ON (prod.Id_producto = cot.Id_producto) GROUP BY cot.mumFactura";
            //$query = "SELECT  nombreCliente, cedulaCliente, fecha_cotizacion, sum(cantidad*precioPublico) as total FROM cotizaciones GROUP BY  cedulaCliente";
           
            $resp = parent::obtenerDatos($query);
            if($resp){
                return $resp;
            } else{
                return $_respuestas-> error_500();
            }
        }
    }

    public function put($json){
        $datosMod = [];
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);    
       
        if(!isset($datos['Id_cotizacion'])){
            return $_respuestas ->error_400();

        }else{
            $this->Id_cotizacion = $datos['Id_cotizacion'];
            if(isset($datos['Id_producto'])){ $this->Id_producto = $datos['Id_producto']; $datosMod['Id_producto'] =  $this->Id_producto;}
            if(isset($datos['cantidad'])){ $this->cantidad = $datos['cantidad']; $datosMod['cantidad'] =  $this->cantidad; }
                 
            $resp = $this->modificarProductoCotizacion($datosMod);
    
            if($resp){
                $respuesta = $_respuestas ->response;
                $respuesta['result'] = array(
                    "Se ha realizado el cambio con exito"
                );

            }else{
                return  json_encode( $_respuestas-> error_200("Error: no se pudo realizar el cambio"));                
            }
        }

    }



    private function modificarProductoCotizacion($datosMod){
        $query = " UPDATE cotizaciones SET ";
        foreach ($datosMod as $key => $value) {           
                $query = $query  . "$key = '" .  $value . "', ";   
        }
        $query1 = rtrim($query, ", ") .  " WHERE Id_cotizacion= '" . $this->Id_cotizacion . "'";
        $resp = parent::nonQuery($query1);

        echo $query1;
        echo $resp;
        if($resp>= 1) {
            return $resp;
        }else{
            return 0;
        }
    }
}

?>