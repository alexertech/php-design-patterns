<?php
/**
 * ctl_template.php
 *
 * Controlador que permite modificar un registro en la base de datos.
 *
 * @author  Alex Barrios <alex@alexertech.com>
 * @version #FECHA
 * @package Template
 *
 */

// Inclusiones
include_once 'lib/base_inc.php';
include_once 'lib/common/Session.php';


// Controlador
class PageController {

    // Atributos especiales del controlador
    var $err, $msj, $vo, $arr, $total, $res, $show, $jsView;

    // Ajustes a la vista
    var $tOpcion = 'Listar Comentarios';  // Titulo de la vista
    var $cSpan   = 2;                     // Combinado de celdas en títulos
    var $prefix  = 'template';            // Prefijo de archivos relacionados

    function __construct() {

        // En la instancia del controlador (constructor) es donde se
        // comienza a procesar información
        try {

            // Instanciamos los valores de las variables globales de la
            // aplicación:
            // $usuLogOb = Información del usuario que inició sesión
            // $p_*      = Numero de permiso para esta opción
            // $res_pp   = Resultado por página para el paginador

            global $usuLogOb, $p_template, $res_pp, $si_del, $noenter;

            $this->parseMsjs();

            // Instancia de la fabrica, que se encargará de la gestión
            // de objetos
            $factory = new Factory();

            // En el DAO de usuario, verificamos el permiso de consultar
            $Udao = $factory->getDAO('usuario');

            $Udao->ConPermisos($usuLogOb, $p_template, 'c');

            // Instancia de el objeto de valor y el dao para las acciones
            // del controlador
            $dao      = $factory->getDAO('templ');
            $this->vo = $factory->getVO('templ');

            // Gestión del Comando "del" (Eliminar)
            if ($_GET['cmd'] == 'del') {

                // Consulta que tenga permiso de eliminar en la
                // instancia existente
                $pE = $Udao->ConPermisos($usuLogOb, $p_template, 'e');

                if ( $pE != 0 ) {

                    // Obtiene y asigna los datos necesarios para la acción
                    // en el objeto de valor
                    $this->parseForm();

                    // Ejecuta la acción
                    $dao->Eliminar($this->vo);

                    // Envía el mensaje a la vista
                    $this->msj = $si_del;

                } else
                    $this->err = $noenter;

            }


            // El siguiente bloque es necesario para el paginador

            // Se cuenta el total de registros
            $this->total = $dao->TotalReg($_GET['s']);

            // El Limit y OffSet que le enviaremos a el generador
            // del listado
            $this->res   = isset($_GET['res']) ? $_GET['res'] : 0;
            $this->show  = $this->res != 0 ? $this->res*$res_pp : 0;

            // Invocamos la acción encargada de generar el listado
            $this->arr   = $dao->Listar($res_pp, $this->show);

        } catch (Exception $e) {

            // Si se produce una excepción, atrapar el mensaje
            // que ésta devuelve
            $this->err = $e->getMessage();

            if ($this->err == $noenter)
                $this->block = 1;

        }

    }

    function parseForm(){

        $this->vo->cod_templ = $_GET['cod'];

    }

    function parseMsjs() {

        // Revisamos si se esta enviando un mensaje a este código
        $this->msj  = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';
        $this->err  = isset($_GET['error']) ? $_GET['error'] : '';

    }

}
?>
