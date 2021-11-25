<?php
include_once("../../configuracion.php");
include_once("../../Utiles/sessmanager.php");
include_once("../estructura/header.php");
?>
<div class="content-wrapper">
    <div class="card">
        <div class="card-body row mt-4">
            <div class="col-5 text-center d-flex align-items-center justify-content-center mx-4 mb-4">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3102.3626106990037!2d-68.05820688495247!3d-38.96138740834625!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x960a33dd78ff8aa5%3A0x62644f9a06d82181!2sToc%20Toc!5e0!3m2!1ses!2sar!4v1636487946382!5m2!1ses!2sar" width="700" height="500" style="border:2px goldenrod solid;border-radius:3px" allowfullscreen="" loading="lazy"></iframe>
            </div>
            <div class="col-5 mx-4">
                <h3 id='wpp' class="textArch">Contactanos! - Wpp: 2996253216 </h3>
                <form id="contacto" name="contacto">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Telefono (Whatsapp)</label>
                        <input type="text" id="telefono" name="telefono" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="resumen">Resumen</label>
                        <input type="text" id="resumen" name="resumen" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="mensaje">Mensaje</label>
                        <textarea id="mensaje" class="form-control" name="mensaje" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-outline-warning" value="Enviar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$('body').ready(function () {
    $("form#contacto").validate({
        rules: {
            nombre: {
                rangelength: [5, 15],
                pattern: /^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ\s]+$/,
            },
            telefono: {
                rangelength: [6, 13],
                number: true,
            },
        },
        messages: {
            nombre: {
                required: "El campo es obligatorio",
                pattern: 'Solo se permiten letras',
                rangelength: 'Debe ingresar entre 5 y 15 carácteres',
            },
            telefono: {
                required: "El campo es obligatorio",
                number: "Ingrese solo números, sin 0 ni 15",
                rangelength: 'La cantidad de números es inválida',
            },
            resumen: {
                required: "El campo es obligatorio",
            },
            mensaje: {
                required: "El campo es obligatorio",
            },
        },
    });
});
</script>
<?php include_once("../estructura/footer.php"); ?>