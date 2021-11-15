<?php
include_once('../../configuracion.php');
$data = data_submitted();
$producto = new AbmProducto();
$ret = '<div class="col-md-4" id="rub'.$data['idrubro'].'">
            <div class="card">
                <img class="card-img-top" src="https://media.discordapp.net/attachments/883712984902434836/908035385957965874/unknown.png?width=523&height=418">
                <div class="card-body">
                    <div class="row">';
foreach($producto->buscar($data) as $prod){
    $id = $prod['idproducto'];
    $ret .= '<div class="col-md-6">
                <h2 class="card-title">'.$prod['pronombre'].'</h2><br>
                <p>'.$prod['prodetalle'].'</p>
            </div>
            <div class="col-md-6 text-end">
                <h1>$'.$prod['proprecio'].'</h1><br>';
    if(!($prod['procantstock'] == 0)){
        $ret .= '<form class="agrega">
                <input type="hidden" name="idproducto" value="'.$id.'">
                <input class="col-6 rounded-0" type="number" name="cantidad" min="1" max="'.$prod['procantstock'].'" value="1">
                <button type="submit" class="btn btn-md btn-rounded btn-primary"><i class="fas fa-cart-plus"></i></button>
                </form>';
    }else{
        $ret .= '<p>Sin stock</p>';
    }
}
$ret .= '</div></div></div></div></div>';
echo json_encode($ret);
?>