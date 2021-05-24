<?php

// Check to make sure the id parameter is specified in the URL
if (isset($_GET['id'])) {
  $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
  $stmt->execute([$_GET['id']]);
  // Fetch the product from the database and return it as array
  $product = $stmt->fetch(PDO::FETCH_ASSOC);
  
  // Check if the product even exists
  if (!$product) {
    http_response_code(404);
    exit('Product does not exist!');
  }
  // Select the product options (if any) from the products_options table
  $stmt = $pdo->prepare('SELECT option_type, GROUP_CONCAT(name) AS options FROM products_options WHERE product_category = ? GROUP BY option_type');
  $stmt->execute([$product['option_category']]);
  // Fetch the product options from the database and return them as array
  $product_options = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<?= template_header($product['name']) ?>

<style>
  @media (min-width: 992px) {

    .ml-lg-13 {
      margin-left: 13rem !important;
    }
  }

  #image-product {
    height: 500px;
    width: 500px;
  }

  .product-name {
    font-size: 60px;
  }

  @media (max-width: 992px) {
    #image-product {
      height: 400px;
      width: 400px;
    }
  }

  @media (max-width: 1038px) {
    .product-name {
      font-size: 45px;
    }
  }


  @media (max-width: 844px) {
    .product-name {
      font-size: 40px;
    }
  }

  .btn-outline-dark {
    border-radius: 3px;
  }

  .btn-outline-beige {
    background-color: #343a40;
    color: #f4f3ef;
    border-color: #343a40;
    border-radius: 3px;
  }

  .btn-outline-beige:hover {
    background-color: #343a40;
    color: #ddac8f;
    border-color: #343a40;
    border-radius: 3px;

  }
</style>


<!--Breadcrumbs-->
<nav aria-label="breadcrumb">
  <ol class="breadcrumb ml-lg-13 ml-5 mt-5" id="bebas">
    <li class="breadcrumb-item"><a href="index.php">Main page</a></li>
    <li class="breadcrumb-item"><a href="productlist.php">Products</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= $product['name'] ?></li>
  </ol>
</nav>



<div class="product content-wrapper" id="bebas">
  <div class="row flex-wrap mx-0">
    <div class="col col-xl px-0">
      <img class="mt-3 mt-lg-0 mb-5 mx-5 ml-lg-13" id="image-product" src="<?= base_url ?>imgs/<?= $product['img'] ?>" alt="<?= $product['name'] ?>">
    </div>

    <div class="col col-lg">
      <div class="product-wrapper ml-4 ml-lg-0">

        <h1 class="product-name"><?= $product['name'] ?></h1>

        <span class="price" style="font-size: 30px;">
          <?= number_format($product['price'], 2) ?> <?= currency_code ?>
        </span><br>
        <a href="index.php?page=colors" target="_blank"><button class="btn-outline-dark mt-3 mb-5" style="font-size: 20px; cursor:pointer;">Color swatches</button></a>

        <form id="product-form" action="<?= url('index.php?page=cart') ?>" method="post">
          <input class="mt-2 mr-1" type="number" name="quantity" value="1" min="1" <?php if ($product['quantity'] != -1) : ?>max="<?= $product['quantity'] ?>" <?php endif; ?> placeholder="Quantity" required>
          <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
          <?php foreach ($product_options as $option) : ?>
            <select name="option" class="mt-3 mb-2" style="font-size: 18px;" required>
              <option value="" selected disabled style="display:none"><?= $option['option_type'] ?></option>
              <?php
              $options_names = explode(',', $option['options']);
              ?>
              <?php foreach ($options_names as $k => $name) : ?>
                <option value="<?= $name ?>"><?= $name ?></option>
              <?php endforeach; ?>
            </select>
          <?php endforeach; ?>
          <br>
          <?php if ($product['quantity'] == 0) : ?>
            <input type="submit" value="Out of Stock" disabled>
          <?php else : ?>
            <input type="submit" class="btn-outline-beige mt-2" style="font-size: 20px; cursor: pointer;" value="Add To Cart">
          <?php endif; ?>
        </form>
        <div class="description mr-5 mt-3" id="bhavuka">
          <?= $product['description'] ?>
        </div>
      </div>
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