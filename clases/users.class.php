<?php 

require_once 'respuestas.class.php';
require_once 'clases/conexion/conexion.php';

class users extends conexion{

    private $table = "user";
    private $id_user = "";
    private $id_type_user = "";
    private $nombre = "";
    private $correo = "";
    private $password = "";
    private $tipoUser = "";

    public function obtenerUser($id){
        $query = "SELECT * FROM " . $this->table. " WHERE Id_user = '$id'";
        return parent::obtenerDatos($query);

    }



    public function post($json){

        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        if(!isset($datos['id_type_user']) || !isset($datos['nombre']) || !isset($datos['correo']) || !isset($datos['password'])){
            return $_respuestas -> error_400();
        }else {
            //$this -> id_user = $datos['id_user'];
            $this -> id_type_user = $datos['id_type_user'];
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
        $query = "INSERT INTO " . $this->table . " ( Id_type_user, nombre, correo, password) VALUES ('" . $this->id_type_user . "','" . $this->nombre . "','" . $this->correo . "','" . $this->password . "')";

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
        
        if(!isset($datos['id_type_user']) || !isset($datos['id_user'])){
            return $_respuestas -> error_200("Se necesita el tipo de usuario que se va modificar");
        }else{
            $this -> id_user = $datos['id_user'];
            $this -> id_type_user = $datos['id_type_user'];
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
        $query = "UPDATE " . $this->table . " SET nombre = '" . $this->nombre . "', correo = '" . $this->correo . "', password = '" . $this->password . "' WHERE Id_user = '" . $this->id_user . "'";
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
        
        $this->tipoUser = $datos['id_type_user'];   
            
        $arrayUser = $this->obtenerTypeUser();
        
        $this->tipoUser = $arrayUser[0]['tipo'];

        if($this->tipoUser == "Administrador"){
            if(!isset($datos['id_user'])){
                return $_respuestas -> error_400();
            }else{
                $this->id_user = $datos['id_user'];
                $resp = $this->eliminarUser();

                if($resp){
                    $respuesta = $_respuestas -> response;
                    $respuesta["result"] = array(
                        "EL usuario ". $this->id_user . " Fue eliminado"
                    );
                    return $respuesta;
                }else{
                    return $_respuestas -> error_500();
    
                }
            }

        }else {
            return $_respuestas -> error_200("Se necesita permiso de administrador paraeliminar usuarios");

        }
        
    }

    private function obtenerTypeUser(){
        $query = "SELECT tipo  FROM typeuser WHERE Id_type_user = '" . $this->tipoUser . "'";
        $resp = parent::obtenerDatos($query);
        if(isset($resp)){
            return $resp;
        }else{
            return 0;
        }

    }

    private function eliminarUser(){
        $query = "DELETE FROM " . $this->table . " WHERE Id_user = '" . $this->id_user . "'";
        $resp =  parent::nonQuery($query);

        if($resp>=1){
            return $resp;
        }else{
            return "error";
        }
    }

    
}


?>