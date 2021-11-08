<?php
class AbmRol extends AbmSuper{
    
    public function __construct(){
        $this->clase = new Rol();
        $this->id = 'idrol';
    }

    public function menus($param){
        $res = array();
        $obj = $this->clase->retornaObj($param[$this->id]);
        foreach($obj->menus()->find_many() as $menu){
            array_push($res, $menu->as_array());
        }
        return $res;
    }
}
?>