<?php
include_once("../../Utiles/sessmanager.php");
if(!$objSess->activa()){
    header('location:../public/login.php');
    exit();
}
include_once("../estructura/header.php");
$carroEnCarga = $objSess->getCarrito();
?>
<div class="content-wrapper">
        <div id="myCarousel" class="carousel slide mb-3" data-bs-ride="carousel">
            <div class="carousel-indicators">
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2" class="active" aria-current="true"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3" class=""></button>
            </div>
            <div class="carousel-inner">
            <div class="carousel-item">
            <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"  preserveAspectRatio="xMidYMid slice" focusable="false"><image width="100%"  y="-15"  href="../css/img/7.jpg" /></svg>
                <div class="container">
                <div class="carousel-caption text-start">
                    <h1 class="txtArchBl">Salvamos tu previa</h1>                    
                    <p class="txtArchBl"><b>Pedí nuestra lista de productos para salvar tus juntadas</b></p>
                    <!-- <p><a class="btn btn-lg btn-outline-warning" href="../public/contacto.php">Contactanos</a></p> -->
                </div>
                </div>
            </div>
            <div class="carousel-item active">
            <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><image width="100%"   y="-8" href="../css/img/4.jpg" /></svg>

                <div class="container">
                <div class="carousel-caption text-start">
                    <h1 class="txtArchBl">Encuentro casual</h1>
                    <p  class="txtArchBl"><b>Toc Toc te banca</b></p>
                    <!-- <p><a class="btn btn-lg btn-primary" href="#">Learn more</a></p> -->
                </div>
                </div>
            </div>
            <div class="carousel-item">
                <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><image width="100%"  y="-10" href="../css/img/6.jpg" /></svg>

                <div class="container" >
                <div class="carousel-caption text-end" >
                    <h1 class="txtArchBl">Listos para todo tipo de encuentro</h1>
                    <p class="txtArchBl">Tenemos tus bebidas favoritas</p>
                    <!-- <p><a class="btn btn-lg btn-primary" href="#">Browse gallery</a></p> -->
                </div>
                </div>
            </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
        </div>
    
    <div class="row ms-1">
        <div class="col-md-3">
            <div class="card sticky-top mx-3">
                <div class="card-body">
                    <div id='filtros'>
                        <h2 class="textArch">Filtros</h2>
                        <div class="form-group">
                            <?php
                                $abmrubro = new AbmRubro();
                                foreach($abmrubro->buscar(array()) as $rubro){
                                    $desc = $rubro['runombre'];
                            ?>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input custom-control-input-warning" type="checkbox" value="<?php echo $rubro['idrubro'];?>" id="<?php echo $desc;?>" checked>
                                <label for="<?php echo $desc;?>" class="custom-control-label"><?php echo $desc;?></label>
                            </div>
                        <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row" id="filaProd">
                <!-- start prod card -->
                <?php
                    $abmprod = new AbmProducto();
                    foreach($abmprod->buscar(array()) as $producto){
                        if(!is_null($producto['prodeshabilitado']) && $producto['prodeshabilitado'] != '0000-00-00 00:00:00'){
                            continue;
                        }else{
                        $rutaimg="../../files/prods/";
                ?>
                <div class="col-md-4 <?=$producto['idrubro'];?>">
                    <div class="card">
                        <img class="card-img-top"  src="<?php echo $rutaimg.md5($producto['pronombre'].$producto['idproducto']).".jpg"  ?> ">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h2 class="card-title"><?php echo $producto['pronombre'];?></h2><br>
                                    <p class="descP"><?php echo $producto['prodetalle'];?></p>
                                    <p class="descP">Stock: <?php echo $producto['procantstock'];?></p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <h5>$<?php echo $producto['proprecio'];?></h5>
                                    <br>
                                    <div id="btns<?=$producto['idproducto'];?>">
                                        <?php
                                            if($producto['procantstock'] != 0){
                                                if(!in_array($producto['idproducto'], $carroEnCarga)){
                                        ?>
                                        <button type="submit" onclick="agregar(<?=$producto['idproducto'];?>)" class="btn btn-md btn-rounded btn-primary"><i class="fas fa-cart-plus"></i></button>
                                        <?php 
                                                }else{
                                        ?>
                                        <button type="button" class="btn btn-sm btn-rounded btn-success"><i class="fas fa-check"></i> En el carro</button>
                                        <?php
                                                }
                                            }else{
                                        ?>
                                        <button type="button" class="btn btn-sm btn-rounded btn-danger"><i class="fas fa-times"></i> Sin stock</button>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }} ?>
                <!-- end prod card -->
            </div>
        </div>
    </div>
</div>
<div hidden id='divEnCarro'>
<button type="button" class="btn btn-sm btn-rounded btn-success enCarro"><i class="fas fa-check"></i> En el carro</button>
</div>
<script>
    $(document).ready(function(){
        $('input[type=checkbox]').click(function(){
            var sqr = $(this);
            var idrubro = $(sqr).val();
            if($(sqr).is(':checked')){
                $('.'+idrubro).show();
            }else{
                $('.'+idrubro).hide();
            }
        });
    });

    function agregar(id){
        var data = {'idproducto' : id};
        $.ajax({
            method: 'POST',
            url: '../accion/cliente/accionProdSumar.php',
            data: data,
            type: 'json',
            success: function(){
                toastr.success('Producto agregado!');
                $('#btns'+data.idproducto).empty();
                $('#divEnCarro > .enCarro').clone().appendTo('#btns'+data.idproducto);
                $('#btns'+data.idproducto+' > .enCarro').attr('id', 'enCarro'+data.idproducto);
            }
        });
    };
    
</script>
<?php include_once("../estructura/footer.php"); ?>