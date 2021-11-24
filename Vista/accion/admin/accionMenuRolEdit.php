<?php 
include_once "../../../configuracion.php";
$data = data_submitted();
$abmrol = new AbmRol();
$abmmenu = new AbmMenu();
$abmmenurol = new AbmMenuRol();
$menu = $abmrol->menus(['idrol' => $data['idrol']]);
$abmmenurol->baja(['idmenu' => $menu[0]['idmenu'], 'idrol' => $data['idrol']]);
$abmmenurol->alta($data);
$newmenu = $abmmenu->buscar(['idmenu' => $data['idmenu']]);
echo json_encode($newmenu[0]['menombre']);