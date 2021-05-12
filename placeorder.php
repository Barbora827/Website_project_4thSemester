<?php


//fetch customer email
$stmt = $pdo->prepare('SELECT email FROM accounts WHERE id = ?');
$stmt->execute([$_SESSION['account_id']]);
$customeremail = $stmt->fetch(PDO::FETCH_ASSOC);



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\xampp\composer\vendor\autoload.php';


//Customer email

/* Create a new PHPMailer object. */
$mail = new PHPMailer();

/* Set the mail sender. */
$mail->setFrom('barcabyrtusova@gmail.com', 'Svatby v podhůří');

/* Add a recipient. */
$mail->addAddress('barcabyrtusova@gmail.com');

/* Set the subject. */
$mail->Subject = 'Customer';

/* Set the mail message body. */
$mail->Body = 'Customer message';


/* SMTP parameters. */

/* Tells PHPMailer to use SMTP. */
$mail->isSMTP();

/* SMTP server address. */
$mail->Host = 'smtp.gmail.com';

/* Use SMTP authentication. */
$mail->SMTPAuth = TRUE;

/* Set the encryption system. */
$mail->SMTPSecure = 'tls';

/* SMTP authentication username. */
$mail->Username = 'barcabyrtusova827@gmail.com';

/* SMTP authentication password. */
$mail->Password = 'Alva281207_';

/* Set the SMTP port. */
$mail->Port = 587;

/* Finally send the mail. */
$mail->send();



//Admin email 

/* Create a new PHPMailer object. */
$mailadmin = new PHPMailer();

/* Set the mail sender. */
$mailadmin->setFrom('barcabyrtusova827@seznam.cz', 'Svatby v podhůří');

/* Add a recipient. */
$mailadmin->addAddress('barcabyrtusova827@gmail.com');

/* Set the subject. */
$mailadmin->Subject = 'Order';

/* Set the mail message body. */
$mailadmin->Body = 'You got an order';

/* SMTP parameters. */

/* Tells PHPMailer to use SMTP. */
$mailadmin->isSMTP();

/* SMTP server address. */
$mailadmin->Host = 'smtp.gmail.com';

/* Use SMTP authentication. */
$mailadmin->SMTPAuth = TRUE;

/* Set the encryption system. */
$mailadmin->SMTPSecure = 'tls';

/* SMTP authentication username. */
$mailadmin->Username = 'barcabyrtusova827@gmail.com';

/* SMTP authentication password. */
$mailadmin->Password = 'Alva281207_';

/* Set the SMTP port. */
$mailadmin->Port = 587;

/* Finally send the mail. */
$mailadmin->send();


unset($_SESSION['cart']);
?>
<?= template_header('Place Order') ?>

<?php if ($error) : ?>
    <p class="content-wrapper error"><?= $error ?></p>
<?php else : ?>
    <div class="placeorder content-wrapper">
        <h1>Your Order Has Been Placed</h1>
        <p>Thank you for ordering with us, we'll contact you by email with your order details.</p>
    </div>
<?php endif; ?>