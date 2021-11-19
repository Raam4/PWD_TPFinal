<?php
include_once("../../../configuracion.php");
$abmuser = new AbmUsuario();
$datos = data_submitted();
$abmuser->modificacion($datos);