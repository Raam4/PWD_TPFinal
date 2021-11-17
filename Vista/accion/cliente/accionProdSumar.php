<?php
include_once('../../../configuracion.php');
$data = data_submitted();
$sess = new Session();
$sess->agregarAlCarrito($data['idproducto']);
?>