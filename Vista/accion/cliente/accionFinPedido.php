<?php
include_once("../../../configuracion.php");
$data = data_submitted();
$sess = new Session();
$abmprod = new AbmProducto;
$abmcompra = new AbmCompra();
$abmcompraitem = new AbmCompraitem();
$user = $sess->getUsuario();
$nostock = array();
foreach($data['arreglo'] as $item){
    $prod = $abmprod->buscar(['idproducto' => $item['idproducto']]);
    if($prod[0]['procantstock'] < $item['cantidad']){
        array_push($nostock, $prod[0]['pronombre']);
    }
}
if(!$nostock){
    $compra = ['cofecha' => date('Y-m-d H:i:s'), 'idusuario' => $user['idusuario']];
    $idcompra = $abmcompra->alta($compra);
    foreach($data['arreglo'] as $item){
        $prod = $abmprod->buscar(['idproducto' => $item['idproducto']]);
        $compraitem = [
            'idproducto' => $item['idproducto'],
            'idcompra' => $idcompra,
            'cicantidad' => $item['cantidad'],
            'citotal' => $prod[0]['proprecio'] * $item['cantidad']
        ];
        $prod[0]['procantstock'] -= $item['cantidad'];
        $abmprod->modificacion($prod[0]);
        $abmcompraitem->alta($compraitem);
    }
    echo json_encode($idcompra);
}else{
    echo json_encode($nostock);
}
?>