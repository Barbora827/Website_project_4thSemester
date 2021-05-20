<?php
// User clicked the "Login" button, proceed with the login process... check POST data and validate email
if (isset($_POST['login'], $_POST['email'], $_POST['password']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    // Check if the account exists
    $stmt = $pdo->prepare('SELECT * FROM accounts WHERE email = ?');
    $stmt->execute([ $_POST['email'] ]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);
    // If account exists verify password
    if ($account && password_verify($_POST['password'], $account['password'])) {
        // User has logged in, create session data
        session_regenerate_id();
        $_SESSION['account_loggedin'] = TRUE;
        $_SESSION['account_id'] = $account['id'];
        $_SESSION['account_admin'] = $account['admin'];
        $products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        if ($products_in_cart) {
            // user has products in cart, redirect them to the checkout page
            header('Location: ' . url('index.php?page=checkout'));
        } else {
            header('Location: ' . url('index.php'));
        }
        exit;
    } else {
        $error = 'Incorrect Email/Password!';
    }
}
// Variable that will output registration errors
$register_error = '';
// User clicked the "Register" button, proceed with the registration process... check POST data and validate email
if (isset($_POST['register'], $_POST['email'], $_POST['password'], $_POST['cpassword']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    // Check if the account exists
    $stmt = $pdo->prepare('SELECT * FROM accounts WHERE email = ?');
    $stmt->execute([ $_POST['email'] ]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($account) {
        // Account exists!
        $register_error = 'Account already exists with this email!';
    } else if ($_POST['cpassword'] != $_POST['password']) {
        $register_error = 'Passwords do not match!';
    } else {
        // Account doesnt exist, create new account
        $stmt = $pdo->prepare('INSERT INTO accounts (email, password, first_name, last_name, address_street, address_city, address_state, address_zip, address_country) VALUES (?,?,"","","","","","","")');
        // Hash the password
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt->execute([ $_POST['email'], $password ]);
        $account_id = $pdo->lastInsertId();
        // Automatically login the user
        session_regenerate_id();
        $_SESSION['account_loggedin'] = TRUE;
        $_SESSION['account_id'] = $account_id;
        $_SESSION['account_admin'] = 0;
        $products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
        if ($products_in_cart) {
            // User has products in cart, redirect them to the checkout page
            header('Location: ' . url('index.php?page=checkout'));
        } else {
            // Redirect the user back to the same page, they can then see their order history
            header('Location: ' . url('index.php'));
        }
        exit;
    }
}
?>
<?=template_header('My Account')?>

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

<div class="myaccount content-wrapper my-5 mx-0" id="bebas">

    <?php if (!isset($_SESSION['account_loggedin'])): ?>

    <div class="row justify-content-center login-register mx-0">

        <div class="col col-lg-3 login text-center mb-5">

            <h1 class="mb-4">Login</h1>

            <form action="" method="post">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="john@example.com" required><br>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" required><br>
                <input name="login" class="mt-4 mb-4" type="submit" value="Login">
            </form>

            <?php if ($error): ?>
            <p class="error"><?=$error?></p>
            <?php endif; ?>

        </div>

        <div class="col col-lg-3 register text-center">

            <h1 class="mb-4">Register</h1>

            <form action="" method="post">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="john@example.com" required><br>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" required><br>
                <label for="cpassword">Confirm Password</label>
                <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password" required><br>
                <input name="register" class="mt-4" type="submit" value="Register">
            </form>

            <?php if ($register_error): ?>
            <p class="error"><?=$register_error?></p>
            <?php endif; ?>

        </div>

    </div>

    <?php endif; ?>

</div>
</main>

   <!-- Footer -->
<footer class="bg-dark mt-5 text-center text-white">
    <div class="container p-5">

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