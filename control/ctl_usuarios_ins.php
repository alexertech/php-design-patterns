<?php
/**
 * ctl_usuarios_ins.php
 *
 * Controlador que permite insertar un registro en la base de datos.
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
    var $tOpcion   = 'Insertar Usuarios'; // Titulo de la vista
    var $prefix    = 'usuarios';          // Prefijo de archivos relacionados
    var $addVolver;                       //Posiciona el paginador en la última página vista

    function __construct() {

        try {

            // Acceso a la variable global con la información del
            // usuario en la sesión, y la variable encargada de asociar
            // ésta página con el menú
            global $usuLogOb, $p_usuarios, $noenter, $si_ins, $no_ins;

            // Invocamos a la fabrica
            $factory = new Factory();

            // Solicitamos el DAO usuario, para comprobar los permisos
            // de acceso. Si no tiene permiso se generará una excepción
            // deteniendo la ejecución
            $dao = $factory->getDAO('usuario');
            $dao->ConPermisos($usuLogOb, $p_usuarios, 'i');


            // Recepción y ejecución de comandos
            if ($_POST['cmd'] == 'insertar') {

                // Creamos un DAO y un VO de perfil
                $dao      = $factory->getDAO('usuario');
                $this->vo = $factory->getVO('usuario');

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
    function parseForm() {

        $this->vo->cod_perfil   = $_POST['cod_perfil'];
        $this->vo->nombre       = $_POST['nombre'];
        $this->vo->cedula       = "{$_POST['nac']}{$_POST['cedula']}";
        $this->vo->telefono     = $_POST['telefono_omit'];
        $this->vo->email        = $_POST['email_omit'];

        $this->vo->usuario      = $_POST['login'];
        $this->vo->clave        = md5($_POST['pass']);

    }

}
?>
