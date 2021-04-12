<?php
// The amounts of products to show on each page
$num_products_on_each_page = 30;
// The current page, in the URL this will appear as index.php?page=products&p=1, index.php?page=products&p=2, etc...
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
// Select products ordered by the date added
$stmt = $pdo->prepare("SELECT * FROM bows ORDER BY id DESC LIMIT ?,?");
// bindValue will allow us to use integer in the SQL statement, we need to use for LIMIT
$stmt->bindValue(1, ($current_page - 1) * $num_products_on_each_page, PDO::PARAM_INT);
$stmt->bindValue(2, $num_products_on_each_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the products from the database and return the result as an Array
$bows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of products
$total_products = $pdo->query('SELECT * FROM bows')->rowCount();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title style="font-family:'Oswald', sans-serif;">Svatby v podhůří</title>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link
    href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Berkshire+Swash&family=Josefin+Sans:wght@300;700&family=Kaushan+Script&family=Oswald:wght@300;600&family=Poiret+One&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/styles.css">
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
              <a class="nav-link mb-1" id="mainnav-item" href="index.html">Hlavní stránka<span
                  class="sr-only"></span></a>
            </li>
            <li class="nav-item my-1"><a class="nav-link" id="mainnav-item" href="index.html">O nás<span
                  class="sr-only"></span></a></li>
            <li class="nav-item my-1"><a class="nav-link" id="mainnav-item" href="objednavka.html">Objednávka<span
                  class="sr-only"></span></a></li>
            <li class="nav-item my-1"><a class="nav-link" id="mainnav-item" href="nabidka.html">Nabídka<span
                  class="sr-only"></span></a></li>
            <li class="nav-item my-1"><a class="nav-link" id="mainnav-item" href="cenik.html">Ceník<span
                  class="sr-only"></span></a></li>
            <li class="nav-item my-1"><a class="nav-link" id="mainnav-item" href="index.html">Kontakt<span
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
  <a class="btn btn-outline-dark btn-floating m-1 social-icon" id="socialicon-f"
    href="https://www.facebook.com/svatbyvpodhuri" role="button"><i class="fa fa-facebook-f"></i></a>
  <a class="btn btn-outline-dark btn-floating m-1 social-icon" id="socialicon-i"
    href="https://www.instagram.com/svatbyvpodhuri" role="button"><i class="fa fa-instagram"></i></a>
  <a class="btn btn-outline-dark btn-floating m-1 social-icon" id="socialicon-e" href="#!" role="button"><i
      class="fa fa-envelope"></i></a>
  <button class="btn btn-outline-dark" id="shopcart">
    <i class="fa fa-shopping-cart"></i>
  </button>

  <!-- Heading Container -->
  <div class="container text-center my-10">
    <div class="row mx-0 justify-content-center">
      <a href="/"><img src="img/logo.png" class="img-2 mx-0 mt-10"></a>
      <h1 class="mt-5 mr-2" id="portfolio-header">Bows</h1>
    </div>

    <!--Breadcrumbs-->
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb" id="bebas">
        <li class="breadcrumb-item"><a href="index.php">Main page</a></li>
        <li class="breadcrumb-item"><a href="portfolio.html">Products</a></li>
        <li class="breadcrumb-item active" aria-current="page">Bows</li>
      </ol>
    </nav>


    <!--Gallery-->
    <section id="gallery">
      <div class="container">
        <div class="row">
        <?php foreach ($bows as $bow): ?>
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="card">
            <img src="img/<?=$bow['img']?>" class="card-img-top" alt="<?=$bow['name']?>">
              <div class="card-body">
              <span class="name"><?=$bow['name']?></span><br>
            <span class="price">
                &dollar;<?=$bow['price']?>
                <?php if ($bow['rrp'] > 0): ?>
                <span class="rrp">&dollar;<?=$bow['rrp']?></span>
                <?php endif; ?>
            </span>
        <br>
        <form action="index.php?page=cart" method="post">
            <input type="number" class="mt-2" name="quantity" value="1" min="1" max="<?=$bow['quantity']?>" placeholder="Quantity" required>
            <input type="hidden" name="product_id" value="<?=$bow['id']?>"><br>
            <input type="submit" class="btn mt-3 btn-outline-dark btn-sm" value="Add To Cart">
        </form>
              </div>
            </div>
          </div>
          <?php endforeach; ?>

         <!-- <div class="col-md-6 col-lg-4 mb-4">
            <div class="card">
              <img src="img/vyvazky_rosegold.jpg" alt="" class="card-img-top">
              <div class="card-body">
                <h5 class="card-title">Rosegold vývazky</h5>
                <p class="card-text">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ut eum similique repellat
                  a laborum, rerum voluptates ipsam eos quo tempore iusto dolore modi dolorum in pariatur. Incidunt
                  repellendus praesentium quae!</p>
                <a href="" class="btn btn-outline-dark btn-sm">Přidat do košíku</a>
                <a href="" class="btn btn-outline-rose btn-sm"><i class="fa fa-heart"></i></a>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="card">
              <img src="img/vyvazky_cervene.JPG" alt="" class="card-img-top">
              <div class="card-body">
                <h5 class="card-title">Červeno-meruňkové vývazky</h5>
                <p class="card-text">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ut eum similique repellat
                  a laborum, rerum voluptates ipsam eos quo tempore iusto dolore modi dolorum in pariatur. Incidunt
                  repellendus praesentium quae!</p>
                <a href="" class="btn btn-outline-dark btn-sm">Přidat do košíku</a>
                <a href="" class="btn btn-outline-rose btn-sm"><i class="fa fa-heart"></i></a>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="card">
              <img src="img/vyvazky_modre.JPG" alt="" class="card-img-top">
              <div class="card-body">
                <h5 class="card-title">Bledě modré vývazky</h5>
                <p class="card-text">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ut eum similique repellat
                  a laborum, rerum voluptates ipsam eos quo tempore iusto dolore modi dolorum in pariatur. Incidunt
                  repellendus praesentium quae!</p>
                <a href="" class="btn btn-outline-dark btn-sm">Přidat do košíku</a>
                <a href="" class="btn btn-outline-rose btn-sm"><i class="fa fa-heart"></i></a>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="card">
              <img src="img/vyvazky_zelene.JPG" alt="" class="card-img-top">
              <div class="card-body">
                <h5 class="card-title">Zelené vývazky</h5>
                <p class="card-text">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ut eum similique repellat
                  a laborum, rerum voluptates ipsam eos quo tempore iusto dolore modi dolorum in pariatur. Incidunt
                  repellendus praesentium quae!</p>
                <a href="" class="btn btn-outline-dark btn-sm">Přidat do košíku</a>
                <a href="" class="btn btn-outline-rose btn-sm"><i class="fa fa-heart"></i></a>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="card">
              <img src="img/vyvazky_sede.jpg" alt="" class="card-img-top">
              <div class="card-body">
                <h5 class="card-title">Stříbrné vývazky</h5>
                <p class="card-text">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ut eum similique repellat
                  a laborum, rerum voluptates ipsam eos quo tempore iusto dolore modi dolorum in pariatur. Incidunt
                  repellendus praesentium quae!</p>
                <a href="" class="btn btn-outline-dark btn-sm">Přidat do košíku</a>
                <a href="" class="btn btn-outline-rose btn-sm"><i class="fa fa-heart"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div> -->
    </section>


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


  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
    integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
    crossorigin="anonymous"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
