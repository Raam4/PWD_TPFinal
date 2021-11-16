<?php
include_once('../../configuracion.php');
$sess = new Session();
foreach($sess->getCarrito() as $item){
    $sess->sacarDelCarrito($item);
}
?>