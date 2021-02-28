<?php
/**
 *
 * Configuración y variables BASE del sistema.
 *
 * Es importado por los controladores que necesiten acceder a los valores
 * almacenados en la sesión. También coloca disponible un objeto en los
 * llamado <strong>usuLogOb</strong> que contiene el objeto de valor {@link Usuario}
 * con la información del usuario autenticado actualmente.
 *
 * @author  Alex Barrios <alex@alexertech.com>
 * @version 05.03.2011
 * @package configuracion
 *
 */



// Extraemos el nombre del script actual en ejecución
$self      = explode('/',$_SERVER['PHP_SELF']);
$srcActual = array_pop($self);



// Chequea que ningun cliente llame directamente a este archivo
// y si lo hace, lo envia directo al index
if (stristr($_SERVER['PHP_SELF'],'config_inc.php')) {
    header('Location: ../index.php');
    die();
}



// Obliga al navegador a enviar el contenido en UTF-8
header('Content-Type: text/html; charset=UTF-8');



/**
 * Las siguientes lineas evitan la inyeccion SQL
 * @TODO Cambiar las líneas de iyección SQL, de foreach a while - each
 * */
foreach( $_GET as $variable => $valor ){
    if (!ctype_digit($_GET [ $variable ])) {
        if (mb_check_encoding($_GET [ $variable ],"UTF-8"))
            $_GET [ $variable ] = str_replace ( "'" , "\'" , $_GET [ $variable ]);
        else
            $_GET [ $variable ] = str_replace ( "'" , "\'" , utf8_encode($_GET [ $variable ]));
    }
}

foreach( $_POST as $variable => $valor ){
    $_POST [ $variable ] = str_replace ( "'" , "\'" , $_POST [ $variable ]);
}



// Configuracion de la base de datos
$pdo_str  = "pgsql:dbname=plantilla";
$pdo_user = "alex";
$pdo_pass = "hola";



//
$appTitulo = "Base";
$appNomSes = "Base";
$appCopy   = "
            <div style=\"color:#999\">
                Copyright&copy; 2011 - alexertech de alex barrios - .:baseApp:.<br>
                Todos los derechos reservados<br>
            </div>
            ";



// Configuracion basica de la apariencia de las tablas
$conf_tablas = "cellspacing=\"0\" cellpadding=\"0\" class=\"borde\"
                style=\"width:100%;margin:0px;\" ";



// Extraemos el nombre del script actual en ejecución
$self      = explode('/',$_SERVER['PHP_SELF']);
$srcActual = array_pop($self);






// CSS a sobrescribir en todas las paginas (incluir etiqueta <style>)
$overload_css = "";



// Mensajes del sistema
$si_ins  = "Registro Insertado con Éxito";
$no_ins  = "Fallo al Insertar!";
$si_mod  = "Registro Modificado con Éxito";
$no_mod  = "Fallo al Modificar!";
$si_del  = "Registro Eliminado con Éxito";
$no_del  = "Fallo al Eliminar!";
$noenter = "No tiene permisos para realizar esa acción";
$nologin = "Usuario & Constraseña incorrectos";
$obliga  = "<a style=\"color:red;cursor:help;text-decoration:none\" title=\"campo obligatorio\">*</a> ";
$jsNO    = "javascript:alert('$noenter')";



// Resultados por página
$res_pp = 20;




// Permisología menu
$p_perfiles = 2;
$p_permisos = 3;
$p_usuarios = 4;

$p_comentarios = 6;
#PERMISOS

?>
