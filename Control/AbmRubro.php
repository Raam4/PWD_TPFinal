<?php
class AbmRubro extends AbmSuper{
    
    public function __construct(){
        $this->clase = new Rubro();
        $this->id = 'idrubro';
    }

    public function subrubros($param){
        $res = array();
        $rubro = new Rubro();
        $obj = $rubro->retornaObj($param['idrubro']);
        foreach($obj->subrubros()->find_many() as $subrubro){
            array_push($res, $subrubro->as_array());
        }
        return $res;
    }

    public function manage($param){
        $obj = $this->buscar($param);
        if(is_null($obj[0]['rudeshabilitado']) || $obj[0]['rudeshabilitado']=='00-00-00 00:00:00'){
            $obj[0]['rudeshabilitado'] = date('Y-m-d H:i:s');
        }else{
            $obj[0]['rudeshabilitado'] = null;
        }
        return $this->modificacion($obj[0]);
    }
}
?>