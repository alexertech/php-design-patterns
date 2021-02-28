<?php
require_once 'control/ctl_cpass.php';
$c = new PageController();
?>

<form id="formulario" name="form" action="javascript:updateView('cpass.php','formulario')"
      method="post" onsubmit="javascript:return validar(this)">


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

    if ( $usuLogOb->cod_perfil==1 ) {

    ?>
    <tr>
        <td class="sombra1" style="width:30%"><?=$obliga?>Usuario</td>
        <td class="sombra2">
            <select name="cod_usuario">
                <?=F::makeCombo('s_usuarios','usuario','cod_usuario','','')?>
            </select>
        </td>
    </tr>
    <?php

    } else {

    ?>
    <tr>
        <td class="sombra1" style="width:30%"><?=$obliga?>Contrase&ntilde;a Anterior</td>
        <td class="sombra2">
            <input type="password" name="anterior" size="26">
            <input type="hidden" name="cod_usuario" value="<?=$usuLogOb->cod_usuario?>">
        </td>
    </tr>
    <?php

    }

    ?>
    <tr>
        <td class="sombra1" >Nueva Contraseña</td>
        <td class="sombra2">
            <input type="password" name="clave" size="26" id="id1">
        </td>
    </tr>
    <tr>
        <td class="sombra1" >Confirmación</td>
        <td class="sombra2">
            <input type="password" name="confirma" size="26" id="id2">
        </td>
    </tr>
    <tr>
        <td colspan="2" class="sombra3">

            <input type="submit" value="Actualizar"
                   onclick="javascript:return comprobar();">

            <input type="hidden" name="cmd" value="modificar">

        </td>
    </tr>

</table>


</form>

