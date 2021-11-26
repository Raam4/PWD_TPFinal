<?php
include_once("../../configuracion.php");
$objSess = new Session();
$abmrol = new AbmRol();
$data = data_submitted();
if(isset($data['newrol'])){
    $objSess->setRolActivo($data['newrol']);
}
$param = array();
if($objSess->activa()) {
    $param['user'] = $objSess->getUsuario();
    $param['roles'] = $objSess->getRoles();
    $param['rolactivo'] = $objSess->getRolActivo();
    $menuPerm = $abmrol->menus($param['rolactivo']);
    if($menuPerm[0]['idmenu'] != $data['perm']){
        header('location:../public/Index.php');
        exit();
    }
    $perfil = Maker::perfil($param);
    $menu = Maker::menu($param['rolactivo']);
}else{
    $perfil = Maker::perfil($param);
    $menu = Maker::menu(['idrol'=>1]);
}
?>