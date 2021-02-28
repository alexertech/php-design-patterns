<?php
require_once 'control/ctl_permisos_mod.php';
$c      = new PageController();
?>

<script type="text/javascript">
    <?=$c->jsView?>
</script>

<form id="formulario" name="form" action="javascript:updateView('<?=$c->prefix?>_mod.php','formulario')"
      method="post" onsubmit="javascript:return validar(this)">

<table class="centrado borde" <?=$conf_tablas?>>
    <tr>
        <td colspan="2" class="titulo">
            <div style="width:80%;padding:4px;float:left;">
                <span style="color:#FFBF2A">.::</span>
                <?=$c->tOpcion?>
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


    if ( $c->arr!=null ) {

    $k = 0;

    while (list(, $row) = each($c->arr)) {

    ?>
        <tr>
            <td colspan="2" class="sombra1 borde" style="text-align:left;">
                <b><?=$row['nombre']?></b>
            </td>
        </tr>
    <?php

    $c->vo->cod_menu = $row['cod_menu'];
    $hijos           = $c->dao->Listar($c->vo,2);

    while (list(, $rowh) = each($hijos)) {

        $color = $aux==0 ? "sombra1" : "sombra2";
        $aux   = $aux==0 ? 1 : 0;

        $c->vo->cod_menu = $rowh['cod_menu'];
        $cm              = $c->vo->cod_menu;
        $opciones        = $c->dao->Listar($c->vo,3);
        $opc             = is_array($opciones) ? $opciones[0]['opciones'] : '0000';


        $sel = null;

        $sel[0] = $opc[0] == 1 ? 'checked="checked"' : '';
        $sel[1] = $opc[1] == 1 ? 'checked="checked"' : '';
        $sel[2] = $opc[2] == 1 ? 'checked="checked"' : '';
        $sel[3] = $opc[3] == 1 ? 'checked="checked"' : '';


    ?>
        <tr class="<?=$color?>">
            <td class="colRes" style="padding-left:30px;">
                <?=$rowh['nombre']?>
            </td>
            <td class="list_ico">
                <script type="text/javascript">
                <?php
                if ($k == 0) {
                ?>
                function permisos(i,cm) {
                    var o = $('#opc_'+cm).val();

                    if (o.charAt(i) == '0')
                        o = o.substr(0,i) + '1' + o.substr(i+1);
                    else
                        o = o.substr(0,i) + '0' + o.substr(i+1);

                    $('#opc_'+cm).val(o);
                }
                <?php
                }
                ?>
                $(function() {
                    $( "#checkbox_<?=$cm?>" ).buttonset();
                });
                </script>
                <div id="checkbox_<?=$cm?>">

                    <input type="checkbox" id="rad1_<?=$cm?>" name="r_<?=$cm?>" <?=$sel[0]?>
                           onClick="javascript:permisos(0,<?=$cm?>)">
                    <label for="rad1_<?=$cm?>">Consultar</label>

                    <input type="checkbox" id="rad2_<?=$cm?>" name="r_<?=$cm?>" <?=$sel[1]?>
                           onClick="javascript:permisos(1,<?=$cm?>)">
                    <label for="rad2_<?=$cm?>">Insertar</label>

                    <input type="checkbox" id="rad3_<?=$cm?>" name="r_<?=$cm?>" <?=$sel[2]?>
                           onClick="javascript:permisos(2,<?=$cm?>)">
                    <label for="rad3_<?=$cm?>">Modificar</label>

                    <input type="checkbox" id="rad4_<?=$cm?>" name="r_<?=$cm?>" <?=$sel[3]?>
                           onClick="javascript:permisos(3,<?=$cm?>)">
                    <label for="rad4_<?=$cm?>">Eliminar</label>

                    <input type="hidden" name="opciones_<?=$cm?>"
                           id="opc_<?=$cm?>" value="<?=$opc?>">

                </div>
                <!--
                <select name="opciones_<?=$rowh['cod_menu']?>" style="width:90%">
                    <option value="0000" <?=$sel[0]?>>Ninguno</option>
                    <option value="1000" <?=$sel[1]?>>consultar</option>
                    <option value="1100" <?=$sel[2]?>>consultar, insertar</option>
                    <option value="1110" <?=$sel[3]?>>consultar, insertar, modificar</option>
                    <option value="1111" <?=$sel[4]?>>consultar, insertar, modificar, eliminar</option>
                </select>
                -->
            </td>
        </tr>
    <?php

        }
        $k++;
    }
    ?>
    <tr>
        <td colspan="2" class="sombra3">
            <input type="submit" value="Actualizar">
            <input type="button" value="Volver" onClick="javascript:updateView('<?=$c->prefix?>.php')">
            <input type="hidden" name="cod" value="<?=$c->vo->cod_perfil?>">
            <input type="hidden" name="cmd" value="modificar">
        </td>
    </tr>
    <?php
    }
    ?>

</table>

</form>
