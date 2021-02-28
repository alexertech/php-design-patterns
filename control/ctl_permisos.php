<?php
/**
 * ctl_permisos.php
 *
 * Controlador que permite listar los registros de la base de datos.
 *
 * @author  Alex Barrios <alex@alexertech.com>
 * @version 05.03.2011
 * @package Perfil
 *
 */

// Inclusiones
include_once 'lib/base_inc.php';
include_once 'lib/common/Session.php';


// Controlador
class PageController {

    // Atributos especiales del controlador
    var $err, $msj, $vo, $arr, $total, $res, $show;

    // Ajustes a la vista
    var $tOpcion = 'Permisos de Perfiles';  // Titulo de la vista
    var $cSpan   = 2;                       // Combinado de celdas en títulos
    var $prefix  = 'permisos';              // Prefijo de archivos relacionados


    function __construct() {

        // En la instancia del controlador (constructor) es donde se
        // comienza a procesar información
        try {

            // Instanciamos los valores de las variables globales de la
            // aplicación:
            // $usuLogOb = Información del usuario que inició sesión
            // $p_*      = Numero de permiso para esta opción
            // $res_pp   = Resultado por página para el paginador

            global $usuLogOb, $p_permisos, $res_pp, $noenter;

            // Instancia de la fabrica, que se encargará de la gestión
            // de objetos
            $factory = new Factory();

            // En el DAO de usuario, verificamos el permiso de consultar
            $Udao = $factory->getDAO('usuario');

            $Udao->ConPermisos($usuLogOb, $p_permisos, 'c');

            // Instancia de el objeto de valor y el dao para las acciones
            // del controlador
            $Pdao        = $factory->getDAO('perfil');
            $this->vo    = $factory->getVO('perfil');

            $this->total = $Pdao->TotalReg();

            $this->res   = isset($_GET['res']) ? $_GET['res'] : 0;
            $this->show  = $this->res != 0 ? $this->res*$res_pp : 0;

            $this->arr   = $Pdao->Listar($res_pp, $this->show);

        } catch (Exception $e) {

            // Si se produce una excepción, atrapar el mensaje
            // que ésta devuelve
            $this->err = $e->getMessage();

            if ($this->err == $noenter)
                $this->block = 1;

        }

    }

}
?>
