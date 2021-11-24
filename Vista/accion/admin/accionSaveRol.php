<?php 
include_once "../../../configuracion.php";
$data = data_submitted();
$abmuserrol = new AbmUsuarioRol();
$objs = $abmuserrol->buscar(['idusuario' => $data['usid']]);
foreach($objs as $obj){
    $abmuserrol->baja($obj);
}
foreach($data['roles'] as $rol){
    $abmuserrol->alta(['idusuario' => $data['usid'], 'idrol' => $rol]);
}