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
                        <th style="width: 29%">
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
                    <tr>
                        <td>
                            <h4>
                                <?php echo $prod['pronombre']; ?>
                            </h4>
                        </td>
                        <td>
                            <h4>
                                <input type="number" id="<?=$prod['idproducto']?>" name="cantidad" class="col-6 rounded-1" min="1" value="1" max="<?=$prod['procantstock']+1?>">
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
                            <button class="btn btn-danger btn-md" type="button">
                                <i class="fas fa-times"></i> Quitar
                            </button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <td colspan="3">
                        Total de compra
                    </td>
                    <td>
                        <h3 id="totcar" class="<?=$total?>">
                            <?php echo '$'.$total?>
                        </h3>
                    </td>
                    <td>
                        <button class="btn btn-danger btn-md" type="button" id="vaciar">
                            <i class="fas fa-trash"></i> Vaciar
                        </button>
                    </td>
                </tfoot>
            </table>
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
            $('#imptot'+id).attr('class', '$'+(precio*$(this).val()));
            $("[id^='imptot']").each(function(){
                total += $(this).attr('class');
            });
            $('#totcar').empty();
            $('#totcar').text('$'+total); //por que aparece el $0?
        });
        $('#vaciar').on('click', function(){
            var elem = $(this);
            $.ajax({
                method: 'POST',
                url: '../accion/accionProdVaciar.php',
                type: 'json',
                success: function(){
                    toastr.error('Carrito vaciado!');
                }
            })
        });
    });
</script>
<?php include_once("../estructura/footer.php");?>