<?php
$stmt = $pdo->prepare("SELECT * FROM products WHERE category='namecard'");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

<?= template_header('Home') ?>

<!-- Heading Container -->
<div class="container text-center my-10">
  <div class="row mx-0 justify-content-center">
    <a href="index.php"><img src="img/logo.png" class="img-2" style="margin-top: 110px;"></a>
    <h1 class="mr-2" style="margin-top: 70px;" id="portfolio-header">Name cards</h1>
  </div>

  <!--Breadcrumbs-->
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb" id="bebas">
      <li class="breadcrumb-item"><a href="index.php">Main page</a></li>
      <li class="breadcrumb-item"><a href="productlist.php">Products</a></li>
      <li class="breadcrumb-item active" aria-current="page">Name cards</li>
    </ol>
  </nav>

  <div class="product-card content-wrapper" style="margin-top: -30px; margin-bottom: 200px;">
    <div class="products my-0">
      <div class="row justify-content-center ">
        <?php foreach ($products as $product) : ?>
          <div class="col-6 col-lg-3 my-4">
            <a href="<?= url('index.php?page=product&id=' . ($product['id'])) ?>" class="product">
              <?php if (!empty($product['img']) && file_exists('imgs/' . $product['img'])) : ?>
                <img src="imgs/<?= $product['img'] ?>" width="200" height="200" alt="<?= $product['name'] ?>">
              <?php endif; ?>
              <span class="name mt-2" id="bebas" style="font-size: 20px; color:#343a40"><?= $product['name'] ?></span><br>
              <span class="price" id="bebas" style="font-size: 20px; color:#343a40">
                <?= currency_code ?><?= number_format($product['price'], 2) ?>
              </span>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  </main>

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
              <li><a href="colors.php" class="text-links">Color swatch</a></li>
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