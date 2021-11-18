<?php
include_once("../../configuracion.php");
include_once("../../Utiles/sessmanager.php");
include_once("../estructura/header.php");
$carrito = $objSess->getCarrito();
$abmprod = new AbmProducto();
?>
<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3>Carrito</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th style="width: 20%">
                            Producto
                        </th>
                        <th style="width: 10%">
                            Cantidad
                        </th>
                        <th style="width: 20%">
                            Precio unitario
                        </th>
                        <th style="width: 20%">
                            Precio total
                        </th>
                        <th style="width: 20%">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach($carrito as $item){
                        $prod = $abmprod->buscar(['idproducto' => $item]);
                        $prod = $prod[0];
                        $total += $prod['proprecio'];
                    ?>
                    <tr id="fila<?=$prod['idproducto']?>" class=<?=$prod['idproducto']?>>
                        <td>
                            <h4>
                                <?php echo $prod['pronombre']; ?>
                            </h4>
                        </td>
                        <td>
                            <h4>
                                <input type="number" id="<?=$prod['idproducto']?>" name="cantidad" class="col-9 rounded-1" min="1" value="1" max="<?=$prod['procantstock']?>">
                            </h4>
                        </td>
                        <td>
                            <h4 id="impunit<?=$prod['idproducto']?>" class="<?=$prod['proprecio']?>">
                                <?php echo '$'.$prod['proprecio']; ?>
                            </h4>
                        </td>
                        <td>
                            <h4 id="imptot<?=$prod['idproducto']?>" class="<?=$prod['proprecio']?>">
                                <?php echo '$'.$prod['proprecio'];?>
                            </h4>
                        </td>
                        <td>
                            <button class="btn btn-danger btn-md" type="button" onclick="quitar($('#fila<?=$prod['idproducto']?>'))">
                                <i class="fas fa-times"></i> Quitar
                            </button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <td colspan="2">
                        <h3>Total del pedido</h3>
                    </td>
                    <td colspan="1">
                        <h3 id="totcar" class="<?=$total?>">
                            <?php echo '$'.$total?>
                        </h3>
                    </td>
                    <td colspan="2">
                        <button class="btn btn-success btn-md" type="button" onclick="finalizar()">
                            <i class="fas fa-shopping-cart"></i> Finalizar pedido
                        </button>
                        <button class="btn btn-danger btn-md" type="button" onclick="vaciar()">
                            <i class="fas fa-trash"></i> Vaciar
                        </button>
                    </td>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="modal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-success" id="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cerrar Pedido</h4>
            </div>
            <div class="modal-body">
                <form id="form-modal">
                    <input type="hidden" name="idproducto" id="idproducto">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <input class="form-control" type="text" name="pronombre" id="pronombre" placeholder="Nombre">
                        </div>
                        <div class="col-sm-2"><label>Rubro:</label></div>
                        <div class="col-sm-4">
                            <select class="form-control" name="idrubro" id="idrubro">
                                <?php
                                foreach($rubros as $rub){
                                    echo '<option value="'.$rub['idrubro'].'">'.$rub['runombre'].'</option>';
                                }?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3">
                            <input class="form-control" type="number" name="procantstock" id="procantstock" placeholder="Stock">
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                    <i class="fas fa-dollar-sign"></i>
                                    </span>
                                </div>
                                <input class="form-control" type="number" name='proprecio' id="proprecio" placeholder="Precio">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <textarea class="form-control" rows='2' name="prodetalle" id="prodetalle" placeholder="Detalle"></textarea>
                        </div>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="reset" class="btn btn-outline-light" onclick="$('#modal').modal('hide')">Close</button>
              <button type="submit" class="btn btn-outline-light">Save changes</button>
            </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalPedido" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-success" id="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pedido realizado</h4>
            </div>
            <div class="modal-body">
                <p id="modalMsg">El pedido fue cargado con éxito.
                    ID del pedido: 
                </p>
            </div>
            <div class="modal-footer">
                <p>(Click fuera del recuadro para salir)</p>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $(':input').on('change', function(){
            var id = $(this).attr('id');
            var precio = $('#impunit'+id).attr('class');
            var total = 0;
            $('#imptot'+id).text('$'+(precio*$(this).val()));
            $('#imptot'+id).attr('class', (precio*$(this).val()));
            $("[id^='imptot']").each(function(){
                total += parseFloat($(this).attr('class'));
            });
            $('#totcar').text('$'+total);
        });
    });
    function quitar(fila){
        var total = 0;
        var data = {'idproducto' : fila.attr('class')};
        $.ajax({
            method: 'POST',
            url: '../accion/cliente/accionCarQuitar.php',
            data: data,
            type: 'json',
            success: function(){
                fila.remove();
                $("[id^='imptot']").each(function(){
                    total += parseFloat($(this).attr('class'));
                });
                $('#totcar').text('$'+total);
            }
        });
    }
    function vaciar(){
        $("[id^='fila']").each(function(){
            quitar($(this));
        });
    }

    function finalizar(){
        var data = [];
        var id = 0;
        var cant = 0;
        $("[id^='fila']").each(function(){
            id = $(this).attr('class');
            cant = $('#'+id).val();
            data.push({'idproducto': id, 'cantidad': cant});
        });
        console.log(typeof data);
        console.log(data);
        $.ajax({
            method: 'POST',
            url: '../accion/cliente/accionFinPedido.php',
            data: {'arreglo' : data},
            type: 'json',
            success: function(ret){
                $('#modalMsg').append(ret);
                $('#modalPedido').modal('show');
                vaciar();
            }
        });
    }
</script>
<?php include_once("../estructura/footer.php");?>