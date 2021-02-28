<?php
require_once 'control/ctl_comentarios.php';
$c = new PageController();
?>

<table class="centrado borde" <?=$conf_tablas?>>
    <tr>
        <td colspan="<?=$c->cSpan?>" class="titulo">
            <div style="width:65%;padding:4px;float:left;">
                <span style="color:#FFBF2A">.::</span>
                <?=$c->tOpcion?>
            </div>
            <div style="width:15%;padding:4px;float:left;">
                <?=F::ico(1)?> <a href="javascript:void(0)" onclick="javascript:updateView('<?=$c->prefix?>_ins.php') " class="nav">Insertar</a>
            </div>
            <div style="width:15%;padding:4px;float:left;">
                <?=F::ico(6)?> Principal
            </div>
        </td>
    </tr>
    <?php

    if ($c->err != '') {

        echo " <tr> ";
        echo "   <td colspan=\"{$c->cSpan}\" class=\"error\">";
        echo $c->err;
        echo "   </td>";
        echo " </tr>";

    }

    if ($c->msj != '') {

        echo " <tr> ";
        echo "   <td colspan=\"{$c->cSpan}\" class=\"mensaje\">";
        echo $c->msj;
        echo "   </td>";
        echo " </tr>";

    }


    if ( $c->arr!=null ) {

    ?>
    <tr>
        <td class="list_titulo"><!-- titulos --></td>
        <td style="width:20%" class="list_titulo">&nbsp;</td>
    </tr>

    <?php

    $aux = 0;

    while (list(, $row) = each($c->arr)) {

        $color    = $aux==0 ? "sombra1" : "sombra2";
        $aux      = $aux==0 ? 1 : 0;

        $strUrl   = "cod={$row[0]}&res={$_GET['res']}&s={$_GET['s']}";

        $link_mod = "updateView('{$c->prefix}_mod.php?$strUrl')";
        $link_del = "updateView('{$c->prefix}.php?$strUrl&cmd=del')";

    ?>
    <tr class="<?=$color?>">

        <td class="colRes"><?=$row[1]?></td>

        <td class="list_ico">
            <?php
            echo "<a href=\"javascript:void(0)\" onclick=\"javascript:$link_mod\">".F::ico(3)."</a>";
            echo "<a href=\"javascript:void(0)\" onclick=\"javascript:{if(pregunta()) $link_del}\">";
            echo F::ico(4);
            echo "</a>";
            ?>
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
    }
    ?>

    <tr>
        <td colspan="<?=$c->cSpan?>" class="sombra3">
            <em>
            Modificar <?=F::ico(3)?>
            Eliminar  <?=F::ico(4)?>
            </em>
        </td>
    </tr>
</table>
