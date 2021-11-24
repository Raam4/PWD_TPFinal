<?php 
include_once "../../../configuracion.php";
$data = data_submitted();
$abmrol = new AbmRol();
$abmmenurol = new AbmMenuRol();
$idrol = $abmrol->alta(['rodescripcion' => $data['rodescripcion']]);
$abmmenurol->alta(['idmenu' => $data['idmenu'], 'idrol' => $idrol]);
?>