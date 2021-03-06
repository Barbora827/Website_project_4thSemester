<?php

if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])) {
    $product_id = (int)$_POST['product_id'];
    $quantity = abs((int)$_POST['quantity']);

    // Get product options
    $options = '';
    $options_price = 0.00;
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'option') !== false) {
            $options .= str_replace('option', '', $k) . $v . ',';
            $stmt = $pdo->prepare('SELECT * FROM products_options WHERE option_type = ? AND name = ? AND product_id = ?');
            $stmt->execute([str_replace('option', '', $k), $v, $product_id]);
            $option = $stmt->fetch(PDO::FETCH_ASSOC);
            $options_price += $option['price'];
        }
    }
    $options = rtrim($options, ',');
  

    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$_POST['product_id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Check if the product even exists
    if ($product && $quantity > 0) {
        // Create cart session
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $cart_product = &get_cart_product($product_id, $options);

        if ($cart_product) {
            // If product is already in the cart, update just the quantity
            $cart_product['quantity'] += $quantity;

        } else {
            // If product is not in the cart, add it
            $_SESSION['cart'][] = [
                'id' => $product_id,
                'quantity' => $quantity,
                'options' => $options,
                'options_price' => $options_price,
            ];
        }
    }
    
    header('location: ' . url('index.php?page=cart'));
    exit;
}
// Remove product from the shopping cart
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    array_splice($_SESSION['cart'], $_GET['remove'], 1);
    header('location: ' . url('index.php?page=cart'));
    exit;
}

// Empty the cart
if (isset($_POST['emptycart']) && isset($_SESSION['cart'])) {
    unset($_SESSION['cart']);
    header('location: ' . url('index.php?page=cart'));
    exit;
}

// Redirect back to productlist to "Continue shopping"
if (isset($_POST['shopping']) && isset($_SESSION['cart'])) {
    header('location: ' . url('productlist.php'));
    exit;
}

// Update product quantities if the user clicks the Update button
if ((isset($_POST['update']) || isset($_POST['checkout'])) && isset($_SESSION['cart'])) {
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) {
            $id = str_replace('quantity-', '', $k);

            // Prevent minus quantity
            $quantity = abs((int)$v);
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                $_SESSION['cart'][$id]['quantity'] = $quantity;
            }
        }
    }

    // Send the user to the place order page if they click the Place Order button and the cart is not empty
    if (isset($_POST['checkout']) && !empty($_SESSION['cart'])) {
        header('Location: ' . url('index.php?page=checkout'));
        exit;
    }
    header('location: ' . url('index.php?page=cart'));
    exit;
}

// Check the session variable for products in cart
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$subtotal = 0.00;


if ($products_in_cart) {

    // There are products in the cart so we need to select those products from the database
    $array = implode(',', array_fill(0, count($products_in_cart), '?'));
    $stmt = $pdo->prepare('SELECT p.id, p.category, p.* FROM products p WHERE p.id IN (' . $array . ') GROUP BY p.id');
    $stmt->execute(array_column($products_in_cart, 'id'));
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Iterate the products in cart 
    foreach ($products_in_cart as &$cart_product) {
        foreach ($products as $product) {
            if ($cart_product['id'] == $product['id']) {
                $cart_product['product'] = $product;
                
                // Calculate the price
                $product_price = $cart_product['options_price'] > 0 ? (float)$cart_product['options_price'] : (float)$product['price'];
                $subtotal += $product_price * (int)$cart_product['quantity'];
            }
        }
    }
}
?>
<?= template_header('Shopping Cart') ?>

<style>
    .remove {
        font-size: 18px;
        color: #800020;
    }

    .remove:hover {
        color: #ca0033;
        text-decoration: none;
    }

    #tableheader {
        font-size: 2rem;
    }

    @media (max-width: 991.98px) {
        #tableheader {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        #tableheader {
            font-size: 1rem;
        }
    }

    .subtotal {
        text-align: right;
        padding-right: 30px;
    }
</style>
<div class="cart content-wrapper">

    <h1 class="text-center my-5">Shopping Cart</h1>
    <div class="row justify-content-center mx-0">
        <form action="" method="post">
            <table class="table-responsive table-bordered mx-0">
                <thead class="table-dark" id="tableheader">
                    <tr>
                        <td class="text-center px-5 px-lg-5" colspan="2">Product</td>
                        <td class="text-center px-4 px-lg-5">Color</td>
                        <td class="text-center px-4 px-lg-5">Price</td>
                        <td class="text-center px-4 px-lg-5">Quantity</td>
                        <td class="text-center px-4 px-lg-5">Total</td>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($products_in_cart)) : ?>
                        <tr>
                            <td colspan="6" id="bebas" class="py-3" style="text-align:center; font-size: 20px">You have no products added in your Shopping Cart</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($products_in_cart as $num => $product) : ?>
                            <tr>
                                <td class="img">
                                    <a href="<?= url('index.php?page=product&id=' . $product['id']) ?>">
                                        <img src="<?= base_url ?>imgs/<?= $product['product']['img'] ?>" style="height: 150px; width: 150px;" alt="<?= $product['product']['name'] ?>">
                                    </a>
                                </td>
                                <td>
                                    <a href="<?= url('index.php?page=product&id=' . $product['id']) ?>" id="bebas" class="px-2" style="font-size: 18px; color: #343e40"><?= $product['product']['name'] ?></a>
                                    <br>
                                    <a href="<?= url('index.php?page=cart&remove=' . $num) ?>" id="bebas" class="px-2 remove">Remove</a>
                                </td>
                                <td class="price px-2" id="bebas" style="font-size: 18px; text-align: center">
                                    <?= $product['options'] ?>
                                    <input type="hidden" name="options" value="<?= $product['options'] ?>">
                                </td>
                                <td class="price" id="bebas" style="font-size: 22px; text-align: center"><?= number_format($product['product']['price'], 2) ?> <?= currency_code ?></td>
                                <td class="quantity text-center" id="bebas">
                                    <input type="number" class="ajax-update" name="quantity-<?= $num ?>" value="<?= $product['quantity'] ?>" min="1" <?php if ($product['product']['quantity'] != -1) : ?>max="<?= $product['product']['quantity'] ?>" <?php endif; ?> placeholder="Quantity" required>
                                </td>
                                <td class="price product-total text-center" id="bebas" style="font-size: 22px; text-align: center"><?= number_format($product['product']['price'] * $product['quantity'], 2) ?> <?= currency_code ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>



            <div class="subtotal mt-3" id="bebas" style="font-size: 25px">
                <span class="text">Total</span>
                <span class="price"><?= number_format($subtotal, 2) ?> <?= currency_code ?></span>
            </div>


            <div class="buttons my-5" id="bebas" style="float:right">
                <input type="submit" value="Continue shopping" name="shopping">
                <input type="submit" value="Update cart" name="update">
                <input type="submit" value="Empty cart" name="emptycart">
                <input type="submit" value="Checkout" name="checkout">
            </div>


        </form>


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
            ?? 2021 Svatby v podh??????
        </div>
    </footer>



    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>