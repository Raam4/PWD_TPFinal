<?php
include_once("../../configuracion.php");
$datos = data_submitted();
$rpta = '';
$abmuser = new AbmUsuario();
if($abmuser->buscar(['usnombre' => $datos['usnombre']])){
    $rpta = 1;
}elseif($abmuser->buscar(['usmail' => $datos['usmail']])){
    $rpta = 2;
}else{
    if($abmuser->alta($datos)){
        $rpta = 3;
    }else{
        $rpta = 4;
    }
}
echo json_encode($rpta);
?>