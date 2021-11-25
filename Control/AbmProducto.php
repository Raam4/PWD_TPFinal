<?php
class AbmProducto extends AbmSuper{
    
    public function __construct(){
        $this->clase = new Producto();
        $this->id = 'idproducto';
    }

    public function deshabilitar($param){
        $obj = $this->buscar($param);
        $obj[0]['prodeshabilitado'] = date('Y-m-d H:i:s');
        return $this->modificacion($obj[0]);
    }

    public function habilitar($param){
        $obj = $this->buscar($param);
        $obj[0]['prodeshabilitado'] = null;
        return $this->modificacion($obj[0]);
    }
}
?>