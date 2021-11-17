<?php
include_once("../../configuracion.php");
$data = data_submitted();
$sess = new Session();
$sess->sacarDelCarrito($data['idproducto']);
?>