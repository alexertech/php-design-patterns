<?php
require_once('control/ctl_login.php');
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
        <script type="text/javascript">
        $(document).ready(function() {
            $(".borde").addClass('ui-corner-all');
            $("input").addClass('ui-corner-all');
            $("select").addClass('ui-corner-all');
            $("textarea").addClass('ui-corner-all');
            $(".borde td:first").addClass('ui-corner-top');
            $(".borde td:last").addClass('ui-corner-bottom');
        });
        </script>
    </head>

    <body onload="javascript:$('#usu').focus();">

    <div id="area">

        <div id="top"></div>


        <div id="principal" style="width:780px;height:380px">

            <form name="nombre" action="?" method="post"
                  onsubmit="javascript:{preparaClave(); return validar(this)}">

            <table class="centrado borde" style="width:50%"
                   cellspacing="0" cellpadding="0">

                <tr class="titulo">
                    <td style="padding:7px;text-align:center" colspan="2">
                        <span style="color:#FFBF2A">.::</span>
                        Inicio de Sesi&oacute;n
                        <span style="color:#FFBF2A">::.</span>
                    </td>
                <?php

                if ($c->err != '') {

                    echo " <tr> ";
                    echo "   <td colspan=\"2\" class=\"error\">";
                    echo $c->err;
                    echo "   </td>";
                    echo " </tr>";

                }

                if ($c->msj != '') {

                    echo " <tr> ";
                    echo "   <td colspan=\"2\" class=\"mensaje\">";
                    echo $c->msj;
                    echo "   </td>";
                    echo " </tr>";

                }

                ?>
                <tr>
                    <td class="sombra1">Usuario</td>
                    <td class="sombra2">
                        <input type="text" name="usuario" id="usu">
                    </td>
                </tr>

                <tr>
                    <td class="sombra1">Contrase&ntilde;a</td>
                    <td class="sombra2">
                        <input type="password" name="clave" id="clv">
                    </td>
                </tr>

                <tr>
                    <td colspan="2" class="sombra3">
                        <input type="submit" value="Ingresar">
                        <input type="hidden" name="cmd" value="validar">
                    </td>
                </tr>

            </table>


            </form>

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
    </body>
</html>
