
function limpiar(item){//borramos el contenido de los campos. No borramos el <tr> para no desencajar el diseño.
  if (confirm('Borrar línea ?')) {
	var id = 'tr'+item;
	var cantidad = '0';
	var precio = '00.00';
    $(id).getElements('.quantity input').set('value', cantidad);
    $(id).getElements('.price input').set('value', precio);
  }else{
  return false;
  }
}


function borrar(item){

  if (confirm('Borrar línea ?')) {
	var id = ('#line_'+item);
        $(id).remove();
  	$('input').trigger('keyup'); //disparamos el evento para que recalcule la presupuesto.
  }else{
  return false;
  }
}


 $(document).ready(function(){

     $(function(){
    //get the click of sendPresupuestoButton on presupuesto/index and show modal
    $('.sendPresupuestoButton').click(function(){
        $('#modalSendPresupuesto').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
});

    /*
    * hacemos una delegación de evento para que las líneas de presupuesto que creemos despues del evento domready,
    * dispongan del evento keyup, de ahí que el evento se dispara cuando se aprieta alguna tecla en cualquier
    * input donde el elemento padre tenga el id items o sumary.
    */

    $('form').delegate('input', 'keyup', function(){
        //$(this).keyup(function(){

            //var i = $(this); // $this > objeto dónde se produce el evento keyup
            //var v = i.val(); // Valor del objeto $this

            var base_imponible = 0;
            var subtotal = 0;
            var fila = $('#item_line .presupuesto_line');
                fila.each(function(i, el) {

                    var cantidad = parseFloat($("#item_cantidad_" + i).val());
                    var precio = parseFloat($("#item_precio_" + i).val());
                    var total_linea = cantidad * precio;
                    var presupuesto_num = $('#presupuesto_num').val();
                    $("#item_total_" + i).val(total_linea.toFixed(2));
                    //$('#item_cantidad_' + i).val(cantidad);
                    //$('#item_precio_' + i).val(precio);
                    $('#presupuesto_item_num_' + i).val(presupuesto_num);

                    base_imponible += parseFloat($("#item_total_" + i).val());
                    $('#presupuesto_base_imponible').val(base_imponible.toFixed(2));

                    $('#presupuesto_importe_descuento').val(((parseFloat($('#presupuesto_base_imponible').val()) * (parseFloat($('#presupuesto_rate_descuento').val()) / 100)) * -1).toFixed(2) );
                    $('#presupuesto_importe_iva').val((parseFloat($('#presupuesto_base_imponible').val()) * (parseFloat($('#presupuesto_rate_iva').val()) / 100)).toFixed(2));
                    $('#presupuesto_importe_irpf').val(((parseFloat($('#presupuesto_base_imponible').val()) * (parseFloat($('#presupuesto_rate_irpf').val()) / 100)) * -1).toFixed(2));
                    $('#presupuesto_total').val((parseFloat($('#presupuesto_base_imponible').val()) + parseFloat($('#presupuesto_importe_descuento').val()) + parseFloat($('#presupuesto_importe_iva').val()) +
                            parseFloat($('#presupuesto_importe_irpf').val())).toFixed(2));

            });
        //});
    });


    $('#print').click(function() {
      window.print();
      return false;
    });



    // Cambiamos el tipo de cursos al pasar por el elemento #add_item_line
    $('#add_item_line').css('cursor','pointer');

    // Insertamos una nueva línea en la presupuesto.
    $('#add_item_line').click(function(){
        var item_order = $('#item_line').find('textarea').length;

        var new_line_div = $('<div/>', {
            'id' : 'line_' + item_order,
            'class' : 'row presupuesto_line',
        });

        var new_div_item_cantidad =  $('<div/>', {
            'class' : 'col-md-2',
        });

        var new_input_cantidad = $('<input>', {
            'type'  : 'text',
            'id'    : 'item_cantidad_' + item_order,
            'name'  : 'PresupuestoItem[' + item_order + '][item_cantidad]',
            'class' : 'form-control text-right',
            'value' : '0.00'
        });

        var new_div_col_5 = $('<div/>', {
            'class' : 'col-md-5',
        });

        var new_textarea = $('<textarea>', {
            'id' : 'item_descripcion_' + item_order,
            'name' : 'PresupuestoItem[' + item_order + '][item_descripcion]',
            'class' : 'form-control',
        });

        var new_div_item_precio =  $('<div/>', {
            'class' : 'col-md-2',
        });

        var new_input_precio = $('<input>', {
            'type'  : 'text',
            'id'    : 'item_precio_' + item_order,
            'name'  : 'PresupuestoItem[' + item_order + '][item_precio]',
            'class' : 'form-control text-right',
            'value' : '0.00'
        });

        var new_div_item_total =  $('<div/>', {
            'class' : 'col-md-2',
        });

        var new_input_total = $('<input>', {
            'type'  : 'text',
            'id'    : 'item_total_' + item_order,
            'name'    : 'item_total_' + item_order,
            'class' : 'form-control text-right',
            'value' : '0.00'
        });

        var new_div_presupuesto_item_num =  $('<div/>', {
            'class' : 'col-md-1',
        });

         var new_input_presupuesto_item_num = $('<input>', {
            'type'  : 'hidden',
            'id'    : 'presupuesto_item_num_' + item_order,
            'name'  : 'PresupuestoItem[' + item_order + '][presupuesto_num]',
        });

        var new_div_delete_line = $('<div/>', {
            'class' : 'col-md-1',
        });

        var new_delete_line = $('<a/>', {
            //'id' : 'delete_item_line_' + item_order,
            href : 'javascript:borrar(' + item_order + ')',
            html : '[ x ]',
        });


        $('#item_line').append(new_line_div);
        $(new_line_div).append(new_div_item_cantidad);
        $(new_div_item_cantidad).append(new_input_cantidad);
        $(new_line_div).append(new_div_col_5);
        $(new_div_col_5).append(new_textarea);
        $(new_line_div).append(new_div_item_precio);
        $(new_div_item_precio).append(new_input_precio);
        $(new_line_div).append(new_div_item_total);
        $(new_div_item_total).append(new_input_total);
        $(new_input_total).append( new_div_presupuesto_item_num);
        $(new_div_presupuesto_item_num).append(new_input_presupuesto_item_num);
        $(new_line_div).append(new_div_delete_line);
        $(new_div_delete_line).append(new_delete_line);

    });
    
    $('#item_cantidad_0').trigger('keyup');

});
