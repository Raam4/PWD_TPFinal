<?php
include_once("../../../configuracion.php");
$data = data_submitted();
$sess = new Session();
$abmprod = new AbmProducto;
$abmcompraestado = new AbmCompraEstado();
$user = $sess->getUsuario();
$nostock = array();
foreach($data['arreglo'] as $item){
    $prod = $abmprod->buscar(['idproducto' => $item['idproducto']]);
    if($prod[0]['procantstock'] < $item['cantidad']){
        array_push($nostock, $prod[0]['pronombre']);
    }
}
if(!$nostock){
    $idcompra = $abmcompraestado->finPedido($data, $user['idusuario']);
    echo json_encode($idcompra);
}else{
    echo json_encode($nostock);
}
?>