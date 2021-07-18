<?php

include("session.php");
include("connection.php");

$name = $_SESSION['name'];

use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

require 'bootstrap.php';

if (!isset($_POST['pay'])) {
    throw new Exception('This script should not be called directly, expected post data');
}

$membership = $_POST['membership'];
$money =$_POST['amount'];
$userId = $_POST['user'];

if(empty($membership)|| empty($money)|| empty($userId) )
{
    $message ="Make sure all fields are filled";
    echo "<script>alert('$message');
    </script>";

    //window.location.href='admin/ahm/panel';
}

$remove = "DELETE FROM temporary ";
mysqli_query($con,$remove);

mysqli_query($con,"INSERT INTO `temporary`(`amount`, `membership`,`name`, `memberId`) VALUES('$money','$membership','$name',$userId)"); 

$payer = new Payer();
$payer->setPaymentMethod('paypal');

// Set some example data for the payment.
$currency = 'USD';
$amountPayable = 10.00;
$total =  floatval($money) + $amountPayable;
$invoiceNumber = $membership;

$amount = new Amount();
$amount->setCurrency($currency)
    ->setTotal($money) ;

$transaction = new Transaction();
$transaction->setAmount($amount)
    ->setDescription('Some description about the payment being made')
    ->setInvoiceNumber($invoiceNumber);

$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl($paypalConfig['return_url'])
    ->setCancelUrl($paypalConfig['cancel_url']);

$payment = new Payment();
$payment->setIntent('sale')
    ->setPayer($payer)
    ->setTransactions([$transaction])
    ->setRedirectUrls($redirectUrls);

try {
    $payment->create($apiContext);
} catch (Exception $e) {
    throw new Exception('Unable to create link for payment');
}

header('location:' . $payment->getApprovalLink());
exit(1);

?>