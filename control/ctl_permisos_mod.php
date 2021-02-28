<?php
/**
 * ctl_perfiles_mod.php
 *
 * Controlador que permite modificar un registro en la base de datos.
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
    var $err, $msj, $vo, $dao, $arr, $total, $res, $show, $jsView;

    // Ajustes a la vista
    var $tOpcion   = 'Modificar Permisos'; // Titulo de la vista
    var $prefix    = 'permisos';        // Prefijo de archivos relacionados
    var $addVolver;                     //Posiciona el paginador en la última página vista

    function __construct() {

        try {

            global $usuLogOb, $p_permisos, $si_mod, $noenter;

            $factory  = new Factory();

            $dao      = $factory->getDAO('usuario');
            $dao->ConPermisos($usuLogOb, $p_permisos, 'm');


            $this->dao = $factory->getDAO('permiso');
            $this->vo  = $factory->getVO('permiso');

            $this->parseForm();



            if ($_POST['cmd']=='modificar'){

                $this->arr = $this->dao->Listar($this->vo,1);

                while (list(, $row) = each($this->arr)) {

                    $this->vo->cod_menu = $row['cod_menu'];
                    $hijos  = $this->dao->Listar($this->vo,2);

                    while (list(, $rowh) = each($hijos)) {

                        $this->vo->cod_menu   = $rowh['cod_menu'];
                        $this->vo->opciones   = $_POST["opciones_{$rowh['cod_menu']}"];

                        $this->dao->Modificar($this->vo);

                    }
                }

                $this->msj    = $si_mod;
                $this->jsView = "creaMenu();";

            }


            // Generar listado de padres para la vista
            $this->arr = $this->dao->Listar($this->vo,1);


        } catch (Exception $e) {

            // Si se produce una excepción, atrapar el mensaje
            // que ésta devuelve
            $this->err = $e->getMessage();

            if ($this->err == $noenter)
                $this->block = 1;

        }

    }


    function parseForm() {

        $this->vo->cod_perfil  = isset($_POST['cod']) ? $_POST['cod'] : $_GET['cod'];

    }

}
?>


<?php
/**
 * ctl_permisos_mod.php
 *
 * Controlador que permite modificar un registro en la base de datos.
 *
 * @author  Alex Barrios <alex@alexertech.com>
 * @version 05.03.2011
 * @package Perfil
 *


// Inclusiones
include_once 'lib/base_inc.php';
include_once 'lib/common/Session.php';

// Controlador
class PageController {

    // Atributos especiales del controlador
    var $err, $msj, $vo, $arr, $total, $res, $show, $cod;

    // Ajustes a la vista
    var $tOpcion   = 'Modificar Permisos'; // Titulo de la vista
    var $prefix    = 'permisos';           // Prefijo de archivos relacionados

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
            $dao = $factory->getDAO('usuario');
            $dao->ConPermisos($usuLogOb, $p_permisos, 'm');

            $this->dao = $factory->getDAO('permisos');
            $this->vo  = $factory->getVO('permisos');

            $this->par

            $this->cod = strlen($_GET['cod'])>0 ? $_GET['cod'] : $_POST['cod'];

            // Recepción y ejecución de comandos
            if ($_POST['cmd']=='modificar'){

                $this->arr = $this->dao->Permisologia($this->cod,1);

                while (list(, $row) = each($this->arr)) {

                    $arr_1 = $this->dao->Permisologia($this->cod,2,$row['cod_menu']);
                    while (list(, $rowu) = each($arr_1)) {

                        $this->dao->ModificarPermisologia($this->cod,$rowu['cod_menu'],$_POST["opciones_{$row['cod_menu']}"]);

                    }

                }

                // Modificar VO en la base de datos
                $this->msj = $si_mod;

            }

            $this->arr = $this->dao->Permisologia($this->cod,1);

        } catch (Exception $e) {

            // Si se produce una excepción, atrapar el mensaje
            // que ésta devuelve
            $this->err = $e->getMessage();

            if ($this->err == $noenter)
                $this->block = 1;

        }
    }

}
*/
?>
