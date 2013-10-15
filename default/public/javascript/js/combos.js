$(document).ready(function(){

$("#ira").hide();
    // COMBO TIPOS CONTRATOS CHANGE
    $("#articulo_descripcion").change(function(){
        mostrarBotonGarantiasOpcionales();

    }) 
    $("#pordescuento").change(function(){
		var subtotal = $ ( "#total" ).val();
		//var total = parseFloat(subtotal)+parseFloat(costo);
		var descuento = parseFloat(subtotal)* ($ ( "#pordescuento" ).val() * parseFloat(0.01));
		$ ( "#descuento" ).attr( "value" , descuento.toFixed(2));
		var totalpag = parseFloat(subtotal) - parseFloat(descuento);
		$ ( "#totalpagar" ).attr( "value" , totalpag.toFixed(2));		
	})
	


function cargarexamenrapido(){
    var form_data = {
        rapida: $("#rapida").val()
    }
    
    if  ( $("#rapida").val()!="" ){
        $.ajax({
            type:"POST",
            dataType: "html",
            url: "ingreso/cargarapidajax",
            data: form_data,
            success:function(msg){
                $("#garantias_opcionales").html(msg);
				
            }
        })
    }
}




function cargarcliente(){
    var form_data = {
        cedula: $("#articulo_descripcion").val()
    }
    if  ( $("#articulo_descripcion").val()!="" ){
        $.ajax({
            type:"POST",
            dataType: "html",
            url: "articulo/autocomplete",
            data: form_data,
            success:function(msg){
                $("#clientes_registrados").html(msg);
				
            }
        })
		
    }
        }
        
        function mostrarBotonGarantiasOpcionales(){


        $( "#ira" ).show();
   
}

$('#ira').click(function(){
    var form_data = {
        articulo: $("#articulo_descripcion").val()
    }
            $.ajax({
            type:"POST",
            dataType: "html",
            url: "http://localhost/almacen/default/articulos/buscar/",
            data: form_data,
            success:function(msg){
                $("#articulo_descripcion").html(msg);
				
            }
        })
})
})