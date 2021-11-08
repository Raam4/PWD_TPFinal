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
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="Index.php" class="h1"><b>Carrito</b></a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Registro de nuevo usuario</p>
                    <form id="registro" name="registro" class="mb-2" action="../accion/accionRegistro.php" method="post">
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
                                <button type="submit" class="btn btn-primary btn-block">Registrarme</button>
                            </div>
                        </div>
                    </form>
                    <a href="login.php" class="text-center">Ya estoy registrado</a>
                </div>
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
                'usmail': $('#usmail').val()
            };
            var evento = false;
            $.ajax({
                method: 'post',
                url: '../accion/accionRegJS.php',
                data: dataToSend,
                type: 'json',
                success: function(data) {
                    if(data == 1){
                        $('#repeUser').show();
                    }
                    if(data == 2){
                        $('#repeMail').show();
                    }
                    if(data == 3){
                        console.log(data);
                        $('#registro').off().submit();
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