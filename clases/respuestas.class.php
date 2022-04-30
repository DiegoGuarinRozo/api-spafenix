<?php 

class respuestas{

    public $response = [
        'status' => "ok",
        "result" => array()
    ];

    public function error_405(){
        $this->response['status']=" error";
        $this->response['result']= array(
            "error_id" => "405",
            "eror_msg" => "metodo no permitido"
        );
        return $this->response;
    }

    public function error_200($valor ="datos incorrectos"){
        $this->response['status']=" error";
        $this->response['result']= array(
            "error_id" => "200",
            "eror_msg" => $valor
        );
        return $this->response;

    }

   public function error_400(){
        $this->response['status']=" error";
        $this->response['result']= array(
            "error_id" => "400",
            "eror_msg" => "datos enviados incorrectos o con formato incompleto"
        );
        return $this-> response;

    }
    public function error_500($valor ="Error interno del servidor"){
        $this->response['status']=" error";
        $this->response['result']= array(
            "error_id" => "500",
            "eror_msg" => $valor
        );
        return $this->response;

    }

    public function error_401($valor ="No autorizado"){
        $this->response['status']=" error";
        $this->response['result']= array(
            "error_id" => "401",
            "eror_msg" => $valor
        );
        return $this->response;

    }
}


?>