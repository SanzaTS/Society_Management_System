<?php

include("session.php");
include("connection.php");

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

require 'bootstrap.php';

if (empty($_GET['paymentId']) || empty($_GET['PayerID'])) {
    throw new Exception('The response is missing the paymentId and PayerID');
}

$paymentId = $_GET['paymentId'];
$payment = Payment::get($paymentId, $apiContext);

$execution = new PaymentExecution();
$execution->setPayerId($_GET['PayerID']);

$sql= "SELECT amount,membership,memberId FROM temporary ";

$results = mysqli_query($con,$sql);

while($row = mysqli_fetch_array($results))
{
    $amount = $row['amount'];
    $membership = $row['membership'];
    $memberId = $row['memberId'];
    
    if($membership == "Food")
    {
        $fee = 1;
    }
    elseif ($membership== "Premium") {
        $fee = 2;
    }
    elseif ($membership == "Both") {
        $fee = 3;
    }
}

$date = date('Y-m-d');

$insert = "INSERT INTO payment ( payment_date, amount, optionId, member_id, fee_id) VALUES ('$date',$amount,2,$memberId,$fee)";

if(mysqli_query($con,$insert) or die(mysqli_error($con)))
{
    $remove = "DELETE FROM temporary WHERE memberId = $memberId ";
    if(mysqli_query($con,$remove))
    {
        header("location:paymentReports.php");
    }
    else
    {
        header("location:paymentReports.php");
    }
    
}
else{
    header("location:instant.php");
}

/*
try {
    // Take the payment
    $payment->execute($execution, $apiContext);

    try {
        $db = new mysqli($dbConfig['host'], $dbConfig['username'], $dbConfig['password'], $dbConfig['name']);

        $payment = Payment::get($paymentId, $apiContext);

        $data = [
            'transaction_id' => $payment->getId(),
            'payment_amount' => $payment->transactions[0]->amount->total,
            'payment_status' => $payment->getState(),
            'invoice_id' => $payment->transactions[0]->invoice_number
        ];
        if (addPayment($data) !== false && $data['payment_status'] === 'approved') {
            // Payment successfully added, redirect to the payment complete page.
            header('location:paymentReports.php');
            exit(1);
        } else {
            // Payment failed

        }

    } catch (Exception $e) {
        // Failed to retrieve payment from PayPal

    }

} catch (Exception $e) {
    // Failed to take payment

}*/

/**
 * Add payment to database
 *
 * @param array $data Payment data
 * @return int|bool ID of new payment or false if failed
 */
function addPayment($data)
{
    global $db;

    if (is_array($data)) {
        $stmt = $db->prepare('INSERT INTO `payments` (transaction_id, payment_amount, payment_status, invoice_id, createdtime) VALUES(?, ?, ?, ?, ?)');
        $stmt->bind_param(
            'sdsss',
            $data['transaction_id'],
            $data['payment_amount'],
            $data['payment_status'],
            $data['invoice_id'],
            date('Y-m-d H:i:s')
        );
        $stmt->execute();
        $stmt->close();

        return $db->insert_id;
    }

    return false;
}

?>