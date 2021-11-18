<?php
include_once("../../../configuracion.php");
$data = data_submitted();
$abmcompraestado = new AbmCompraEstado();
$compraestado = $abmcompraestado->buscar($data);
$compraestado[0]['idcompraestadotipo'] = 3;
$compraestado[0]['cefechafin'] = date('Y-m-d H:i:s');
$abmcompraestado->modificacion($compraestado[0]);