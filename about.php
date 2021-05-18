<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title style="font-family:'Oswald', sans-serif;">Svatby v podhůří</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Berkshire+Swash&family=Josefin+Sans:wght@300;700&family=Kaushan+Script&family=Oswald:wght@500&family=Poiret+One&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>

<body>
    <!--Navbar-->
    <nav class="navbar navbar-expand-md" style="height: 60px;">
        <div class="container mr-2 mr-sm-0">
            <button class="btn btn-outline-dark navbar-toggler" id="side-toggler" style="position: absolute; left: 15px; top: 15px;" type="button" data-toggle="collapse" data-target="#sidebar-side" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <button class="btn btn-outline-dark" id="shopcart">
                <i class="fa fa-shopping-cart"></i>
            </button>

            <!--Collapsing sidebar-->

            <div class="collapse" id="sidebar-side" style="background-color: #f4f3ef;">
                <div class="navbar-nav ml-auto">
                    <ul class="navbar-nav">
                        <li class="nav-item mb-1">
                            <a class="nav-link" id="mainnav-item" href="index.html">Hlavní stránka<span class="sr-only"></span></a>
                        </li>
                        <li class="nav-item my-1"><a class="nav-link" id="mainnav-item" href="index.html">O nás<span class="sr-only"></span></a></li>
                        <li class="nav-item my-1"><a class="nav-link" id="mainnav-item" href="portfolio.html">Portfolio<span class="sr-only"></span></a></li>
                        <li class="nav-item my-1"><a class="nav-link" id="mainnav-item" href="nabidka.html">Nabídka<span class="sr-only"></span></a></li>
                        <li class="nav-item my-1"><a class="nav-link" id="mainnav-item" href="objednavka.html">Objednávka<span class="sr-only"></span></a></li>
                        <li class="nav-item my-1"><a class="nav-link" id="mainnav-item" href="kontakt.html">Kontakt<span class="sr-only"></span></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!--Collapsing sidebar-->

        <!--Main navbar-->
        </div>
    </nav>
    <a class="btn btn-outline-dark btn-floating m-1 social-icon" id="socialicon-f" href="https://www.facebook.com/svatbyvpodhuri" role="button"><i class="fa fa-facebook-f"></i></a>
    <a class="btn btn-outline-dark btn-floating m-1 social-icon" id="socialicon-i" href="https://www.instagram.com/svatbyvpodhuri" role="button"><i class="fa fa-instagram"></i></a>
    <a class="btn btn-outline-dark btn-floating m-1 social-icon" id="socialicon-e" href="mailto: terikbyrtusek@seznam.cz" role="button"><i class="fa fa-envelope"></i></a>

    <!-- Heading Container -->
    <div class="container text-center my-5">
        <a href="index.php"><img src="img/logo.png" class="img-2 mb-5" style="margin-top: 120px"></a>
        <h1 style="margin-top: 200px; font-size: 3.5rem">About us</h1>
    </div>
    <div class="container text-center">
        <img src="imgs/41380338_10214897840153637_6284105172062830592_n.jpg" class="rounded-circle align-content-center mx-3 mt-3 mb-2" style="height: 250px; width: 250px; box-shadow: 1px 1px 1px 10px #fff">
        <img src="imgs/84543533_2985617251449820_488809149920968704_n.jpg" class="rounded-circle align-content-center mx-3 mt-3 mb-2" style="height: 250px; width: 250px; box-shadow: 1px 1px 1px 10px #fff">
    </div>
    <div class="container text-center my-4" style="width: 500px">
        <p id="bhavuka" style="font-size: 1.5rem; color: #2a2b2e"><b id="kaushan">Svatby v podhůří</b><br> – tak to jsme my –
        <p id="kaushan" style="font-size: 1.5rem; font-weight:bold; color: #2a2b2e">Terka a Pája</p><br>
        <p id="bhavuka" style="font-size: 1.2rem; color: #2a2b2e"> Dvě zcela odlišné povahy spojené kreativním duchem.<br>
            Každá už ví, co je její úkol, kdy pomoct a přiložit ruku k dílu či jen propůjčit svůj úhel pohledu.<br>
            Našimi startovacími body byly naše vlastní svatby, svatby přátel, rozlučky kamarádek či rodinné oslavy.<br>
            A nyní jsme spojily naše sny i síly a společně dodáváme krásným momentům neméně důležité detaily
            v podobě tiskovin i dekorací.</p>
    </div>


    <!-- Footer -->
    <footer class="bg-dark mt-5 text-center text-white">
        <div class="container p-4">

            <!--Links -->
            <section>
                <div class="row justify-content-center" id="bebas">
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="text-uppercase" id="odkazy">Navigation</h5>

                        <ul class="list-unstyled mb-0">
                            <li><a href="index.php" class="text-links">Home</a></li>
                            <li><a href="about.php" class="text-links">About us</a></li>
                            <li><a href="productlist.php" class="text-links">Products</a></li>
                            <li><a href="portfolio.php" class="text-links">Portfolio</a></li>
                            <li><a href="index.php?page=colors" target="_blank" class="text-links">Color swatch</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="text-uppercase" id="odkazy">Useful links</h5>

                        <ul class="list-unstyled mb-0">
                            <li><a href="terms.php" class="text-links">Terms of use</a></li>
                            <li><a href="privacy.php" class="text-links">Privacy policy</a></li>
                            <li><a href="faq.php" class="text-links">FAQ</a></li>
                            <li><a href="howto.php" class="text-links">How to order</a></li>
                            <li><a href="shipping.php" class="text-links">Shipping</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="text-uppercase" id="odkazy">Contact us</h5>

                        <ul class="list-unstyled mb-0">
                            <a class="btn btn-outline-light btn-floating m-1" href="https://www.facebook.com/svatbyvpodhuri" style="padding-left: 13px; padding-right: 13px;" role="button"><i class="fa fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-floating m-1" href="https://www.instagram.com/svatbyvpodhuri" role="button"><i class="fa fa-instagram"></i></a>
                            <a class="btn btn-outline-light btn-floating m-1" href="mailto: terikbyrtusek@seznam.cz" role="button"><i class="fa fa-envelope"></i></a>
                            <li class="text-links">+420 721 046 729</li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>


        <!-- Copyright -->
        <div class="text-center p-3" id="kaushan" style="background-color: rgba(0, 0, 0, 0.2); color:#ddac8f; margin-bottom: -20px;">
            © 2021 Svatby v podhůří
        </div>
    </footer>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>