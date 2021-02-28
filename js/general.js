/**
 * General
 *
 * Script personalizado de uso general y global en la aplicación.
 *
 * @author  Alex Barrios <alex@alexertech.com>
 * @version 27.11.2008 16:58:46
 * @package js
 */

// global
cuenta = 0;

// Para las notificaciones
function create( template, vars, opts ){
    $container = $("#notify").notify({ stack:'above' });
    return $container.notify("create", template, vars, opts);
}


// updateView() ~ Carga datos o direcciones

var prevHref = '';
var prevAux  = 0;

function updateView(urlHref, form) {

    var loader  = '<div id="loader" style=\"margin-left:25px;margin-top:25px;float:left\"><img src="images/ajax-loader.gif"></div>';

    form        = typeof(form) != 'undefined' ? form : '';

    var tipo    = 'get';
    var datos   = '';
    var dataVal = '';

    if (form != '' ) {
        $('#'+form+' :input').each(
            function() {
                value   = encodeURI(this.value);
                dataVal = this.name+'='+value+'&';
                datos   = datos + dataVal;
            }
        );
        tipo = form == 'buscador' ? 'get' : 'post';
    } else {
        var str = urlHref.split('?');
        urlHref = str[0];
        datos   = str[1];
    }

    $.ajax({
        type       : tipo,
        url        : urlHref,
        data       : datos,
        dataType   : 'html',
        cache      : false,
        beforeSend : function () {
            $("#loader").remove();
            $("#top").append(loader);
        },
        success    : function (html) {

            if ($("#loader").fadeOut('slow'))
                $("#loader").remove();

            $("#principal").html(html);

            $(".borde").addClass('ui-corner-all');
            $("input").addClass('ui-corner-all');
            $("select").addClass('ui-corner-all');
            $("textarea").addClass('ui-corner-all');
            $(".borde td:first").addClass('ui-corner-top');
            $(".borde td:last").addClass('ui-corner-bottom');

        }
    });
}


// validar() ~ Es un validador general de todos los formularios.
function validar(fx) {

    // Expresión regular para la validación de campos de correo
    email_str=/^[^@\s]+@[^@\.\s]+(\.[^@\.\s]+)+$/;
    ok = 0;

    // Revisión de todos los campos
    for (i = 0; i < fx.elements.length; i++) {

        // Que tipo de elemento recibirá la validacion
        if ((fx.elements[i].type == 'text' ||
             fx.elements[i].type == 'password' ||
             fx.elements[i].type == 'textarea') &&
             (fx.elements[i].type != 'hidden' &&
              fx.elements[i].type != 'file')){

            // De acuerdo al nombre, cuales elementos no serán validados
            // Si el nombre del campo finaliza en "_omit" el campo no es validado
            if((fx.elements[i].name.substr(-5))!='_omit'){

                // Reglas a validar en los campos
                if (fx.elements[i].value.length == 0  ||
                    fx.elements[i].value == 'null' ||
                    fx.elements[i].value.indexOf("\\", 0) > -1){

                    fx.elements[i].style.background="#FFEEF0";


                    // Si los elementos no son de tipo 'hidden' colocará
                    // el foco en el elemento que no cumple la validación
                    if(fx.elements[i].type != 'hidden' && ok == 0)
                        fx.elements[i].focus();

                    ok = 1;

                } else {

                    fx.elements[i].style.background="#FFFFFF";

                }

            }
        }

        // Verificar el correo con una expresión regular
        if ((fx.elements[i].name == 'email' || fx.elements[i].name == 'email_omit') && fx.elements[i].value.length > 0) {
            if (!email_str.test(fx.elements[i].value)) {

                create("sticky", { title:'El formato del campo E-mail no es válido', text:'Ejemplo: usuario@dominio.com'});
                return false;
                break;

            }
        }

        // Verificar campos fecha
        if (fx.elements[i].type == 'hidden') {
            var idFecha = fx.elements[i].id;
            var fecha   = idFecha.substr(0,7);

            if (fecha == 'f_fecha' && fx.elements[i].value == '') {

                create("sticky", { title:'Completa todos los campos del formulario', text:'Verifica las fechas'});

                return false;
                break;
            }
        }

        // Verificar que las listas de selección no estén en su valor
        // predeterminado
        if (fx.elements[i].value=='_defa_') {

            create("sticky", { title:'Completa todos los campos del formulario', text:'Verifica las listas dependientes'});

            return false;
            break;
        }

        // Validaciones relacionadas con AJAX
        if (document.getElementById('cK')) {

            create("sticky", { title:'No puedes utilizar ese valor en el campo'});

            return false;
            break;

        }

    }

    if (ok == 1) {
        create("sticky", { title:'Verifica el formulario', text:'Se ha sombreado en rosa los campos obligatorios. Por favor completalos para enviar.'});
        return false;
    }

    // Evita que el usuario envíe 2 veces el formulario
    /*if (cuenta == 0) {
        cuenta++;
        return true;
    }else{
        //alert('Por favor espera la respuesta de tu peticion!');
        return false;
    }*/

}


