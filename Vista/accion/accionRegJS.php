<?php
include_once("../../configuracion.php");
$datos = data_submitted();
print_r($datos);
$rpta = '';
$abmuser = new AbmUsuario();
if($abmuser->buscar(['usnombre' => $datos['usnombre']])){
    $rpta = 1;
}elseif($abmuser->buscar(['usmail' => $datos['usmail']])){
    $rpta = 2;
}else{
    $rpta = 3;
}
echo json_encode($rpta);
?>