<?php
/**
 * Gestión de sesiones de usuario en la aplicación.
 *
 * Es importado por los controladores que necesiten acceder a los valores
 * almacenados en la sesión. También coloca disponible un objeto
 * llamado "usuLogOb" que contiene el objeto de valor {@link Usuario}
 * con la información del usuario autenticado actualmente.
 *
 * @author  Alex Barrios <alex@alexertech.com>
 * @version 05.03.2011
 * @package configuracion
 */

/*
 * Chequea que ningun cliente llame directamente a este archivo
 * y si lo hace, lo envia directo al index
 */
if (stristr($_SERVER['PHP_SELF'],'Session.php')) {
    Header('Location: ../index.php');
    die();
}

include_once 'Session.Manager.php';
SessionManager::sessionStart($appNomSes);

// Si no existe una session lo manda al index
if ( empty($_SESSION['usuario']) )
    die( "<html><body><script type=\"text/javascript\">parent.location='?cmd=logout';</script></body></html>" );
else
    $usuLogOb = unserialize($_SESSION['usuario']);
?>
