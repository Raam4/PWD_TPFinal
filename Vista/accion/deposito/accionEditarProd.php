<?php
include_once("../../../configuracion.php");
$data = data_submitted();
$abmprod = new AbmProducto();
$producto = $abmprod->buscar($data);
$producto = $producto[0];
echo json_encode($producto);