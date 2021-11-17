<?php
include_once("../../configuracion.php");
$data = data_submitted();
$abmcompraestado = new AbmCompraEstado();
$compraestado = $abmcompraestado->buscar($data);
$compraestado[0]['idcompraestadotipo'] = 4;
$abmcompraestado->modificacion($compraestado[0]);
//implementar los movimientos de stock con la cancelacion del pedido