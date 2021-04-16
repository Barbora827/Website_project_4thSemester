<?php
// Get the 4 most recently added products
$stmt = $pdo->prepare('SELECT * FROM products ORDER BY date_added DESC LIMIT 4');
$stmt->execute();
$recently_added_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title style="font-family:'Oswald', sans-serif;">Svatby v podhůří</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Berkshire+Swash&family=Josefin+Sans:wght@300;700&family=Kaushan+Script&family=Oswald:wght@500&family=Poiret+One&display=swap"
        rel="stylesheet">
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
    <!--Collapsing sidebar-->
  <nav class="navbar navbar-expand-md" style="height: 60px;">
    <div class="container mr-2 mr-sm-0">
      <button class="btn btn-outline-dark navbar-toggler" id="side-toggler"
        style="position: absolute; left: 15px; top: 20px;" type="button" data-toggle="collapse"
        data-target="#sidebar-side" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-bars"></i>
      </button>

      <div class="collapse" id="sidebar-side" style="background-color: #f4f3ef;">
        <div class="navbar-nav ml-auto">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link mb-1" id="mainnav-item" href="index.php">Home<span
                  class="sr-only"></span></a>
            </li>
            <li class="nav-item my-1"><a class="nav-link" id="mainnav-item" href="index.html">About us<span
                  class="sr-only"></span></a></li>
            <li class="nav-item my-1"><a class="nav-link" id="mainnav-item" href="productlist.php">Products<span
                  class="sr-only"></span></a></li>
            <li class="nav-item my-1"><a class="nav-link" id="mainnav-item" href="portfolio.php">Portfolio<span
                  class="sr-only"></span></a></li>
            <li class="nav-item my-1"><a class="nav-link" id="mainnav-item" href="tutorial.php">How to order<span
                  class="sr-only"></span></a></li>
            <li class="nav-item my-1"><a class="nav-link" id="mainnav-item" href="contact.php">Contact us<span
                  class="sr-only"></span></a></li>
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
  <a class="btn btn-outline-dark btn-floating m-1 social-icon" id="socialicon-f" style="padding: 10px" href="https://www.facebook.com/svatbyvpodhuri" role="button"><i class="fa fa-facebook-f"></i></a>
    <a class="btn btn-outline-dark btn-floating m-1 social-icon" id="socialicon-i" style="padding: 10px" href="https://www.instagram.com/svatbyvpodhuri" role="button"><i class="fa fa-instagram"></i></a>
    <a class="btn btn-outline-dark btn-floating m-1 social-icon" id="socialicon-e" style="padding: 10px" href="#!" role="button"><i class="fa fa-envelope"></i></a>
    <a href="index.php?page=cart"><button class="btn btn-outline-dark" style="padding: 10px 12px" id="shopcart">
        <i class="fa fa-shopping-cart"></i>
    </button></a>


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
                <img src="img/Aesthetic-Trees-Sky-Afterglow-Branches-Clouds-3172763.jpg" class="img-fluid"
                    style="width: 100%;">
                <a href="/webovky/portfolio.php"><span class="img-label">Portfolio</span></a>
            </div>
            <div class="col-6 p-2 col-md mx-md-2 col-lg-3">
                <img src="img/22bdb1d3453dca3120fa6c4294ca0d89.png" class="img-fluid" style="width: 100%;">
                <a href="/webovky/productlist.php"><span class="img-label">Products</span></a>
            </div>
            <div class="col-6 my-2 p-0 mx-auto col-md mx-md-0 my-md-0 p-md-2 col-lg-3">
                <img src="img/aesthetic-photography-3.jpg" class="img-fluid" style="width: 100%;">
                <a href="/objednavka.html"><span class="img-label">How to order</span></a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
        crossorigin="anonymous"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Footer -->
<footer class="bg-dark mt-5 text-center text-white">
        <div class="container p-4">
            <section class="mb-4">

            </section>

            <!--Text -->
            <section class="mb-4">
                <p style="font-family: bhavuka;">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam sapien
                    elit, consequat eget, tristique non, venenatis quis, ante. Pellentesque ipsum. Sed ac dolor sit amet
                    purus malesuada congue. Mauris tincidunt sem sed arcu. Phasellus faucibus molestie nisl. Excepteur
                    sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    Curabitur bibendum justo non orci. Aenean fermentum risus id tortor. Aliquam in lorem sit amet leo
                    accumsan lacinia. Aliquam ornare wisi eu metus. Fusce tellus. Mauris dictum facilisis augue. Integer
                    tempor.
                </p>
            </section>

            <!--Links -->
            <section>
                <div class="row justify-content-center" id="bebas">
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="text-uppercase" id="odkazy">Navigation</h5>

                        <ul class="list-unstyled mb-0">
                            <li><a href="#!" class="text-links">Main page</a></li>
                            <li><a href="#!" class="text-links">Products</a></li>
                            <li><a href="#!" class="text-links">Portfolio</a></li>
                            <li><a href="#!" class="text-links">Order</a></li>
                            <li><a href="#!" class="text-links">Message us</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="text-uppercase" id="odkazy">Useful links</h5>

                        <ul class="list-unstyled mb-0">
                            <li><a href="#!" class="text-links">Terms of use</a></li>
                            <li><a href="#!" class="text-links">Privacy policy</a></li>
                            <li><a href="#!" class="text-links">FAQ</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="text-uppercase" id="odkazy">Contact</h5>

                        <ul class="list-unstyled mb-0">
                            <a class="btn btn-outline-light btn-floating m-1"
                                href="https://www.facebook.com/svatbyvpodhuri"
                                style="padding-left: 13px; padding-right: 13px;" role="button"><i
                                    class="fa fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-floating m-1"
                                href="https://www.instagram.com/svatbyvpodhuri" role="button"><i
                                    class="fa fa-instagram"></i></a>
                            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
                                    class="fa fa-envelope"></i></a>
                            <li><a href="#!" class="text-links">+420 721 046 729</a></li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>

        <!-- Copyright -->
        <div class="text-center p-3" id="kaushan" style="background-color: rgba(0, 0, 0, 0.2); color:#ddac8f;">
            © 2021 Svatby v podhůří
        </div>
    </footer>