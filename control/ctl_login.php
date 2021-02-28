<?php
/**
 * Controlador de página index.php, autentificación.
 *
 * @author  Alex Barrios <alex@alexertech.com>
 * @version 05.03.2011
 * @package aplicacion
 */

// Inclusiones
include_once 'lib/base_inc.php';
include_once 'lib/common/Session.Manager.php';

// Clase controladora
class PageController {

    var $vo, $err, $msj;

    function __construct(){


        // Recepción de comando para cerrar una sesión
        if ($_GET['cmd']=='logout') {

            SessionManager::sessionStart($appNomSes);
            session_destroy();

            $this->msj = 'Sesión Finalizada';

        }

        // Recepción de comando para inicializar una sesión
        // (/lib/common/session.php)
        if ($_GET['cmd']=='out') {

            $this->err = 'Debe iniciar una sesión';

        }

        // Recepción de comando para validar el inicio de sesión
        if ($_POST['cmd']=='validar') {

            try {
                // Invoca a la fábrica de clases
                $factory   = new Factory();

                // Genera un VO y un DAO para el objeto usuario
                $this->vo = $factory->getVO('usuario');
                $dao      = $factory->getDAO('usuario');

                // Invoca el método encargado de recojer la información
                // del formulario
                $this->parseForm();

                // Ejecuta la validación
                $dao->Validar($this->vo);

                // Si la validación es exitosa el script continuará, si
                // no se generará una excepción

                ob_start();

                SessionManager::sessionStart($appNomSes);

                // Guardamos el objeto usuario en la sesión
                $_SESSION['usuario'] = serialize($this->vo);
                $_SESSION['session'] = 'true';

                header('Location:?');

                ob_end_flush();


            } catch (Exception $e) {

                // Atrapamos el mensaje de error generado por
                // la excepción
                $this->err = $e->getMessage();

            }

        }

    }

    function parseForm() {

        $this->vo->usuario = $_POST['usuario'];

        $this->vo->clave   = $_POST['clave'];

    }

}

?>
