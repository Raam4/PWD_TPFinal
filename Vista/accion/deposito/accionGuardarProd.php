<?php
include_once("../../../configuracion.php");
$data = data_submitted();
$abmprod = new AbmProducto();
if(!isset($data['idproducto'])){
    $idprod = $abmprod->alta($data);
}else{
    $idprod = $data['idproducto'];
    $abmprod->modificacion($data);
}
if($_FILES){
    $ruta = '../../files/prods/';
    $nombre = md5($data['pronombre'].$idprod).'.'.pathinfo($_FILES['imgprod']['name'],PATHINFO_EXTENSION);
    if(!isset($data['idproducto'])){
        unlink('../'.$ruta.$nombre);
    }
    move_uploaded_file($_FILES['imgprod']['tmp_name'], '../'.$ruta.$nombre);
}