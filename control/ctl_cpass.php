<?php
/**
 * ctl_cpass.php
 *
 * Controlador que permite cambiar la clave de los usuario.
 *
 * @author  Alex Barrios <alex@alexertech.com>
 * @version 05.03.2011
 * @package Usuario
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
    var $tOpcion = 'Cambiar Clave';  // Titulo de la vista
    var $cSpan   = 2;                // Combinado de celdas en títulos
    var $prefix  = 'cpass';       // Prefijo de archivos relacionados

    function __construct() {

        try {

            global $usuLogOb, $noenter, $si_mod, $no_mod;


            if ($_POST['cmd']=='modificar'){

                $factory = new Factory();

                $dao      = $factory->getDAO('usuario');
                $this->vo = $factory->getVO('usuario');

                $this->parseForm();

                $dao->ModificarClave($this->vo);
                $this->msj = $si_mod;

            }

        } catch (Exception $e) {

            // Si se produce una excepción, atrapar el mensaje
            // que ésta devuelve
            $this->err = $e->getMessage();

            if ($this->err == $noenter)
                $this->block = 1;

        }

    }

    // Método para recibir los datos del formulario, cualquier validación
    // adicional del lado del servidor, debe realizarse en éste metodo
    function parseForm() {

        $this->vo->cod_usuario = $_POST['cod_usuario'];
        $this->vo->clave       = md5($_POST['clave'])."|".md5($_POST['anterior']);

    }
}

?>
