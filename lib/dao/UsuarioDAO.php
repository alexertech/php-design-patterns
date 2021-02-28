<?php
/**
 * Objeto de Acceso a la base de datos
 *
 * @author  Alex Barrios <alex@alexertech.com>
 * @version 05.03.2011
 * @package Usuario
 *
 */


class UsuarioDAO{

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
     * Validar() recibe el objeto de valor {@link Usuario}, y valida
     * la existencia de la información contenida en dicho objeto con
     * los registros existentes en la base de datos. Si existe,
     * completa el objeto de valor con toda la información asociada,
     * incluyendo su su perfil de acceso, de lo contrario se genera una
     * excepción.
     *
     * @param class $vo Objeto de valor "Usuario"
     *
     */

    function Validar(&$vo){

        $query = "SELECT s_usuarios.*,
                         s_perfiles.nombre as perfil
                  FROM s_usuarios, s_perfiles
                  WHERE s_usuarios.usuario='{$vo->usuario}'
                    AND s_usuarios.clave='{$vo->clave}'
                    AND s_perfiles.cod_perfil=s_usuarios.cod_perfil";

        $rs    = $this->db->query($query);

        if ($rs->rowCount()>0) {

            $row = $rs->fetch();

            $vo->cod_usuario = $row['cod_usuario'];
            $vo->cod_perfil  = $row['cod_perfil'];
            $vo->nombre      = $row['nombre'];
            $vo->cedula      = $row['cedula'];
            $vo->telefono    = $row['telefono'];
            $vo->email       = $row['email'];
            $vo->perfil      = $row['perfil'];

        } else
            throw new Exception('Usuario / Contraseña incorrectos<br>');
    }

    /**
     * ConPermisos() recibe el objeto de valor {@link Usuario}, un código
     * de menú y una opcion a consultar. Permite consultar la permisología
     * de acceso del Usuario instanciado en el objeto de valor con
     * respecto a la opción que esta tratando de acceder. Si no tiene
     * permisos, se genera una excepción.
     *
     * @param class $vo Objeto de valor "Usuario"
     * @param integer $menu Código del menú donde se ubica la opción
     * @param char $opc Opción a verificar. Las disponibles son: 'c'
     * para consultar, 'i' para insertar, 'm' para modificar y 'e'
     * para eliminar.
     */

    function ConPermisos(&$vo, $menu, $opc) {

        global $noenter;
        $row = null;

        $query = "SELECT opciones FROM s_permisos
                  WHERE cod_perfil={$vo->cod_perfil}
                  AND cod_menu=$menu";

        $rs    = $this->db->query($query);

        if($rs->rowCount()>0)
            $row = $rs->fetch();
        else
            $row = '0000';

        $_SESSION['permiso']['menu'][$menu] = $row;

        switch($opc) {

            case 'c' : $perm = 0; break;
            case 'i' : $perm = 1; break;
            case 'm' : $perm = 2; break;
            case 'e' : $perm = 3; break;

        }


        if ( $row != '0000' ) {

            if ( $opc == 'e' )
                return $row[0][$perm] != 1 ? 0 : 1;
            else {
                if ($row[0][$perm] != 1)
                    throw new Exception($noenter);
            }

        } else
            throw new Exception($noenter);

    }

    /**
     * BuscarStr() utiliza el atributo "aux" para agregar los filtros
     * tanto a Listar como a TotalReg.
     *
     * @param string $s Palabra clave para la busqueda
     *
     * @return string
     */

