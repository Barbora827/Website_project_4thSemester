<?php
// Function that will connect to the MySQL database
function pdo_connect_mysql()
{
    try {
        // Connect to the MySQL database using PDO...
        return new PDO('mysql:host=' . db_host . ';dbname=' . db_name . ';charset=utf8', db_user, db_pass);
    } catch (PDOException $exception) {
        // Could not connect to the MySQL database, if this error occurs make sure you check your db settings are correct!
        exit('Failed to connect to database!');
    }
}
// Function to retrieve a product from cart by the ID and options string
function &get_cart_product($id, $options)
{
    $p = null;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as &$product) {
            if ($product['id'] == $id && $product['options'] == $options) {
                $p = &$product;
                return $p;
            }
        }
    }
    return $p;
}
// Send order details email function
function send_order_details_email($email, $products, $first_name, $last_name, $address_street, $address_city, $address_state, $address_zip, $address_country, $subtotal, $order_id)
{
    if (!mail_enabled) {
        return;
    }
    $subject = 'Order Details';
    $headers = 'From: ' . mail_from . "\r\n" . 'Reply-To: ' . mail_from . "\r\n" . 'Return-Path: ' . mail_from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
    ob_start();
    include 'order-details-template.php';
    $order_details_template = ob_get_clean();
    mail($email, $subject, $order_details_template, $headers);
}
// Template header, feel free to customize this
function template_header($title, $head = '')
{
    // Get the amount of items in the shopping cart, this will be displayed in the header.
    $num_items_in_cart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
    $home_link = url('index.php');
    $products_link = url('index.php?page=products');
    $myaccount_link = url('index.php?page=myaccount');
    $cart_link = url('index.php?page=cart');
    $admin_link = isset($_SESSION['account_loggedin']) && $_SESSION['account_admin'] ? '<a href="' . base_url . 'admin/index.php" target="_blank">Admin</a>' : '';
    $logout_link = isset($_SESSION['account_loggedin']) ? '<a title="Logout" href="' . url('index.php?page=logout') . '"><i class="fas fa-sign-out-alt"></i></a>' : '';
    $site_name = site_name;
    $base_url = base_url;
    echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,minimum-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>$title</title>
        <link rel="icon" type="image/png" href="{$base_url}favicon.png">
		<link href="{$base_url}style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <title style="font-family:'Oswald', sans-serif;">Svatby v podhůří</title>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Berkshire+Swash&family=Josefin+Sans:wght@300;700&family=Kaushan+Script&family=Oswald:wght@300;600&family=Poiret+One&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/styles.css">
        $head
	</head>
	<body>
    <!--Navbar-->
    <nav class="navbar navbar-expand-md" style="height: 60px;">
        <div class="container mr-2 mr-sm-0">
            <button class="btn btn-outline-dark navbar-toggler" id="side-toggler"
                style="position: absolute; left: 15px; top: 15px;" type="button" data-toggle="collapse"
                data-target="#sidebar-side" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <button class="btn btn-outline-dark" id="shopcart">
                <i class="fa fa-shopping-cart"></i>
            </button>

            <!--Collapsing sidebar-->

            <div class="collapse" id="sidebar-side" style="background-color: #f4f3ef;">
                <div class="navbar-nav ml-auto">
                    <ul class="navbar-nav">
                        <li class="nav-item mb-1">
                            <a class="nav-link" id="mainnav-item" href="index.php">Home<span
                                    class="sr-only"></span></a>
                        </li>
                        <li class="nav-item"><a class="nav-link" id="mainnav-item" href="about.php">About us<span
                                    class="sr-only"></span></a></li>
                        <li class="nav-item"><a class="nav-link" id="mainnav-item" href="productlist.php">Products<span
                                    class="sr-only"></span></a></li>
                        <li class="nav-item"><a class="nav-link" id="mainnav-item" href="portfolio.php">Portfolio<span
                                    class="sr-only"></span></a></li>
                        <li class="nav-item"><a class="nav-link" id="mainnav-item" href="colors.php">Color swatch<span
                                    class="sr-only"></span></a></li>
                        <li class="nav-item"><a class="nav-link" id="mainnav-item" href="howto.php">How to order<span
                                    class="sr-only"></span></a></li>
                        <li class="nav-item"><a class="nav-link" id="mainnav-item" href="contact.php">Contact us<span
                                    class="sr-only"></span></a></li>
                    </ul>
                </div>
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
        <main>
EOT;
}

