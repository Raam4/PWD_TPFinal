<?php
include_once("../../configuracion.php");
$data = data_submitted();
$objSess = new Session();
$abmrol = new AbmRol();
if($objSess->activa()) {
    header('location:../public/Index.php');
    exit();
}else{
    $perfil = Maker::perfil(null);
    $menu = Maker::menu(['idrol'=>4]);
}
include_once("../estructura/header.php");
?>
<div class="content-wrapper">
    <div class="row justify-content-center py-5">
        <div class="login-box">
            <div class="card card-outline card-warning">
                <div class="card-body">
                    <p class="login-box-msg h5" style="color: #ddaa44ff;">Registro de nuevo usuario</p>
                    <form id="registro" name="registro" class="mb-2" method="post">
                        <!-- agregar labels? o algun decorado-->
                        <input type="text" class="form-control" placeholder="Nombre de usuario" id="usnombre" name="usnombre" required>
                            
                            <input type="date" id="usfecnac" name="usfecnac" class="form-control mt-2" min="1900-01-01" max="2003-11-25" placeholder="Fecha de nacimiento" required>
                        
                            <input type="text" id="usmail" name="usmail" class="form-control mt-2" placeholder="Email" required>
                            
                            <input type="text" id="ustelefono" name="ustelefono" class="form-control mt-2" placeholder="Teléfono celular" required>
                            
                            <input type="password" class="form-control mt-2" id="uspass" name="uspass" placeholder="Contraseña" required>
                            
                        <div class="row" id="repeUser" style="display: none;">
                            <div class="alert alert-danger py-1">
                                <button type="button" class="close" onclick="$('#repeUser').hide();">×</button>
                                <p class="text-center my-1"><i class="icon fas fa-ban"></i>Nombre de usuario ya utilizado</p>
                            </div>
                        </div>
                        <div class="row" id="repeMail" style="display: none;">
                            <div class="alert alert-danger py-1">
                                <button type="button" class="close" onclick="$('#repeMail').hide();">×</button>
                                <p class="text-center my-1"><i class="icon fas fa-ban"></i>Correo ya utilizado</p>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-3">
                            <div class="col-md-10">
                                <button type="submit" class="btn btn-md btn-outline-warning btn-block">Registrarme</button>
                            </div>
                        </div>
                    </form>
                    <a href="login.php" class="lgReg">Ya estoy registrado</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-success" id="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Registro</h4>
            </div>
            <div class="modal-body">
                <p id="modalMsg"></p>
            </div>
            <div class="modal-footer">
                <p>(Click fuera del recuadro para salir)</p>
            </div>
        </div>
    </div>
</div>
<script src="../js/port_md5.js"></script>
<script>
$(document).ready(function(){
    $('#usfecnac').get(0).type= 'text';
    $('#usfecnac').blur(function(){
        $(this).get(0).type = 'text';
    });
    $('#usfecnac').focus(function(){
        $(this).get(0).type = 'date';
    });
    $(function(){
        $("#registro").validate({
            rules:{
                usnombre: {
                    rangelength: [5, 15],
                    pattern: /^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ_.\s]+$/,
                },
                uspass: {
                    rangelength: [5, 15],
                    pattern: /^([a-z]+[0-9]+)|([0-9]+[a-z]+)/i,
                },
                usmail: {
                    pattern: /^(?:[^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*|"[^\n"]+")@(?:[^<>()[\].,;:\s@"]+\.)+[^<>()[\]\.,;:\s@"]{2,63}$/i,
                },
                ustelefono: {
                    rangelength: [6, 13],
                    number: true,
                }
            },
            messages: {
                usnombre: {
                    required: "El campo es obligatorio",
                    pattern: "Solo se permiten letras _ y .",
                    rangelength: 'Debe ingresar entre 5 y 15 carácteres',
                },
                uspass: {
                    required: "El campo es obligatorio.",
                    pattern: "Solo se permiten letras y números, al menos uno de cada tipo",
                    rangelength: 'Debe ingresar entre 5 y 15 carácteres',
                },
                usfecnac: {
                    required: "El campo es obligatorio",
                },
                usmail: {
                    required: "El campo es obligatorio",
                    pattern: "Ingrese una direccion de correo valida",
                },
                ustelefono: {
                    required: "El campo es obligatorio",
                    number: "Ingrese solo números, sin 0 ni 15",
                    rangelength: 'La cantidad de números es inválida',
                },
            },
            submitHandler: function() {
                $('#repeUser').hide();
                $('#repeMail').hide();
                var dataToSend = {
                    'usnombre': $('#usnombre').val(),
                    'usfecnac': $('#usfecnac').val(),
                    'usmail': $('#usmail').val(),
                    'ustelefono': $('#ustelefono').val(),
                    'uspass': md5($('#uspass').val()),
                };
                $.ajax({
                    method: 'post',
                    url: '../accion/public/accionRegJS.php',
                    data: dataToSend,
                    type: 'json',
                    success: function(data) {
                        if(data == '1'){
                            $('#repeUser').show();
                        }
                        if(data == '2'){
                            $('#repeMail').show();
                        }
                        if(data == '3'){
                            $('#registro')[0].reset();
                            $('#modal-content').attr('class', 'modal-content bg-success');
                            $('#modalMsg').text('Usted se ha registrado con éxito. En breve, un administrador revisará sus datos y le asignará un rol.');
                            $('#modal').modal('show');
                        }
                        if(data == '4'){
                            $('#modal-content').attr('class', 'modal-content bg-danger');
                            $('#modalMsg').text('Algo salió mal, por favor revise los datos ingresados e intente nuevamente');
                            $('#modal').modal('show');
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
                return false;
            }
        });
    });
});
</script>
<?php
include_once("../estructura/footer.php");
?>