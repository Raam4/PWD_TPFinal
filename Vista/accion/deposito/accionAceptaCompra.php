<?php
include_once("../../../configuracion.php");
$data = data_submitted();
$abmcompraestado = new AbmCompraEstado();
$compraestado = $abmcompraestado->buscar($data);
$compraestado[0]['idcompraestadotipo'] = 2;
$abmcompraestado->modificacion($compraestado[0]);