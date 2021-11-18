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
                <h3 id='Contacto' class="textArch">Contactanos! - Wpp: 2996253216 </h3>
                <div class="form-group">
                    <label for="inputName">Nombre</label>
                    <input type="text" id="inputName" class="form-control">
                </div>
                <div class="form-group">
                    <label for="inputEmail">Telefono (Wpp)</label>
                    <input type="email" id="inputEmail" class="form-control">
                </div>
                <div class="form-group">
                    <label for="inputSubject">Resumen</label>
                    <input type="text" id="inputSubject" class="form-control">
                </div>
                <div class="form-group">
                    <label for="inputMessage">Mensaje</label>
                    <textarea id="inputMessage" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-outline-warning" value="Enviar">
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once("../estructura/footer.php"); ?>