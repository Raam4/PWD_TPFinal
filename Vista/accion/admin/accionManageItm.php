<?php
include_once("../../../configuracion.php");
$data = data_submitted();
$abmmenu = new AbmMenu();
$abmmenu->manage($data);
?>