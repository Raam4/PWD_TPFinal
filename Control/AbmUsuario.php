<?php
class AbmUsuario extends AbmSuper{
    
    public function __construct(){
        $this->clase = new Usuario();
        $this->id = 'idusuario';
    }

    public function roles($param){
        $res = array();
        $obj = $this->clase->retornaObj($param[$this->id]);
        foreach($obj->roles()->find_many() as $rol){
            array_push($res, $rol->as_array());
        }
        return $res;
    }
}
?>