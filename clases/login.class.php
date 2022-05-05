<?php 

require_once "respuestas.class.php";
require_once "clases/conexion/conexion.php";

class login extends conexion{

    public function logins($json){

        $_respuestas = new respuestas;
        $datos = json_decode($json,true);

        if(!isset($datos['user']) || !isset($datos['password'])){
                return $_respuestas -> error_400();
        }else{

            $user = $datos['user'];
            $password = $datos['password'];
            //$password = parent::encriptar($password);
            $resp = $this-> obtenerUsuario($user);
            if($datos){

                if($resp[0]['correo'] == $user){

                    if($resp[0]['password']== $password){

                        $respuesta = $_respuestas-> response;
                        $respuesta['result'] = array(
                            "SE HA REALIZADO EL LOGN"
                        );
                        return $respuesta;

                    }else{
                       return $_respuestas -> error_200('contraseña incorrecta');
                    }

                }else{
                     return $_respuestas -> error_200("El usuario $user no existe");
                }
            }else{
                return $_respuestas-> error_500();
            }
            



        }

    }

    private function obtenerUsuario($correo){

        $query = "SELECT correo, password FROM user WHERE correo = '$correo'";
        $resp = parent::obtenerDatos($query);
        if($resp){
            return $resp;
        }else{
            return 0;
        }

    }


}




?>