<?php
class AbmMenuRol extends AbmSuper{
    
    public function seteadosCamposClaves($param){
        return isset($param[$this->id[0]]) && isset($param[$this->id[1]]);
    }

    public function __construct(){
        $this->clase = new MenuRol();
        $this->id = ['idmenurol', 'idrol'];
    }
}
?>