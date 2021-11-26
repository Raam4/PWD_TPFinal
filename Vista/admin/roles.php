<?php
include_once("../../Utiles/sessmanager.php");
if(!$objSess->activa()){
    header('location:../public/login.php');
    exit();
}
include_once("../estructura/header.php");
$abmrol = new AbmRol();
$roles = $abmrol->buscar(array());
$abmmenu = new AbmMenu();
$menues = $abmmenu->buscar(array());
?>

<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Roles</h3>
                </div>
                <div class="card-body">
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th style="width: 10%">
                                    ID Rol
                                </th>
                                <th style="width: 15%">
                                    Descripción
                                </th>
                                <th style="width: 15%">
                                    Menú Asociado
                                </th>
                                <th style="width: 15%">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4">
                                    <button type="button" class="btn btn-success" onclick="$('#modalnuevo').modal('show')"><i class="fas fa-plus"></i> Nuevo</button>
                                </td>
                            </tr>
                            <?php
                            foreach($roles as $rol){
                                $menu = $abmrol->menus($rol);
                                $idrol = $rol['idrol'];
                                $data = ['idrol' => $idrol, 'idmenu' => $menu[0]['idmenu']];
                            ?>
                            <tr>
                                <td>
                                    <?=$idrol;?>
                                </td>
                                <td>
                                    <?=$rol['rodescripcion'];?>
                                </td>
                                <td id="menombre<?=$idrol;?>">
                                    <?=$menu[0]['menombre']?>
                                </td>
                                <td id="menues<?=$idrol;?>" style="display: none">
                                    <select id="selmenu<?=$idrol;?>" class="form-control">
                                        <?php
                                        foreach($menues as $me){
                                            if(is_null($me['idpadre'])){
                                        ?>
                                        <option value="<?=$me['idmenu']?>"><?=$me['menombre']?></option>
                                        <?php
                                        }}
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <button type="button" id="btnedit<?=$idrol?>" class="btn btn-warning" onclick="edit(<?=$idrol?>)"><i class="fas fa-pen"></i></button>
                                    <div id="btnsacc<?=$idrol?>" style="display: none">
                                        <button type="button" id="ok<?=$idrol?>" class="btn btn-success" onclick="guardar(<?=$idrol?>)"><i class="fas fa-check"></i></button>
                                        <button type="button" id="can<?=$idrol?>" class="btn btn-danger" onclick="cancelar(<?=$idrol?>)"><i class="fas fa-times"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalnuevo" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-success" id="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-white">Crear Nuevo rol</h4>
            </div>
            <div class="modal-body">
                <form id='nuevorol' name='nuevorol'>
                <div class="row">
                    <div class="col-sm-6">
                        <input class="form-control" type="text" id='rodescripcion' name="rodescripcion" placeholder="Nombre Rol" required>
                    </div>
                    <div class="col-sm-2"><label class="pt-2">Menú:</label></div>
                    <div class="col-sm-4">
                        <select class="form-control" id='idmenu' name='idmenu'>
                            <?php
                            foreach($menues as $me){
                                if(is_null($me['idpadre'])){
                            ?>
                            <option value="<?=$me['idmenu']?>"><?=$me['menombre']?></option>
                            <?php
                            }}
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="reset" class="btn btn-outline-light" onclick="$('#modalnuevo').modal('hide')">Cancelar</button>
                    <button type="submit" class="btn btn-outline-light">Guardar</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function edit(id){
    $('#menombre'+id).hide();
    $('#menues'+id).show();
    $('#btnsacc'+id).show();
    $('#btnedit'+id).hide();
}
function guardar(idrol){
    var dataToSend = {'idrol' : idrol, 'idmenu': $('#selmenu'+idrol).val()};
    if(confirm('Cambiar menú asociado?')){
        $.ajax({
            method: 'POST',
            url: '../accion/admin/accionMenuRolEdit.php',
            data: dataToSend,
            type: 'json',
            success: function(data){
                $('#menombre'+idrol).text(JSON.parse(data));
                toastr.success('Menú cambiado con exito!');
                cancelar(idrol);
            }
        });
    }
}
function cancelar(id){
    $('#menombre'+id).show();
    $('#menues'+id).hide();
    $('#btnsacc'+id).hide();
    $('#btnedit'+id).show();
}
$(document).ready(function(){
    $("#nuevorol").validate({
        messages: {
            rodescripcion: {
                required: "El campo es obligatorio",
            }
        },
        submitHandler: function() {
            var dataToSend = $(this).serialize();
            $.ajax({
                method: 'post',
                url: '../accion/admin/accionMenuRolNew.php',
                data: dataToSend,
                type: 'json',
                success: function(){
                    $('#nuevorol').off().submit();
                }
            });
            return false;
        }
    });
});
</script>
<?php
include_once("../estructura/footer.php");
?>