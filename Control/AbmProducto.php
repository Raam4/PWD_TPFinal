<?php
class AbmProducto extends AbmSuper{
    
    public function __construct(){
        $this->clase = new Producto();
        $this->id = 'idproducto';
    }
}
?>