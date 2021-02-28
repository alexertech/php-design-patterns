<?php
require_once 'control/ctl_comentarios_mod.php';
$c = new PageController();
?>

<script type="text/javascript">
    <?=$c->jsView?>
</script>

<form id="formulario" name="form" action="javascript:updateView('<?=$c->prefix?>_mod.php','formulario')"
      method="post" onsubmit="javascript:return validar(this)">

<table class="centrado borde" <?=$conf_tablas?>>
    <tr>
        <td colspan="2" class="titulo">
            <div style="width:65%;padding:4px;float:left;">
                <span style="color:#FFBF2A">.::</span>
                <?=$c->tOpcion?>
            </div>
            <div style="width:15%;padding:4px;float:left;">
                <?=F::ico(1)?> <a href="javascript:void(0)" onclick="javascript:updateView('<?=$c->prefix?>_ins.php') " class="nav">Insertar</a>
            </div>
            <div style="width:15%;padding:4px;float:left;">
                <?=F::ico(7)?> <a href="javascript:void(0)" onclick="javascript:updateView('<?=$c->prefix?>.php') " class="nav">Volver</a>
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

        echo "   </td>";
        echo " </tr>";

    }

    if ($c->block != 1) {

    ?>

    <tr>
        <td class="sombra1" style="width:25%"><?=$obliga?>nombre</td>
        <td class="sombra2">
            <input type="text" name="nombre"
                   value="<?=$c->vo->nombre?>">
        </td>
    </tr>
    <tr>
        <td class="sombra1" style="width:25%"><?=$obliga?>mensaje</td>
        <td class="sombra2">
            <input type="text" name="mensaje"
                   value="<?=$c->vo->mensaje?>">
        </td>
    </tr>


    <tr>
        <td colspan="2" class="sombra3">

            <input type="submit" value="Actualizar">
            <input type="button" value="Volver" onClick="javascript:updateView('<?="{$c->prefix}.php?{$c->addVolver}"?>')">
            <input type="hidden" name="cod" value="<?=$c->vo->cod_comentario?>">
            <input type="hidden" name="cmd" value="modificar">

        </td>
    </tr>

    <?php
    }
    ?>

</table>

</form>
