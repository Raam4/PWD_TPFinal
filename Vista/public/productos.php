<?php
include_once("../../Utiles/sessmanager.php");
include_once("../estructura/header.php");
$listaImg="";
$ruta = "../css/img/publico/"; // Indicar la ruta
$fileh = opendir($ruta); // Abrir archivos de la carpeta
while ($file = readdir($fileh)) {
        if ($file != "." && $file != "..") {
                $tamanyo = GetImageSize($ruta . $file);
                $listaImg.="<div class='contImg col-sm-3 mb-3'>
                <a href='../public/login.php' title='Project Name'>
                    <img class='img-fluid' src='".$ruta.$file."' alt='...' style='border-radius:3px'> 
                </a>
            </div>";
        } 
} 
closedir($fileh); // Fin lectura archivos
?>
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-body text-center">
                <h2 id="titleProd" class="textArch">Nuestros productos</h2>
            </div>
        </div>  
    </div>
    <div id="portfolio">
            <div class="container-fluid p-3">
                <div class="row g-0 m-4">
                    <?php echo $listaImg;  ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once("../estructura/footer.php");
?>