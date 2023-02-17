<?php

//Incluir archivo de configuración
require_once 'app/config.php';

//Incluir controladores necesarios
require_once 'app/controlador/AnunciosController.php';
require_once 'app/controlador/UsuariosController.php';
require_once 'app/modelo/Usuario.php';
require_once 'app/modelo/UsuarioDAO.php';
require_once 'app/modelo/AnuncioDAO.php';
require_once 'app/modelo/Anuncio.php';
require_once 'app/modelo/Foto.php';
require_once 'app/modelo/FotoDAO.php';
require_once 'app/utilidades/MensajeFlash.php';
// Crear un arreglo de mapeo de acciones
$map = array(
    "login" => array("controller" =>  "UsuariosController", "method" => "login", "publica" => true),
    "registro" => array("controller" =>  "UsuariosController", "method" => "registrar", "publica" => true),
    "inicio" => array("controller" => "AnunciosController", "method" => "inicio", "publica" => true), 
    "descripcion" => array("controller" => "AnunciosController", "method" => "descripcion", "publica" => true),
    "logout" => array("controller" => "UsuariosController", "method" => "logout", "publica" => false),
    "comprobar_email" => array("controller" => "UsuariosController", "method" =>"comprobar_email", "publica" => true),
    "subir_anuncio" => array("controller" => "AnunciosController", "method" =>"subirAnuncio", "publica" => false),
    "mis_anuncios" => array("controller" => "AnunciosController", "method" =>"misAnuncios", "publica" => false),
    "editar_anuncio" => array("controller" => "AnunciosController", "method" =>"editarAnuncio", "publica" => false),
    "borrar_anuncio" => array("controller" => "AnunciosController", "method" =>"borrarAnuncio", "publica" => false)

);

/* PARSEO DE LA RUTA */
if (!isset($_GET['action'])) {    //Si no existe el parámetro GET action como index.php?action=algo
    $action = 'inicio';
} else {
    if (!isset($map[$_GET['action']])) {  //Si no existe la acción en el mapa
        print "La acción indicada no existe.";
        header('Status: 404 Not Found');
        die();
    } else {
        $action = filter_var($_GET['action'], FILTER_SANITIZE_SPECIAL_CHARS);
    }
}
/* RECORDAR USUARIO CUANDO CIERRE EL NAVEGADOR MEDIANTE COOKIES */
/* Si tiene cookie y no tiene sesión iniciada la iniciaremos */
if (!isset($_SESSION['idUsuario']) && isset($_COOKIE['uid'])) {
    //Obtenemos el usuario de la BD
    $uid = filter_var($_COOKIE['uid'], FILTER_SANITIZE_STRING);
    $usuarioDAO = new UsuarioDAO(ConexionBD::conectar());
    $usuario = $usuarioDAO->obtenerPorUid($uid);

    if (!$usuario) {    //Si no se encuentra el usuario
        setcookie("uid", "", 0);   //Borramos la cookie
        header("Location: index.php");
    } else {
        //Iniciamos sesión
        $_SESSION['email'] = $usuario->getEmail();
        $_SESSION['nombre'] = $usuario->getNombre();
        $_SESSION['idUsuario'] = $usuario->getId();
        $_SESSION['foto'] = $usuario->getFoto();
        
        //Renovamos la cookie otra semana
        setcookie("uid", $uid, time() + 7 * 24 * 60 * 60);
    }
}

// Verificar si la acción es pública o no
if (!$map[$action]['publica'] && !isset($_SESSION['idUsuario'])) {
    // Si la acción no es pública y no existe una sesión de usuario, redirigir al index
    header("Location: index.php");
    die();
}

// Incluir el controlador especificado en el mapeo$controller = $map[$action]['controller'];
$controller = $map[$action]['controller'];
$method = $map[$action]['method'];

if (method_exists($controller, $method)) {
    $obj_controller = new $controller();
    $obj_controller->$method();
} else {
    header('Status: 404 Not Found');
    echo "El método $method del controlador $controller no existe.";
}