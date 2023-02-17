<?php
require 'app/vistas/plantilla.php';
?>

<div class="tm-hero d-flex justify-content-center align-items-center" data-parallax="scroll" data-image-src="../../img/hero.jpg">

</div>

<div class="container-fluid tm-container-content tm-mt-60">
    <div class="row mb-4">
        <h2 class="col-12 tm-text-primary">Descripción del anuncio </h2>
    </div>
    <div class="row tm-mb-90">
        <div class="col-xl-8 col-lg-7 col-md-6 col-sm-12">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">


                <div class="carousel-inner">



                    <?php
                    $number_words = array('First', 'Second', 'Third', 'Fourth'); //crea el array con los nombres en inglés
                    $counter = 1; //inicializa el contador
                    foreach ($fotos as $foto) :
                        $alt = $number_words[$counter - 1] . " slide"; //accede al nombre en inglés correspondiente
                    ?>
                        <div class="carousel-item <?php echo ($counter === 1) ? 'active' : ''; ?>" id="carrusel">
                            <img class="d-block w-100" src="web/img/<?= $foto->getFoto(); ?>" alt="<?= $alt; ?>">
                        </div>
                    <?php
                        $counter++; //incrementa el contador
                    endforeach;
                    ?>

                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev" style="background-color: black;">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Anterior</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next" style="background-color: black;">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Siguiente</span>
                </a>
            </div>
            <!--<img src="web/img/<?= $anuncio->getImagen(); ?>" alt="Image" class="img-fluid">-->
        </div>
        <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
            <div class="tm-bg-gray tm-video-details">
                <a href="#" style="font-size: 50px; color: red; margin-left: 150px; float:right;"><i class="fa-sharp fa-regular fa-heart" id="heart"></i></a>
                <p class="mb-4">
                    Este anuncio a sido subido por: <a href="#"><?= $usuario->getEmail(); ?></a>
                </p><br>

                <!--
                <div class="mb-4 d-flex flex-wrap">
                    <div class="mr-4 mb-2">
                        <span class="tm-text-gray-dark">Dimension: </span><span class="tm-text-primary">1920x1080</span>
                    </div>
                    <div class="mr-4 mb-2">
                        <span class="tm-text-gray-dark">Format: </span><span class="tm-text-primary">JPG</span>
                    </div>
                </div>
                -->
                <form id="contact-form" action="" method="POST" class="tm-contact-form mx-auto">
                    <div class="form-group">
                        <h3 class="tm-text-gray-dark mb-3">Titulo</h3>
                        <p><?= $anuncio->getTitulo(); ?></p>
                    </div>

                    <div class="form-group">
                        <h3 class="tm-text-gray-dark mb-3">Descripcion</h3>
                        <p> <?= $anuncio->getDescripcion() ?> </p>
                    </div>
                    <div class="form-group">
                        <h2 class="tm-text-gray-dark mb-3">Precio</h2>
                        <p style="font-size: 30px;"> <?= $anuncio->getPrecio() ?> .00€</p>
                    </div>


                    <div class="form-group tm-text-right">
                        <button type="submit" class="btn btn-primary">Chatear con <?= $usuario->getEmail(); ?></button>
                    </div>
                    <?php
                    $idUsuario = $_SESSION['idUsuario'];
                    $idAnunciante = $anuncio->getId_usuario();
                    if (isset($idUsuario) && $idUsuario === $idAnunciante) :
                    ?>

                        <div class="form-group tm-text-right">
                            <a class="btn btn-primary" href="index.php?action=editar_anuncio&idAnuncio=<?= $_GET['idAnuncio'] ?>">Editar anuncio</a>
                        </div>
                        <div class="form-group tm-text-right">
                            <a class="btn btn-primary" href="index.php?action=borrar_anuncio&idAnuncio=<?= $_GET['idAnuncio'] ?>">Borrar Anuncio</a>
                        </div>
                    <?php endif; ?>

                </form>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <h2 class="col-12 tm-text-primary">
            Otros anuncios
        </h2>
    </div>
    <div class="row mb-3 tm-gallery">

        <?php
        $anuncios_inicio = ($pagina - 1) * $anuncios_por_pagina;
        $anuncios_fin = $anuncios_inicio + $anuncios_por_pagina;
        for ($i = $anuncios_inicio; $i < $anuncios_fin && $i < count($array_anuncios); $i++) :
            $anuncio = $array_anuncios[$i];
        ?>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-5">
                <figure class="effect-ming tm-video-item">
                    <img src="web/img/<?= $anuncio->getImagen() ?>" alt="Image" class="img-fluid">
                    <figcaption class="d-flex align-items-center justify-content-center">
                        <h2><?= $anuncio->getTitulo() ?></h2>
                        <a href="index.php?action=descripcion&idAnuncio=<?= $anuncio->getId(); ?>">View more</a>
                    </figcaption>
                </figure>
                <div class="d-flex justify-content-between tm-text-gray">
                    <span class="tm-text-gray-light"><?= $anuncio->getFecha(); ?></span>
                    <span><?= $anuncio->getPrecio(); ?> .00€</span>
                </div>
            </div>
        <?php endfor; ?>

        <!-- row -->
        <div class="col-12 d-flex justify-content-between align-items-center tm-paging-col">
            <a href="javascript:void(0);" class="btn btn-primary tm-btn-prev mb-2 disabled">Anterior</a>
            <div class="tm-paging d-flex">
                <?php
                $total_paginas = ceil(count($array_anuncios) / $anuncios_por_pagina);
                for ($pagina = 1; $pagina <= $total_paginas; $pagina++) :
                ?>
                    <a href="index.php?action=descripcion&pagina=<?= $pagina ?>" class="<?= $pagina === $num_pagina ? 'active tm-paging-link' : 'tm-paging-link' ?>">
                        <?= $pagina ?>
                    </a>
                <?php endfor; ?>
            </div>
            <a href="javascript:void(0);" class="btn btn-primary tm-btn-next">Próxima página</a>
        </div>
    </div>
