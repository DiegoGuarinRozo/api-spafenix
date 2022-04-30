<?php 


class conexion {

    // se crean los atributos privados.
    
    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
    private $conexion;



    function __construct()
    {
        $listadatos = $this -> datosConexion(); # guardar todos los datos de la coneccion del archivo config convertidos array
        
        foreach($listadatos as $key => $value){ # recorrer cad un de las filas del array y almacenar en value 

            #traemos el valor de cada archivo 
            $this ->server = $value['server'];
            $this ->user = $value['user'];
            $this ->password = $value['password'];
            $this ->database = $value['database'];
            $this ->port  = $value['port'];

        }

        $this ->conexion = new mysqli($this->server, $this->user, $this-> password, $this->database, $this->port);
       
        if($this->conexion ->connect_errno){
            echo"algo va mal con la conexion";
            die();
        }

  
    }
    
    private function datosConexion(){ # funcion para obtener datos y convertir a un array
        $direccion = dirname(__FILE__); # almacenamos la dirrecion del archivo
        
        $jsondata = file_get_contents($direccion . "/" . "config"); # abrir archivo y guardar contenido
        
        return json_decode($jsondata, true); #convertir los datos de config en un array 
    }
   
    
    private function convertirUTF8($array){ # funcion para detectar caracteres no comunes "ñ", "tildes"; recibe un array con los datos 

        array_walk_recursive($array,function(&$item,$key){
            if(!mb_detect_encoding($item, 'utf-8',true)){
                $item=utf8_encode($item);
            }

        });
        return $array;
    }

    //--------- obetenemos los datos de la base de datos

    public function obtenerDatos($sqlstr){
        $results = $this->conexion->query($sqlstr); //resultados del query
        $resultArray = array();
        foreach ($results as $key) {
            $resultArray[] = $key;
        }
        return $this->convertirUTF8($resultArray);

    }

    //--------- la funcion nonQuery se usa para: Guardar, eliminar y editar
    public function nonQuery($sqlstr){
        $results= $this->conexion->query($sqlstr);
        return  $this-> conexion->affected_rows;
    }


    #INSERT ------ guardar y devolver el id de la fila 
    public function nonQueryId($sqlstr){
        $results= $this->conexion->query($sqlstr);
        $filas = $this-> conexion->affected_rows;
        if($filas >=1){
            return $this->conexion->insert_id;
        }else{
            return 0;
        }

    }

    protected function encriptar($string){
        return md5($string);
    }

 
}


?>