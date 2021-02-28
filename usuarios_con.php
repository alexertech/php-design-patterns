<?php
require_once 'control/ctl_usuarios_con.php';
$c = new PageController();
?>

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
    ?>
    <tr>
        <td class="sombra1" style="width:25%">Nombre</td>
        <td class="sombra2"><?=$c->vo->nombre?></td>
    </tr>
    <tr>
        <td class="sombra1">E-mail</td>
        <td class="sombra2"><?=$c->vo->email?></td>
    </tr>
    <tr>
        <td colspan="2" class="titulo" style="height:20px;text-align:center">Datos del Usuario</td>
    </tr>
    <tr>
        <td class="sombra1">Perfil</td>
        <td class="sombra2"><?=$c->vo->perfil?></td>
    </tr>
    <tr>
        <td class="sombra1">Usuario</td>
        <td class="sombra2"><?=$c->vo->usuario?></td>
    </tr>
    <tr>
        <td colspan="2" class="sombra3">
            <input type="button" value="Volver"
                   onClick="javascript:updateView('<?="{$c->prefix}.php?{$c->addVolver}"?>')">
        </td>
    </tr>

</table>
