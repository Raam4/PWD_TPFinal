<?php
include_once("../../configuracion.php");
$data = data_submitted();
$objSess = new Session();
if (!$objSess->activa()) {
    header('location:../ejercicios/login.php');
    exit();
}else{
    header('location:'.$data['destino']);
}