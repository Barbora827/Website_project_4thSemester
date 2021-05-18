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

    <!-- Heading Container -->
    <div class="container text-center my-5">
        <div class="row mx-0 justify-content-center">
            <div class="col-12 p-0 col-lg-9">
                <img src="img/wallpaper.jpg" class="img-fluid" id="mainpic" style="height: 400px;">
                <img src="img/logo.png" class="img-2">
            </div>
        </div>
        <div class="row no-gutters mx-0 my-2 justify-content-center">
            <div class="col-6 p-2 col-md p-0 col-lg-3">
                <img src="img/Aesthetic-Trees-Sky-Afterglow-Branches-Clouds-3172763.jpg" class="img-fluid" style="width: 100%;">
                <a href="portfolio.php"><span class="img-label">Portfolio</span></a>
            </div>
            <div class="col-6 p-2 col-md mx-md-2 col-lg-3">
                <img src="img/22bdb1d3453dca3120fa6c4294ca0d89.png" class="img-fluid" style="width: 100%;">
                <a href="productlist.php"><span class="img-label">Products</span></a>
            </div>
            <div class="col-6 my-2 p-0 mx-auto col-md mx-md-0 my-md-0 p-md-2 col-lg-3">
                <img src="img/aesthetic-photography-3.jpg" class="img-fluid" style="width: 100%;">
                <a href="/objednavka.html"><span class="img-label" id="img-label-long">How to order</span></a>
            </div>
        </div>
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
                        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fa fa-envelope"></i></a>
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