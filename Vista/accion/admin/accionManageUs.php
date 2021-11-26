<?php
include_once("../../../configuracion.php");
$data = data_submitted();
$abmuser = new AbmUsuario();
$abmuser->manage($data);
?>