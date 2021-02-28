<?php
require_once 'control/ctl_perfiles_ins.php';
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
                <?=F::ico(7)?> <a href="javascript:void(0)" onclick="javascript:updateView('<?=$c->prefix?>.php') " class="nav">Volver</a>
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

    if ($c->block != 1) {

    ?>

    <tr>
        <td class="sombra1" style="width:25%"><?=$obliga?>Nombre</td>
        <td class="sombra2">

            <input type="text" name="nombre" id="id_nombre" maxlength="50"
                   onblur="javascript:validarCampo(11,'id_nombre','nombre','s_perfiles','ajax_resp')">

            <span id="ajax_resp"></span>

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

