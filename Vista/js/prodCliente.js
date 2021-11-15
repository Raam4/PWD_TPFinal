$('#filtros').ready(function(){
    $('input[type=checkbox]').each(function(){
        if($(this).is(':checked')){
            var self = $(this);
            var select = '#rub'+self.val();
            $.ajax({
                method: 'POST',
                url: '../accion/accionProducto.php',
                data: {'idrubro' : self.val()},
                type: 'json',
                success: function(ret) {
                    $('#filaProd').append(JSON.parse(ret));
                },
                error: function (ret) {
                }
            });
        };
    });
    $('input[type=checkbox]').on('change', function() {
        var self = $(this);
        var select = '#rub'+self.val();
        if(!self.is(':checked')){
            $(select).each(function(){
                $(this).remove();
            });
        }else{
            $.ajax({
                method: 'POST',
                url: '../accion/accionProducto.php',
                data: {'idrubro' : self.val()},
                type: 'json',
                success: function(ret) {
                    $('#filaProd').append(JSON.parse(ret));
                },
                error: function (ret) {
                }
            });
        }
    });
});

$(document).ready(function(){
    $('form.agrega').on('submit', function(){
        var elem = $(this);
        $.ajax({
            method: 'POST',
            url: '../accion/accionProdSumar.php',
            data: elem.serialize(),
            type: 'json',
            success: function(){
                toastr.success('Producto agregado!');
            }
        });
        return false;
    });
});