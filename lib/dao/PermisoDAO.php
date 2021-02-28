<?php
/**
 * Objeto de Acceso a la base de datos
 *
 * @author  Alex Barrios <alex@alexertech.com>
 * @version 06.03.2011
 * @package Permiso
 *
 */

class PermisoDAO{

    /**
     * $db es el contenedor de la conexión a la base de datos
     * @var database resource
     */

    var $db;

    /**
     * El constructor instancia una conexión a la base de datos en el
     * atributo $db, la cual recibe a través del parámetro &$db
     * desde {@link Factory}
     *
     *
     * @param resource &$db Link o identificador de conexión a la base
     * de datos generado en {@link DB}.
     */

    function __construct(&$db){

        $this->db =& $db;

    }

    /**
     * Listar() crea un listado de los registros de la base de datos,
     * devolviendo un arreglo asociativo con claves iguales a los
     * nombres de los campos.
     *
     * @param integer $c Tipo de listado a devolver
     *
     * @return array
     */

    function Listar(&$vo,$c) {

        $query = '';

        switch($c) {
            case 1 :
            $query = "SELECT cod_menu,nombre
                        FROM s_menu
                        WHERE padre=1000
                        ORDER by posicion ASC";
            break;
            case 2 :
            $query = "SELECT cod_menu,nombre
                        FROM s_menu
                        WHERE padre={$vo->cod_menu}
                        ORDER by posicion ASC";
            break;
            case 3 :
            $query = "SELECT cod_permiso,opciones
                        FROM s_permisos
                        WHERE cod_menu={$vo->cod_menu} AND
                              cod_perfil = {$vo->cod_perfil}";
            break;
        }

        if ($rs = $this->db->query($query)){

            while ($row = $rs->fetch()){

                $listado[] = $row;

            }

            return $listado;

        } else
            throw new Exception('Ocurrió un error al generar el listado '.$c);

    }


    function Modificar(&$vo){

        $query = "SELECT cod_permiso FROM s_permisos
                    WHERE cod_perfil={$vo->cod_perfil}
                    AND cod_menu={$vo->cod_menu}";

        $rs    = $this->db->query($query);


        if ($rs->rowCount()>0) {

            $query = "UPDATE s_permisos SET opciones='{$vo->opciones}'
                        WHERE cod_perfil={$vo->cod_perfil}
                        AND cod_menu={$vo->cod_menu}";

             $this->db->exec($query);

        } else {

            $query = "INSERT INTO s_permisos(cod_perfil,cod_menu,opciones)
                        VALUES ({$vo->cod_perfil},{$vo->cod_menu},'{$vo->opciones}')";

             $this->db->query($query);

        }
    }
}

?>
