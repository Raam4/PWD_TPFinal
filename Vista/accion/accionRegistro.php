<?php
include_once("../../configuracion.php");
$data = data_submitted();
$abmuser = new AbmUsuario();
if($abmuser->alta($data)){
    echo "El registro fue realizado con éxito. Un administrador le brindará un rol cuando revise los
    datos cargados.";
}else{
    echo "Algo malió sal.";
}
?>