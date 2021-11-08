<?php
class AbmCompraestado extends AbmSuper{
    
    public function __construct(){
        $this->clase = new CompraEstado();
        $this->id = 'idcompraestado';
    }
}
?>