// formatoCampo() ~ permite definir que caracteres puede introducir
// un usuario en un campo. Para utilizarlo:
// onKeyPress="return(formatoCampo(this,event,1))"

function formatoCampo(fld,e,t) {

    // Variables
    var aux = aux2 = '';
    var i = j = 0;
    var strCheck = null;

    // solo numeros
    if (t==1)
        var strCheck = '0123456789';

    // solo letras
    if (t==2)
        var strCheck = 'AaBbCcDdEeFfGgHhIiJjKkLlÑñNnMmOoPpQqRrSsTtUuVvWwXxYyZzáÁéÉíÍóÓúÚ ';

    // telefonos
    if (t==3)
        var strCheck = '0123456789-ext';

    // moneda & numerico con decimales
    if (t==4)
        var strCheck = '0123456789,.';

    // Dimensiones (800x600)
    if (t==5)
        var strCheck = '0123456789x';

    // Obtiene el codigo de la letra precionada
    var code = '';
    if (e.keyCode) code = e.keyCode;
    else if (e.which) code = e.which;
    var whichCode = code;

    // Comienza la comprobación
    if (whichCode == 13 || whichCode == 8)
        return true; // Permitir Tecla Enter

    if (t==4 && (whichCode == 44 || whichCode == 46))
        return true; // Permitir Comas y puntos

    if (whichCode == 9)
        return true; // Permitir Tabulador

    // Consigue el valor del codigo de tecla
    key = String.fromCharCode(whichCode);

    // Verifica el caracter con los seleccionados en strCheck
    if (strCheck.indexOf(key) == -1)
        return false;

    // Retorna el caracter al campo
    fld.value += aux2.charAt(i);
}


// ventanaPopUp() ~ generador de ventanas emergentes
// La sintaxis sería similar a la siguiente:
// <a href="javascript:ventanaPopUp('pagina.html',
//                                  'nombreVentana',
//                                  '600px','400px','yes');">Texto Enlace</a>

function ventanaPopUp (pagina,nom_ventana,ancho,alto,scroll_b){
    var opciones=("toolbar=no, "+
                  "location=no, "+
                  "directories=no, "+
                  "status=no, "+
                  "menubar=yes, "+
                  "scrollbars="+scroll_b+","+
                  "resizable=no,"+
                  "width="+ancho+","+
                  "height="+alto+"");
    var w=window.open(pagina,nom_ventana,opciones);
}



// pregunta() ~ es utilizada en los links para eliminar para solicitar
// confirmación al usuario

function pregunta() {

    if ( confirm('¿Estás seguro de eliminar el registro?') )
        return true;
    else
        return false;

}

// pregunta() ~ protege la clave del usuario transformando el string en
// sha1 antes de enviarlo por la red

function preparaClave(token) {

    var token  = typeof(token) != 'undefined' ? token : '';

    var clv    = $('#clv').val();

    if (clv.length > 0) {

        var shpass = Sha1.hash(clv);

        $('#clv').val(shpass);

    }

}


