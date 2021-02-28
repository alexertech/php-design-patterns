<?php
require_once 'control/ctl_template_ins.php';
$c = new PageController();
?>

<form id="formulario" name="form" action="javascript:updateView('<?=$c->prefix?>_ins.php','formulario')"
      method="post" onsubmit="javascript:return validar(this)">

<table class="centrado borde" <?=$conf_tablas?>>
    <tr>
        <td colspan="2" class="titulo">
            <div style="width:65%;padding:4px;float:left;">
                <span style="color:#FFBF2A">.::</span>
                <?=$c->tOpcion?>
            </div>
            <div style="width:15%;padding:4px;float:left;">
                <?=F::ico(1)?> Insertar
            </div>
            <div style="width:15%;padding:4px;float:left;">
                <?=F::ico(17)?> <a href="javascript:void(0)" onclick="javascript:updateView('<?=$c->prefix?>.php') " class="nav">Volver</a>
            </div>
        </td>
    </tr>

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

    if ($c->block != 1) {

    ?>

    <tr>
        <td class="sombra1" style="width:25%"><?=$obliga?>Título</td>
        <td class="sombra2">
            <input type="text" name="titulo" maxlength="50">
        </td>
    </tr>

    <tr>
        <td class="sombra1" style="width:25%"><?=$obliga?>Contenido</td>
        <td class="sombra2">
            <textarea name="contenido"></textarea>
        </td>
    </tr>

    <tr>
        <td colspan="2" class="sombra3">

            <input type="submit" value="Insertar">
            <input type="reset" value="Limpiar">
            <input type="hidden" name="cmd" value="insertar">

        </td>
    </tr>

    <?php
    }
    ?>

</table>

</form>
