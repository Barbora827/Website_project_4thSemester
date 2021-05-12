<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\xampp\composer\vendor\autoload.php';

$stmt = $pdo->prepare('SELECT email FROM accounts WHERE id = ?');
$stmt->execute([$_SESSION['account_id']]);
// Fetch the account from the database and return the result as an Array
$customeremail = $stmt->fetch(PDO::FETCH_ASSOC);

$messcustomer = 'hello user';
$messadmin = 'hello admin';
$adminemail = 'barcabyrtusova827@gmail.com';

$mail = new PHPMailer(TRUE);

try {

   $mail->setFrom($adminemail, 'Svatby v podhůří');
   $mail->addAddress($customeremail);
   $mail->Subject = 'Thank you for your order!';
   $mail->Body = ':)';

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



} catch (Exception $e) {
   echo $e->errorMessage();
} catch (\Exception $e) {
   echo $e->getMessage();
}
