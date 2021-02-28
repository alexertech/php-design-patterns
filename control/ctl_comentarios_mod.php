<?php
/**
 * ctl_comentarios_mod.php
 *
 * Controlador que permite modificar un registro en la base de datos.
 *
 * @author  Alex Barrios <alex@alexertech.com>
 * @version 07.03.11
 * @package Comentario
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
    var $tOpcion   = 'Modificar Comentario'; // Titulo de la vista
    var $prefix    = 'comentarios';        // Prefijo de archivos relacionados
    var $addVolver;                     //Posiciona el paginador en la última página vista

    function __construct() {

        try {

            global $usuLogOb, $p_comentarios, $si_mod, $noenter;

            $factory  = new Factory();

            $dao      = $factory->getDAO('usuario');
            $dao->ConPermisos($usuLogOb, $p_comentarios, 'm');


            $dao      = $factory->getDAO('comentarios');
            $this->vo = $factory->getVO('comentarios');

            $this->parseForm();

            if ($_POST['cmd']=='modificar'){

                $dao->Modificar($this->vo);

                $this->jsView = "updateView('{$this->prefix}.php?mensaje=$si_mod&{$this->addVolver}')";

            }

            $vo = $dao->Consultar($this->vo);

        } catch (Exception $e) {

            // Si se produce una excepción, atrapar el mensaje
            // que ésta devuelve
            $this->err = $e->getMessage();

            if ($this->err == $noenter)
                $this->block = 1;

        }

    }


    function parseForm() {

        $this->vo->cod_comentario  = isset($_POST['cod']) ? $_POST['cod'] : $_GET['cod'];

        $this->vo->nombre = $_POST['nombre'];
        $this->vo->mensaje = $_POST['mensaje'];
        

        //Posiciona el paginador en la última página vista  (requerido)
        $this->addVolver = "res={$_GET['res']}&s={$_GET['s']}";


    }

}
?>
