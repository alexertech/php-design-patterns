<?php
include_once 'lib/base_inc.php';
include_once 'lib/common/Session.Manager.php';
SessionManager::sessionStart($appNomSes);

if ($_GET['cmd']=='logout')
    $_SESSION['session'] ='';


if ( empty($_SESSION['session']) )
    include_once 'login.php';
elseif ( $_SESSION['session'] == 'true' )
    include_once 'interfaz.php';

?>
