<?php

// Default values for the input form elements
$account = [
    'first_name' => '',
    'last_name' => '',
    'address_street' => '',
    'address_city' => '',
    'address_state' => '',
    'address_zip' => '',
    'address_country' => 'Czech Republic'
];
// Error array, output errors on the form
$errors = [];
// Make sure when the user submits the form all data was submitted and shopping cart is not empty
if (isset($_POST['first_name'], $_POST['last_name'], $_POST['address_street'], $_POST['address_city'], $_POST['address_state'], $_POST['address_zip'], $_POST['address_country'], $_SESSION['cart'])) {
    $account_id = null;
    // If the user is already logged in
    if (isset($_SESSION['account_loggedin'])) {
        // Account logged-in, update the user's details
        $stmt = $pdo->prepare('UPDATE accounts SET first_name = ?, last_name = ?, address_street = ?, address_city = ?, address_state = ?, address_zip = ?, address_country = ? WHERE id = ?');
        $stmt->execute([$_POST['first_name'], $_POST['last_name'], $_POST['address_street'], $_POST['address_city'], $_POST['address_state'], $_POST['address_zip'], $_POST['address_country'], $_SESSION['account_id']]);
        $account_id = $_SESSION['account_id'];
    } else if (isset($_POST['email'], $_POST['password'], $_POST['cpassword']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        // User is not logged in, check if the account already exists with the email they submitted
        $stmt = $pdo->prepare('SELECT id FROM accounts WHERE email = ?');
        $stmt->execute([$_POST['email']]);
        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            // Email exists, user should login instead...
            $errors[] = 'Account already exists with this email, please login instead!';
        }
        if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
            // Password must be between 5 and 20 characters long.
            $errors[] = 'Password must be between 5 and 20 characters long!';
        }
        if ($_POST['password'] != $_POST['cpassword']) {
            // Password and confirm password fields do not match...
            $errors[] = 'Passwords do not match!';
        }
        if (!$errors) {
            // Email doesnt exist, create new account
            $stmt = $pdo->prepare('INSERT INTO accounts (email, password, first_name, last_name, address_street, address_city, address_state, address_zip, address_country) VALUES (?,?,?,?,?,?,?,?,?)');
            // Hash the password
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt->execute([$_POST['email'], $password, $_POST['first_name'], $_POST['last_name'], $_POST['address_street'], $_POST['address_city'], $_POST['address_state'], $_POST['address_zip'], $_POST['address_country']]);
            $account_id = $pdo->lastInsertId();
            $stmt = $pdo->prepare('SELECT * FROM accounts WHERE id = ?');
            $stmt->execute([$account_id]);
            // Fetch the account from the database and return the result as an Array
            $account = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    } else if (account_required) {
        $errors[] = 'Account creation required!';
    }
    if (!$errors) {
        // No errors, process the order
        $products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        $subtotal = 0.00;
        $shippingtotal = 0.00;
        $selected_shipping_method = isset($_SESSION['shipping_method']) ? $_SESSION['shipping_method'] : null;
        // If there are products in cart
        if ($products_in_cart) {
            // There are products in the cart so we need to select those products from the database
            // Products in cart array to question mark string array, we need the SQL statement to include: IN (?,?,?,...etc)
            $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
            $stmt = $pdo->prepare('SELECT p.id, c.id AS category_id, p.* FROM products p LEFT JOIN products_categories pc ON p.id = pc.product_id LEFT JOIN categories c ON c.id = pc.category_id WHERE p.id IN (' . $array_to_question_marks . ') GROUP BY p.id, c.id');
            // We use the array_column to retrieve only the id's of the products
            $stmt->execute(array_column($products_in_cart, 'id'));
            // Fetch the products from the database and return the result as an Array
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Get the current date
            $current_date = strtotime((new DateTime())->format('Y-m-d H:i:s'));
            // Retrieve shipping methods
            $stmt = $pdo->query('SELECT * FROM shipping');
            $shipping_methods = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $selected_shipping_method = $selected_shipping_method == null && $shipping_methods ? $shipping_methods[0]['name'] : $selected_shipping_method;
            // Iterate the products in cart and add the meta data (product name, desc, etc)
            foreach ($products_in_cart as &$cart_product) {
                foreach ($products as $product) {
                    if ($cart_product['id'] == $product['id']) {

                        // Calculate the subtotal
                        $product_price = $cart_product['options_price'] > 0 ? (float)$cart_product['options_price'] : (float)$product['price'];
                        $subtotal += $product_price * (int)$cart_product['quantity'];
                        // Calculate the shipping
                        foreach ($shipping_methods as $shipping_method) {
                            if ($shipping_method['name'] == $selected_shipping_method && $product_price >= $shipping_method['price_from'] && $product_price <= $shipping_method['price_to'] && $product['weight'] >= $shipping_method['weight_from'] && $product['weight'] <= $shipping_method['weight_to']) {
                                $cart_product['shipping_price'] = (float)$shipping_method['price'] * (int)$cart_product['quantity'];
                                $shippingtotal += $cart_product['shipping_price'];
                            }
                        }
                        // Calculate the discount
                        if (isset($discount) && $discount && $current_date >= strtotime($discount['start_date']) && $current_date <= strtotime($discount['end_date'])) {
                            if ((!$discount['category_ids'] && !$discount['product_ids']) || in_array($product['id'], explode(',', $discount['product_ids'])) || in_array($product['category_id'], explode(',', $discount['category_ids']))) {
                                $cart_product['discounted'] = true;
                            }
                        }
                    }
                }
            }
        }
        // Process Stripe Payment
        if (isset($_POST['stripe']) && $products_in_cart) {
            // Include the stripe lib
            require_once('lib/stripe/init.php');
            $stripe = new \Stripe\StripeClient(stripe_secret_key);
            $line_items = [];
            // Iterate the products in cart and add each product to the array above
            for ($i = 0; $i < count($products_in_cart); $i++) {
                $line_items[] = [
                    'quantity' => $products_in_cart[$i]['quantity'],
                    'price_data' => [
                        'currency' => stripe_currency,
                        'unit_amount' => ($products_in_cart[$i]['options_price'] > 0 ? $products_in_cart[$i]['options_price'] : $products_in_cart[$i]['meta']['price']) * 100,
                        'product_data' => [
                            'name' => $products_in_cart[$i]['meta']['name'],
                            'metadata' => [
                                'item_id' => $products_in_cart[$i]['id'],
                                'item_options' => $products_in_cart[$i]['options'],
                                'item_shipping' => $products_in_cart[$i]['shipping_price']
                            ]
                        ]
                    ]
                ];
            }
            // Add the shipping
            $line_items[] = [
                'quantity' => 1,
                'price_data' => [
                    'currency' => stripe_currency,
                    'unit_amount' => $shippingtotal * 100,
                    'product_data' => [
                        'name' => 'Shipping',
                        'description' => $selected_shipping_method,
                        'metadata' => [
                            'item_id' => 'shipping'
                        ]
                    ]
                ]
            ];
            // Webhook that will notify the stripe IPN file when a payment has been made
            $webhooks = $stripe->webhookEndpoints->all();
            $webhook = null;
            $secret = '';
            foreach ($webhooks as $wh) {
                if ($wh['description'] == 'codeshack_shoppingcart_system') {
                    $webhook = $wh;
                    $secret = $webhook['metadata']['secret'];
                }
            }
            if ($webhook == null) {
                $webhook = $stripe->webhookEndpoints->create([
                    'url' => stripe_ipn_url,
                    'description' => 'codeshack_shoppingcart_system',
                    'enabled_events' => ['checkout.session.completed'],
                    'metadata' => ['secret' => '']
                ]);
                $secret = $webhook['secret'];
                $stripe->webhookEndpoints->update($webhook['id'], ['metadata' => ['secret' => $secret]]);
            }
            $stripe->webhookEndpoints->update($webhook['id'], ['url' => stripe_ipn_url . '?key=' . $secret]);
            // Create the stripe checkout session and redirect the user
            $session = $stripe->checkout->sessions->create([
                'success_url' => stripe_return_url,
                'cancel_url' => stripe_cancel_url,
                'payment_method_types' => ['card'],
                'line_items' => $line_items,
                'mode' => 'payment',
                'customer_email' => isset($account['email']) && !empty($account['email']) ? $account['email'] : $_POST['email'],
                'metadata' => [
                    'first_name' => $_POST['first_name'],
                    'last_name' => $_POST['last_name'],
                    'address_street' => $_POST['address_street'],
                    'address_city' => $_POST['address_city'],
                    'address_state' => $_POST['address_state'],
                    'address_zip' => $_POST['address_zip'],
                    'address_country' => $_POST['address_country'],
                    'account_id' => $account_id
                ]
            ]);
            header('Location: stripe-redirect.php?stripe_session_id=' . $session['id']);
            exit;
        }
        // Process PayPal Payment
        if (isset($_POST['paypal']) && $products_in_cart) {
            // Process PayPal Checkout
            // Variable that will stored all details for all products in the shopping cart
            $data = [];
            // Add all the products that are in the shopping cart to the data array variable
            for ($i = 0; $i < count($products_in_cart); $i++) {
                $data['item_number_' . ($i + 1)] = $products_in_cart[$i]['id'];
                $data['item_name_' . ($i + 1)] = str_replace(['(', ')'], '', $products_in_cart[$i]['meta']['name']);
                $data['quantity_' . ($i + 1)] = $products_in_cart[$i]['quantity'];
                $data['amount_' . ($i + 1)] = $products_in_cart[$i]['options_price'] > 0 ? $products_in_cart[$i]['options_price'] : $products_in_cart[$i]['meta']['price'];
                $data['on0_' . ($i + 1)] = 'Options';
                $data['os0_' . ($i + 1)] = $products_in_cart[$i]['options'];
                $data['shipping_' . ($i + 1)] = $products_in_cart[$i]['shipping_price'];
            }
            // Variables we need to pass to paypal
            $data = $data + [
                'cmd'            => '_cart',
                'upload'        => '1',
                'custom'        => $account_id,
                'business'         => paypal_email,
                'cancel_return'    => paypal_cancel_url,
                'notify_url'    => paypal_ipn_url,
                'currency_code'    => paypal_currency,
                'return'        => paypal_return_url
            ];
            if ($account_id != null) {
                // Log the user in with the details provided
                session_regenerate_id();
                $_SESSION['account_loggedin'] = TRUE;
                $_SESSION['account_id'] = $account_id;
                $_SESSION['account_admin'] = $account ? $account['admin'] : 0;
            }
            // Redirect the user to the PayPal checkout screen
            header('location:' . (paypal_testmode ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr') . '?' . http_build_query($data));
            // End the script, don't need to execute anything else
            exit;
        }
        if (isset($_POST['checkout']) && $products_in_cart) {
            // Process Normal Checkout
            // Iterate each product in the user's shopping cart
            // Unique transaction ID
            $transaction_id = strtoupper(uniqid('SC') . substr(md5(mt_rand()), 0, 5));
            $stmt = $pdo->prepare('INSERT INTO transactions (txn_id, payment_amount, payment_status, created, payer_email, first_name, last_name, address_street, address_city, address_state, address_zip, address_country, account_id, payment_method) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
            $stmt->execute([
                $transaction_id,
                $subtotal + $shippingtotal,
                'Completed',
                date('Y-m-d H:i:s'),
                isset($account['email']) && !empty($account['email']) ? $account['email'] : $_POST['email'],
                $_POST['first_name'],
                $_POST['last_name'],
                $_POST['address_street'],
                $_POST['address_city'],
                $_POST['address_state'],
                $_POST['address_zip'],
                $_POST['address_country'],
                $account_id,
                'website'
            ]);
            $order_id = $pdo->lastInsertId();
            foreach ($products_in_cart as $product) {
                // For every product in the shopping cart insert a new transaction into our database
                $stmt = $pdo->prepare('INSERT INTO transactions_items (txn_id, item_id, item_price, item_quantity, item_options, item_shipping_price) VALUES (?,?,?,?,?,?)');
                $stmt->execute([$transaction_id, $product['id'], $product['options_price'] > 0 ? $product['options_price'] : $product['meta']['price'], $product['quantity'], $product['options'], $product['shipping_price']]);
                // Update product quantity in the products table
                $stmt = $pdo->prepare('UPDATE products SET quantity = quantity - ? WHERE quantity > 0 AND id = ?');
                $stmt->execute([$product['quantity'], $product['id']]);
            }
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
                $_POST['address_state'],
                $_POST['address_zip'],
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
        'address_state' => $_POST['address_state'],
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
$countries = ["Czech Republic", "Slovakia"];


// If the user clicked the add to cart button on the product page we can check for the form data
if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])) {
    // Set the post variables so we easily identify them, also make sure they are integer
    $product_id = (int)$_POST['product_id'];
    // abs() function will prevent minus quantity and (int) will make sure the value is an integer
    $quantity = abs((int)$_POST['quantity']);
    // Get product options
    $options = '';
    $options_price = 0.00;
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'option') !== false) {
            $options .= str_replace('option', '', $k) . $v . ',';
            $stmt = $pdo->prepare('SELECT * FROM products_options WHERE title = ? AND name = ? AND product_id = ?');
            $stmt->execute([str_replace('option', '', $k), $v, $product_id]);
            $option = $stmt->fetch(PDO::FETCH_ASSOC);
            $options_price += $option['price'];
        }
    }
    $options = rtrim($options, ',');
    // Prepare the SQL statement, we basically are checking if the product exists in our database
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$_POST['product_id']]);
    // Fetch the product from the database and return the result as an Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the product exists (array is not empty)
    if ($product && $quantity > 0) {
        // Product exists in database, now we can create/update the session variable for the cart
        if (!isset($_SESSION['cart'])) {
            // Shopping cart session variable doesnt exist, create it
            $_SESSION['cart'] = [];
        }
        $cart_product = &get_cart_product($product_id, $options);
        if ($cart_product) {
            // Product exists in cart, update the quanity
            $cart_product['quantity'] += $quantity;
        } else {
            // Product is not in cart, add it
            $_SESSION['cart'][] = [
                'id' => $product_id,
                'quantity' => $quantity,
                'options' => $options,
                'options_price' => $options_price,
                'shipping_price' => 0.00
            ];
        }
    }
    // Prevent form resubmission...
    header('location: ' . url('index.php?page=cart'));
    exit;
}
// Remove product from cart, check for the URL param "remove", this is the product id, make sure it's a number and check if it's in the cart
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    // Remove the product from the shopping cart
    array_splice($_SESSION['cart'], $_GET['remove'], 1);
    header('location: ' . url('index.php?page=cart'));
    exit;
}
// Empty the cart
if (isset($_POST['emptycart']) && isset($_SESSION['cart'])) {
    // Remove all products from the shopping cart
    unset($_SESSION['cart']);
    header('location: ' . url('index.php?page=cart'));
    exit;
}

