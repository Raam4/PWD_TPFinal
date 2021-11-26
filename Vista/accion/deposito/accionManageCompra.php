<?php
include_once("../../../configuracion.php");
$data = data_submitted();
$abmcompraestado = new AbmCompraEstado();
$compraestado = $abmcompraestado->buscar(['idcompraestado' => $data['idcompraestado']]);
if($data['stat'] == 1){
    $compraestado[0]['idcompraestadotipo'] = 2;
    $abmcompraestado->modificacion($compraestado[0]);
}
if($data['stat'] == 2){
    $compraestado[0]['idcompraestadotipo'] = 3;
    $compraestado[0]['cefechafin'] = date('Y-m-d H:i:s');
    $abmcompraestado->modificacion($compraestado[0]);
}