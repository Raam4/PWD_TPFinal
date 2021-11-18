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
                <div class="card-header text-center">
                    <!-- <a href="Index.php" class="h1"><b>Carrito</b></a> -->
                </div>
                <div class="card-body">
                    <p class="login-box-msg h5" style="color: #ddaa44ff;">Registro de nuevo usuario</p>
                    <form id="registro" name="registro" class="mb-2" method="post">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Nombre de usuario" id="usnombre" name="usnombre">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="date" id="usfecnac" name="usfecnac" class="form-control" placeholder="Fecha de nacimiento">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-calendar"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="email" id="usmail" name="usmail" class="form-control" placeholder="Email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" id="ustelefono" name="ustelefono" class="form-control" placeholder="Teléfono celular">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-phone"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="uspass" name="uspass" placeholder="Contraseña">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
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
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-outline-primary btn-block">Registrarme</button>
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
    });

    $('body').ready(function (){
        $('#registro').submit(function (event) {
            event.preventDefault();
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
        });
    });
</script>
<?php
include_once("../estructura/footer.php");
?>