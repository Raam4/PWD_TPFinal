<?php
include_once("../../../configuracion.php");
$data = data_submitted();
$abmcompraestado = new AbmCompraEstado();
if($data['stat'] == 1){
    $abmcompraestado->aceptaPedido($data['idcompraestado']);
}
if($data['stat'] == 2){
    $abmcompraestado->enviaPedido($data['idcompraestado']);
}