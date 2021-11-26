<?php
class AbmProducto extends AbmSuper{
    
    public function __construct(){
        $this->clase = new Producto();
        $this->id = 'idproducto';
    }

    public function manage($param){
        $obj = $this->buscar($param);
        if(is_null($obj[0]['prodeshabilitado']) || $obj[0]['prodeshabilitado']=='0000-00-00 00:00:00'){
            $obj[0]['prodeshabilitado'] = date('Y-m-d H:i:s');
        }else{
            $obj[0]['prodeshabilitado'] = null;
        }
        return $this->modificacion($obj[0]);
    }
}
?>