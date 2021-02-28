<?php
/**
 * DB - Base de datos.
 *
 * Permite crear conexiones a la base de datos guardando el identificador
 * de conexión en el atributo $db. Solo con instanciar
 * la clase ya se obtiene el cursor para enviar sentencias SQL utilizando
 * los métodos de la clase interna de PHP, PDO.
 *
 * @author  Alex Barrios <alex@alexertech.com>
 * @version 05.03.2011
 * @package configuracion
 *
 */
class DB {

    /**
     * $db es el contenedor de la conexión a la base de datos
     * @var database resource
     */

    var $db;

    /**
     * El constructor instancia una conexión a la base de datos en el
     * atributo $db utilizando la capa de abstracción PDO
     *
     * @global String de conexión desde archivo de configuración
     * @global String con la información del usuario
     * @global String con la información de la clave
     */

    function __construct(){

        global $pdo_str, $pdo_user, $pdo_pass;

        $this->db = new PDO($pdo_str, $pdo_user, $pdo_pass);

    }

    /**
     * getConn() - Permite obtener el identificador de conexión desde cualquier
     * parte del código
     *
     * @return resource
     */


    function getConn(){

        return $this->db;

    }

    /**
     * El destructor cierra la conexión
     */

    function __destruct(){

        $this->db = NULL;

    }

}

?>
