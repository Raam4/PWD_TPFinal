<?php
include_once("../../configuracion.php");
include_once("../../Utiles/sessmanager.php");
include_once("../estructura/header.php");
$abmprod = new AbmProducto();
$abmrub = new AbmRubro();
$rubros = $abmrub->buscar(array());
$productos = $abmprod->buscar(array());
?>
<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3>Productos</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th style="width: 3%">
                            ID
                        </th>
                        <th style="width: 15%">
                            Nombre
                        </th>
                        <th style="width: 10%">
                            Precio
                        </th>
                        <th style="width: 15%">
                            Rubro
                        </th>
                        <th style="width: 5%">
                            Stock
                        </th>
                        <th style="width: 30%">
                            Detalle
                        </th>
                        <th style="width: 22%">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($productos as $item){
                        $id = $item['idproducto'];
                    ?>
                    <tr>
                        <td>
                            <?php echo $id; ?>
                        </td>
                        <td>
                            <?php echo $item['pronombre']; ?>
                        </td>
                        <td>
                            <?php echo $item['proprecio']; ?>
                        </td>
                        <td>
                            <?php echo $item['idrubro']; ?>
                        </td>
                        <td>
                            <?php echo $item['procantstock']; ?>
                        </td>
                        <td>
                            <?php echo $item['prodetalle']; ?>
                        </td>
                        <td>
                            <button id="editar" class="btn btn-primary btn-sm" type="button" onclick="editar(<?=$id?>)">
                                <i class="fas fa-pen"></i> Editar
                            </button>
                            <button id="borrar" class="btn btn-danger btn-sm" type="button" onclick="borrar(<?=$id?>)">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <td colspan="7"><button type="button" class="btn btn-success btn-md" onclick="$('#modal').modal('show')"><i class="fas fa-plus"></i>Añadir</button>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-success" id="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editar</h4>
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
<script>
    function editar(id){
        var dataToSend = {'idproducto': id};
        $.ajax({
            method: 'post',
            url: '../accion/accionProdStock.php',
            data: dataToSend,
            type: 'json',
            success: function(data){
                data = JSON.parse(data);
                $('#idproducto').val(data.idproducto);
                $('#pronombre').val(data.pronombre);
                $('#idrubro').val(data.idrubro);
                $('#procantstock').val(data.procantstock);
                $('#proprecio').val(data.proprecio);
                $('#prodetalle').val(data.prodetalle);
                $('#modal').modal('show');
            }
        });
    }

    function borrar(id){
        var dataToSend = {'idproducto': id};
        $.ajax({
            method: 'post',
            url: '../accion/accionBorrarStock.php',
            data: dataToSend,
            type: 'json',
            success: function(data){
                toastr.error('Producto eliminado.');
            }
        });
    }

    $(document).ready(function(){
        $('#form-modal').on('submit', function(){
            var dataToSend = $(this).serialize();
            $.ajax({
                method: 'post',
                url: '../accion/accionSaveStock.php',
                data: dataToSend,
                type: 'json',
                success: function(){
                    $('#form-modal').off().submit();
                }
            });
            return false;
        });
    });
</script>
<?php include_once('../estructura/footer.php');?>