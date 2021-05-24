<?php

unset($_SESSION['cart']);
?>
<?= template_header('Place Order') ?>

<?php if ($error) : ?>
    <p class="content-wrapper error"><?= $error ?></p>
<?php else : ?>
    <div class="placeorder content-wrapper text-center">
        <h1>Your Order Has Been Placed</h1>
        <p>Thank you for ordering with us, we'll contact you by email with your order details.</p>
    </div>
<?php endif; ?>