<?php
include_once("../../configuracion.php");
include_once("../../Utiles/sessmanager.php");
include_once("../estructura/header.php");
$carroEnCarga = $objSess->getCarrito();
?>
<div class="content-wrapper">
        <div id="myCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
            <div class="carousel-indicators">
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2" class="active" aria-current="true"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3" class=""></button>
            </div>
            <div class="carousel-inner">
            <div class="carousel-item">
                <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#777"></rect></svg>

                <div class="container">
                <div class="carousel-caption text-start">
                    <h1>Example headline.</h1>
                    <p>Some representative placeholder content for the first slide of the carousel.</p>
                    <p><a class="btn btn-lg btn-primary" href="#">Sign up today</a></p>
                </div>
                </div>
            </div>
            <div class="carousel-item active">
                <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#777"></rect></svg>

                <div class="container">
                <div class="carousel-caption">
                    <h1>Another example headline.</h1>
                    <p>Some representative placeholder content for the second slide of the carousel.</p>
                    <p><a class="btn btn-lg btn-primary" href="#">Learn more</a></p>
                </div>
                </div>
            </div>
            <div class="carousel-item">
                <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#777"></rect></svg>

                <div class="container">
                <div class="carousel-caption text-end">
                    <h1>One more for good measure.</h1>
                    <p>Some representative placeholder content for the third slide of this carousel.</p>
                    <p><a class="btn btn-lg btn-primary" href="#">Browse gallery</a></p>
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
            <div class="card sticky-top">
                <div class="card-body">
                    <div id='filtros'>
                        <h3>Filtros</h3>
                        <div class="form-group">
                            <?php
                                $abmrubro = new AbmRubro();
                                foreach($abmrubro->buscar(array()) as $rubro){
                                    $desc = $rubro['runombre'];
                            ?>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input custom-control-input-danger" type="checkbox" value="<?php echo $rubro['idrubro'];?>" id="<?php echo $desc;?>" checked>
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
                ?>
                <div class="col-md-4 <?=$producto['idrubro'];?>">
                    <div class="card">
                        <img class="card-img-top" src="https://media.discordapp.net/attachments/883712984902434836/908035385957965874/unknown.png?width=523&amp;height=418">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h2 class="card-title"><?php echo $producto['pronombre'];?></h2><br>
                                    <p><?php echo $producto['prodetalle'];?></p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <h1>$<?php echo $producto['proprecio'];?></h1>
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
                <?php } ?>
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
            url: '../accion/accionProdSumar.php',
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