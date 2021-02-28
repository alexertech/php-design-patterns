<?php
/**
 * Base de inclusiones del sistema.
 *
 * @author  Alex Barrios <alex@alexertech.com>
 * @version 05.03.2011
 * @package configuracion
 */


// Configuracion
include_once 'lib/config_inc.php';
include_once 'lib/common/DB.php';
include_once 'lib/common/Factory.php';
include_once 'lib/common/Funciones.php';


// A partir de acá se deben colocar los enlaces a VO y DAO's

// Usuarios
include_once 'lib/model/Usuario.php';
include_once 'lib/dao/UsuarioDAO.php';

// Perfiles
include_once 'lib/model/Perfil.php';
include_once 'lib/dao/PerfilDAO.php';

// Permisos
include_once 'lib/model/Permiso.php';
include_once 'lib/dao/PermisoDAO.php';

// Comentario 
include_once 'lib/model/Comentario.php';
include_once 'lib/dao/ComentarioDAO.php';

#INCLUDES
?>
