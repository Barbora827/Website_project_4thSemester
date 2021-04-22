<?php

// Check to make sure the id parameter is specified in the URL
if (isset($_GET['id'])) {
    // Prepare statement and execute, prevents SQL injection
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ? OR url_structure = ?');
    $stmt->execute([$_GET['id'], $_GET['id']]);
    // Fetch the product from the database and return the result as an Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the product exists (array is not empty)
    if (!$product) {
        // Output simple error if the id for the product doesn't exists (array is empty)
        http_response_code(404);
        exit('Product does not exist!');
    }
    // Select the product images (if any) from the products_images table
    $stmt = $pdo->prepare('SELECT * FROM products_images WHERE product_id = ?');
    $stmt->execute([$product['id']]);
    // Fetch the product images from the database and return the result as an Array
    $product_imgs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Select the product options (if any) from the products_options table
    $stmt = $pdo->prepare('SELECT title, GROUP_CONCAT(name) AS options, GROUP_CONCAT(price) AS prices FROM products_options WHERE product_category = ? GROUP BY title');
    $stmt->execute([$product['broad_category']]);
    // Fetch the product options from the database and return the result as an Array
    $product_options = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Add the HTML meta data (for SEO purposes)
    $meta = '
        <meta property="og:url" content="' . url('index.php?page=product&id=' . ($product['url_structure'] ? $product['url_structure']  : $product['id'])) . '">
        <meta property="og:title" content="' . $product['name'] . '">
    ';
    if (!empty($product['img']) && file_exists('imgs/' . $product['img'])) {
        $meta .= '<meta property="og:image" content="' . base_url . 'imgs/' . $product['img'] . '">';
    }
} else {
    // Output simple error if the id wasn't specified
    http_response_code(404);
    exit('Product does not exist!');
}
?>
<?= template_header($product['name'], $meta) ?>


<div class="product content-wrapper" id="bebas">
    <div class="row mt-5 mx-0">
        <div class="col-5">
            <img class="product-img-large mb-5" src="<?= base_url ?>imgs/<?= $product['img'] ?>" style="width: 400px; height: 400px; margin-left: 230px;" alt="<?= $product['name'] ?>">

        </div>

        <div class="col-5 ml-2">
            <div class="product-wrapper">

                <h1 class="name" style="font-size: 60px;"><?= $product['name'] ?></h1>

                <span class="price" style="font-size: 30px;">
                    <?= currency_code ?><?= number_format($product['price'], 2) ?>
                    <?php if ($product['rrp'] > 0) : ?>
                        <span class="rrp"><?= currency_code ?><?= number_format($product['rrp'], 2) ?></span>
                    <?php endif; ?>
                </span>

                <form id="product-form" action="<?= url('index.php?page=cart') ?>" method="post">
                    <input class="mt-2 mr-1" type="number" name="quantity" value="1" min="1" <?php if ($product['quantity'] != -1) : ?>max="<?= $product['quantity'] ?>" <?php endif; ?> placeholder="Quantity" required>
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <?php foreach ($product_options as $option) : ?>
                        <select name="option-<?= $option['title'] ?>" class="mt-3" style="font-size: 18px;" required>
                            <option value="" selected disabled style="display:none"><?= $option['title'] ?></option>
                            <?php
                            $options_names = explode(',', $option['options']);
                            $options_prices = explode(',', $option['prices']);
                            ?>
                            <?php foreach ($options_names as $k => $name) : ?>
                                <option value="<?= $name ?>" data-price="<?= $options_prices[$k] ?>"><?= $name ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php endforeach; ?>
                    <br>
                    <?php if ($product['quantity'] == 0) : ?>
                        <input type="submit" value="Out of Stock" disabled>
                    <?php else : ?>
                        <input type="submit" class="btn-outline-dark mt-2" style="font-size: 20px; cursor: pointer;" value="Add To Cart">
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
                    <h5 class="text-uppercase" id="odkazy">Navigace</h5>

                    <ul class="list-unstyled mb-0">
                        <li><a href="#!" class="text-links">Hlavní stránka</a></li>
                        <li><a href="#!" class="text-links">Nabídka</a></li>
                        <li><a href="#!" class="text-links">Portfolio</a></li>
                        <li><a href="#!" class="text-links">Objednávkový formulář</a></li>
                        <li><a href="#!" class="text-links">Napište nám</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase" id="odkazy">Užitečné odkazy</h5>

                    <ul class="list-unstyled mb-0">
                        <li><a href="#!" class="text-links">Podmínky užití</a></li>
                        <li><a href="#!" class="text-links">Ochrana osobních údajů</a></li>
                        <li><a href="#!" class="text-links">FAQ</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase" id="odkazy">Kontakt</h5>

                    <ul class="list-unstyled mb-0">
                        <a class="btn btn-outline-light btn-floating m-1" href="https://www.facebook.com/svatbyvpodhuri" style="padding-left: 13px; padding-right: 13px;" role="button"><i class="fa fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-floating m-1" href="https://www.instagram.com/svatbyvpodhuri" role="button"><i class="fa fa-instagram"></i></a>
                        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fa fa-envelope"></i></a>
                        <li><a href="#!" class="text-links">+420 721 046 729</a></li>
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