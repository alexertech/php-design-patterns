<?php
/**
 * Objeto de Acceso a la base de datos
 *
 * @author  Alex Barrios <alex@alexertech.com>
 * @version 07.03.11
 * @package Comentario
 *
 */

class ComentarioDAO{

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

        $query = "SELECT * FROM i_comentarios
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

        $query = "SELECT count(cod_comentario) FROM i_comentarios";

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

        $query = "INSERT INTO i_comentarios(nombre,mensaje)
                    VALUES('{$vo->nombre}','{$vo->mensaje}')";

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

        $query = "SELECT * FROM i_comentarios WHERE cod_comentario='{$vo->cod_comentario}'";

        $rs    = $this->db->query($query);

        if ($rs->RowCount()>0) {

            $row        = $rs->fetch();

            $vo->nombre = $row['nombre'];
            $vo->mensaje = $row['mensaje'];


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

        $query = "UPDATE i_comentarios SET
                    nombre = '{$vo->nombre}',
                    mensaje = '{$vo->mensaje}'

                  WHERE cod_comentario={$vo->cod_comentario}";

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

        $query = "DELETE FROM i_comentarios WHERE cod_comentario={$vo->cod_comentario}";

        if (!$this->db->query($query))
            throw new Exception('Fallo al eliminar!');

    }

}

?>
