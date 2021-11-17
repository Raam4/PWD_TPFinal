<?php
include_once("../../../configuracion.php");
$data = data_submitted();
$sess = new Session();
$abmprod = new AbmProducto;
$abmcompra = new AbmCompra();
$abmcompraitem = new AbmCompraitem();
$user = $sess->getUsuario();
$compra = ['cofecha' => date('Y-m-d H:i:s'), 'idusuario' => $user['idusuario']];
$abmcompra->alta($compra);
$compra = $abmcompra->buscar($compra);
foreach($data['arreglo'] as $item){
    $prod = $abmprod->buscar(['idproducto' => $item['idproducto']]);
    $compraitem = [
        'idproducto' => $item['idproducto'],
        'idcompra' => $compra[0]['idcompra'],
        'cicantidad' => $item['cantidad'],
        'citotal' => $prod[0]['proprecio'] * $item['cantidad']
    ];
    $abmcompraitem->alta($compraitem);
}
echo json_encode($compra[0]['idcompra']);
?>