    function BuscarStr($s) {

        $str = " (s_usuarios.nombre ILIKE '%$s%' ";
        $str.= " OR s_usuarios.usuario ILIKE '%$s%' )";

        return $str;

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
    function Listar($limit, $offset, $search) {

        $sql = '';

        if ($search != '')
            $sql = " AND " . $this->BuscarStr($search);

        $query = "SELECT s_usuarios.*,s_perfiles.nombre AS perfil
                    FROM s_usuarios,s_perfiles
                    WHERE s_usuarios.cod_perfil = s_perfiles.cod_perfil
                    $sql ORDER BY cod_usuario ASC
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

    function TotalReg($search) {

        $sql = '';

        if ($search != '')
            $sql = " WHERE " . $this->BuscarStr($search);

        $query = "SELECT count(cod_usuario) FROM s_usuarios $sql";

        $rs = $this->db->query($query);

        $row = $rs->fetch();

        if ($row[0]>0)
            return $row[0];
        else
            throw new Exception('No exísten registros!');

    }

    /**
     * Insertar() recibe el objeto de valor {@link Usuario}, e inserta
     * la información que éste contenga en la base de datos.
     *
     * @param class $vo Objeto de valor "Usuario"
     *
     * @return array
     */

    function Insertar(&$vo){

        $into   = 'cod_perfil,nombre,email,usuario,clave';
        $values = "{$vo->cod_perfil},'{$vo->nombre}','{$vo->email}',
                  '{$vo->usuario}','{$vo->clave}'";

        $query  = "INSERT INTO s_usuarios($into) VALUES($values)";

        if (!$this->db->query($query))
            throw new Exception('Fallo al insertar!');

    }

    /**
     * Consultar() recibe el objeto de valor {@link Usuario}, con solo
     * el código del Usuario a consultar instanciado.
     *
     * @param class $vo Objeto de valor "Usuario"
     *
     * @return class
     */

    function Consultar(&$vo){

        $query = "SELECT
                    s_usuarios.*,
                    s_perfiles.nombre as perfil
                  FROM
                    s_usuarios,s_perfiles
                  WHERE
                    s_usuarios.cod_usuario = {$vo->cod_usuario} AND
                    s_usuarios.cod_perfil = s_perfiles.cod_perfil";

        $rs    = $this->db->query($query);

        if ($rs->RowCount()>0) {

            $row        = $rs->fetch();

            $vo->cod_perfil = $row['cod_perfil'];
            $vo->perfil     = $row['perfil'];
            $vo->nombre     = $row['nombre'];
            $vo->email      = $row['email'];
            $vo->usuario    = $row['usuario'];

        } else
            throw new Exception('Fallo al consultar!');
    }

    /**
     * Modificar() recibe el objeto de valor {@link Usuario}, con nuevos
     * datos para para modificar los existentes en la base de datos.
     *
     * @param class $vo Objeto de valor "Usuario"
     */

    function Modificar(&$vo){


        $set = "nombre='{$vo->nombre}',
                email='{$vo->email}',
                cod_perfil={$vo->cod_perfil},
                Usuario='{$vo->usuario}' ";

        $query = "UPDATE s_usuarios SET $set
                  WHERE cod_usuario={$vo->cod_usuario}";


        if (!$this->db->query($query))
            throw new Exception('Fallo al actualizar!');

    }

    /**
     * ModificarClave() recibe el objeto de valor {@link Usuario}, con nuevos
     * datos para para modificar los existentes en la base de datos.
     *
     * @param class $vo Objeto de valor "Usuario"
     */

    function ModificarClave(&$vo) {

        global $usuLogOb, $no_mod;

        $pass = explode('|',$vo->clave);

        if ($usuLogOb->cod_perfil != 1){

            $query = "SELECT cod_usuario FROM s_usuarios
                      WHERE cod_usuario={$vo->cod_usuario}
                      AND clave='{$pass[1]}'";

            $rs    = $this->db->query($query);

            if($rs->rowCount()>0){

                $query= "UPDATE s_usuarios SET clave='{$pass[0]}'
                         WHERE cod_usuario={$vo->cod_usuario}";

                if ($this->db->exec($query) == 0)
                    throw new Exception($no_mod);

            }else
                throw new Exception("Contraseña anterior incorrecta.");

        } else {

            $query= "UPDATE s_usuarios SET clave='{$pass[0]}'
                     WHERE cod_usuario={$vo->cod_usuario}";

            if (!$this->db->query($query))
                throw new Exception($no_mod);

        }
    }

    /**
     * Eliminar() recibe el objeto de valor {@link Usuario}, con solo
     * el código del Usuario a eliminar instanciado.
     *
     * @param class $vo Objeto de valor "Usuario"
     */

    function Eliminar(&$vo){

        $query = "DELETE FROM s_usuarios WHERE cod_usuario={$vo->cod_usuario}";

        if (!$this->db->query($query))
            throw new Exception('Fallo al eliminar!');

    }

}

?>
