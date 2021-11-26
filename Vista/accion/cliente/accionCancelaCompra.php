<?php
include_once("../../../configuracion.php");
$data = data_submitted();
$abmcompraestado = new AbmCompraEstado();
$res = $abmcompraestado->cancelaPedido($data);
json_encode($res);