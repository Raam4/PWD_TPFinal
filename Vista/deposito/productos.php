<?php
include_once("../../configuracion.php");
include_once("../../Utiles/sessmanager.php");
if(!$objSess->activa()){
    header('location:../public/login.php');
    exit();
}else if($objSess->getRolActivo()['idrol']!=2){
    header('location:../public/Index.php');
    exit();
}
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
                        <th style="width: 20%">
                            Detalle
                        </th>
                        <th style="width: 10%">
                            Imagen
                        </th>
                        <th style="width: 22%">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <td colspan=8>
                        <button type="button" class="btn btn-success btn-md" onclick="$('#modal').modal('show')"><i class="fas fa-plus" title='Alta Producto'></i> Alta</button>
                    </td>
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
                            <div class="image">
                                <img src="../../files/prods/<?=md5($item['pronombre'].$item['idproducto'])?>.jpg" class="img-circle" style="max-width:100%;width:auto;height:auto;" alt="Imagen Producto">
                            </div>
                        </td>
                        <td>
                            <button id="editar<?=$id?>" class="btn btn-primary btn-sm" type="button" onclick="editar(<?=$id?>)" title='Editar'>
                                <i class="fas fa-pen"></i> </button>
                                <?php
                                if(is_null($item['prodeshabilitado']) || $item['prodeshabilitado'] == '00-00-00 00:00:00'){
                                    $statusal = 'inline';
                                    $statusba = 'none';
                                }else{
                                    $statusal = 'none';
                                    $statusba = 'inline';
                                }
                                ?>
                            <button id="baja<?=$id?>" class="btn btn-danger btn-sm" type="button" style="display: <?=$statusal?>" onclick="deshabilitar(<?=$id?>)" title='deshabilitar'>
                                <i class="fas fa-arrow-down"></i> </button>
                            <button id="alta<?=$id?>" class="btn btn-success btn-sm" type="button" style="display: <?=$statusba?>" onclick="habilitar(<?=$id?>)" title='habilitar'>
                            <i class="fas fa-arrow-up"></i> </button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
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
                            <input class="form-control" type="text" name="pronombre" id="pronombre" placeholder="Nombre" required>
                        </div>
                        <div class="col-sm-2"><label class="pt-2">Rubro:</label></div>
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
                            <input class="form-control" type="number" name="procantstock" id="procantstock" placeholder="Stock" required>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                    <i class="fas fa-dollar-sign"></i>
                                    </span>
                                </div>
                                <input class="form-control" type="number" name='proprecio' id="proprecio" placeholder="Precio" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label>Imagen:</label>
                        <div class="col-sm">
                            <input type="file" id="imgprod" name="imgprod" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <textarea class="form-control" rows='2' name="prodetalle" id="prodetalle" placeholder="Detalle" required></textarea>
                        </div>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="reset" class="btn btn-outline-light" onclick="$('#modal').modal('hide')">Cancelar</button>
              <button type="submit" class="btn btn-outline-light">Guardar</button>
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
            url: '../accion/deposito/accionEditarProd.php',
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

    function deshabilitar(id){
        var dataToSend = {'idproducto': id};
        $.ajax({
            method: 'post',
            url: '../accion/deposito/accionBorrarProd.php',
            data: dataToSend,
            type: 'json',
            success: function(data){
                $('#baja'+id).hide();
                $('#alta'+id).show();
                toastr.error('Producto deshabilitado.');
            }
        });
    }

    function habilitar(id){
        var dataToSend = {'idproducto': id};
        $.ajax({
            method: 'post',
            url: '../accion/deposito/accionHabProd.php',
            data: dataToSend,
            type: 'json',
            success: function(data){
                $('#baja'+id).show();
                $('#alta'+id).hide();
                toastr.success('Producto habilitado.');
            }
        });
    }

    $(document).ready(function(){
        $("#form-modal").validate({
            messages: {
                pronombre: {
                    required: "El campo es obligatorio.",
                },
                procantstock: {
                    required: "El campo es obligatorio.",
                },
                proprecio: {
                    required: "El campo es obligatorio.",
                },
                prodetalle: {
                    required: "El campo es obligatorio.",
                }
            },
            submitHandler: function() {
                var formData = new FormData();
                formData.append('pronombre', $('#pronombre').val());
                formData.append('procantstock', $('#procantstock').val());
                formData.append('proprecio', $('#proprecio').val());
                formData.append('prodetalle', $('#prodetalle').val());
                formData.append('idrubro', $('#idrubro').val());
                if($('#idproducto').val() != ''){
                    formData.append('idproducto', $('#idproducto').val());
                }
                if($('#imgprod').val() != ''){
                    formData.append('imgprod', $('#imgprod')[0].files[0]);
                }
                $.ajax({
                    method: 'post',
                    url: '../accion/deposito/accionGuardarProd.php',
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(){
                        $('#form-modal').off().submit();
                    }
                });
            return false;
            }
        });
    });
</script>
<?php include_once('../estructura/footer.php');?>