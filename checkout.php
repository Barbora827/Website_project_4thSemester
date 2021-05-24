<?php
// Default values for the input form elements
$account = [
    'first_name' => '',
    'last_name' => '',
    'address_street' => '',
    'address_city' => '',
    'address_zip' => '',
    'address_country' => 'Czech Republic'
];
// Error array, output errors on the form
$errors = [];

// Check if user is logged in
if (isset($_SESSION['account_loggedin'])) {
    $stmt = $pdo->prepare('SELECT * FROM accounts WHERE id = ?');
    $stmt->execute([$_SESSION['account_id']]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);
}
// Make sure the user submits all data and shopping cart is not empty
if (isset($_POST['first_name'], $_POST['last_name'], $_POST['address_street'], $_POST['address_city'], $_POST['address_zip'], $_POST['address_country'], $_SESSION['cart'])) {
    $account_id = null;

    // If the user is already logged in
    if (isset($_SESSION['account_loggedin'])) {
        $stmt = $pdo->prepare('UPDATE accounts SET first_name = ?, last_name = ?, address_street = ?, address_city = ?, address_zip = ?, address_country = ? WHERE id = ?');
        $stmt->execute([$_POST['first_name'], $_POST['last_name'], $_POST['address_street'], $_POST['address_city'], $_POST['address_zip'], $_POST['address_country'], $_SESSION['account_id']]);
        $account_id = $_SESSION['account_id'];
    } 
    
    // User is not logged in, check if the email already exists in database
    else if (isset($_POST['email'], $_POST['password'], $_POST['cpassword']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $stmt = $pdo->prepare('SELECT id FROM accounts WHERE email = ?');
        $stmt->execute([$_POST['email']]);
        // Email exists, user should login
        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            $errors[] = 'Account already exists with this email, please login instead!';
        }

        // Password and confirm password fields do not match
        if ($_POST['password'] != $_POST['cpassword']) {
            $errors[] = 'Passwords do not match!';
        }

        if (!$errors) {
            // Email does not exist yet in the database, create new account
            $stmt = $pdo->prepare('INSERT INTO accounts (email, password, first_name, last_name, address_street, address_city, address_zip, address_country) VALUES (?,?,?,?,?,?,?,?,?)');
            // Hash the password
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt->execute([$_POST['email'], $password, $_POST['first_name'], $_POST['last_name'], $_POST['address_street'], $_POST['address_city'], $_POST['address_zip'], $_POST['address_country']]);
            $account_id = $pdo->lastInsertId();
            $stmt = $pdo->prepare('SELECT * FROM accounts WHERE id = ?');
            $stmt->execute([$account_id]);
    
            $account = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    } else if (account_required) {
        $errors[] = 'Account creation required!';
    }
    if (!$errors) {
        // No errors, process the order
        $products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        $subtotal = 0.00;

      
        if (isset($_POST['checkout']) && $products_in_cart) {
            // Process Normal Checkout
            // Iterate each product in the user's shopping cart
            // Unique transaction ID
            $stmt->execute([
                $subtotal + $shippingtotal,
                'Completed',
                date('Y-m-d H:i:s'),
                isset($account['email']) && !empty($account['email']) ? $account['email'] : $_POST['email'],
                $_POST['first_name'],
                $_POST['last_name'],
                $_POST['address_street'],
                $_POST['address_city'],
                $_POST['address_zip'],
                $_POST['address_country'],
                $account_id,
                'website'
            ]);
            $order_id = $pdo->lastInsertId();

            if ($account_id != null) {
                // Log the user in with the details provided
                session_regenerate_id();
                $_SESSION['account_loggedin'] = TRUE;
                $_SESSION['account_id'] = $account_id;
                $_SESSION['account_admin'] = $account ? $account['admin'] : 0;
            }
            send_order_details_email(
                isset($account['email']) && !empty($account['email']) ? $account['email'] : $_POST['email'],
                $products_in_cart,
                $_POST['first_name'],
                $_POST['last_name'],
                $_POST['address_street'],
                $_POST['address_city'],
                $_POST['address_zip'],
                $_POST['address_state'],
                $_POST['address_country'],
                $subtotal + $shippingtotal,
                $order_id
            );
            header('Location: ' . url('index.php?page=placeorder'));
            exit;
        }
    }
    // Preserve form details if the user encounters an error
    $account = [
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'address_street' => $_POST['address_street'],
        'address_city' => $_POST['address_city'],
        'address_zip' => $_POST['address_zip'],
        'address_country' => $_POST['address_country']
    ];
}
// Redirect the user if the shopping cart is empty
if (empty($_SESSION['cart'])) {
    header('Location: ' . url('index.php?page=cart'));
    exit;
}
// List of countries available, feel free to remove any country from the array
$countries = ["Czech Republic", "Denmark", "Slovakia"];

?>
<?= template_header('Checkout') ?>

<style>
    label {
        display: inline-block;
        text-align: center;
        text-align: right;
        width: 100px;
    }

    input {
        display: inline-block;

    }

    @media (max-width: 535px) {
        label {
            width: 70px;
        }
    }
</style>
<div class="text-center mt-3 mb-5">
    <h1>Checkout</h1>
</div>
<p class="error"><?= implode('<br>', $errors) ?></p>

<div class="row justify-content-center mx-0 mb-5">
    <form action="index.php?page=placeorder" method="post" class="my-5" id="bebas" style="margin-right: 70px;">

        <?php if (!isset($_SESSION['account_loggedin'])) : ?>
            <h2 class="text-center" style="margin-left: 80px">Create Account<?php if (!account_required) : ?> (optional)<?php endif; ?></h2>

            <?php if (!isset($_SESSION['account_loggedin'])) : ?>
                <p class="text-center" style="margin-left: 80px">Already have an account? <a href="<?= url('index.php?page=myaccount') ?>">Log In</a></p>
            <?php endif; ?>
                <label for="email" style="margin-left: 120px">Email</label>
                <input type="email" name="email" id="email" placeholder="john@example.com"><br>

                <label for="password" style="margin-left: 120px">Password</label>
                <input type="password" class="mr-4" name="password" id="password" placeholder="Password"><br>

                <label for="cpassword" style="margin-left: 120px">Confirm Password</label>
                <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password">
        <?php endif; ?>


        <div class="row mt-5">
            <label for="first_name" class="mr-1 mr-lg-3">First Name</label>
            <input type="text" value="<?= $account['first_name'] ?>" name="first_name" id="first_name" placeholder="" required>
            <label for="last_name" class="mr-1 mr-lg-3">Last Name</label>
            <input type="text" value="<?= $account['last_name'] ?>" name="last_name" id="last_name" placeholder="" required>
        </div>

        <div class="row">
            <label for="address_street" class="mr-1 mr-lg-3">Address</label>
            <input type="text" value="<?= $account['address_street'] ?>" name="address_street" id="address_street" placeholder="" required>

            <label for="address_city" class="mr-1 mr-lg-3">City</label>
            <input type="text" value="<?= $account['address_city'] ?>" name="address_city" id="address_city" placeholder="" required>
        </div>

        <div class="row">
            <label for="address_zip" class="mr-1 mr-lg-3">Zip</label>
            <input type="text" value="<?= $account['address_zip'] ?>" name="address_zip" id="address_zip" placeholder="" required>
        </div>

        <label for="address_country">Country</label>
        <select name="address_country" required>
            <?php foreach ($countries as $country) : ?>
                <option value="<?= $country ?>" <?= $country == $account['address_country'] ? ' selected' : '' ?>><?= $country ?></option>
            <?php endforeach; ?>
        </select>
        <br>

        <button type="submit" class="float-right" name="checkout">Place Order</button>

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
        © 2021 Svatby v podhůří
    </div>
</footer>



    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>