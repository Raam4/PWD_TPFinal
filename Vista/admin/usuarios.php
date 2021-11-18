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
            <h3>Usuarios</h3>
        </div>
        <div class="card-body">
            <div id="salida">
                <!-- Se genera la lista -->
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $.ajax({
            method: 'post',
            url: '../accion/admin/accionListarUsuarios.php',
            success: function(data) {
                $('#salida').html(data)
            },
            error: function(data) {
                console.log(data);
            }
        })
    });

    $(document).on("click", "#altaUs", function() {
        var currentRow = $(this).closest("tr");
        var nom = currentRow.find("td:eq(1)").html();
        var mail = currentRow.find("td:eq(2)").html();

        if (nom != '' && mail != '') {
            $.ajax({
                method: 'post',
                url: '../accion/admin/accionAltaUs.php',
                data: {
                    'usnombre': nom,
                    'usmail': mail
                },
                type: 'json',
                success: function(data) {
                    $("#salida").load('../accion/admin/accionListarUsuarios.php');
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    });

    $(document).on("click", ".borrarUs", function() {
        if (confirm('Seguro que desea borrar el registro')) {
            var id = $(this).data("id");
            $.ajax({
                method: 'post',
                url: '../accion/admin/accionBorrarUs.php',
                data: {
                    'idusuario': id,
                },
                type: 'json',
                success: function(data) {
                    $("#salida").load('../accion/admin/accionListarUsuarios.php');
                },
                error: function(data) {
                    console.log(data);
                }
            })
        }
    });

    
    $(document).on("click", ".editarUs", function() {
        var currentRow = $(this).closest("tr");
        var col1 = currentRow.find("td:eq(0)").html();
        // var butEdit = $(this).closest("button");

        currentRow.find("td:eq(1)").attr('contenteditable', true);
        currentRow.find("td:eq(2)").attr('contenteditable', true);
        currentRow.find("td:eq(1)").focus();

        controlButton(col1, 1);

        $(document).on("click", "#confirm" + col1, function() {
        // controlar no-accion si no se modifico nada
            currentRow.find("td:eq(1)").attr('contenteditable', false);
            currentRow.find("td:eq(2)").attr('contenteditable', false);

            var dataF = {
                "idusuario": currentRow.find("td:eq(0)").html(),
                "usnombre": currentRow.find("td:eq(1)").html(),
                "usmail": currentRow.find("td:eq(2)").html()
            };
            controlButton(col1, 0);
            editar(dataF);
        })

    });
    function controlButton(id, accion) {
        if (accion == 1) {
            $('#editarUs'+id).hide();
            $('#borrarUs' + id).hide();
            $('#gestion' + id).hide();
            $('#confirm' + id).show();
            $('#cancel' + id).show();
        } else {
            // $('td').attr('contenteditable', false);
            $('#editarUs'+id).show();
            $('#borrarUs' + id).show();
            $('#gestion' + id).show();
            $('#confirm' + id).hide();
            $('#cancel' + id).hide();
        }
    }

    function editar(dataF) {
        $.ajax({
            method: 'post',
            url: '../accion/admin/accionEditarUs.php',
            data: dataF,
            type: 'json',
            success: function(data) {
                // alert("exito");
                $("#salida").load('../accion/admin/accionListarUsuarios.php');
            },
            error: function(data) {
                alert("error");
            }
        })
        console.log(dataF);
    }
    // $(document).on("click", "#editarUs", function() {
    //     var currentRow = $(this).closest("tr");
    //     var col1 = currentRow.find("td:eq(0)").html();
    //     var col2 = currentRow.find("td:eq(1)").html();
    //     var col3 = currentRow.find("td:eq(2)").html();

    //     $('#us_nombre').attr("value", col2);
    //     $('#us_email').attr("value", col3);
    //     $('#dlg').show();

    //     $('form#fm').submit(function(event) {
    //         event.preventDefault();
    //         var $f = $(this);
    //         if ($f.data('locked') == undefined && !$f.data('locked')) {
    //             //recuperar datos actualizados
    //             var nom = $('#us_nombre').val();
    //             var mail = $('#us_email').val();
    //             var dataF = {
    //                 "idusuario": col1,
    //                 "usnombre": nom,
    //                 "usmail": mail
    //             };
    //             $.ajax({
    //                 method: 'post',
    //                 url: '../accion/usuario/editarUs.php',
    //                 data: dataF,
    //                 type: 'json',
    //                 beforeSend: function() {
    //                     $f.data('locked', true);
    //                 },
    //                 success: function(data) {
    //                     $("#salida").load('../accion/usuario/listar.php');
    //                 },
    //                 error: function(data) {},
    //                 complete: function() {
    //                     $f.data('locked', false);
    //                     $f.off().submit();
    //                 }

    //             });
    //         }
    //         $("#dlg").on("click", "#cancelarUs", function() {
    //             cerrarDlg();
    //         });
    //     });
    // });

    $(document).on("click", "#habilUs", function() {
        var id = $(this).data("id");
        $.ajax({
            method: 'post',
            url: '../accion/admin/accionHabilitarUs.php',
            data: {
                'idusuario': id,
            },
            type: 'json',
            success: function(data) {
                $("#salida").load('../accion/admin/accionListarUsuarios.php');
            },
            error: function(data) {
                alert("error");
            }
        })
    });

    function cerrarDlg() {
        // event.preventDefault();
        // $("#fm")[0].reset();
        $(dlg).hide();
    }
</script>
<?php include_once('../estructura/footer.php'); ?>