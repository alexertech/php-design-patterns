<?php
require_once('control/ctl_interfaz.php');
$c = new PageController();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title><?=$appTitulo?></title>
        <link rel="stylesheet" href="css/all.css" type="text/css">
        <script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.8.16.min.js"></script>
        <script type="text/javascript" src="js/jquery.notify.min.js"></script>
        <script type="text/javascript" src="js/Lookup-1.0.min.js"></script>
        <script type="text/javascript" src="js/md5.js"></script>
        <script type="text/javascript" src="js/sha1.js"></script>
        <script type="text/javascript" src="js/ui.datepicker-es.js"></script>
        <script type="text/javascript" src="js/general.js"></script>
    </head>

    <body onLoad="javascript:{creaMenu();updateView('blank.php')}">

    <div id="area">

        <div id="top"></div>
        <div id="menu"></div>
        <div id="principal">

            <!-- Area principal -->

        </div>
        <div id="bottom"><?=$appCopy?></div>

        <div id="notify" style="display:none; top:auto; right:0; bottom:0; margin:0 20px 20px 0">
            <div id="sticky">
                <a class="ui-notify-close ui-notify-cross" href="#">x</a>
                <h1>#{title}</h1>
                <p>#{text}</p>
            </div>
        </div>

    </div>

    <input type="hidden" name="_lookup" id="_lookup">

    </body>
</html>
