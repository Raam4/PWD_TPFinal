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

    public function manage($param){
        $obj = $this->buscar($param);
        if(is_null($obj[0]['usdeshabilitado']) || $obj[0]['usdeshabilitado']=='0000-00-00 00:00:00'){
            $obj[0]['usdeshabilitado'] = date('Y-m-d H:i:s');
        }else{
            $obj[0]['usdeshabilitado'] = null;
        }
        return $this->modificacion($obj[0]);
    }
}
?>