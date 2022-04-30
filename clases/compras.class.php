<?php 

require_once "clases/conexion/conexion.php";
require_once "respuestas.class.php";
require_once "producto.class.php";

class compras extends conexion{
    
    private $table = "venta_productos";
    private $id_venta = ""; 
    private $total_venta = "";
    private $total_inversion = "";
    private $ganancia_venta = "";
    private $fecha_venta = "0000-00-00";
    private $cantidad = "";
    private $id_producto = "";
    private $id_ventaProducto = "";
    private $nombreProducto = "";
    private $precioCosto = "";
    private $precioPublico = "";
    private $cantidadProducto = "";
    private $rentabilidad = "";



    public function post($json){

        $_respuestas = new respuestas;
        $_producto = new producto;

        $datos = json_decode($json,true);

        if(!isset($datos['cantidad']) || !isset($datos['id_producto']) || !isset($datos['fecha_venta'])){
            return $_respuestas -> error_400();

        }else{

            $this -> cantidad = $datos['cantidad'];
            $this -> id_producto = $datos['id_producto'];
            $this -> fecha_venta = $datos['fecha_venta'];

            $datosProducto = $_producto -> obtenerProducto($this->id_producto);
            

            foreach ($datosProducto as $key => $value) {

                $this-> id_producto = $value['Id_producto'] ; 
                $this-> nombreProducto = $value['nombre'] ;
                $this-> precioCosto = $value['precio_costo'] ;
                $this-> precioPublico =  $value['precio_publico'];

            } 
           
            $resp = $this-> registrarVentaProducto();
            if($resp){
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

    private function registrarVentaProducto(){


        $query = " INSERT INTO " . $this->table . " (Id_producto , nombre, cantidad, precioPublico, precioCosto, fecha_venta)
        values 
        ('" . $this->id_producto . "','" . $this->nombreProducto . "','" . $this->cantidad . "','" . $this-> precioPublico . "','" . $this->precioCosto . "','" . $this->fecha_venta . "')";

        $resp = parent::nonQueryId($query);
        echo $resp;
        if($resp){
            return $resp;
        }else{
            return 0;
        }


    }


}

?>