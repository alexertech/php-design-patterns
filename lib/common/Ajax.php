<?php
/**
 * ajax.php
 *
 * Es la parte que funciona de lado del servidor para el
 * éxito de las peticiones ajax junto con js/general.js, que es la parte
 * de lado del cliente, es decir el javascript.
 *
 * @author  Alex Barrios <alex@alexertech.com>
 * @version 05.03.2011
 * @package Configuración
 *
 * */



// Inclusiones
include_once '../config_inc.php';
include_once 'DB.php';
include_once 'Funciones.php';
include_once 'Session.php';



// Inicialización
$dbc       = new DB();
$db        = $dbc->getConn();
$acc       = $_GET['acc'];
$ico_where = '';
$i         = 0;


/* *
 *
 * ACCIONES GENERICAS
 * Definidas por el desarrollador para el funcionamiento general
 * de la aplicación
 *
 * */

// acc=11 es la respuesta de la funcion validarCampo () de AJAX
// Comprueba si no existe el valor que se este colocando en el campo

if ($acc == 11 and $_GET['valor']!='') {

    $query = "SELECT {$_GET['db_campo']} FROM {$_GET['db_tabla']}
              WHERE {$_GET['db_campo']}='{$_GET['valor']}'";

    $rs    = $db->query($query);

    if ($rs->rowCount() > 0) {

        echo "<img src=\"{$ico_where}images/iconos/s_cancel.png\" title=\"Valor No disponible\">";
        echo "<input type=\"hidden\" id=\"cK\" value=\"1\">";

    } else
        echo "<img src=\"{$ico_where}images/iconos/s_okay.png\" title=\"Valor disponible\">";

    /* *
     *
     * Para hacer efectiva la comprobación deberia utilizarse la funcion
     * validar() de javascript.js o una funcion de comprobacion que
     * contenga el siguiente bloque
     *
     *    if(document.getElementById('cK')){
     *        alert ('Introduzca un valor Válido!');
     *        return false;
     *    }
     *
     * */
}

// Identico al anterior solo que comprueba si el valor existe

if ($acc == 12 and $_GET['valor'] != '') {

    $query = "SELECT {$_GET['db_campo']} FROM {$_GET['db_tabla']}
              WHERE {$_GET['db_campo']}='{$_GET['valor']}'";

    $rs    = $db->query($query);

    if ($rs->rowCount() > 0)
        echo "<img src=\"{$ico_where}images/iconos/s_okay.png\" title=\"El Valor Existe\">";
    else {
        echo "<img src=\"{$ico_where}images/iconos/s_cancel.png\" title=\"El Valor No Existe\">";
        echo "<input type=\"hidden\" id=\"cK\" value=\"1\">";
    }

}

?>