// Redirect back to productlist to "Continue shopping"
if (isset($_POST['shopping']) && isset($_SESSION['cart'])) {
    header('location: ' . url('productlist.php'));
    exit;
}

// Update product quantities in cart if the user clicks the "Update" button on the shopping cart page
if ((isset($_POST['update']) || isset($_POST['checkout'])) && isset($_SESSION['cart'])) {
    // Iterate the post data and update quantities for every product in cart
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) {
            $id = str_replace('quantity-', '', $k);
            // abs() function will prevent minus quantity and (int) will make sure the number is an integer
            $quantity = abs((int)$v);
            // Always do checks and validation
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                // Update new quantity
                $_SESSION['cart'][$id]['quantity'] = $quantity;
            }
        }
    }

    // Send the user to the place order page if they click the Place Order button, also the cart should not be empty
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
// If there are products in cart
if ($products_in_cart) {
    // There are products in the cart so we need to select those products from the database
    // Products in cart array to question mark string array, we need the SQL statement to include: IN (?,?,?,...etc)
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $stmt = $pdo->prepare('SELECT p.id, pc.category_id, p.* FROM products p LEFT JOIN products_categories pc ON p.id = pc.product_id LEFT JOIN categories c ON c.id = pc.category_id WHERE p.id IN (' . $array_to_question_marks . ') GROUP BY p.id');
    // We use the array_column to retrieve only the id's of the products
    $stmt->execute(array_column($products_in_cart, 'id'));
    // Fetch the products from the database and return the result as an Array
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get the current date
    $current_date = strtotime((new DateTime())->format('Y-m-d H:i:s'));

    // Iterate the products in cart and add the meta data (product name, desc, etc)
    foreach ($products_in_cart as &$cart_product) {
        foreach ($products as $product) {
            if ($cart_product['id'] == $product['id']) {
                $cart_product['product'] = $product;
                // Calculate the subtotal
                $product_price = $cart_product['options_price'] > 0 ? (float)$cart_product['options_price'] : (float)$product['price'];
                $subtotal += $product_price * (int)$cart_product['quantity'];
            }
        }
    }
}
?>

