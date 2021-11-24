<?php
include_once("../../configuracion.php");
include_once("../../Utiles/sessmanager.php");
if(!$objSess->activa()){
    header('location:../public/login.php');
    exit();
}else if($objSess->getRolActivo()['idrol']!=1){
    header('location:../public/Index.php');
    exit();
}
include_once("../estructura/header.php");
$abmrol = new AbmRol();
$roles = $abmrol->buscar(array());
?>

<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3>Usuarios</h3>
        </div>
        <div class="card-body">
            <div id="salida">
                <!-- Se genera la lista -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalroles" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-success" id="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-white">Gestionar Roles</h4>
            </div>
            <div class="modal-body text-center">
                <form id="formroles" name="formroles">
                    <div class="form-group">
                        <input type="hidden" id="usid" name="usid">
                    <?php foreach($roles as $rol){
                        $idrol = $rol['idrol'];
                    ?>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="rol<?=$idrol?>" name="roles[]" value="<?=$idrol?>">
                            <label class="custom-control-label" for="rol<?=$idrol?>"><?=$rol['rodescripcion']?></label>
                        </div>
                    <?php } ?>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="reset" class="btn btn-outline-light" onclick="$('#modalroles').modal('hide')">Cancelar</button>
                    <button type="submit" class="btn btn-outline-light">Guardar</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $.ajax({
            method: 'post',
            url: '../accion/admin/accionListarUsuarios.php',
            success: function(data) {
                $('#salida').html(data)
            },
            error: function(data) {
                console.log(data);
            }
        })
        $('#formroles').on('submit', function(){
            var dataToSend = $(this).serialize();
            $.ajax({
                method: 'post',
                url: '../accion/admin/accionSaveRol.php',
                data: dataToSend,
                type: 'json',
                success: function(data){
                    $("#modalroles").modal("hide");
                    toastr.success('Roles guardados!');
                }
            });
            return false;
        });
    });

    $(document).on("click", "#altaUs", function() {
        var currentRow = $(this).closest("tr");
        var nom = currentRow.find("td:eq(1)").html();
        var mail = currentRow.find("td:eq(2)").html();
        var tel = currentRow.find("td:eq(3)").html();
        var pass = currentRow.find("td:eq(4)").html();
        if (nom == '' || mail == '' || tel == '' || pass == '') {
            if(nom == ''){
                currentRow.find("td:eq(1)").attr('style', 'border: 3px solid red');
            }
            if(mail == ''){
                currentRow.find("td:eq(2)").attr('style', 'border: 3px solid red');
            }
            if(tel == ''){
                currentRow.find("td:eq(3)").attr('style', 'border: 3px solid red');
            }
            if(pass == ''){
                currentRow.find("td:eq(4)").attr('style', 'border: 3px solid red');
            }
        }else{
            $.ajax({
                method: 'post',
                url: '../accion/admin/accionAltaUs.php',
                data: {
                    'usnombre': nom,
                    'usmail': mail,
                    'ustelefono':tel,
                    'uspass':pass
                },
                type: 'json',
                success: function(data) {
                    $("#salida").load('../accion/admin/accionListarUsuarios.php');
                    find("td:eq(1)").removeAttr('style');
                    find("td:eq(1)").removeAttr('style');
                    find("td:eq(1)").removeAttr('style');
                    find("td:eq(1)").removeAttr('style');
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    });

    $(document).on("click", ".borrarUs", function() {
        if (confirm('Seguro que desea borrar el registro')) {
            var id = $(this).data("id");
            $.ajax({
                method: 'post',
                url: '../accion/admin/accionBorrarUs.php',
                data: {
                    'idusuario': id,
                },
                type: 'json',
                success: function(data) {
                    $("#salida").load('../accion/admin/accionListarUsuarios.php');
                },
                error: function(data) {
                    console.log(data);
                }
            })
        }
    });

    
    $(document).on("click", ".editarUs", function() {
        var currentRow = $(this).closest("tr");
        var col0 = currentRow.find("td:eq(0)").html();
        // var butEdit = $(this).closest("button");

        currentRow.find("td:eq(1)").attr('contenteditable', true);
        currentRow.find("td:eq(2)").attr('contenteditable', true);
        currentRow.find("td:eq(3)").attr('contenteditable', true);
        currentRow.find("td:eq(1)").focus();

        controlButton(col0, 1);

        $(document).on("click", "#confirm" + col0, function() {
            var col1 = currentRow.find("td:eq(1)").html();
            var col2 = currentRow.find("td:eq(2)").html();
            var col3 = currentRow.find("td:eq(3)").html();
            if(col1 == '' || col2 == '' || col3 == ''){
                if(col1 == ''){
                    currentRow.find("td:eq(1)").attr('style', 'border: 3px solid red');
                }
                if(col2 == ''){
                    currentRow.find("td:eq(2)").attr('style', 'border: 3px solid red');
                }
                if(col3 == ''){
                    currentRow.find("td:eq(3)").attr('style', 'border: 3px solid red');
                }
            }else{
                currentRow.find("td:eq(1)").attr('contenteditable', false);
                currentRow.find("td:eq(2)").attr('contenteditable', false);
                currentRow.find("td:eq(3)").attr('contenteditable', false);

                var dataF = {
                    "idusuario": currentRow.find("td:eq(0)").html(),
                    "usnombre": currentRow.find("td:eq(1)").html(),
                    "usmail": currentRow.find("td:eq(2)").html(),
                    "ustelefono": currentRow.find("td:eq(3)").html()
                };
                if(editar(dataF)){
                    currentRow.find("td:eq(1)").removeAttr('style');
                    currentRow.find("td:eq(2)").removeAttr('style');
                    currentRow.find("td:eq(3)").removeAttr('style');
                }
            }
        })

    });
    function controlButton(id, accion) {
        if (accion == 1) {
            $('#editarUs'+id).hide();
            $('#borrarUs' + id).hide();
            $('#gestion' + id).hide();
            $('#confirm' + id).show();
            $('#cancel' + id).show();
        } else {
            $("#salida").load('../accion/admin/accionListarUsuarios.php');
        }
    }

    function editar(dataF) {
        var ret = false;
        $.ajax({
            method: 'post',
            url: '../accion/admin/accionEditarUs.php',
            data: dataF,
            type: 'json',
            success: function(data) {
                // alert("exito");
                $("#salida").load('../accion/admin/accionListarUsuarios.php');
                ret = true;
            },
            error: function(data) {
                alert("error");
            }
        })
        return ret;
    }
    

    $(document).on("click", "#habilUs", function() {
        var id = $(this).data("id");
        $.ajax({
            method: 'post',
            url: '../accion/admin/accionHabilitarUs.php',
            data: {
                'idusuario': id,
            },
            type: 'json',
            success: function(data) {
                $("#salida").load('../accion/admin/accionListarUsuarios.php');
            },
            error: function(data) {
                alert("error");
            }
        })
    });

    function cerrarDlg() {
        // event.preventDefault();
        // $("#fm")[0].reset();
        $(dlg).hide();
    }
    
    function roles(iduser){
        $('#usid').attr('value', iduser);
        $("input[name='roles[]']").each(function(){$(this).attr('checked', false);});
        $.ajax({
            method: 'post',
            url: '../accion/admin/accionRetRol.php',
            data: {'idusuario': iduser},
            type: 'json',
            success: function(data){
                data = JSON.parse(data);
                $("input[name='roles[]']").each(function(){
                    var val = $(this).val();
                    if($.inArray(val, data) != -1){
                        $(this).attr('checked', true);
                    }
                })
            }
        });
        $("#modalroles").modal("show");
    }
</script>
<?php include_once('../estructura/footer.php'); ?>