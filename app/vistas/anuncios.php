<div class="tm-hero d-flex justify-content-center align-items-center" data-parallax="scroll" data-image-src="web/img/hero.jpg">
    <form class="d-flex tm-search-form">
        <input class="form-control tm-search-input" type="search" placeholder="Busca por categoria" aria-label="Search">
        <button class="btn btn-outline-success tm-search-btn" type="submit">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>
<?php if (isset($_SESSION['email'])): ?>

<strong
    style="
    font-size: 35px;
float: right;
margin: 20px;
margin-right: 150px;
padding: 0 15px;
padding-bottom: 12.5px;
background: linear-gradient(to right, #00c6ff, #0072ff);
color: white;
text-shadow: 2px 2px #333;
border: 1px solid rgba(255,255,255,0.5);
border-top: 1px solid rgba(255,255,255,0.8);
border-left: 1px solid rgba(255,255,255,0.8);
border-radius: 20px;
box-shadow: 5px 5px 5px rgba(0,0,0,0.2);
transform: skew(-10deg);       "
    >¡Bienvenid@ <?= $_SESSION['email'] ?>!     <div style="background-image:url('web/img/<?= $_SESSION['foto'] ?>')" id='fotoUsuario'></div></strong>

<?php endif; ?>
<div class="container-fluid tm-container-content tm-mt-60">
    <div class="row mb-4">
        <h2 class="col-6 tm-text-primary">
            Últimos anuncios
        </h2>



    </div>
    <div class="row tm-mb-90 tm-gallery">
        <!-- Bucle escribe anuncios en lan vista -->

        <?php foreach ($array_Paginas as $anuncio) : ?>


            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-5">
                <figure class="effect-ming tm-video-item">
                    <img src="web/img/<?= $anuncio['imagen']; ?>" alt="Image" class="img-fluid">
                    <figcaption class="d-flex align-items-center justify-content-center">
                        <h2><?= $anuncio['titulo'] ?></h2>
                        <a href="index.php?action=descripcion&idAnuncio=<?= $anuncio['id']; ?>">View more</a>
                    </figcaption>
                </figure>
                <div class="d-flex justify-content-between tm-text-gray">
                    <span class="tm-text-gray-light"><?= $anuncio['fecha'] ?></span>
                    <span><?= $anuncio['precio'] ?>.00 €</span>
                </div>
                <p><?= $anuncio['descripcion'] ?></p>
            </div>
        <?php endforeach; ?> <!--Fin del bucle -->

        <!--CONTENEDOR DE EJEMPLO-->
        <!--
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-5">
            <figure class="effect-ming tm-video-item">
                <img src="../../web/img/img-03.jpg" alt="Image" class="img-fluid">
                <figcaption class="d-flex align-items-center justify-content-center">
                    <h2>Clocks</h2>
                    <a href="photo-detail.html">View more</a>
                </figcaption>                    
            </figure>
            <div class="d-flex justify-content-between tm-text-gray">
                <span class="tm-text-gray-light">18 Oct 2020</span>
                <span>9,906 €</span>
            </div>
            <p>Esta sería la descripción del articulo</p>
        </div>
    </div>
        <!-- row -->
        <div class="row tm-mb-90">
            <div class="col-12 d-flex justify-content-between align-items-center tm-paging-col">
                <?php if ($num_pagina == 1) : ?>
                    <a href="index.php?action=inicio&pagina=<?php echo $num_pagina - 1; ?>" class="btn btn-primary tm-btn-prev mb-2 disabled" id="pagina">Anterior</a>
                <?php else : ?>
                    <a href="index.php?action=inicio&pagina=<?php echo $num_pagina - 1; ?>" class="btn btn-primary tm-btn-prev mb-2 " id="pagina">Anterior</a>
                <?php endif; ?>
                <div class="tm-paging d-flex">
                    <!--                    <a href="javascript:void(0);" class="active tm-paging-link">1</a>
                                        <a href="javascript:void(0);" class="tm-paging-link">2</a>
                                        <a href="javascript:void(0);" class="tm-paging-link">3</a>
                                        <a href="javascript:void(0);" class="tm-paging-link">4</a>-->
                </div>
                <a href="index.php?action=inicio&pagina=<?php echo $num_pagina + 1; ?>" class="btn btn-primary tm-btn-next" id="pagina">Próxima página</a>
            </div>
        </div>
    </div> <!-- container-fluid, tm-container-content -->

    <footer class="tm-bg-gray pt-5 pb-3 tm-text-gray tm-footer">
        <div class="container-fluid tm-container-small">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12 px-5 mb-5">
                    <h3 class="tm-text-primary mb-4 tm-footer-title">Sobre FakePop</h3>
                    <p>FakePop es una copia falsa de <a rel="sponsored" href="https://es.wallapop.com/">Wallapop</a> Es un proyecto académico de compraventa de segunda mano </p>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 px-5 mb-5">
                    <h3 class="tm-text-primary mb-4 tm-footer-title">Enlaces</h3>
                    <ul class="tm-footer-links pl-0">
                        <li><a href="#">Advertencia</a></li>
                        <li><a href="#">Soporte</a></li>
                        <li><a href="#">Nuestra compañía</a></li>
                        <li><a href="#">Contacto</a></li>
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
                    Copyright 2020 Gustavo Company. All rights reserved.
                </div>
                <div class="col-lg-4 col-md-5 col-12 px-5 text-right">
                    Designed by <a href="https://templatemo.com" class="tm-text-gray" rel="sponsored" target="_parent">GustavoCo</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="web/js/plugins.js"></script>
    <script>
        $(window).on("load", function() {
            $('body').addClass('loaded');
        });
    </script>
    </body>

    </html>