</div>
</div> <!-- container-fluid, tm-container-content -->

<footer class="tm-bg-gray pt-5 pb-3 tm-text-gray tm-footer">
    <div class="container-fluid tm-container-small">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-12 px-5 mb-5">
                <h3 class="tm-text-primary mb-4 tm-footer-title">About Catalog-Z</h3>
                <p>Integer ipsum odio, pharetra ac massa ac, pretium facilisis nibh. Donec lobortis consectetur molestie. Nullam nec diam dolor. Fusce quis viverra nunc, sit amet varius sapien.</p>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 px-5 mb-5">
                <h3 class="tm-text-primary mb-4 tm-footer-title">Our Links</h3>
                <ul class="tm-footer-links pl-0">
                    <li><a href="#">Advertise</a></li>
                    <li><a href="#">Support</a></li>
                    <li><a href="#">Our Company</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 px-5 mb-5">
                <ul class="tm-social-links d-flex justify-content-end pl-0 mb-5">
                    <li class="mb-2"><a href="https://facebook.com"><i class="fab fa-facebook"></i></a></li>
                    <li class="mb-2"><a href="https://twitter.com"><i class="fab fa-twitter"></i></a></li>
                    <li class="mb-2"><a href="https://instagram.com"><i class="fab fa-instagram"></i></a></li>
                    <li class="mb-2"><a href="https://pinterest.com"><i class="fab fa-pinterest"></i></a></li>
                </ul>
                <a href="#" class="tm-text-gray text-right d-block mb-2">Terms of Use</a>
                <a href="#" class="tm-text-gray text-right d-block">Privacy Policy</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-7 col-12 px-5 mb-3">
                Copyright 2020 Catalog-Z Company. All rights reserved.
            </div>
            <div class="col-lg-4 col-md-5 col-12 px-5 text-right">
                Designed by <a href="https://templatemo.com" class="tm-text-gray" rel="sponsored" target="_parent">TemplateMo</a>
            </div>
        </div>
    </div>
</footer>

<script src="web/js/plugins.js"></script>
<script>
    $(window).on("load", function() {
        $('body').addClass('loaded');
    });
    $('.carousel').carousel({
        interval: 2000
    })

    $('a i.fa-heart').click(function() {
        if ($(this).hasClass('fa-solid')) {
            $(this).removeClass('fa-solid');
            $(this).addClass('fa-regular');
        } else {
            $(this).removeClass('fa-regular');
            $(this).addClass('fa-solid');
        }
    });
</script>
</body>

</html>