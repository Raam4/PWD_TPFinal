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
    <div class="row justify-content-center pt-5">
        <div class="login-box">
            <div class="card card-outline card-warning">
                <div class="card-body login-card-body">
                    <p class="login-box-msg h4" style="color: #ddaa44ff;">Iniciar Sesión</p>
                    <form method="POST" name="login" id="login">
                        <input type="text" class="form-control" placeholder="Nombre de usuario" name="usnombre" id="usnombre" required>
                        <input type="password" class="form-control mt-3" placeholder="Contraseña" name="uspass" id="uspass" required>
                        <div class="row mt-3" id="noCred" style="display: none;">
                            <div class="alert alert-danger py-1">
                                <button type="button" class="close" onclick="$('#noCred').hide();">×</button>
                                <p class="text-center my-1"><i class="icon fas fa-ban"></i> Credenciales incorrectas</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                                <button type="submit" class="btn btn-outline-warning btn-block">Ingresar</button>
                        </div>
                    </form>
                    <p class="my-1">
                        <a href="#" class="lgReg">Olvidé mi contraseña</a>
                    </p>
                    <p class="mb-0">
                        <a href="registro.php" class="lgReg">Quiero registrarme</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../js/port_md5.js"></script>
<script>
    $('body').ready(function () {
        $("#login").validate({
            messages: {
                usnombre: {
                    required: "El campo es obligatorio.",
                },
                uspass: {
                    required: "El campo es obligatorio.",
                },
            },
            submitHandler: function() {
                var dataToSend = {'usnombre' : $('#usnombre').val(), 'uspass' : md5($('#uspass').val())}
                $.ajax({
                    method: 'POST',
                    url: '../accion/public/accionLogin.php',
                    data: dataToSend,
                    type: 'json',
                    success: function(data) {
                        if(data == 'true'){
                            $(location).attr('href','Index.php');
                        }else{
                            $('#noCred').show();
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
</script>
<?php
include_once("../estructura/footer.php");
?>