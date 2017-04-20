$(document).ready(function() {
	/*************** Tooltips ***************/
	var tooltips = $("[title]").tooltip( {
			position: {
				my: "center bottom-20",
				at: "center top",
				using: function( position, feedback ) {
					$( this ).css( position );
					$( "<div>" )
					.addClass( "arrow" )
					.addClass( feedback.vertical )
					.addClass( feedback.horizontal )
					.appendTo( this );
				}
			}
		}
	);

    /******* Español para validaciones *******/
    var esErrorDialogs = {
        errorTitle : 'El envío del formulario ha fallado',
        requiredFields : 'No has llenado un campo obligatorio',
        badTime : 'No has indicado una hora valida',
        badEmail : 'No has indicado un correo electrónico válido',
        badTelephone : 'No has indicado un número de teléfono válido',
        badSecurityAnswer : 'No has respondido correctamente la pregunta de seguridad',
        badDate : 'No has indicado una fecha valida',
        lengthBadStart : 'El campo debe tener entre ',
        lengthBadEnd : ' caracteres',
        lengthTooLongStart : 'Tu respuesta debe ser más larga que ',
        lengthTooShortStart : 'Tu respuesta debe ser más corta que ',
        notConfirmed : 'Los valores no coinciden',
        badDomain : 'Dominio incorrecto',
        badUrl : 'No has indicado una URL válida',
        badCustomVal : 'Valor incorrecto',
        badInt : 'No has indicado un número válido',
        badSecurityNumber : 'Número de seguridad incorrecto',
        badUKVatAnswer : 'Número UK VAT incorrecto',
        badStrength : 'La contraseña no es lo suficientemente segura',
        badNumberOfSelectedOptionsStart : 'Selecciona al menos ',
        badNumberOfSelectedOptionsEnd : ' respuestas',
        badAlphaNumeric : 'El campo debe contener caracteres alfanumericos únicamente ',
        badAlphaNumericExtra: ' y ',
        wrongFileSize : 'El archivo que intentas subir es demasiado grande',
        wrongFileType : 'El archivo que intentas subir no es del tipo correcto',
        groupCheckedTooFewStart : 'Por favor selecciona al menos ',
        groupCheckedTooManyStart : 'Por favor selecciona un máximo de ', 
        groupCheckedRangeStart : 'Por favor seleccionar entre ',
        groupCheckedEnd : ' elemento(s)'
    };

    /************ Validaciones ************/
    $.validate({
        language : esErrorDialogs,
        decimalSeparator : '.',
        modules : 'date, security',
        onModulesLoaded : function() {
            var optionalConfig = {
                fontSize: '12pt',
                padding: '4px',
                bad : 'Muy débil',
                weak : 'Débil',
                good : 'Buena',
                strong : 'Fuerte'
            };
            $('input[name="contrasenia_confirmation"]').displayPasswordStrength(optionalConfig);
        }
    });

    /******** Selector de fecha de nacimiento ********/
    $(function() {
        $( "#fecha_nacimiento" ).datepicker({ minDate: "-120Y", maxDate: 1 });
        $( "#fecha_nacimiento" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
    });

    /************ Acordeon de ayudas ************/
    $(function() {
        $( "#mostrarayudas" ).accordion({
            active: false,
            heightStyle: "content",
            collapsible: true
        });
    });

    /************** Busqueda *************/
    var consulta;
    //hacemos focus al campo de búsqueda
    $("#busqueda").focus();
    //comprobamos si se pulsa una tecla
    $("#busqueda").keyup(function(e){
        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#busqueda").val();
        //hace la búsqueda
        $.ajax({
            type: "POST",
            url: "elementos/buscar.php",
            data: "b="+consulta,
            dataType: "html",
            beforeSend: function(){
                //imagen de carga
                $("#resultado").html("<p align='center'><img src='cargando.gif' /></p>");
            },
            error: function(){
                alert("error petición ajax");
            },
            success: function(data){                                                   
                $("#resultado").empty();
                $("#resultado").append(data);
            }
        });
    });
    $("#busquedacriterio").keyup(function(e){
        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#busquedacriterio").val();
        //hace la búsqueda
        $.ajax({
            type: "POST",
            url: "elementos/buscar.php",
            data: "bc="+consulta,
            dataType: "html",
            beforeSend: function(){
                //imagen de carga
                $("#resultado").html("<p align='center'><img src='cargando.gif' /></p>");
            },
            error: function(){
                alert("error petición ajax");
            },
            success: function(data){                                                   
                $("#resultado").empty();
                $("#resultado").append(data);
            }
        });
    });
});
// Subir imagen
function popUp(URL) {
      day = new Date();
      id = day.getTime();
      eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=1,statusbar=1,menubar=0,resizable=0,width=500,height=500,left = 710,top = 290');");
}
// Imagen de carga de página
window.onload = detectarCarga;
function detectarCarga(){
    document.getElementById("carga").style.display="none";
}