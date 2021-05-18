<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title style="font-family:'Oswald', sans-serif;">Svatby v podhůří</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Berkshire+Swash&family=Josefin+Sans:wght@300;700&family=Kaushan+Script&family=Oswald:wght@300;600&family=Poiret+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">

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
                            <a class="nav-link" id="mainnav-item" href="index.php">Home<span class="sr-only"></span></a>
                        </li>
                        <li class="nav-item"><a class="nav-link" id="mainnav-item" href="about.php">About us<span class="sr-only"></span></a></li>
                        <li class="nav-item"><a class="nav-link" id="mainnav-item" href="productlist.php">Products<span class="sr-only"></span></a></li>
                        <li class="nav-item"><a class="nav-link" id="mainnav-item" href="portfolio.php">Portfolio<span class="sr-only"></span></a></li>
                        <li class="nav-item"><a class="nav-link" id="mainnav-item" href="index.php?page=colors" target="_blank">Color swatch<span class="sr-only"></span></a></li>
                        <li class="nav-item"><a class="nav-link" id="mainnav-item" href="howto.php">How to order<span class="sr-only"></span></a></li>
                        <li class="nav-item"><a class="nav-link" id="mainnav-item" href="contact.php">Contact us<span class="sr-only"></span></a></li>
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
    <a href="index.php?page=cart"><button class="btn btn-outline-dark" id="shopcart">
            <i class="fa fa-shopping-cart"></i>
        </button></a>



    <!-- Heading Container -->
    <div class="container text-center" style="margin-top: 130px;">
        <div class="row mx-0 justify-content-center">
            <a href="index.php"><img src="img/logo.png" class="img-2" style="margin-top: 110px;"></a>
        </div>

        <!--Breadcrumbs-->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" id="bebas">
                <li class="breadcrumb-item"><a href="index.php">Main page</a></li>
                <li class="breadcrumb-item active" aria-current="page">Products</li>
            </ol>
        </nav>

        <div class="row mx-0 my-0 justify-content-center">
            <div class="col-5 mt-1 col-md p-0 col-lg bb-height-image-tall" id="portfolio">
                <a href="index.php?page=bows"><span class="img-label">Bows</span></a>
            </div>
            <div class="col-5 mt-1 mx-1 col-md mx-md-1 col-lg bb-height-image-tall" id="portfolio">
                <a href="index.php?page=envelopes"><span class="img-label">Envelopes</span></a>
            </div>
            <div class="col-5 mt-1 col-md p-0 col-lg bb-height-image-tall" id="portfolio">
                <a href="index.php?page=pillows"><span class="img-label">Ring pillows</span></a>
            </div>
            <div class="col-5 mt-1 mx-1 col-md mx-md-1 col-lg bb-height-image-tall" id="portfolio">
                <a href="index.php?page=namecards"><span class="img-label">Name cards</span></a>
            </div>
        </div>

    </div>
    <div class="row no-gutters mx-0 my-2 justify-content-center">
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