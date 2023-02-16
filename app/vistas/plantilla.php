<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalog-Z Bootstrap 5.0 HTML Template</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="web/css/bootstrap.minCopia.css">
    <link rel="stylesheet" href="web/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="web/css/templatemo-style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">

    <style>
        #email_check {
            color: green;
            display: none;
        }

        #email_error {

            color: red;
            display: none;
        }

        #preloader {
            display: none;
            height: 20px;
            width: 20px
        }

        #fotoUsuario {
            width: 55px;
            height: 55px;
            background-position: center;
            background-size: cover;
            display: inline-block;
            border-radius: 30px;
            position: relative;
            top: 10px;
            border: 1px solid #999;
        }

        #heart {
            transition: transform 0.3s ease-out;
        }

        #heart:hover {
            transform: scale(1.5);
        }

        #carrusel {}

        #carrusel img {
            width: 100%;
            height: 900px;
            object-fit: contain;
        }

        figure.effect-ming {
            height: 400px;
            width: 400px;
            background-color: #fff;
        }

        figure.effect-ming img {
            min-width: 100%;
            min-height: 100%;
            object-fit: contain;
            object-position: center;
        }
    </style>
</head>

<body>
    <!-- Page Loader -->
    <div id="loader-wrapper">
        <div id="loader"></div>

        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>

    </div>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php?action=inicio">

                WallaFake
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link nav-link-1" style="max-width: 80%;" aria-current="page" href="index.php?action=inicio">Anuncios</a>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['idUsuario'])):  ?>
                            <a class="nav-link nav-link-2" href="index.php?action=subir_anuncio">Subir Anuncio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-2" href="index.php?action=mis_anuncios">Mis Anuncios</a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION['email'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link nav-link-2" href="index.php?action=logout">Logout</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link nav-link-3" href="index.php?action=login"><i class="fa-solid fa-right-to-bracket"></i> Login/Registro</a>
                    </li>
                <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>