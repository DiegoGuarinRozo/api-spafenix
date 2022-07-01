<?php 

require_once 'respuestas.class.php';
require_once 'conexion/conexion.php';

class proveedor extends conexion{
    public $Id_proveedor = '';
    public $nombre = '';
    public $nit = '';
    public $correo = '';
    public $telefono = '';

    public function listaProvee($proveedores){
        $_respuestas = new respuestas;
        if($proveedores == 'Proveedores'){
            $query = "SELECT * FROM proveedor";
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
}

?>