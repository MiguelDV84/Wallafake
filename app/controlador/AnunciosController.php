<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */
require 'app/modelo/Anuncio.php';
require 'app/modelo/AnuncioDAO.php';
require_once 'app/modelo/ConexionBD.php';

/**
 * Description of AnunciosController
 *
 * @author Alumno
 */
class AnunciosController
{

    function inicio()
    {

        $anuncioDAO = new AnuncioDAO(ConexionBD::conectar());

        //Obtengo todos los anuncios de la BD
        //        $array_anuncios = $anuncioDAO->getAnuncios();
        //
        //        $array_fotos_principales = array();
        //
        //        foreach ($array_anuncios as $anuncio) {
        //            $id_anuncio_foto = $anuncio->getId();
        //
        //            $array_fotos_principales[] = $anuncioDAO->getFotoPrincipal($id_anuncio_foto);
        //        }
        // Obtener el número de página a mostrar
        if (isset($_GET['pagina'])) {
            $num_pagina = $_GET['pagina'];
        } else {
            $num_pagina = 1;
        }

        // Calcular el inicio de la página actual
        $inicio = ($num_pagina - 1) * 5;

        // Obtener los siguientes 5 anuncios
        $array_Paginas = $anuncioDAO->paginacionAnuncios($inicio);


        require 'app/vistas/inicio.php';
    }

    function descripcion()
    {

        $anuncioDAO = new AnuncioDAO(ConexionBD::conectar());

        if (isset($_GET['pagina']) && is_numeric($_GET['pagina'])) {
            $pagina = (int) $_GET['pagina'];
        } else {
            $pagina = 1;
        }

        $anuncios_por_pagina = 4;

        $idAnuncio = $_GET['idAnuncio'];

        //Obtenemos el anuncio para la descripcion del anuncio
        $anuncio = $anuncioDAO->getAnunciosIdAnuncio($idAnuncio);

        //Para mostrar otros anuncios en descripcion.php
        $array_anuncios = $anuncioDAO->getAnuncios();

        //Obtenemos las imagenes de la tabla fotografias del anuncio de la descripción
        $fotos = $anuncioDAO->getImagenesAnuncios($idAnuncio);

        //Para mostrar el usuario que ha subido el producto
        $usuario = $anuncioDAO->getUsuarioAnuncio($idAnuncio);

        //incluimos la vista
        require 'app/vistas/descripcion.php';
    }




    function subirAnuncio()
    {
        require 'app/vistas/subirAnuncio.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $anuncio = new Anuncio();
            $foto = new Foto();
            //Obtener los datos del formulario
            $titulo = $_POST['titulo'];
            $precio = $_POST['precio'];
            $descripcion = $_POST['descripcion'];
            $file_name = [];
            $principal = 0;
            $anuncioDAO = new AnuncioDAO(ConexionBD::conectar());
            $idAnuncio = $anuncioDAO->insertarAnuncio($precio, $titulo, $descripcion, $_SESSION['idUsuario']);

            foreach ($_FILES['foto']['tmp_name'] as $key => $tmp_name) {
                $file_name[] = $_FILES['foto']['name'][$key];
                $file_size = $_FILES['foto']['size'][$key];
                $file_tmp = $_FILES['foto']['tmp_name'][$key];
                $file_type = $_FILES['foto']['type'][$key];

                $fotoDAO = new FotoDAO(ConexionBD::conectar());
                $fotoDAO->insertarFoto($idAnuncio, $file_name[$key], $principal);
                //Move the uploaded file to the desired location
                move_uploaded_file($file_tmp, "web/img/" . $file_name[$key]);
            }
        }
    }

    function misAnuncios()
    {




        $idUsuario = $_SESSION['idUsuario'];
        $anuncioDAO = new AnuncioDAO(ConexionBD::conectar());

        $array_anuncios = $anuncioDAO->getAnunciosIdUsuario($idUsuario);

        foreach ($array_anuncios as $anuncio) {
            $id_anuncio_foto = $anuncio->getId();

            $array_fotos_principales[] = $anuncioDAO->getFotoPrincipal($id_anuncio_foto);
        }
        require 'app/vistas/misAnuncios.php';
    }

    function editarAnuncio()
    {


        //Obtenemos el id del anuncio
        $idAnuncio = filter_var($_GET['idAnuncio'], FILTER_SANITIZE_NUMBER_INT);

        //Instanciamos un anuncioDAO
        $anuncioDAO = new AnuncioDAO(ConexionBD::conectar());
        //Obtenemos el anuncio por id
        $anuncio = $anuncioDAO->getAnunciosIdAnuncio($idAnuncio);
        //Obtenemos las imagenes de la tabla fotografias del anuncio de la descripción
        $fotoDAO = new FotoDAO(ConexionBD::conectar());

        $fotos = $anuncioDAO->getImagenesAnuncios($idAnuncio);
        //Para mostrar el usuario que ha subido el producto
        $usuario = $anuncioDAO->getUsuarioAnuncio($idAnuncio);
        require 'app/vistas/editarAnuncio.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Obtener los datos del formulario
            $titulo = $_POST['titulo'];
            $precio = $_POST['precio'];
            $descripcion = $_POST['descripcion'];
            $file_name = [];
            $principal = 0;
            $anuncio->setPrecio($precio);
            $anuncio->setTitulo($titulo);
            $anuncio->setDescripcion($descripcion);
            // Llama a la función para actualizar el anuncio
            $anuncioDAO->editarAnuncio($anuncio);
            // Procesar las imágenes
            foreach ($_FILES['foto']['tmp_name'] as $key => $tmp_name) {
                $file_name[] = $_FILES['foto']['name'][$key];
                $file_size = $_FILES['foto']['size'][$key];
                $file_tmp = $_FILES['foto']['tmp_name'][$key];
                $file_type = $_FILES['foto']['type'][$key];
                foreach ($fotos as $foto) {
                    $foto->setFoto($file_name[$key]);
                    $fotoDAO->actualzarFoto($foto);
                }
                //Move the uploaded file to the desired location
                move_uploaded_file($file_tmp, "web/img/" . $file_name[$key]);
            }
            header("Location: index.php");
        }
    }
}
