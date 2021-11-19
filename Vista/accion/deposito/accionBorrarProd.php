<?php
include_once("../../../configuracion.php");
$data = data_submitted();
$abmprod = new AbmProducto();
$abmprod->baja($data);
?>