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
}
?>