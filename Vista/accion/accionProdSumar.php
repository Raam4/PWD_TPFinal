<?php
include_once('../../configuracion.php');
$data = data_submitted();
$sess = new Session();
$newmax = $sess->sumarAlCarrito($data);
echo json_encode($newmax);
?>