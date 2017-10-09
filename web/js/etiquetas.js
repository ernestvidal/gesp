
$(document).ready(function () {


    /*
     * hacemos una delegación de evento para que las líneas de factura que creemos despues del evento domready,
     * dispongan del evento keyup, de ahí que el evento se dispara cuando se aprieta alguna tecla en cualquier
     * input donde el elemento padre tenga el id items o sumary.
     */

    $('form').delegate('input', 'keyup', function () {
//$(this).keyup(function(){

//var i = $(this); // $this > objeto dónde se produce el evento keyup
//var v = i.val(); // Valor del objeto $this

        var anchoEtiqueta = 0;
        var largoEtiqueta = 0;
        var anchoSoporte = 0;
        var largoSoporte = 0;
        var precioSoporte = 0;
        var metrosSoporte, costeSoporte, costeImpresion,costeTransporte, costeTotal, costeCorteMl;
        var numEtiquetas = [500,1000,2000,5000,10000];
        //var costeImpresion = [100,100,125,125,150];
        
        
        
        anchoEtiqueta = parseFloat($("#ancho_etiqueta").val());
        largoEtiqueta = parseFloat($("#largo_etiqueta").val());
        anchoSoporte = parseFloat($("#ancho_soporte").val());
        largoSoporte = parseFloat($("#largo_soporte").val());
        precioSoporte = parseFloat($("#precio_soporte").val());
        costeImpresion = parseFloat($('#coste_impresion').val());
        costeTransporte = parseFloat($('#coste_transporte').val());
        costeCorteMl = parseFloat($('#coste_corte').val());
        metrosSoporte = ((largoEtiqueta/1000)*(anchoEtiqueta/1000));//En metros cuadrados
        costeCorte = (((largoEtiqueta)/1000)*costeCorteMl);
        costeTotal = costeImpresion + (metrosSoporte*precioSoporte) + costeTransporte + costeCorte;
              

        
        $('#500costeUnidadImpresion').html(costeImpresion/500);
        $('#1000costeUnidadImpresion').html(costeImpresion/1000);
        $('#2000costeUnidadImpresion').html(costeImpresion/2000);
        $('#5000costeUnidadImpresion').html(costeImpresion/5000);
        $('#10000costeUnidadImpresion').html(costeImpresion/10000);
        
        $('#500costeUnidadSoporte').html((metrosSoporte*500*precioSoporte)/500);
        $('#1000costeUnidadSoporte').html((metrosSoporte*1000*precioSoporte)/1000);
        $('#2000costeUnidadSoporte').html((metrosSoporte*2000*precioSoporte)/2000);
        $('#5000costeUnidadSoporte').html((metrosSoporte*5000*precioSoporte)/5000);
        $('#10000costeUnidadSoporte').html((metrosSoporte*10000*precioSoporte)/10000);
        
        $('#500costeUnidadCorte').html((costeCorte).toFixed(4));
        $('#1000costeUnidadCorte').html((costeCorte).toFixed(4));
        $('#2000costeUnidadCorte').html((costeCorte).toFixed(4));
        $('#5000costeUnidadCorte').html((costeCorte).toFixed(4));
        $('#10000costeUnidadCorte').html((costeCorte).toFixed(4));
                
        $('#500coste').html(((costeImpresion/500)+(((metrosSoporte*500*precioSoporte)/500))+(costeTransporte/500)+(costeCorte/500)).toFixed(4));
        $('#1000coste').html(((costeImpresion/1000)+(((metrosSoporte*1000*precioSoporte)/1000))+(costeTransporte/1000)+(costeCorte/1000)).toFixed(4));
        $('#2000coste').html(((costeImpresion/2000)+(((metrosSoporte*2000*precioSoporte)/2000))+(costeTransporte/2000)+(costeCorte/2000)).toFixed(4));
        $('#5000coste').html(((costeImpresion/5000)+(((metrosSoporte*5000*precioSoporte)/5000))+(costeTransporte/5000)+(costeCorte/5000)).toFixed(4));
        $('#10000coste').html(((costeImpresion/10000)+(((metrosSoporte*10000*precioSoporte)/10000))+(costeTransporte/10000)+(costeCorte/10000)).toFixed(4));
        
        
     
    });
    
    // Cambiamos el tipo de cursos al pasar por el elemento #add_item_line
    $('#add_item_line').css('cursor', 'pointer');
    $('#item_cantidad_0').trigger('keyup');
});


