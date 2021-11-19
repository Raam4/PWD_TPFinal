<?php
include_once("../../../configuracion.php");
$data = data_submitted();
$ruta = '../../files/users/';
$nombre = md5($data['usnombre'].$data['idusuario']).'.'.pathinfo($_FILES['imagen']['name'],PATHINFO_EXTENSION);
if(move_uploaded_file($_FILES['imagen']['tmp_name'], '../'.$ruta.$nombre)){
    echo json_encode($ruta.$nombre);
}else{
    echo json_encode('');
}