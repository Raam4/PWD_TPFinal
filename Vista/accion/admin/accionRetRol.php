<?php 
include_once "../../../configuracion.php";
$data = data_submitted();
$abmuser = new AbmUsuario();
$roles = $abmuser->roles($data);
$ret = array();
foreach($roles as $rol){
    array_push($ret, $rol['idrol']);
}
echo json_encode($ret);