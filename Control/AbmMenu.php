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
}
?>