// Template admin header
function template_admin_header($title, $selected = 'orders')
{
    $admin_links = '
        <a href="index.php?page=dashboard"' . ($selected == 'dashboard' ? ' class="selected"' : '') . '><i class="fas fa-tachometer-alt"></i>Dashboard</a>
        <a href="index.php?page=orders"' . ($selected == 'orders' ? ' class="selected"' : '') . '><i class="fas fa-shopping-cart"></i>Orders</a>
        <a href="index.php?page=products"' . ($selected == 'products' ? ' class="selected"' : '') . '><i class="fas fa-box-open"></i>Products</a>
        <a href="index.php?page=categories"' . ($selected == 'categories' ? ' class="selected"' : '') . '><i class="fas fa-list"></i>Categories</a>
        <a href="index.php?page=accounts"' . ($selected == 'accounts' ? ' class="selected"' : '') . '><i class="fas fa-users"></i>Accounts</a>
        <a href="index.php?page=shipping"' . ($selected == 'shipping' ? ' class="selected"' : '') . '><i class="fas fa-shipping-fast"></i>Shipping</a>
        <a href="index.php?page=discounts"' . ($selected == 'discounts' ? ' class="selected"' : '') . '><i class="fas fa-tag"></i>Discounts</a>
        <a href="index.php?page=images"' . ($selected == 'images' ? ' class="selected"' : '') . '><i class="fas fa-images"></i>Upload Images</a>
        <a href="index.php?page=emailtemplates"' . ($selected == 'emailtemplates' ? ' class="selected"' : '') . '><i class="fas fa-envelope"></i>Email Templates</a>
        <a href="index.php?page=settings"' . ($selected == 'settings' ? ' class="selected"' : '') . '><i class="fas fa-tools"></i>Settings</a>
    ';
    echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,minimum-scale=1">
		<title>$title</title>
        <link rel="icon" type="image/png" href="../favicon.png">
		<link href="admin.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="admin">
        <aside class="responsive-width-100 responsive-hidden">
            <h1>Shopping Cart Admin</h1>
            $admin_links
        </aside>
        <main class="responsive-width-100">
            <header>
                <a class="responsive-toggle" href="#">
                    <i class="fas fa-bars"></i>
                </a>
                <div class="space-between"></div>
                <a href="index.php?page=about" class="right"><i class="fas fa-question-circle"></i></a>
                <a href="index.php?page=logout" class="right"><i class="fas fa-sign-out-alt"></i></a>
            </header>
EOT;
}
// Template admin footer
function template_admin_footer()
{
    echo <<<EOT
        </main>
        <script>
        document.querySelector(".responsive-toggle").onclick = function(event) {
            event.preventDefault();
            let aside = document.querySelector("aside"), main = document.querySelector("main"), header = document.querySelector("header");
            let asideStyle = window.getComputedStyle(aside);
            if (asideStyle.display == "none") {
                aside.classList.remove("closed", "responsive-hidden");
                main.classList.remove("full");
                header.classList.remove("full");
            } else {
                aside.classList.add("closed", "responsive-hidden");
                main.classList.add("full");
                header.classList.add("full");
            }
        };
        </script>
    </body>
</html>
EOT;
}
// Rewrite URL function
function url($url)
{
    if (rewrite_url) {
        $url = preg_replace('/\&(.*?)\=/', '/', str_replace(['index.php?page=', 'index.php'], '', $url));
    }
    return base_url . $url;
}
// Routeing function
function routes($urls)
{
    foreach ($urls as $url) {
        $url = '/' . ltrim($url, '/');
        $prefix = dirname($_SERVER['PHP_SELF']);
        $uri = $_SERVER['REQUEST_URI'];
        if (substr($uri, 0, strlen($prefix)) == $prefix) {
            $uri = substr($uri, strlen($prefix));
        }
        $uri = '/' . ltrim($uri, '/');
        $path = explode('/', parse_url($uri)['path']);
        $routes = explode('/', $url);
        $values = [];
        foreach ($path as $pk => $pv) {
            if (isset($routes[$pk]) && preg_match('/{(.*?)}/', $routes[$pk])) {
                $var = str_replace(['{', '}'], '', $routes[$pk]);
                $routes[$pk] = preg_replace('/{(.*?)}/', $pv, $routes[$pk]);
                $values[$var] = $pv;
            }
        }
        if ($routes === $path && rewrite_url) {
            foreach ($values as $k => $v) {
                $_GET[$k] = $v;
            }
            return file_exists($routes[1] . '.php') ? $routes[1] . '.php' : 'home.php';
        }
    }
    if (rewrite_url) {
        http_response_code(404);
        exit;
    }
    return null;
}
