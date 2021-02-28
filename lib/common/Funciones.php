<?php
/**
 * Funciones comunes de la aplicación.
 *
 * "F" sirve de contenedor de funciones útiles en el sistema
 * necesarias para la gestión de iconos, paginar resultados, entre otros.
 *
 * @author  Alex Barrios <alex@alexertech.com>
 * @version 05.03.2011
 * @package configuracion
 *
 */

class F {

    function __construct(){

    }


    /**
     * function fecha()
     *
     * @desc   Devuelve la fecha actual formato. Ej. 27 de Junio de 2000.
     *         De acuerdo a el parámetro devuelve la información en formato
     *         ingles o español
     * @return String
     *
     * */

    function fecha($t) {

        switch ($t) {
            case 1 :
                setlocale (LC_TIME,"en_US.UTF-8");
                $fecha = ucwords(strftime("%A, %B %d, %Y"));
            break;
            case 2 :
                setlocale (LC_TIME,"es_VE.UTF-8");
                $fecha = str_replace("De","de",ucwords(strftime("%A, %d de %B de %Y")));
            break;
        }

        return $fecha;

    }


    /**
     * function traduceFecha()
     *
     * @desc   Cambia una fecha de formato tradicional a ISO. Ej: 27/06/2000 -> 2000/06/27
     * @return String
     *
     * */

    function traduceFecha($fecha){

        $str = explode('-',$fecha);
        $str = "{$str[2]}-{$str[1]}-{$str[0]}";

        return $str;

    }


    /**
     * function convierteFecha()
     *
     * @desc   Convierte una fecha en formato ISO en un entero único de tiempo
     * @return Integer
     *
     * */

    function convierteFecha($fecha) {

        return strtotime($fecha);

    }


    /**
     * paginar() - Permite paginar los resultados de una consulta a la
     * base de datos
     *
     * @param integer $res  Limite de resultados
     * @param integer $show Offset de la sentencia SQL
     * @param integer $data_per_pag Numero de registros a mostrar por pagina
     * @param integer $rango_pag Numero de paginas a la izquierda y derecha
     * de la posicion actual
     * @param integer $total_data Total de registros que existen en la
     * base de datos
     * @param integer $url URL para los enlaces de las páginas
     *
     * @return string
     *
     */

    function paginar($res,$show,$data_per_pag,$rango_pag,$total_data,$url) {

        $nro_pags  = ceil($total_data/$data_per_pag);
        $actual    = $res;

        $anterior  = $actual - 1;
        $posterior = $actual + 1;

        $ak        = $actual+1;

        $texto     = "Página <b>$ak</b> de <b>$nro_pags</b> | ";

        if ($actual!=0)
            $texto .= "<a href=\"javascript:void(0)\" onClick=\"updateView('$url?res=$anterior&s={$_GET['s']}')\">&laquo;</a> ";
        else
            $texto .= "<b>&laquo;</b> ";

        $r1 = $actual<$rango_pag ? 1 : $actual-($rango_pag-2);
        $r1 = $r1<1 ? 1 : $r1;

        $r2 = ($actual+1)==$nro_pags ? $nro_pags : $actual+$rango_pag;
        $r2 = $r2>$nro_pags ? $nro_pags : $r2;


        for ($i=$r1; $i<=$r2; $i++) {

            $ik = $i-1;

            if ($i==$ak)
                $texto .= "<b>$ak</b> ";
            else
                $texto .= "<a href=\"javascript:void(0)\" onClick=\"updateView('$url?res=$ik&s={$_GET['s']}')\">$i</a> ";

        }

        if ($actual<$nro_pags-1)
            $texto .= "<a href=\"javascript:void(0)\" onClick=\"updateView('$url?res=$posterior&s={$_GET['s']}')\">&raquo;</a> ";
        else
            $texto .= "<b>&raquo;</b>";

        return $texto;

    }


    /**
     * ico() - Controla todos los iconos utilizados en el sistema.
     * Genera un string preformateado con la etiqueta <img> y la
     * ruta de la carpeta de iconos ('images/iconos')
     *
     * @param integer $opc Número del icono a mostrar
     *
     * @return string
     *
     */

    function ico($opc) {

        $iconos = "images/iconos";

        switch($opc) {

            case 0 :
                $str = "<img src=\"$iconos/information.png\" alt=\"icono\" style=\"margin-right:5px;float:left\" title=\"Info\">";        // Info
            break;
            case 1 :
                $str = "<img src=\"$iconos/add-page.png\" alt=\"icono\" style=\"padding-right:3px;float:left\" title=\"Insertar\">";      // insertar
            break;
            case 2 :
                $str = "<img src=\"$iconos/magnifier.png\" alt=\"icono\" style=\"padding-right:3px\" title=\"Consultar Rápida\">";        // consultar
            break;
            case 3 :
                $str = "<img src=\"$iconos/edit-page.png\" alt=\"icono\" style=\"padding-right:3px\" title=\"Modificar\">";               // modificar
            break;
            case 4 :
                $str = "<img src=\"$iconos/delete-page.png\" alt=\"icono\" style=\"padding-right:3px\" title=\"Eliminar\">";              // eliminar
            break;
            case 5 :
                $str = "<img src=\"$iconos/user.png\" alt=\"icono\" style=\"padding-right:5px\">";                                        // usuario
            break;
            case 6 :
                $str = "<img src=\"$iconos/home-icon.png\" alt=\"icono\" style=\"padding-right:5px;float:left\">";                        // inicio
            break;
            case 7 :
                $str = "<img src=\"$iconos/resultset_previous.png\" alt=\"icono\"  style=\"padding-right:5px;float:left\">";              // volver
            break;
            case 8 :
                $str = "<img src=\"$iconos/key_go.png\" alt=\"icono\" title=\"Generar Clave\">";                                          // generar contraseña
            break;
            case 9 :
                $str = "<img src=\"$iconos/magnifier_zoom_in.png\" style=\"padding-right:3px\" alt=\"icono\" title=\"Consulta Rápida\">"; // generar contraseña
            break;


            // -------------
            default:
                $str='';
            break;

        }

        return $str;

    }


    /**
     * function makeCombo()
     *
     * @desc   Permite crear un combo a partir de una tabla
     * @return HTML String
     *
     * */

    function makeCombo($tabla, $descripcion, $value, $arg, $equal, $not = '') {

        $dbc  = new DB();
        $db   = $dbc->getConn();

        $desc  = explode(',',$descripcion);

        $c     = count($desc);

        $query = "SELECT $value,$descripcion FROM $tabla $arg";

        $rsc   = $db->query($query);

        if ( $rsc->rowCount()>0 ) {

            while ($row_c = $rsc->fetch()) {

                if ($row_c[$value] != $not) {

                    $sel = $row_c[$value]==$equal ? "SELECTED" : "";

                    echo "<option value=\"{$row_c[$value]}\" $sel>";

                    if ($c > 1) {

                        $str = '';
                        while (list(, $f) = each($desc))
                            $str .= "{$row_c[$f]} ";

                        echo $str; // echo substr($str, 0, -3);

                        reset($desc);

                    } else
                        echo $row_c[$descripcion];

                    echo "</option>\n";

                }

            }

        } else
            echo "<option value=\"_defa_\">No hay registros</option>";

    }
}


?>
