<?php
include_once("../../Utiles/sessmanager.php");
if(!$objSess->activa()){
    header('location:../public/login.php');
    exit();
}
include_once("../estructura/header.php");
$carrito = $objSess->getCarrito();
$abmproducto = new AbmProducto();
$abmcompra = new AbmCompra();
$abmcompraitem = new AbmCompraItem();
$abmcompraestado = new AbmCompraEstado();
$abmcompraestadotipo = new AbmCompraEstadoTipo();
$abmuser = new AbmUsuario();
$compras = $abmcompra->buscar(array());
?>
<style type="text/css">
    .popover-header{
        background-color: #1b120d;
        color: #ddaa44;
    }
    .popover-body{
        color: #1b120d;
        background-color: #ddaa44;
    }
</style>
<div class="content-wrapper">
    <?php
    if(!$compras){
    ?>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="alert alert alert-dismissible mt-5 text-center" style="background-color: #ddaa44;">
                <h3><i class="icon fas fa-info"></i> Vacío</h3>
                    <h5>Aún no se han cargado pedidos.</h5>
            </div>
        </div>
    </div>
    <?php
    }else{
    ?>
    <div class="card">
        <div class="card-header">
            <h3>Pedidos</h3>
        </div>
        <div class="card-body">
            <table class="table  text-center">
                <thead>
                    <tr>
                        <th style="width: 10%">
                            ID Pedido
                        </th>
                        <th style="width: 15%">
                            Usuario
                        </th>
                        <th style="width: 15%">
                            Fecha y hora
                        </th>
                        <th style="width: 20%">
                            Productos
                        </th>
                        <th style="width: 10%">
                            Importe total
                        </th>
                        <th style="width: 10%">
                            Estado
                        </th>
                        <th style="width: 25%">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        foreach($compras as $pedido){
                            $id = $pedido['idcompra'];
                            $usuario = $abmuser->buscar(['idusuario' => $pedido['idusuario']]);
                            $compraitem = $abmcompraitem->buscar(['idcompra' => $id]);
                            $compraestado = $abmcompraestado->buscar(['idcompra' => $id]);
                            $idce = $compraestado[0]['idcompraestado'];
                            $idcet = $compraestado[0]['idcompraestadotipo'];
                            $estadotipo = $abmcompraestadotipo->buscar(['idcompraestadotipo' => $idcet]);
                            $total = 0;
                        ?>
                        <td>
                            <?=$id?>
                        </td>
                        <td>
                            <?=$usuario[0]['usnombre']?>
                        </td>
                        <td>
                            <?=$pedido['cofecha']?>
                        </td>
                        <td>
                            <?php
                            $strprod = "";
                            foreach($compraitem as $item){
                                $prod = $abmproducto->buscar(['idproducto' => $item['idproducto']]);
                                $total += $item['citotal'];
                                $strprod .= $prod[0]['pronombre']." x".$item['cicantidad']." <br> ";
                            }?>
                            <button type="button" class="btn btn-sm btn-warning" data-bs-placement="bottom" data-bs-trigger="focus"
                            data-bs-toggle="popover" title="Productos" data-bs-html="true" data-bs-content="<?=$strprod?>">Click para ver productos</button>
                        </td>
                        <td>
                            <?=$total?>
                        </td>
                        <td id="colestado<?=$idce?>">
                            <?=$estadotipo[0]['cetdescripcion']?>
                        </td>
                        <td id="<?=$idce?>" class="btnacciones">
                            <input type="hidden" id="estado<?=$idce?>" value="<?=$idcet?>">
                            <button class="btn btn-outline-info btn-sm m-1" type="button" id="ace<?=$idce?>" onclick="manage(1, <?=$idce?>)" disabled>
                                <i class="fas fa-check"></i> Aceptar
                            </button>
                            <button class="btn btn-outline-success btn-sm m-1" type="button" id="env<?=$idce?>" onclick="manage(2, <?=$idce?>)" disabled>
                                <i class="fas fa-paper-plane"></i> Enviar
                            </button>
                            <button class="btn btn-outline-danger btn-sm m-1" type="button" id="can<?=$idce?>" onclick="cancelar(<?=$idce?>)" disabled>
                                <i class="fas fa-times"></i> Cancelar
                            </button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
    <?php
    }
    ?>
    
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    $('[data-bs-toggle="popover"]').popover();
    $('.btnacciones').each(function(){
        var id = $(this).attr('id');
        var estado = $('#estado'+id).val();
        if(estado == 1){
            $('#ace'+id).removeAttr('disabled');
            $('#env'+id).hide();
            $('#can'+id).removeAttr('disabled');
        }
        if(estado == 2){
            $('#ace'+id).hide();
            $('#env'+id).removeAttr('disabled');
            $('#can'+id).removeAttr('disabled');
        }
        if(estado == 3 || estado == 4){
            $('#ace'+id).hide();
            $('#env'+id).hide();
        }
    });
});
function manage(stat, idce){
    var dataToSend = {'stat' : stat, 'idcompraestado' : idce};
    if(stat == 1){
        if(confirm("Desea aceptar el pedido?")){
            $('#ace'+idce).hide();
            $('#env'+idce).removeAttr('disabled');
            $('#env'+idce).show();
            $('#colestado'+idce).text('Aceptado');
        }
    }
    if(stat == 2){
        if(confirm("Desea enviar el pedido?")){
            $('#env'+idce).hide();
            $('#can'+idce).attr('disabled', true);
            $('#colestado'+idce).text('Enviado');
        }
    }
    $.ajax({
        method: 'post',
        url: '../accion/deposito/accionManageCompra.php',
        data: dataToSend,
        type: 'json',
        success: function(data){
            if(stat == 1){
                toastr.success('Pedido aceptado!');
            }
            if(stat == 2){
                toastr.success('Pedido enviado!');
            }
        }
    });
}
function cancelar(idce){
    var dataToSend = {'idcompraestado' : idce};
    if(confirm("Desea cancelar el pedido?")){
        $('#ace'+idce).hide();
        $('#env'+idce).hide();
        $('#can'+idce).attr('disabled', true);
        $('#colestado'+idce).text('Cancelado');
        $.ajax({
            method: 'post',
            url: '../accion/cliente/accionCancelaCompra.php',
            data: dataToSend,
            type: 'json',
            success: function(data){
                toastr.success('Pedido cancelado!');
            }
        });
    }
}
</script>
<?php include_once("../estructura/footer.php");?>