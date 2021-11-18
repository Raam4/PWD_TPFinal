<?php
include_once("../../../configuracion.php");
$data = data_submitted();
$abmcompraestado = new AbmCompraEstado();
$abmcompraitem = new AbmCompraItem();
$abmproducto = new AbmProducto();
$compraestado = $abmcompraestado->buscar($data);
$compraestado[0]['idcompraestadotipo'] = 4;
$compraestado[0]['cefechafin'] = date('Y-m-d H:i:s');
if($abmcompraestado->modificacion($compraestado[0])){
    $compraitem = $abmcompraitem->buscar(['idcompra' => $compraestado['idcompra']]);
    foreach($compraitem as $item){
        $prod = $abmproducto->buscar(['idproducto' => $item['idproducto']]);
        $prod[0]['procantstock'] += $item['cicantidad'];
        $abmproducto->modificacion($prod[0]);
    }
}