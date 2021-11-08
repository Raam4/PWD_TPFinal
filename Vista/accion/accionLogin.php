<?php
include_once("../../configuracion.php");
$datos = data_submitted();
$rpta = false;
$objSess = new Session();
if ($objSess->iniciar($datos['usnombre'], $datos['uspass'])) {
	$rpta = true;
}
echo json_encode($rpta);
?>