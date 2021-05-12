<?php
$stmt = $pdo->prepare("SELECT * FROM products_options ORDER BY name ASC");
$stmt->execute();
$colors = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

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

<style>
    .color-label {
        position: absolute;
        font-family: 'Bebas Neue', cursive;
        font-size: 2.5rem;
        text-align: center;
        color: #f4f3ef;
        text-shadow: 3px 3px 3px #000;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    @media (max-width: 768px) {
        .color-label {
            font-size: 1.5rem;
        }
    }
</style>

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
                        <li class="nav-item"><a class="nav-link" id="mainnav-item" href="index.php?page=colors">Color swatch<span class="sr-only"></span></a></li>
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
            <a href="index.php"><img src="img/logo.png" class="img-2" style="margin-top: 110px"></a>
        </div>

        <!--Breadcrumbs-->
        <nav aria-label="breadcrumb" class="mt-5">
            <ol class="breadcrumb" id="bebas">
                <li class="breadcrumb-item"><a href="index.php">Main page</a></li>
                <li class="breadcrumb-item active" aria-current="page">Color swatches</li>
            </ol>
        </nav>

        <div class="row mx-0 justify-content-center">
        <?php foreach ($colors as $color) : ?>
        <div class="col-5 col-md-4 col-lg-3 col-xl-2 my-4">
          <?php if (!empty($color['imgsrc']) && file_exists('imgs/colors/' . $color['imgsrc'])) : ?>
            <img src="imgs/colors/<?= $color['imgsrc'] ?>" width="200" height="180" alt="<?= $color['name'] ?>">
          <?php endif; ?>
          <span class="name mt-2" id="bebas" style="font-size: 20px; color:#343a40"><?= $color['name'] ?></span><br>
          </span>
        </div>
      <?php endforeach; ?>
          </div>

      <!--  <div class="row mx-0 my-0 justify-content-center">
            <div class="col mt-1 p-0 mr-md-1 ">
                <img class="img-responsive" src="imgs/colors/Antracitová.jpg">
                <span class="color-label">Anthracit</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Azure.jpg">
                <span class="color-label">Azure</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/azurro.jpg">
                <span class="color-label">Azurro</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/bettula.jpg">
                <span class="color-label">Bettula</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Bisquit.jpg">
                <span class="color-label">Bisquit</span>
            </div>
        </div>

        <div class="row mx-0 my-0 justify-content-center">
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/burgundy.jpg">
                <span class="color-label">Burgundy</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Kakao.jpg">
                <span class="color-label">Cacao</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Celeste.jpg">
                <span class="color-label">Celeste</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Cipria.jpg">
                <span class="color-label">Cipria</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Coral red.jpg">
                <span class="color-label">Coral red</span>
            </div>
        </div>

        <div class="row mx-0 my-0 justify-content-center">
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Kraft eco.jpg">
                <span class="color-label">Craft eco</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Dark Blue.jpg">
                <span class="color-label">Dark blue</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Dusty blue.jpg">
                <span class="color-label">Dusty blue</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/English green.jpg">
                <span class="color-label">English green</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/foglia green.jpg">
                <span class="color-label">Foglia green</span>
            </div>
        </div>

        <div class="row mx-0 my-0 justify-content-center">
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Grey fog.jpg">
                <span class="color-label">Grey fog</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/guardsman red.jpg">
                <span class="color-label">Guardsman red</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Holly tmavězelená.jpg">
                <span class="color-label">Holly darkgreen</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/cherry red.jpg">
                <span class="color-label">Cherry red</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Indian Yellow.jpg">
                <span class="color-label">Indian yellow</span>
            </div>


        </div>

        <div class="row mx-0 my-0 justify-content-center">
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Lampone.jpg">
                <span class="color-label">Lampone</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Limone.jpg">
                <span class="color-label">Limone</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Lipstick.jpg">
                <span class="color-label">Lipstick</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Malva.jpg">
                <span class="color-label">Malva</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Matcha tee.jpg">
                <span class="color-label">Matcha tea</span>
            </div>
        </div>

        <div class="row mx-0 my-0 justify-content-center">
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Mocca.jpg">
                <span class="color-label">Mocca</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Modrá.jpg">
                <span class="color-label">Blue</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Noce.jpg">
                <span class="color-label">Noce</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Nude.jpg">
                <span class="color-label">Nude</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Old rose.jpg">
                <span class="color-label">Old rose</span>
            </div>
        </div>

        <div class="row mx-0 my-0 justify-content-center">
            
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Zelená olivová.jpg">
                <span class="color-label">Olive green</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Pastel Blue.jpg">
                <span class="color-label">Pastel blue</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Pastel green.jpg">
                <span class="color-label">Pastel green</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Pastel pink.jpg">
                <span class="color-label">Pastel pink</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Pietra.jpg">
                <span class="color-label">Pietra</span>
            </div>
        </div>
        <div class="row mx-0 my-0 justify-content-center">
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Port wine.jpg">
                <span class="color-label">Port wine</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Rosa.jpg">
                <span class="color-label">Rosa</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/rosebud.jpg">
                <span class="color-label">Rosebud</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Sun.jpg">
                <span class="color-label">Sun</span>
            </div>
            <div class="col mt-1 p-0 mr-md-1">
                <img class="img-responsive" src="imgs/colors/Vino.jpg">
                <span class="color-label">Wine</span>
            </div>
        </div> -->


    </div>
    <div class="row no-gutters mx-0 my-2 justify-content-center">
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
                            <li><a href="index.php?page=colors" class="text-links">Color swatch</a></li>
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