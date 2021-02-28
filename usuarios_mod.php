<?php
require_once 'control/ctl_usuarios_mod.php';
$c = new PageController();
?>

<script type="text/javascript">
    <?=$c->jsView?>
</script>

<form id="formulario" name="form" method="post"
      action="javascript:updateView('<?=$c->prefix?>_mod.php','formulario')"
      onsubmit="javascript:return validar(this)">

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
                <?=F::ico(7)?> <a href="javascript:void(0)" onclick="javascript:updateView('<?="{$c->prefix}.php?{$c->addVolver}"?>') " class="nav">Volver</a>
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
            <input type="text" name="nombre" maxlength="50"
                   value="<?=$c->vo->nombre?>"
                   onKeyPress="return(formatoCampo(this,event,2))">
        </td>
    </tr>

    <tr>
        <td class="sombra1">E-mail</td>
        <td class="sombra2">
            <input type="text" name="email_omit" maxlength="200"
                   value="<?=$c->vo->email?>">
        </td>
    </tr>
    <tr>
        <td colspan="2" class="titulo"
            style="height:20px;text-align:center">
            Datos del Usuario
        </td>
    </tr>
    <tr>
        <td class="sombra1"><?=$obliga?>Perfil</td>
        <td class="sombra2">
            <select name="cod_perfil">
            <?=F::makeCombo('s_perfiles','nombre','cod_perfil','',$c->vo->cod_perfil,$db)?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="sombra1"><?=$obliga?>Usuario</td>
        <td class="sombra2">
            <input type="text" name="login" id="id_login"  maxlength="20"
                   value="<?=$c->vo->usuario?>"
                   onblur="javascript:validarCampo(11,'id_login','usuario','usuarios','ajax_resp')">
            <span id="ajax_resp"></span>
        </td>
    </tr>
    <tr>
        <td colspan="2" class="sombra3">
            <input type="submit" value="Actualizar">
            <input type="button" value="Volver" onClick="javascript:updateView('<?="{$c->prefix}.php?{$c->addVolver}"?>')">
            <input type="hidden" name="cod" value="<?=$c->vo->cod_usuario?>">
            <input type="hidden" name="cmd" value="modificar">
        </td>
    </tr>

    <?php
    }
    ?>

</table>

</form>
