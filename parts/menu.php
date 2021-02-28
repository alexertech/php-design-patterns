<?php
/**
 * menu.php
 *
 * Crea un menú a partir de la tabla "menu" en la DB.
 *
 * @author  Alex Barrios <alex@alexertech.com>
 * @version 05.03.2011
 * @package configuracion
 *
 * */

include_once '../lib/config_inc.php';
include_once '../lib/common/DB.php';
include_once '../lib/model/Usuario.php';
include_once '../lib/common/Session.php';

$dbc = new DB();
$dbm = $dbc->getConn();

// Verificando la ubicación de algunos archivos predeterminados
$icons = 'images/iconos/user.png';
$cpass = 'cpass.php';

?>
<script type="text/javascript">

    // Primer nivel de opciones
    function montre(id) {

        for (var i = 1; i<=10; i++) {

            if ($('#smenu'+i))
                $('#smenu'+i).css('display','none');

        }

        if ($("#"+id)) { $("#"+id).css('display','block') };

        checkHeight();

        setTimeout("checkHeight()",3500);

    }

    // Invocar el cierre de la sesión
    function logout() {

        if (confirm('Estas seguro de que deseas salir?'))
            parent.location='?cmd=logout';
        else
            return false;

    }

</script>

<div id="area_menu">

<table style="width:100%;">
     <tr>
        <td style="height:10px"></td>
     </tr>
     <tr>
        <td style="text-align:left;padding-left:15px;">
            <img src="<?=$icons?>" alt="Icono" style="padding-right:8px">
            <strong><?=$usuLogOb->nombre?></strong>
        </td>
     </tr>
     <tr>
        <td style="text-align:center">
            <em><?=$usuLogOb->perfil?></em>
        </td>
     </tr>
     <tr>
        <td>
            <div class="t_menu">
                <strong>Menu Principal</strong>
            </div>
            <?php

            $rsm=$dbm->query("SELECT *
                             FROM s_menu
                             WHERE padre=1000
                             AND cod_menu IN
                              (SELECT padre
                               FROM s_menu
                               WHERE cod_menu IN
                                (SELECT cod_menu
                                 FROM s_permisos
                                 WHERE cod_perfil={$usuLogOb->cod_perfil}
                                 AND opciones LIKE '1%'
                                )
                              )
                             ORDER BY posicion ASC");


            while ($rowm = $rsm->fetch()) {
            //foreach ($rsm as $rowm) {

                // menu padre
                echo "<div class=\"t_menu\" onclick=\"javascript:montre('{$rowm['link']}');\">";
                echo $rowm['nombre'];
                echo "</div>";

                // hijos
                echo "<div id=\"{$rowm['link']}\">";

                $rsm2=$dbm->query("SELECT *
                                  FROM s_menu
                                  WHERE
                                   padre={$rowm['cod_menu']}
                                  AND cod_menu IN
                                   (SELECT cod_menu
                                    FROM s_permisos
                                    WHERE cod_perfil={$usuLogOb->cod_perfil}
                                    AND opciones LIKE '1%'
                                   )
                                  ORDER BY posicion ASC");

                while ($row_sub = $rsm2->fetch()) {
                // foreach ($rsm2 as $row_sub) {

                    $link     = $row_sub['link'];

                    $linkBold = explode('.',$link);

                    $nombre   = $row_sub['nombre'];

                    echo "<div onclick=\"javascript:updateView('$link') \" class=\"opcs_menu\">
                              $nombre
                          </div>";
                }
                echo "</div>";

            }

            ?>

        </td>
     </tr>
     <tr>
        <td>
            <div class="t_menu" onclick="javascript:updateView('<?=$cpass?>')">
                Cambiar Clave
            </div>
            <div class="t_menu" onclick="javascript:logout();">
                Salir
            </div>
        </td>
     </tr>
</table>

<img src="images/bg-menu_bot.jpg" align="left">

</div>


