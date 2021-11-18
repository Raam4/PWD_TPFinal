<?php
include_once("../../../configuracion.php");
$data = data_submitted();
$abmprod = new AbmProducto();
print_r($data['idproducto']);
if(!is_int($data['idproducto'])){
    unset($data['idproducto']);
    $abmprod->alta($data); //se saltea el fcking if
}else{
    $abmprod->modificacion($data);
}