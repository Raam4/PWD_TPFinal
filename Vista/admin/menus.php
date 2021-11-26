<?php
include_once("../../configuracion.php");
include_once("../../Utiles/sessmanager.php");
if(!$objSess->activa()){
    header('location:../public/login.php');
    exit();
}else if($objSess->getRolActivo()['idrol']!=1){
    header('location:../public/Index.php');
    exit();
}
include_once("../estructura/header.php");
?>

<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3>Gestión Item-Menu</h3>
        </div>
        <div class="card-body">
            <div id="salidaItm">
                <!-- Se genera la lista -->
            </div>
        </div>
    </div>
</div>

<script>
      $(document).ready(function() {
        $.ajax({
            method: 'post',
            url: '../accion/admin/accionListarItemM.php',
            success: function(data) {
                $('#salidaItm').html(data)
            },
            error: function(data) {
                console.log(data);
            }
        })
    });

    $(document).on("click", "#altaIt", function() {
        var currentRow = $(this).closest("tr");
        var nom = currentRow.find("td:eq(1)").html();
        var desc = currentRow.find("td:eq(2)").html();
        var idp = currentRow.find("td:eq(3)").html();

        if (nom == '' || desc == '' || idp == '') {
            if(nom == ''){
                currentRow.find("td:eq(1)").attr('style', 'border: 3px solid red');
            }
            if(desc == ''){
                currentRow.find("td:eq(2)").attr('style', 'border: 3px solid red');
            }
            if(idp == ''){
                currentRow.find("td:eq(3)").attr('style', 'border: 3px solid red');
            }
        }else{
            $.ajax({
                method: 'post',
                url: '../accion/admin/accionAltaItm.php',
                data: {
                    'menombre': nom,
                    'medescripcion': desc,
                    'idpadre':idp
                },
                type: 'json',
                success: function(data) {
                    $("#salidaItm").load('../accion/admin/accionListarItemM.php');
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    });

    function manage(id){
        $.ajax({
            method: 'post',
            url: '../accion/admin/accionManageItm.php',
            data: {'idmenu': id},
            type: 'json',
            success: function(data) {
                $("#salidaItm").load('../accion/admin/accionListarItemM.php');
                toastr.success('Estado modificado');
            },
            error: function(data) {
                console.log(data);
            }
        })
    }

    function cerrarDlg() {
        $('#dlgItm').hide();
    }

    $(document).on("click", ".editarItm", function() {
        var currentRow = $(this).closest("tr");
        var col0 = currentRow.find("td:eq(0)").html();
        // var butEdit = $(this).closest("button");

        currentRow.find("td:eq(1)").attr('contenteditable', true);
        currentRow.find("td:eq(2)").attr('contenteditable', true);
        currentRow.find("td:eq(3)").attr('contenteditable', true);
        currentRow.find("td:eq(1)").focus();

        controlButton(col0, 1);

        $(document).on("click", "#confirmIt" + col0, function() {
        // controlar no-accion si no se modifico nada
            var col1 = currentRow.find("td:eq(1)").html();
            var col2 = currentRow.find("td:eq(2)").html();
            var col3 = currentRow.find("td:eq(3)").html();
            if(col1 == '' || col2 == '' || col3 == ''){
                if(col1 == ''){
                    currentRow.find("td:eq(1)").attr('style', 'border: 3px solid red');
                }
                if(col2 == ''){
                    currentRow.find("td:eq(2)").attr('style', 'border: 3px solid red');
                }
                if(col3 == ''){
                    currentRow.find("td:eq(3)").attr('style', 'border: 3px solid red');
                }
            }else{
                currentRow.find("td:eq(1)").attr('contenteditable', false);
                currentRow.find("td:eq(2)").attr('contenteditable', false);
                currentRow.find("td:eq(3)").attr('contenteditable', false);

                var dataF = {
                    "idmenu": currentRow.find("td:eq(0)").html(),
                    "menombre": currentRow.find("td:eq(1)").html(),
                    "medescripcion": currentRow.find("td:eq(2)").html(),
                    "idpadre": currentRow.find("td:eq(3)").html()
                };

                if(editar(dataF)){
                    currentRow.find("td:eq(1)").removeAttr('style');
                    currentRow.find("td:eq(2)").removeAttr('style');
                    currentRow.find("td:eq(3)").removeAttr('style');
                }
            }
        })

    });

    function controlButton(id, accion) {
        if (accion == 1) {
            $('#editarIt'+id).hide();
            $('#borrarIt' + id).hide();
            $('#confirmIt' + id).show();
            $('#cancelIt' + id).show();
        } else {
            $("#salidaItm").load('../accion/admin/accionListarItemM.php');
        }
    }

    function editar(dataF) {
        $.ajax({
            method: 'post',
            url: '../accion/admin/accionEditarItm.php',
            data: dataF,
            type: 'json',
            success: function(data) {
                // alert("exito");
                $("#salidaItm").load('../accion/admin/accionListarItemM.php');
                //recargar menu 
            },
            error: function(data) {
                alert("error");
            }
        })
        console.log(dataF);
    }
</script>


<?php
include_once("../estructura/footer.php");
?>