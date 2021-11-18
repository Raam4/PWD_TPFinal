<?php
include_once("../../../configuracion.php");
$objSess = new Session();
if ($objSess->cerrar()) {
    header('location:../../public/Index.php');
    exit();
}else{
    echo 'Hubo un error al cerrar la sesion
	<a href="../../public/Index.php"><button type="button" class="btn btn-outline-primary mt-3">Volver</button></a>';
}