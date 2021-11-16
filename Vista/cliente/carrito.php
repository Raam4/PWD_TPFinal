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
                        <th style="width: 1%">
                            #
                        </th>
                        <th style="width: 30%">
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
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $total = 0;
                    foreach($carrito as $item){
                        $prod = $abmprod->buscar(['idproducto' => $item]);
                        $prod = $prod[0];
                    ?>
                    <tr>
                        <td>
                            <?php echo $i; $i++; ?>
                        </td>
                        <td>
                            <h4>
                                <?php echo $prod['pronombre']; ?>
                            </h4>
                        </td>
                        <td>
                            <h4>
                                <?php  ?>
                            </h4>
                        </td>
                        <td>
                            <h4>
                                <?php echo '$'.$prod['proprecio']; ?>
                            </h4>
                        </td>
                        <td>
                            <h4>
                                <?php echo '$'?>
                            </h4>
                        </td>
                        <td>
                            <form class="resta">
                                <input type="hidden" name="idproducto" value="<?=$item?>">
                                <input type="number" name="cantidad" class="col-6 rounded-0" min="1" value="1" max="<?=$prod['procantstock']+1?>">
                                <button class="btn btn-warning btn-sm" type="submit">
                                    <i class="fas fa-minus"></i> Restar
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <td colspan="4">
                        Total de compra
                    </td>
                    <td>
                        <?php echo '$' ?>
                    </td>
                    <td>
                        <button class="btn btn-danger btn-sm" type="button" id="vaciar">
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
        $('form.resta').on('submit', function(){
            var elem = $(this);
            $.ajax({
                method: 'POST',
                url: '../accion/accionProdRestar.php',
                data: elem.serialize(),
                type: 'json',
                success: function(){
                    toastr.success('Producto descontado!');
                }
            })
            return false;
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