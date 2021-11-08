<?php
class AbmCompraitem extends AbmSuper{
    
    public function __construct(){
        $this->clase = new CompraItem();
        $this->id = 'idcompraitem';
    }
}
?>