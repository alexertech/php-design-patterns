<?php
require_once 'control/ctl_usuarios_ins.php';
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
                <?=F::ico(7)?> <a href="javascript:void(0)" onclick="javascript:updateView('<?="{$c->prefix}.php"?>') " class="nav">Volver</a>
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
            <input type="text" name="nombre" id="id_nombre"
                   onKeyPress="return(formatoCampo(this,event,2))">
        </td>
    </tr>

    <tr>
        <td class="sombra1">E-mail</td>
        <td class="sombra2">
            <input type="text" name="email_omit" maxlength="200">
        </td>
    </tr>
    <tr>
        <td colspan="2" class="titulo" style="height:20px;text-align:center">
            Datos del Usuario
        </td>
    </tr>
    <tr>
        <td class="sombra1" style="width:25%"><?=$obliga?>Perfil</td>
        <td class="sombra2">
            <select name="cod_perfil">
                <?=F::makeCombo('s_perfiles','nombre','cod_perfil','','')?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="sombra1"><?=$obliga?>Usuario</td>
        <td class="sombra2">
            <input type="text" name="login" id="id_login"  maxlength="20"
                   onblur="javascript:validarCampo(11,'id_login','usuario','s_usuarios','ajax_resp')">

            <span id="ajax_resp"></span>

        </td>
    </tr>
    <tr>
        <td class="sombra1"><?=$obliga?>Contrase&ntilde;a</td>
        <td class="sombra2">
            <input type="password" name="pass" id="id1" maxlength="50">
            <a href="javascript:void(0)"
               onClick="javascript:{var clave = $.password(6); $('#id1').val(clave); $('#id2').val(clave); $('#clave').html(clave);}">
                <?=F::ico(8)?>
            </a>
            <span id="clave"></span>
        </td>
    </tr>
    <tr>
        <td class="sombra1"><?=$obliga?>Confirmaci&oacute;n</td>
        <td class="sombra2">
            <input type="password" name="confirma" id="id2" maxlength="50">
        </td>
    </tr>
    <tr>
        <td colspan="2" class="sombra3">

            <input type="submit" value="Insertar"
                   onclick="javascript:return comprobar();">
            <input type="reset" value="Limpiar">
            <input type="hidden" name="cmd" value="insertar">

        </td>
    </tr>

    <?php
    }
    ?>

</table>

</form>
