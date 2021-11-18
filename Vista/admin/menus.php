<?php
include_once("../../configuracion.php");
include_once("../../Utiles/sessmanager.php");
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
        //modificar uso de input
        // var nom = $('#itnom_td').val();
        // var desc = $('#itdescripcion_td').val();
        // var idp = $('#itidpadre_td').val();
        var currentRow = $(this).closest("tr");
        var nom = currentRow.find("td:eq(1)").html();
        var desc = currentRow.find("td:eq(2)").html();
        var idp = currentRow.find("td:eq(3)").html();

        if (nom != '' && desc != '' && idp != '') {
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

    $(document).on("click", ".borrarItm", function() {
        if (confirm('Seguro que desea borrar el registro')) {
            var id = $(this).data("id");
            $.ajax({
                method: 'post',
                url: '../accion/admin/accionBorrarItm.php',
                data: {
                    'idmenu': id,
                },
                type: 'json',
                success: function(data) {
                    $("#salidaItm").load('../accion/admin/accionListarItemM.php');
                },
                error: function(data) {
                  console.log(data);
                }
            })
        }
    });

    $(document).on("click", "#habilIt", function() {
        var id = $(this).data("id");
        $.ajax({
            method: 'post',
            url: '../accion/admin/accionHabilitarItm.php',
            data: {
                'idmenu': id,
            },
            type: 'json',
            success: function(data) {
                $("#salidaItm").load('../accion/admin/accionListarItemM.php');
            },
            error: function(data) {
                alert("error");
            }
        })
    });

    function cerrarDlg() {
        $('#dlgItm').hide();
    }

    $(document).on("click", ".editarItm", function() {
        var currentRow = $(this).closest("tr");
        var col1 = currentRow.find("td:eq(0)").html();
        // var butEdit = $(this).closest("button");

        currentRow.find("td:eq(1)").attr('contenteditable', true);
        currentRow.find("td:eq(2)").attr('contenteditable', true);
        currentRow.find("td:eq(3)").attr('contenteditable', true);
        currentRow.find("td:eq(1)").focus();

        controlButton(col1, 1);

        $(document).on("click", "#confirmIt" + col1, function() {
        // controlar no-accion si no se modifico nada
            currentRow.find("td:eq(1)").attr('contenteditable', false);
            currentRow.find("td:eq(2)").attr('contenteditable', false);
            currentRow.find("td:eq(3)").attr('contenteditable', false);

            var dataF = {
                "idmenu": currentRow.find("td:eq(0)").html(),
                "menombre": currentRow.find("td:eq(1)").html(),
                "medescripcion": currentRow.find("td:eq(2)").html(),
                "idpadre": currentRow.find("td:eq(3)").html()
            };
            controlButton(col1, 0);
            editar(dataF);
        })

    });

    function controlButton(id, accion) {
        if (accion == 1) {
            $('#editarIt'+id).hide();
            $('#borrarIt' + id).hide();
            $('#confirmIt' + id).show();
            $('#cancelIt' + id).show();
        } else {
            $('#editarIt'+id).show();
            $('#borrarIt' + id).show();
            $('#confirmIt' + id).hide();
            $('#cancelIt' + id).hide();
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