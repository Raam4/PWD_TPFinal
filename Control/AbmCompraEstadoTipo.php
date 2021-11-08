<?php
class AbmCompraestadotipo extends AbmSuper{
    
    public function __construct(){
        $this->clase = new CompraEstadoTipo();
        $this->id = 'idcompraestadotipo';
    }
}
?>