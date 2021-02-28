<?php
/**
 * Objeto de Acceso a la base de datos
 *
 * @author  Alex Barrios <alex@alexertech.com>
 * @version 05.03.2011
 * @package Perfil
 *
 */

class PerfilDAO{

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
     * @param integer $limit Numero máximo de registros
     * @param integer $offset Numero de registro desde donde se
     * comenzarán a extraer los resultados
     *
     * @return array
     */
    function Listar($limit, $offset) {

        $query = "SELECT * FROM s_perfiles ORDER BY nombre ASC
                  LIMIT $limit OFFSET $offset";

        if ($rs = $this->db->query($query)){

            while ($row = $rs->fetch()){

                $listado[] = $row;

            }

            return $listado;

        } else
            throw new Exception('Ocurrió un error al generar el listado');

    }

    /**
     * TotalReg() cuenta todos los registros existentes en la base
     * de datos.
     *
     * @return integer
     */

    function TotalReg() {

        $query = "SELECT count(cod_perfil) FROM s_perfiles";

        $rs = $this->db->query($query);

        $row = $rs->fetch();

        if ($row[0]>0)
            return $row[0];
        else
            throw new Exception('No exísten registros!');

    }

    /**
     * Insertar() recibe el objeto de valor {@link Perfil}, e inserta
     * los datos que éste contenga en la base de datos.
     *
     * @param class $vo Objeto de valor "Perfil"
     *
     * @return array
     */

    function Insertar(&$vo){

        $query = "INSERT INTO s_perfiles(nombre) VALUES('{$vo->nombre}')";

        if (!$this->db->query($query))
            throw new Exception('Fallo al insertar!');

    }

    /**
     * Eliminar() recibe el objeto de valor {@link Perfil}, con solo
     * el código del Perfil a consultar instanciado.
     *
     * @param class $vo Objeto de valor "Perfil"
     */

    function Consultar(&$vo){

        $query = "SELECT * FROM s_perfiles WHERE cod_perfil='{$vo->cod_perfil}'";

        $rs    = $this->db->query($query);

        if ($rs->RowCount()>0) {

            $row        = $rs->fetch();

            $vo->nombre = $row['nombre'];

        } else
            throw new Exception('Fallo al consultar!');
    }

    /**
     * Modificar() recibe el objeto de valor {@link Perfil}, con nuevos
     * datos para para modificar los existentes en la base de datos.
     *
     * @param class $vo Objeto de valor "Perfil"
     */

    function Modificar(&$vo){

        $query = "UPDATE s_perfiles SET nombre='{$vo->nombre}'
                  WHERE cod_perfil={$vo->cod_perfil}";

        if (!$this->db->query($query))
            throw new Exception('Fallo al actualizar!');

    }

    /**
     * Eliminar() recibe el objeto de valor {@link Perfil}, con solo
     * el código del Perfil a eliminar instanciado.
     *
     * @param class $vo Objeto de valor "Perfil"
     */

    function Eliminar(&$vo){

        $query = "DELETE FROM s_perfiles WHERE cod_perfil={$vo->cod_perfil}";

        if (!$this->db->query($query))
            throw new Exception('Fallo al eliminar!');

    }

    /**
     * Permisologia() crea un listado de acuerdo a el menú de la
     * aplicación, para de acuerdo a los perfiles actualizar la
     * permisología de acceso.
     *
     * @param class $vo Objeto de valor "Perfil"
     *
     * @return array
     */

    function Permisologia($cod, $case, $value = null){

        if ($case == 1) {

            $query = "SELECT cod_menu,nombre FROM s_menu
                      WHERE padre=1000 ORDER by posicion ASC";

            if ($rs = $this->db->query($query)){

                while ($row = $rs->fetch()){

                    $listado[] = $row;

                }

                return $listado;

            } else
                throw new Exception('Ocurrió un error al generar el listado 1');

        }
        if ($case == 2) {

            $query = "SELECT cod_menu,nombre FROM s_menu WHERE padre=$value
                      ORDER by posicion ASC";

            if ($rs = $this->db->query($query)){

                while ($row = $rs->fetch()){

                    $listado[] = $row;

                }

                return $listado;

            } else
                throw new Exception('Ocurrió un error al generar el listado 2');

        }
        if ($case == 3) {

            $query = "SELECT opciones FROM s_permisos
                      WHERE cod_menu=$value AND cod_perfil = $cod";

            if ($rs = $this->db->query($query)){

                while ($row = $rs->fetch()){

                    $listado[] = $row;

                }

                return $listado;

            } else
                throw new Exception('Ocurrió un error al generar el listado 3');

        }
    }


    function ModificarPermisologia($cod_perfil, $cod_menu, $opciones){

        $rs= $this->db->query("SELECT cod_permiso FROM s_permisos
                        WHERE cod_perfil=$cod_perfil
                        AND cod_menu=$cod_menu");


        if($rs->rowCount()>0){

            // si existe una permisologia para ese menu, la actualiza
             $this->db->exec("UPDATE s_permisos SET opciones='$opciones'
                            WHERE cod_perfil=$cod_perfil
                            AND cod_menu=$cod_menu");

        }else{
            // si no existe una permisologia para ese menu, la inserta
             $this->db->query("INSERT INTO s_permisos(cod_perfil,cod_menu,opciones)
                            VALUES ($cod_perfil,$cod_menu,'$opciones')");
        }
    }
}

?>
