<?php
include_once("../../configuracion.php");
include_once("../../Utiles/sessmanager.php");
if(!$objSess->activa()){
    header('location:../public/login.php');
    exit();
}else if($objSess->getRolActivo()['idrol']!=2){
    header('location:../public/Index.php');
    exit();
}
include_once("../estructura/header.php");
$abmprod = new AbmProducto();
$abmrubro = new AbmRubro();
$rubros = $abmrubro->buscar(array());
?>
<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3>Productos</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th style="width: 5%">
                            ID
                        </th>
                        <th style="width: 20%">
                            Nombre
                        </th>
                        <th style="width: 10%">
                            Cantidad de productos
                        </th>
                        <th style="width: 15%">
                            Editar
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <td colspan=4>
                        <button type="button" class="btn btn-success btn-md" onclick="$('#modal').modal('show')"><i class="fas fa-plus" title='Alta Producto'></i> Alta</button>
                    </td>
                    <?php
                    foreach($rubros as $rub){
                        $id = $rub['idrubro'];
                        $prods = $abmprod->buscar(['idrubro' => $id]);
                    ?>
                    <tr>
                        <td>
                            <?php echo $id; ?>
                        </td>
                        <td>
                            <?php echo $rub['runombre']; ?>
                        </td>
                        <td>
                            <?php echo count($prods); ?>
                        </td>
                        <td>
                            <button id="editar" class="btn btn-primary btn-sm editarRub" type="button" title='Editar'>
                                <i class="fas fa-pen"></i> </button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
$(document).on("click", ".editarRub", function() {
    var currentRow = $(this).closest("tr");
    var col0 = currentRow.find("td:eq(0)").html();
    currentRow.find("td:eq(1)").attr('contenteditable', true);
    currentRow.find("td:eq(1)").focus();
    controlButton(col0, 1);
    $(document).on("click", "#confirm" + col0, function() {
        var col1 = currentRow.find("td:eq(1)").html();
        if(col1 == ''){
            if(col1 == ''){
                currentRow.find("td:eq(1)").attr('style', 'border: 3px solid red');
            }
        }else{
            currentRow.find("td:eq(1)").attr('contenteditable', false);
            var dataF = {
                "idrubro": currentRow.find("td:eq(0)").html(),
                "runombre": currentRow.find("td:eq(1)").html(),
            };
            if(editar(dataF)){
                currentRow.find("td:eq(1)").removeAttr('style');
                currentRow.find("td:eq(2)").removeAttr('style');
                currentRow.find("td:eq(3)").removeAttr('style');
            }
        }
    });
});
</script>