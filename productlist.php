<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title style="font-family:'Oswald', sans-serif;">Svatby v podhůří</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Berkshire+Swash&family=Josefin+Sans:wght@300;700&family=Kaushan+Script&family=Oswald:wght@300;600&family=Poiret+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <!--Collapsing sidebar-->
    <nav class="navbar navbar-expand-md" style="height: 60px;">
        <div class="container mr-2 mr-sm-0">
            <button class="btn btn-outline-dark navbar-toggler" id="side-toggler" style="position: absolute; left: 15px; top: 20px;" type="button" data-toggle="collapse" data-target="#sidebar-side" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>

            <div class="collapse" id="sidebar-side" style="background-color: #f4f3ef;">
                <div class="navbar-nav ml-auto">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link mb-1" id="mainnav-item" href="index.html">Hlavní stránka<span class="sr-only"></span></a>
                        </li>
                        <li class="nav-item my-1"><a class="nav-link" id="mainnav-item" href="index.html">O nás<span class="sr-only"></span></a></li>
                        <li class="nav-item my-1"><a class="nav-link" id="mainnav-item" href="objednavka.html">Objednávka<span class="sr-only"></span></a></li>
                        <li class="nav-item">
                            <a class="nav-link mb-1" id="mainnav-item" href="cenik.html">Ceník<span class="sr-only"></span></a>
                        </li>
                        <li class="nav-item my-1"><a class="nav-link" id="mainnav-item" href="index.html">Kontakt<span class="sr-only"></span></a></li>
                    </ul>
                </div>
            </div>
            <!--Collapsing sidebar-->

            <!--Main navbar-->
            <div class="collapse navbar-collapse" id="playgroundsNavbar">
                <div class="navbar-nav ml-auto">
                    <ul class="navbar-nav">
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <a class="btn btn-outline-dark btn-floating m-1 social-icon" id="socialicon-f" href="https://www.facebook.com/svatbyvpodhuri" role="button"><i class="fa fa-facebook-f"></i></a>
    <a class="btn btn-outline-dark btn-floating m-1 social-icon" id="socialicon-i" href="https://www.instagram.com/svatbyvpodhuri" role="button"><i class="fa fa-instagram"></i></a>
    <a class="btn btn-outline-dark btn-floating m-1 social-icon" id="socialicon-e" href="#!" role="button"><i class="fa fa-envelope"></i></a>
    <button class="btn btn-outline-dark" id="shopcart">
        <i class="fa fa-shopping-cart"></i>
    </button>



    <!-- Heading Container -->
    <div class="container text-center" style="margin-top: 130px;">
        <div class="row mx-0 justify-content-center">
            <a href="/"><img src="img/logo.png" class="img-2 mt-10"></a>
        </div>

        <!--Breadcrumbs-->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" id="bebas">
                <li class="breadcrumb-item"><a href="/">Hlavní stránka</a></li>
                <li class="breadcrumb-item active" aria-current="page">Portfolio</li>
            </ol>
        </nav>

        <div class="row mx-0 my-0 justify-content-center">
            <div class="col-5 mt-1 col-md p-0 col-lg bb-height-image-tall" id="portfolio">
                <a href="index.php?page=bows"><span class="img-label">Vývazky</span></a>
            </div>
            <div class="col-5 mt-1 mx-1 col-md mx-md-1 col-lg bb-height-image-tall" id="portfolio">
                <a href="obalky.html"><span class="img-label">Obálky</span></a>
            </div>
            <div class="col-5 mt-1 col-md p-0 col-lg bb-height-image-tall" id="portfolio">
                <a href="polstarky.html"><span class="img-label">Polštářky</span></a>
            </div>
            <div class="col-5 mt-1 mx-1 col-md mx-md-1 col-lg bb-height-image-tall" id="portfolio">
                <a href="krabicky.html"><span class="img-label">Ozdobné krabičky</span></a>
            </div>
        </div>
        <div class="row mx-0  justify-content-center">
            <div class="col-5 mt-1 col-md p-0 col-lg bb-height-image-tall" id="portfolio">
                <a href="makronky.html"><span class="img-label">Makronky</span></a>
            </div>
            <div class="col-5 mt-1 mx-1 col-md mx-md-1 col-lg bb-height-image-tall" id="portfolio">
                <a href="jmenovky.html"><span class="img-label">Jmenovky</span></a>
            </div>
            <div class="col-5 mt-1 col-md p-0 col-lg bb-height-image-tall" id="portfolio">
                <span class="img-label">7</span>
            </div>
            <div class="col-5 mt-1 mx-1 col-md mx-md-1 col-lg bb-height-image-tall" id="portfolio">
                <span class="img-label">8</span>
            </div>
        </div>

    </div>
    <div class="row no-gutters mx-0 my-2 justify-content-center">
    </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark mt-5 text-center text-white">
        <div class="container p-4">
            <section class="mb-4">

            </section>

            <!--Text -->
            <section class="mb-4">
                <p>
                </p>
            </section>

            <!--Links -->
            <section>
                <div class="row justify-content-center" id="bebas">
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="text-uppercase" id="odkazy">Odkazy</h5>

                        <ul class="list-unstyled mb-0">
                            <li><a href="#!" class="text-links">1</a></li>
                            <li><a href="#!" class="text-links">2</a></li>
                            <li><a href="#!" class="text-links">3</a></li>
                            <li><a href="#!" class="text-links">4</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="text-uppercase" id="odkazy">Odkazy</h5>

                        <ul class="list-unstyled mb-0">
                            <li><a href="#!" class="text-links">1</a></li>
                            <li><a href="#!" class="text-links">2</a></li>
                            <li><a href="#!" class="text-links">3</a></li>
                            <li><a href="#!" class="text-links">4</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="text-uppercase" id="odkazy">Odkazy</h5>

                        <ul class="list-unstyled mb-0">
                            <li><a href="#!" class="text-links">1</a></li>
                            <li><a href="#!" class="text-links">2</a></li>
                            <li><a href="#!" class="text-links">3</a></li>
                            <li><a href="#!" class="text-links">4</a></li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>

        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2); color:#ddac8f;">
            © 2021 Svatby v podhůří
        </div>
    </footer>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>