<?php
include_once("../../configuracion.php");
$objSess = new Session();
$data = data_submitted();
if(isset($data['newrol'])){
    $objSess->setRolActivo($data['newrol']);
}
$param = array();
if($objSess->activa()) {
    $param['roles'] = $objSess->getRoles();
    $param['user'] = $objSess->getUsuario();
    $param['rolactivo'] = $objSess->getRolActivo();
    $perfil = Maker::perfil($param);
    $menu = Maker::menu($param['rolactivo']);
}else{
    $perfil = Maker::perfil($param);
    $menu = Maker::menu(['idrol'=>4]);
}
?>