// validarCampo() ~ Permite validar si un valor introducido existe o no
// en la base de datos. Para validar un campo con esta funcion:
//   <input type="text" name="nombre" id="id_n"
//          onblur="javascript:validarCampo(11|12,'id_n','nombre_campo','tabla_validar','ajax_respuesta')">
//   <span id="ajax_respuesta"></span>

// NOTA: Esta función depende de jQuery.

// NOTA: Donde se muestra 11|12 en el los parámetros de la función se refiere
// a que el valor puede ser 11 para validar si no existe y 12 para validar
// si existe.

function validarCampo(acc,campo,db_campo,db_tabla,respuesta) {

    var valor     = $('#'+campo).val();

    var bloqueo   = '<input type="hidden" id="cKk" value="0">';
    var imagen    = '<img src="images/preload.gif">';
    var pendiente = bloqueo+imagen;
    var datos     = 'acc='+acc+'&valor='+valor+'&db_campo='+db_campo+
                    '&db_tabla='+db_tabla;

    $.ajax({
        type       : 'GET',
        data       : datos,
        url        : 'lib/common/Ajax.php',
        dataType   : 'html',
        cache      : false,
        beforeSend : function () {
            $("#"+respuesta).empty();
            $("#"+respuesta).append(bloqueo);
        },
        success: function (html) {
            $("#"+respuesta).empty();
            $("#"+respuesta).append(html);
        }
    });

}


// comprobar() ~ cpass.php : comprobar si las contraseñas son correctas

function comprobar(){

    if ( $('#id1').val() != $('#id2').val() ) {
        $('#id1').focus();
        create("sticky", { title:'Las contraseñas introducidas no coinciden'});
        return false;
    }else
        return true;

}


// creaMenu() ~ genera el menú de la interfaz

function creaMenu() {
    $.ajax({
        type       : 'GET',
        url        : 'parts/menu.php',
        dataType   : 'html',
        cache      : false,
        success: function (html) {
            $("#menu").empty();
            $("#menu").append(html);
        }
    });
}


// selectorFecha() ~ crea un calendario

function selectorFecha(id,sel) {

    $(document).ready(function() {

        sel = typeof(sel) != 'undefined' ? sel : '';

        $('#'+id).css({'border':'none','background-color':'#E5E5E5','float':'left'});

        $('#'+id).datepicker(
            {
                showOn          : 'button',
                buttonImage     : 'images/iconos/calendar.png',
                dateFormat      : 'dd-mm-yy',
                buttonImageOnly : true
            },
        $.datepicker.regional['es']);

    });

}

/*
 *
 * Definición de Funciones especiales de JQuery para apoyar la interfaz
 *
 * */

// Precarga de Imágenes
(function($) {
    var cache = [];
    $.preLoadImages = function() {
        var args_len = arguments.length;
        for (var i = args_len; i--;) {
            var cacheImage = document.createElement('img');
            cacheImage.src = arguments[i];
            cache.push(cacheImage);
        }
    }
})(jQuery)
jQuery.preLoadImages('images/aula.png','images/aula_ov.png','images/videos.png','images/videos_ov.png','images/descargas.png','images/descargas_ov.png');

// Generador de claves
$.extend({
  password: function (length, special) {
    var iteration = 0;
    var password = "";
    var randomNumber;
    if(special == undefined){
        var special = false;
    }
    while(iteration < length){
        randomNumber = (Math.floor((Math.random() * 100)) % 94) + 33;
        if(!special){
            if ((randomNumber >=33) && (randomNumber <=47)) { continue; }
            if ((randomNumber >=58) && (randomNumber <=64)) { continue; }
            if ((randomNumber >=91) && (randomNumber <=96)) { continue; }
            if ((randomNumber >=123) && (randomNumber <=126)) { continue; }
        }
        iteration++;
        password += String.fromCharCode(randomNumber);
    }
    return password;
  }
});


