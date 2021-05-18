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
function send_order_details_email($email, $products, $first_name, $last_name, $address_street, $address_city, $address_zip, $address_country, $subtotal, $order_id)
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
// Template header
function template_header($title, $head = '')
{ 
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
            <a href="index.php?page=cart"><button class="btn btn-outline-dark" id="shopcart">
                <i class="fa fa-shopping-cart"></i>
            </button>
            </a>

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
                        <li class="nav-item"><a class="nav-link" id="mainnav-item" href="index.php?page=colors" target="_blank">Color swatch<span
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
        href="https://www.facebook.com/svatbyvpodhuri" target="_blank" role="button"><i class="fa fa-facebook-f"></i></a>
    <a class="btn btn-outline-dark btn-floating m-1 social-icon" id="socialicon-i"
        href="https://www.instagram.com/svatbyvpodhuri" target="_blank" role="button"><i class="fa fa-instagram"></i></a>
    <a class="btn btn-outline-dark btn-floating m-1 social-icon" id="socialicon-e" href="mailto: terikbyrtusek@seznam.cz" role="button"><i
            class="fa fa-envelope"></i></a>
        <main>
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
