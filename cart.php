<!--INSERT INTO `products` (`id`, `name`, `descript`, `price`, `rrp`, `quantity`, `img`, `date_added`) VALUES
(2, 'Green bows', 'bow', '9.99', '0.00', 50, 'vyvazky_zelene.jpg', '2019-03-13 18:52:49'),
(3, 'Silver bows', 'bow', '9.99', '0.00', 50, 'vyvazky_sede.jpg', '2019-03-13 18:47:56'),
(4, 'Red envelope', 'envelope', '14.99', '0.00', 50, 'obalka_red.jpg', '2019-03-13 17:42:04'),
(5, 'Royal blue envelope', 'envelope', '14.99', '0.00', 50, 'obalka_red.jpg', '2019-03-13 17:42:04'),
(6, 'Gold envelope', 'envelope', '14.99', '0.00', 50, 'obalka_red.jpg', '2019-03-13 17:42:04'); -->

<?php
// If the user clicked the add to cart button on the product page we can check for the form data
if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])) {
    // Set the post variables so we easily identify them, also make sure they are integer
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    // Prepare the SQL statement, we basically are checking if the product exists in our databaser
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$_POST['product_id']]);
    // Fetch the product from the database and return the result as an Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the product exists (array is not empty)
    if ($product && $quantity > 0) {
        // Product exists in database, now we can create/update the session variable for the cart
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            if (array_key_exists($product_id, $_SESSION['cart'])) {
                // Product exists in cart so just update the quanity
                $_SESSION['cart'][$product_id] += $quantity;
            } else {
                // Product is not in cart so add it
                $_SESSION['cart'][$product_id] = $quantity;
            }
        } else {
            // There are no products in cart, this will add the first product to cart
            $_SESSION['cart'] = array($product_id => $quantity);
        }
    }
    // Prevent form resubmission...
    header('location: index.php?page=cart');
    exit;
}

// Remove product from cart, check for the URL param "remove", this is the product id, make sure it's a number and check if it's in the cart
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    // Remove the product from the shopping cart
    unset($_SESSION['cart'][$_GET['remove']]);
}

// Update product quantities in cart if the user clicks the "Update" button on the shopping cart page
if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    // Loop through the post data so we can update the quantities for every product in cart
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) {
            $id = str_replace('quantity-', '', $k);
            $quantity = (int)$v;
            // Always do checks and validation
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                // Update new quantity
                $_SESSION['cart'][$id] = $quantity;
            }
        }
    }
    // Prevent form resubmission...
    header('location: index.php?page=cart');
    exit;
}

// Send the user to the place order page if they click the Place Order button, also the cart should not be empty
if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    header('Location: index.php?page=placeorder');
    exit;
}

// Check the session variable for products in cart
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;
// If there are products in cart
if ($products_in_cart) {
    // There are products in the cart so we need to select those products from the database
    // Products in cart array to question mark string array, we need the SQL statement to include IN (?,?,?,...etc)
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id IN (' . $array_to_question_marks . ')');
    // We only need the array keys, not the values, the keys are the id's of the products
    $stmt->execute(array_keys($products_in_cart));
    // Fetch the products from the database and return the result as an Array
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Calculate the subtotal
    foreach ($products as $product) {
        $subtotal += (float)$product['price'] * (int)$products_in_cart[$product['id']];
    }
}
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
                            <a class="nav-link mb-1" id="mainnav-item" href="index.html">Hlavní stránka<span class="sr-only"></span></a>
                        </li>
                        <li class="nav-item my-1"><a class="nav-link" id="mainnav-item" href="index.html">O nás<span class="sr-only"></span></a></li>
                        <li class="nav-item my-1"><a class="nav-link" id="mainnav-item" href="objednavka.html">Objednávka<span class="sr-only"></span></a></li>
                        <li class="nav-item">
                            <a class="nav-link mb-1" id="mainnav-item" href="cenik.html">Ceník<span class="sr-only"></span></a>
                        </li>
                        <li class="nav-item my-1"><a class="nav-link" id="mainnav-item" href="index.html">Kontakt<span class="sr-only"></span></a></li>
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
    <button class="btn btn-outline-dark" id="shopcart">
        <i class="fa fa-shopping-cart"></i>
    </button>



    <!-- Heading Container -->
    <div class="container text-center" style="margin-top: 130px;">
        <div class="row mx-0 justify-content-center">
            <a href="/"><img src="img/logo.png" class="img-2 mt-10"></a>
        </div>

        <!--Breadcrumbs-->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" id="bebas">
                <li class="breadcrumb-item"><a href="index.php">Main page</a></li>
                <li class="breadcrumb-item"><a href="productlist.php">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shopping cart</li>
            </ol>
        </nav>


        <div class="cart content-wrapper">
            <h1 class="mb-5">Shopping Cart</h1>
            <form action="index.php?page=cart" method="post">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr style="font-size: 20px;">
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($products)) : ?>
                                <tr>
                                    <td colspan="5" style="text-align:center; font-size: 20px;" id="bebas">You have no products added in your Shopping Cart</td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($products as $product) : ?>
                                    <tr>
                                        <td class="img">
                                                <img src="img/<?= $product['img'] ?>" style="height: 130px; width: 150px; margin-left: 50px" alt="<?= $product['name'] ?>">
                                           
                                            <a href="index.php?page=cart&remove=<?= $product['id'] ?>" class="remove ml-2" style="color:#bb183b; text-decoration: none; font-size: 18px;" id="bebas">Remove</a><br>
                                            <a href="index.php?page=product&id=<?= $product['id'] ?>" style="color: black; font-size: 18px;" id="bebas"><?= $product['name'] ?></a>
                                            
                                        </td>
                                        <td class="price" id="bebas" style="font-size: 20px;">&dollar;<?= $product['price'] ?></td>
                                        <td class="quantity">
                                            <input type="number" id="bebas" name="quantity-<?= $product['id'] ?>" value="<?= $products_in_cart[$product['id']] ?>" min="1" max="<?= $product['quantity'] ?>" placeholder="Quantity" required>
                                        </td>
                                        <td class="price" id="bebas" style="font-size: 20px;">&dollar;<?= $product['price'] * $products_in_cart[$product['id']] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <div class="subtotal mb-2">
                        <span class="text" id="bebas" style="font-size: 25px;">Subtotal</span>
                        <span class="price" id="bebas" style="font-size: 25px;">&dollar;<?= $subtotal ?></span>
                    </div>
                
                    <div class="buttons">
                        <input type="submit" id="bebas" style="cursor: pointer; font-size: 20px;" value="Update" name="update">
                        <input type="submit" id="bebas" style="cursor: pointer; font-size: 20px;" value="Place Order" name="placeorder">
                    </div>
            </form>
        </div>
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


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>