<?php
include_once("../../configuracion.php");
include_once("../../Utiles/sessmanager.php");
if(!$objSess->activa()){
    header('location:../public/login.php');
    exit();
}else if($objSess->getRolActivo()['idrol']!=3){
    header('location:../public/Index.php');
    exit();
}
include_once("../estructura/header.php");
$carrito = $objSess->getCarrito();
$abmprod = new AbmProducto();
?>
<div class="content-wrapper">
    <?php
    if(!$carrito){
    ?>
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="alert alert alert-dismissible mt-5 text-center" style="background-color: #ddaa44;">
                    <h3><i class="icon fas fa-info"></i> Vacío</h3>
                        <h5>Aún no se han cargado productos.</h5>
                </div>
            </div>
        </div>
    </div>
    <?php }else{ ?>
    <div class="card">
        <div class="card-header">
            <h3 class="txtArchBl">Carrito</h3>
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
                            <h6>
                                <?php echo $prod['pronombre']; ?>
                            </h6>
                        </td>
                        <td>
                            <h6>
                                <input type="number" id="<?=$prod['idproducto']?>" name="cantidad" class="col-9 rounded-1" min="1" value="1" max="<?=$prod['procantstock']?>">
                            </h6>
                        </td>
                        <td>
                            <h6 id="impunit<?=$prod['idproducto']?>" class="<?=$prod['proprecio']?>">
                                <?php echo '$'.$prod['proprecio']; ?>
                            </h6>
                        </td>
                        <td>
                            <h6 id="imptot<?=$prod['idproducto']?>" class="<?=$prod['proprecio']?>">
                                <?php echo '$'.$prod['proprecio'];?>
                            </h6>
                        </td>
                        <td>
                            <button class="btn btn-outline-danger btn-md" type="button" onclick="quitar($('#fila<?=$prod['idproducto']?>'))">
                                <i class="fas fa-times"></i> Quitar
                            </button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <td colspan="2">
                        <h6>Total del pedido</h6>
                    </td>
                    <td colspan="1">
                        <h6 id="totcar" class="<?=$total?>">
                            <?php echo '$'.$total?>
                        </h6>
                    </td>
                    <td colspan="2">
                        <button class="btn btn-outline-success btn-md" type="button" onclick="$('#modalCerrarPedido').modal('show')">
                            <i class="fas fa-shopping-cart"></i> Finalizar
                        </button>
                        <button class="btn btn-outline-danger btn-md" type="button"  onclick="vaciar()">
                            <i class="fas fa-trash"></i> Vaciar
                        </button>
                    </td>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="modalCerrarPedido" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-success" id="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cerrar Pedido</h4>
            </div>
            <div class="modal-body">
                <form id="formCerrarPedido">
                    <input type="hidden" name="idproducto" id="idproducto">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <input class="form-control" type="text" name="usnombre" id="usnombre" placeholder="Nombre" value="<?=$param['user']['usnombre']?>" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <input class="form-control" type="text" name="ustelefono" id="ustelefono" placeholder="Telefono" value="<?=$param['user']['ustelefono']?>" required>
                        </div>
                        <div class="col-sm-6">
                            <input class="form-control" type="text" name='usdireccion' id="usdireccion" placeholder="Direccion" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <label>Forma de Pago:</label>
                            <div class="form-group ms-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pago" checked="">
                                    <label class="form-check-label">Online</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pago">
                                    <label class="form-check-label">En domicilio</label>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="reset" class="btn btn-outline-light" onclick="$('#modalCerrarPedido').modal('hide')">Cancelar</button>
              <button type="submit" class="btn btn-outline-light">Finalizar Pedido</button>
            </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalPedido" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-success" id="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-white">Pedido realizado</h4>
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
        $("#formCerrarPedido").validate({
            rules:{
                usnombre: {
                    rangelength: [3, 15],
                },
                ustelefono: {
                    rangelength: [6, 13],
                    number: true,
                },
            },
            messages: {
                usnombre: {
                    required: "El campo es obligatorio",
                    rangelength: "Debe ingresar entre 3 y 15 carácteres",
                },
                ustelefono: {
                    required: "El campo es obligatorio",
                    number: "Ingrese solo números, sin 0 ni 15",
                    rangelength: 'La cantidad de números es inválida',
                },
                usdireccion: {
                    required: "El campo es obligatorio",
                }
            },
            submitHandler: function() {
                var data = [];
                var id = 0;
                var cant = 0;
                $("[id^='fila']").each(function(){
                    id = $(this).attr('class');
                    cant = $('#'+id).val();
                    data.push({'idproducto': id, 'cantidad': cant});
                });
                $.ajax({
                    method: 'POST',
                    url: '../accion/cliente/accionFinPedido.php',
                    data: {'arreglo' : data},
                    type: 'json',
                    success: function(ret){
                        $('#modalCerrarPedido').modal('hide');
                        $('#modalMsg').append(ret);
                        $('#modalPedido').modal('show');
                        vaciar();
                    }
                });
                return false;
            }
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

</script>
<?php } include_once("../estructura/footer.php");?>