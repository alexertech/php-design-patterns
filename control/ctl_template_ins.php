<?php
/**
 * ctl_template_ins.php
 *
 * Controlador que permite insertar un registro en la base de datos.
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
    var $tOpcion = 'Insertar Comentario';  // Titulo de la vista
    var $prefix  = 'template';             // Prefijo de archivos relacionados

    function __construct() {

        try {

            // Acceso a la variable global con la información del
            // usuario en la sesión, y la variable encargada de asociar
            // ésta página con el menú
            global $usuLogOb, $p_template, $si_ins, $noenter;

            // Invocamos a la fabrica
            $factory = new Factory();

            // Solicitamos el DAO usuario, para comprobar los permisos
            // de acceso. Si no tiene permiso se generará una excepción
            // deteniendo la ejecución
            $dao = $factory->getDAO('usuario');
            $dao->ConPermisos($usuLogOb, $p_template, 'i');

            // Recepción y ejecución de comandos
            if ($_POST['cmd'] == 'insertar') {

                // Creamos un DAO y un VO de templ
                $dao      = $factory->getDAO('templ');
                $this->vo = $factory->getVO('templ');

                // Recepción de datos del formulario y asignación en el
                // VO
                $this->parseForm();

                // Insertar VO en la base de datos
                $dao->Insertar($this->vo);
                $this->msj = $si_ins;

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
    function parseForm(){

        $this->vo->titulo     = $_POST['titulo'];
        $this->vo->contenido  = $_POST['contenido'];

    }

}
?>
