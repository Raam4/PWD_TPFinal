<?php
class AbmCompraItem extends AbmSuper{
    
    public function __construct(){
        $this->clase = new CompraItem();
        $this->id = 'idcompraitem';
    }
}
?>