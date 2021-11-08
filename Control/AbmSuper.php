<?php
class AbmSuper{
    public $clase;
    public $id;

    public function seteadosCamposClaves($param){
        return isset($param[$this->id]);
    }

    public function alta($param){
        return $this->clase->insertar($param);
    }
    
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $resp = $this->clase->eliminar($param);
        }
        return $resp;
    }
    
    public function modificacion($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $resp = $this->clase->modificar($param);
        }
        return $resp;
    }
    
    public function buscar($param){
        return $this->clase->listar($param);
    }
}
?>