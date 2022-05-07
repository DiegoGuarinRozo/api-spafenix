<?php 

require_once 'respuestas.class.php';
require_once 'clases/conexion/conexion.php';

class users extends conexion{

    private $table = "user";
    private $id_user = "";
    private $tipo = "";
    private $nombre = "";
    private $correo = "";
    private $password = "";
    private $tipoUser = "";

    public function obtenerUser($correo){
        $query = "SELECT * FROM " . $this->table. " WHERE correo = '$correo'";
        return parent::obtenerDatos($query);

    }



    public function post($json){

        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        if(!isset($datos['tipo']) || !isset($datos['nombre']) || !isset($datos['correo']) || !isset($datos['password'])){
            return $_respuestas -> error_400();
        }else {
            //$this -> id_user = $datos['id_user'];
            $this -> tipo = $datos['tipo'];
            $this -> nombre = $datos['nombre'];
            $this -> correo = $datos['correo'];
            $this -> password = parent::encriptar($datos['password']);
            $resp = $this->insertarUser();
            if($resp){
                $respuesta = $_respuestas -> response;
                $respuesta["result"] = array(
                    "se agrego el usuario con id:" => $resp );
                
                return $respuesta;
            }else{
                return $_respuestas -> error_500();
            }
        }
    }

    private function insertarUser(){
        $query = "INSERT INTO " . $this->table . " ( tipo, nombre, correo, password) VALUES ('" . $this->tipo . "','" . $this->nombre . "','" . $this->correo . "','" . $this->password . "')";

        $resp = parent::nonQueryId($query);
        if($resp){
            return $resp;
        }else {
            return 0;
        }
    }



    public function put($json){

        $_respuestas = new respuestas;
        $datos = json_decode($json,true);
        
        if( !isset($datos['id_user'])){
            return $_respuestas -> error_200("datos incorrectos");
        }else{
            $this -> id_user = $datos['id_user'];
            if(isset($datos['tipo'])) {$this -> tipo = $datos['tipo'];}
            if(isset($datos['nombre'])){ $this-> nombre = $datos['nombre'];}
            if(isset($datos['correo'])){ $this-> correo = $datos['correo'];}
            if(isset($datos['password'])){ $this-> password = parent::encriptar($datos['password']);}
            $resp = $this->modificarUser();
            if($resp){
                $respuesta = $_respuestas ->response;
                $respuesta['result'] = array(
                    "El usuario ha sido modificado"
                );
                return $respuesta;
            }else{
                return $_respuestas -> error_500();
            }
        }

        
    }

    private function modificarUser(){
        $query = "UPDATE " . $this->table . " SET nombre = '" . $this->nombre . "', tipo = '" . $this->tipo . "', correo = '" . $this->correo . "', password = '" . $this->password . "' WHERE Id_user = '" . $this->id_user . "'";
        $resp = parent::nonQuery($query);
        if($resp>=1){
            return $resp;
        }else{
            return 0;
        } 

    }

    public function delete($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);
        
        $this->tipoUser = $datos['tipo'];   
            
        $arrayUser = $this->obtenerTypeUser();
        
        $this->tipoUser = $arrayUser[0]['tipo'];

        if($this->tipoUser == "Administrador"){
            if(!isset($datos['correo'])){
                return $_respuestas -> error_400();
            }else{
                $this->correo = $datos['correo'];
                $resp = $this->eliminarUser();

                if($resp){
                    $respuesta = $_respuestas -> response;
                    $respuesta["result"] = array(
                        "EL usuario ". $this->correo . " Fue eliminado"
                    );
                    return $respuesta;
                }else{
                    return $_respuestas -> error_500();
    
                }
            }

        }else {
            return $_respuestas -> error_200("Se necesita permiso de administrador para eliminar usuarios");

        }
        
    }

    private function obtenerTypeUser(){
        $query = "SELECT tipo  FROM typeuser WHERE tipo = '" . $this->tipoUser . "'";
        $resp = parent::obtenerDatos($query);
        if(isset($resp)){
            return $resp;
        }else{
            return 0;
        }

    }

    private function eliminarUser(){
        $query = "DELETE FROM " . $this->table . " WHERE correo = '" . $this->correo . "'";
        $resp =  parent::nonQuery($query);

        if($resp>=1){
            return $resp;
        }else{
            return "error";
        }
    }

    
}


?>