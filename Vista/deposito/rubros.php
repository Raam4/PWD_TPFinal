<?php
include_once("../../Utiles/sessmanager.php");
if(!$objSess->activa()){
    header('location:../public/login.php');
    exit();
}
include_once("../estructura/header.php");
$abmprod = new AbmProducto();
$abmrubro = new AbmRubro();
$rubros = $abmrubro->buscar(array());
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
                        <th style="width: 5%">
                            ID
                        </th>
                        <th style="width: 20%">
                            Nombre
                        </th>
                        <th style="width: 10%">
                            Cantidad de productos
                        </th>
                        <th style="width: 10%">
                            Estado
                        </th>
                        <th style="width: 15%">
                            Editar
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <td colspan=5>
                        <button type="button" class="btn btn-success btn-md" onclick="$('#modalrubro').modal('show')"><i class="fas fa-plus" title='Alta Producto'></i> Alta</button>
                    </td>
                    <?php
                    foreach($rubros as $rub){
                        $id = $rub['idrubro'];
                        $prods = $abmprod->buscar(['idrubro' => $id]);
                    ?>
                    <tr>
                        <td>
                            <?php echo $id; ?>
                        </td>
                        <td id="name<?=$id?>">
                            <?php echo $rub['runombre']; ?>
                        </td>
                        <td>
                            <?php echo count($prods); ?>
                        </td>
                        <td id="status<?=$id?>">
                            <?php if(is_null($rub['rudeshabilitado'])) : echo 'Habilitado'; else : echo 'Deshabilitado'; endif?>
                        </td>
                        <td>
                            <button id="editar<?=$id?>" class="btn btn-primary btn-sm editarRub" type="button" onclick="editar(<?=$id?>,'<?=$rub['runombre']?>')" title='Editar'>
                                <i class="fas fa-pen"></i>
                            </button>
                            <?php
                                if(is_null($rub['rudeshabilitado']) || $rub['rudeshabilitado'] == '0000-00-00 00:00:00'){
                                    $statusal = 'inline';
                                    $statusba = 'none';
                                }else{
                                    $statusal = 'none';
                                    $statusba = 'inline';
                                }
                                ?>
                            <button id="baja<?=$id?>" class="btn btn-danger btn-sm" type="button" style="display: <?=$statusal?>" onclick="manage(0, <?=$id?>)" title='deshabilitar'>
                                <i class="fas fa-arrow-down"></i> </button>
                            <button id="alta<?=$id?>" class="btn btn-success btn-sm" type="button" style="display: <?=$statusba?>" onclick="manage(1, <?=$id?>)" title='habilitar'>
                            <i class="fas fa-arrow-up"></i> </button>
                            </button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="modalrubro" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-success" id="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editar</h4>
            </div>
            <div class="modal-body">
                <form id="form-modal">
                <input type="hidden" name="idrubro" id="idrubro">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <input class="form-control" type="text" name="runombre" id="runombre" placeholder="Nombre rubro" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="reset" class="btn btn-outline-light" onclick="$('#modalrubro').modal('hide')">Cancelar</button>
              <button type="submit" class="btn btn-outline-light">Guardar</button>
            </form>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    $('#form-modal').on('submit', function(){
        if($('#idrubro').val() == ''){
            var dataToSend = {'runombre' : $('#runombre').val()};
        }else{
            var dataToSend = $(this).serialize();
        }
        $.ajax({
            method: 'post',
            url: '../accion/deposito/accionManageRub.php',
            data: dataToSend,
            type: 'json',
            success: function(id){
                if($('#idrubro').val() == ''){
                    location.reload();
                }else{
                    id = JSON.parse(id);
                    $('#name'+id).text($('#runombre').val());
                    $('#modalrubro').modal('hide');
                }
            }
        });
        return false;
    });
});
function manage(stat, id){
    var dataToSend = {'idrubro': id, 'stat' : stat};
    $.ajax({
        method: 'post',
        url: '../accion/deposito/accionManageRub.php',
        data: dataToSend,
        type: 'json',
        success: function(){
            if(stat == 1){
                $('#baja'+id).show();
                $('#alta'+id).hide();
                $('#status'+id).text('Habilitado');
                toastr.success('Rubro habilitado.');
            }
            if(stat == 0){
                $('#baja'+id).hide();
                $('#alta'+id).show();
                $('#status'+id).text('Deshabilitado');
                toastr.error('Rubro deshabilitado.');
            }
        }
    });
}
function editar(id, nombre){
    $('#idrubro').attr('value', id);
    $('#runombre').attr('value', nombre);
    $('#modalrubro').modal('show');
}
</script>

<?php include_once('../estructura/footer.php');?>