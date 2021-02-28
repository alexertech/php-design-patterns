<?php
/**
 * Fábrica de clases.
 *
 * Permite de forma sencilla crear instancias de las clases registradas
 * en la fábrica. Si se desean agregar nuevas opciones de clases deben
 * agregarlas en el método que sea necesario. Por ejemplo, para agregar
 * a la fábrica un nuevo objeto DAO de "Factura", necesitamos agregar
 * el siguiente código en el método {@link getDAO}:<br>
 * <code>
 * switch ($vo_class) {
 *    case 'factura' : return new FacturaDAO($db->getConn()); break;
 * }
 * </code>
 * Actualmente se manejan 2 tipos de instancias a través de 2 métodos,
 * el primer tipo es de "acceso a base de datos" ({@link getDAO})
 * y el segundo es de "objetos de valor" ({@link getVO}).<br>
 * Al momento de crear la instancia, la fábrica debe automáticamente
 * enviarle a los constructores de dichas clases todos los recursos
 * necesarios para su correcto desempeño.
 *
 * @author Alex Barrios <alex@alexertech.com>
 * @version 1.0
 * @package Factory
 *
 */
class Factory {

    function __construct(){

        //

    }

    function __destruct(){

        //

    }

    /**
     * getDAO() Genera las instancias de los objetos de acceso a base
     * de datos.
     *
     * @param string $vo_class Nombre del objeto de valor (en minúsculas)
     * del cual deseamos instanciar el DAO
     *
     * @return new class
     *
     */

    function getDAO($vo_class){

        /**
         * $db es el contenedor del identificador de conexión a la base
         * de datos. El enlace es generado automáticamente en el constructor
         * de la clase {@link DB}
         *
         * @var database resource
         */

        $db = new DB();

        switch ($vo_class) {

            case 'usuario' : return new UsuarioDAO($db->getConn()); break;
            case 'perfil'  : return new PerfilDAO($db->getConn()); break;
            case 'permiso' : return new PermisoDAO($db->getConn()); break;

            case 'comentarios' : return new ComentarioDAO($db->getConn()); break;
            #FACTORYDAO

        }

    }

    /**
     * getVO() Genera las instancias de los objetos de valor
     *
     * @param string $vo_class Nombre del objeto de valor (en minúsculas)
     * del cual deseamos crear una nueva instancia
     *
     * @return new class
     *
     */

    function getVO($vo_class){

        switch ($vo_class) {

            case 'usuario' : return new Usuario(); break;
            case 'perfil'  : return new Perfil(); break;
            case 'permiso' : return new Permiso(); break;

            case 'comentarios' : return new Comentario(); break;
            #FACTORYVO

        }

    }

}

?>

