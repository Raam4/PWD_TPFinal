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
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                        <a href="Index.php" class="h1"><b>Carrito</b></a>
                </div>
                <div class="card">
                    <div class="card-body login-card-body">
                        <p class="login-box-msg">Iniciar Sesión</p>
                        <form method="POST" name="login" id="login">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Nombre de usuario" name="usnombre" id="usnombre">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" placeholder="Contraseña" name="uspass" id="uspass">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="noCred" style="display: none;">
                                <div class="alert alert-danger py-1">
                                    <button type="button" class="close" onclick="$('#noCred').hide();">×</button>
                                    <p class="text-center my-1"><i class="icon fas fa-ban"></i> Credenciales incorrectas</p>
                                </div>
                            </div>
                            <div class="row">
                                    <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                            </div>
                        </form>
                        <p class="my-1">
                            <a href="#">Olvidé mi contraseña</a>
                        </p>
                        <p class="mb-0">
                            <a href="registro.php" class="text-center">Quiero registrarme</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../js/port_md5.js"></script>
<script>
    $('body').ready(function () {
        /*
            Este .on nos va a server para cachar el evento submit, cuando haces click en un boton del tipo "submit" y quiere enviar el formulario, lo hago de esta forma por si tienes un required en un input o algun type="email" de HTML5 se haga la validacion antes de enviar los datos. De igual forma es buena practica hacer una validacion en el back antes de hacer cualquier cosa.
        */
        $('#login').on('submit', function () { // Nos suscribimos al evento "submit" de nuestro formulario el cual se lanzara al hacer click en un boton del tipo submit
            var dataToSend = {'usnombre' : $('#usnombre').val(), 'uspass' : md5($('#uspass').val())}
            // Despues hacemos el $.ajax
            $.ajax({
                method: 'POST', // Metodo a utilizar POST, GET, etc...
                url: '../accion/accionLogin.php', // URL de la pagina que recibira la petición
                data: dataToSend, // Aqui van los datos a enviar, en este caso serializamos los campos del formulario y los asinamos a esta variable por eso solo ponemos esta variable
                type: 'json',
                success: function(data) {
                    if(data == 'true'){
                        $(location).attr('href','Index.php');
                    }else{
                        $('#noCred').show();
                    }
                    // Este callback que se lanzara si la url 'myPage.php' responde como un status 200: OK, y lo que imprimas en php lo cachara en la variable data.
                },
                error: function (data) {
                    console.log(data); // Este callback que se lanzara si la url 'myPage.php' responde con status de error, e.g. 400, 404, 500, etc...
                }
            });
            return false; // Este return es para que no se lanze el evento submit al navegador y no brinque de pagina, si no que se queda esperando la respuesta de nuestra llamada ajax.
        });
    });
</script>
<?php
include_once("../estructura/footer.php");
?>