<?php 

require_once "clases/conexion/conexion.php";
require_once "respuestas.class.php";
require_once "producto.class.php";

class cotizacion extends conexion{
    
    private $table = "cotizaciones";
    private $nombreCliente = ""; 
    private $fecha_cotizacion = "0000-00-00";
    private $cantidad = "";
    private $id_producto = "";
    private $nombreProducto = "";
    private $precioCosto = "";
    private $precioPublico = "";
    private $rentabilidad = "";
    private $cedulaCliente = "";
    private $id_cotizacion = "";
   

    public function post($json){

        $_respuestas = new respuestas;
        $_producto = new producto;

        $datos = json_decode($json,true);

        if(!isset($datos['cantidad']) || !isset($datos['nombreProducto']) || !isset($datos['fecha_cotizacion']) || !isset($datos['nombreCliente']) || !isset($datos['cedulaCliente']) ){
            return $_respuestas -> error_400();

        }else{
            $this -> cedulaCliente = $datos['cedulaCliente'];
            $this -> cantidad = $datos['cantidad'];
            $this -> nombreProducto = $datos['nombreProducto'];
            $this -> fecha_cotizacion = $datos['fecha_cotizacion'];
            $this -> nombreCliente = $datos['nombreCliente'];

            $datosProducto = $_producto -> obtenerProducto($this->nombreProducto);
            echo json_encode($datosProducto);

            foreach ($datosProducto as $key => $value) {

                $this-> id_producto = $value['Id_producto'] ; 
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
                    "la venta fue registrada"
                );
                return $respuesta;
            }else{
                $_respuestas -> error_500();
            }

        
        }

    }

    private function registrarCotProducto(){

        $query = " INSERT INTO " . $this->table . " (Id_producto, cedulaCliente, nombreProducto, nombreCliente, cantidad, precioPublico, precioCosto, fecha_cotizacion)
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


    public function obtenerCotizacion($cedula){
        
        $_respuestas = new respuestas;
        $query = "SELECT Id_cotizacion, nombreProducto, cantidad, precioPublico, cantidad*precioPublico as total FROM cotizaciones WHERE cedulaCliente = '$cedula'";
        $query2 = "SELECT  nombreCliente, cedulaCliente, fecha_cotizacion, sum(cantidad*precioPublico) as total FROM cotizaciones WHERE cedulaCliente = '" . "$cedula" . "'" ; 

        $resp1 = parent::nonQuery($query);
        $resp1_datos = parent:: obtenerDatos($query);
        $resp2 = parent::nonQuery($query2);
        $resp2_datos = parent:: obtenerDatos($query2);


        if ($resp1>=1){
            if($resp2>=1){
                return json_encode($resp1_datos) . json_encode($resp2_datos);
            }else{
                return json_encode( $_respuestas-> error_200("No se encontraron resultados"));
            }
        }else{
            return  json_encode( $_respuestas-> error_200("No se encontraron resultados"));
        }
        
    }

    public function obtenerCotizaciones($cotizaciones){

        $_respuestas = new respuestas;

        if($cotizaciones == 'cotizaciones'){
            $query = "SELECT  nombreCliente, cedulaCliente, fecha_cotizacion, sum(cantidad*precioPublico) as total FROM cotizaciones GROUP BY  cedulaCliente";
            $resp = parent::obtenerDatos($query);
            if($resp){
                return $resp;
            } else{
                return $_respuestas-> error_500();
            }
        }
    }

    public function put($json){

        $_respuestas = new respuestas;
        $_producto = new producto;
        $datos = json_decode($json,true);    
       
        if(!isset($datos['id_cotizacion'])){
            return $_respuestas ->error_400();

        }else{

            $this->id_cotizacion = $datos['id_cotizacion'];
            if(isset($datos['nombreProducto'])){ $this->nombreProducto = $datos['nombreProducto'];}
            if(isset($datos['cantidad'])){ $this->cantidad = $datos['cantidad'];}

            $datosProducto = $_producto -> obtenerProducto($this->nombreProducto);        
            echo json_encode($datosProducto);
    
            foreach ($datosProducto as $key => $value) {
                
                $this-> id_producto = $value['Id_producto'] ; 
                $this-> nombreProducto = $value['nombre'] ;
                $this-> precioCosto = $value['precio_costo'] ;
                $this-> precioPublico =  $value['precio_publico'];
                
            }
            
            
            $resp = $this->modificarProductoCotizacion();
    
            if($resp){
                $respuesta = $_respuestas ->response;
                $respuesta['result'] = array(
                    "Se ha realizado el cambio con exito"
                );

            }else{

                
            }
        }

        if(isset($datos['cedulaCliente']) || isset($datos['nombreCliente']) || isset($datos['fecha_cotizacion']) ){
            
            if(isset($datos['cedulaCliente'])){ 
                $this->cedulaCliente = $datos['cedulaCliente'];
                $query1 = "SELECT cedulaCliente";
                $query = "UPDATE cotizaciones SET cedulaCliente = '" . $this->cedulaCliente . "'";
            }
            if(isset($datos['nombreCliente'])){ $this->nombreCliente = $datos['nombreCliente'];}
            if(isset($datos['fecha_cotizacion'])){ $this->fecha_cotizacion = $datos['fecha_cotizacion'];}

            
        }
    }

    

    private function modificarProductoCotizacion(){

        $query = "UPDATE cotizaciones SET Id_producto ='" . $this-> id_producto . "', nombreProducto = '" . $this->nombreProducto . "', cantidad = '" . $this->cantidad . "', precioPublico = '" . $this->precioPublico . "', precioCosto = '" . $this->precioCosto . "' WHERE Id_cotizacion = '" .$this->id_cotizacion . "'";

        $resp = parent::nonQuery($query);
        if($resp >= 1){
            return $resp;
        }else{
            return 0;
        }
    }
}

?>