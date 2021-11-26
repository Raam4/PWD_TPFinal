<?php
class AbmMenu extends AbmSuper{
    
    public function __construct(){
        $this->clase = new Menu();
        $this->id = 'idmenu';
    }

    public function submenus($param){
        $res = array();
        $menu = new Menu();
        $obj = $menu->retornaObj($param['idmenu']);
        foreach($obj->submenus()->find_many() as $submenu){
            array_push($res, $submenu->as_array());
        }
        return $res;
    }

    public function manage($param){
        $obj = $this->buscar($param);
        if(is_null($obj[0]['medeshabilitado']) || $obj[0]['medeshabilitado']=='00-00-00 00:00:00'){
            $obj[0]['medeshabilitado'] = date('Y-m-d H:i:s');
        }else{
            $obj[0]['medeshabilitado'] = null;
        }
        return $this->modificacion($obj[0]);
    }
}
?>