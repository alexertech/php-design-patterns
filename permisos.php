<?php
require_once 'control/ctl_permisos.php';
$c = new PageController();
?>
<table class="centrado borde" <?=$conf_tablas?>>
    <tr>
        <td colspan="<?=$c->cSpan?>" class="titulo">
            <div style="width:80%;padding:4px;float:left;">
                <span style="color:#FFBF2A">.::</span>
                <?=$c->tOpcion?>
            </div>
            <div style="width:15%;padding:4px;float:left;">
                <?=F::ico(6)?> Principal
            </div>
        </td>
    </tr>
    <?php

    if ($c->err != '' OR $c->msj != '') {

        $class = $c->err != '' ? "error" : "mensaje";

        echo " <tr> ";
        echo "   <td colspan=\"2\" class=\"$class\">";
        echo $c->err != '' ? $c->err : $c->msj;
        echo "   </td>";
        echo " </tr>";

    }

    if ( $c->arr!=null ) {

    ?>
    <tr>
        <td class="list_titulo">Nombre Perfil</td>
        <td style="width:20%"  class="list_titulo">&nbsp;</td>
    </tr>
    <?php

    $aux = 0;

    while (list(, $row) = each($c->arr)) {

        $color    = $aux==0 ? "sombra1" : "sombra2";
        $aux      = $aux==0 ? 1 : 0;

        $link_mod = "updateView('{$c->prefix}_mod.php?cod={$row[0]}')";

    ?>
    <tr class="<?=$color?>">

        <td class="colRes"><?=$row[1]?></td>
        <td class="list_ico">
            <?=F::ico(3)?><a href="javascript:void(0)"
                          onclick="javascript:<?=$link_mod?>">Ver Permisos</a>
        </td>

    </tr>
    <?php
    }
    ?>


    <tr>
        <td colspan="<?=$c->cSpan?>" class="sombra3">
            <strong><?=$c->total?></strong> registro(s) | <?=$c->total!=0 ? F::paginar($res,$show,$res_pp,5,$c->total,"{$c->prefix}.php") : ''?>
        </td>
    </tr>

    <?php

    } else {

        echo " <tr> ";
        echo "   <td colspan=\"{$c->cSpan}\" class=\"error\">";
        echo "    No se encontraron registros!";
        echo "   </td>";
        echo " </tr>";

    }

    ?>

</table>