<?= template_header('Checkout') ?>

<style>
label{
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

<div class="checkout content-wrapper">
    <div class="row justify-content-center mx-0 mb-5">
        <h1>Checkout</h1>
    </div>
        <p class="error"><?= implode('<br>', $errors) ?></p>
        <div class="row bg-danger justify-content-center mx-0" id="bebas">
        <form action="" method="post" style="margin-right: 50px;">

            <div class="row">
                <label for="first_name" class="mr-1 mr-lg-3">First Name</label>
                <input type="text" value="<?= $account['first_name'] ?>" name="first_name" id="first_name" placeholder="" required>
                <label for="last_name" class="mr-1 mr-lg-3">Last Name</label>
                <input type="text" value="<?= $account['last_name'] ?>" name="last_name" id="last_name" placeholder="" required>
            </div>

            <div class="row ">
            <label for="address_street" class="mr-1 mr-lg-3">Address</label>
            <input type="text" value="<?= $account['address_street'] ?>" name="address_street" id="address_street" placeholder="" required>

            <label for="address_city" class="mr-1 mr-lg-3">City</label>
            <input type="text" value="<?= $account['address_city'] ?>" name="address_city" id="address_city" placeholder="" required>
            </div>

            <div class="row">
                <label for="address_zip" class="mr-1 mr-lg-3">Zip</label>
                <input type="text" value="<?= $account['address_zip'] ?>" name="address_zip" id="address_zip" placeholder="" required>
            

            <label for="address_country" class="mr-1 mr-lg-3">Country</label>
            <select name="address_country" required>
                <?php foreach ($countries as $country) : ?>
                    <option value="<?= $country ?>" <?= $country == $account['address_country'] ? ' selected' : '' ?>><?= $country ?></option>
                <?php endforeach; ?>
            </select>
            </div><br>
            <button type="submit" name="checkout">Place Order</button>

        </form>
    </div>
</div>
</div>


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
<div class="cart content-wrapper my-5">
    <div class="row justify-content-center mx-0">
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
                                    <?php if (!empty($product['product']['img']) && file_exists('imgs/' . $product['product']['img'])) : ?>
                                        <a href="<?= url('index.php?page=product&id=' . $product['id']) ?>">
                                            <img src="<?= base_url ?>imgs/<?= $product['product']['img'] ?>" style="height: 150px; width: 150px;" alt="<?= $product['product']['name'] ?>">
                                        </a>
                                    <?php endif; ?>
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
                                <td class="price" id="bebas" style="font-size: 22px; text-align: center"><?= currency_code ?><?= number_format($product['product']['price'], 2) ?></td>
                                <td class="quantity text-center" id="bebas">
                                    <input type="number" class="ajax-update" name="quantity-<?= $num ?>" value="<?= $product['quantity'] ?>" min="1" <?php if ($product['product']['quantity'] != -1) : ?>max="<?= $product['product']['quantity'] ?>" <?php endif; ?> placeholder="Quantity" required>
                                </td>
                                <td class="price product-total text-center" id="bebas" style="font-size: 22px; text-align: center"><?= currency_code ?><?= number_format($product['product']['price'] * $product['quantity'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>



            <div class="subtotal mt-3" id="bebas" style="font-size: 25px">
                <span class="text">Total</span>
                <span class="price"><?= currency_code ?><?= number_format($subtotal, 2) ?></span>
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