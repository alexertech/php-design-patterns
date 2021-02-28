<?php
/**
 * ctl_usuarios_mod.php
 *
 * Controlador que permite modificar un registro en la base de datos.
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
    var $err, $msj, $vo, $arr, $total, $res, $show, $jsView;

    // Ajustes a la vista
    var $tOpcion   = 'Modificar Usuarios'; // Titulo de la vista
    var $prefix    = 'usuarios';           // Prefijo de archivos relacionados
    var $addVolver;                        //Posiciona el paginador en la última página vista

    function __construct() {

        try {

            // Acceso a la variable global con la información del
            // usuario en la sesión, y la variable encargada de asociar
            // ésta página con el menú
            global $usuLogOb, $p_usuarios, $noenter, $si_mod, $no_mod;

            // Invocamos a la fabrica
            $factory = new Factory();

            // Solicitamos el DAO usuario, para comprobar los permisos
            // de acceso. Si no tiene permiso se generará una excepción
            // deteniendo la ejecución
            $dao = $factory->getDAO('usuario');
            $dao->ConPermisos($usuLogOb, $p_usuarios, 'm');

            // Generamos un VO para tratar la información
            // no es necesario el DAO en este caso ya que se sigue
            // trabajando con el mismo objeto de los permisos
            $this->vo = $factory->getVO('usuario');


            $this->parseForm();

            // Recepción y ejecución de comandos
            if ($_POST['cmd']=='modificar'){

                // Modificar VO en la base de datos
                $dao->Modificar($this->vo);
                $this->jsView = "updateView('{$this->prefix}.php?mensaje=$si_mod&{$this->addVolver}')";

            }

            // Consulta de los datos actuales en la base de datos
            $vo = $dao->Consultar($this->vo);

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

        $this->vo->cod_usuario  = isset($_POST['cod']) ? $_POST['cod'] : $_GET['cod'];
        $this->vo->cod_perfil   = $_POST['cod_perfil'];
        $this->vo->nombre       = $_POST['nombre'];
        $this->vo->cedula       = "{$_POST['nac']}{$_POST['cedula']}";
        $this->vo->telefono     = $_POST['telefono_omit'];
        $this->vo->email        = $_POST['email_omit'];
        $this->vo->usuario      = $_POST['login'];

        //Posiciona el paginador en la última página vista  (requerido)
        $this->addVolver = "res={$_GET['res']}&s={$_GET['s']}";

    }
}

?>
