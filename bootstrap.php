<?php

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

require 'vendor/autoload.php';

// For test payments we want to enable the sandbox mode. If you want to put live
// payments through then this setting needs changing to `false`.
$enableSandbox = true;

// PayPal settings. Change these to your account details and the relevant URLs
// for your site.  http://127.0.0.1/Society_ Management_System/instant.php
$paypalConfig = [
    'client_id' => 'ASVv6TCLQKFrGW_B3XndPUyGIa5wmEgt-SY8myB_8oWKcG6TWcX0TpFCZ7GvTm6qFStDoyDrxA1V6lk6',
    'client_secret' => 'EBkp7z0_BYQJExaNnfBTOhAxnJpKqqb-UK3XDzE8BnZIoAC46PMerx-AHY5_Lvd9BXES_i-qtBCkG2ZD',
    'return_url' => 'http://127.0.0.1/Society_Management_System/response.php',
    'cancel_url' => 'http://127.0.0.1/Society_Management_System/instant.php'
]; 
//   http://localhost:80/Society_Management_System/response.php
// Database settings. Change these for your database configuration.
$dbConfig = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'name' => 'example_database'
];

$apiContext = getApiContext($paypalConfig['client_id'], $paypalConfig['client_secret'], $enableSandbox);

/**
 * Set up a connection to the API
 *
 * @param string $clientId
 * @param string $clientSecret
 * @param bool   $enableSandbox Sandbox mode toggle, true for test payments
 * @return \PayPal\Rest\ApiContext
 */
function getApiContext($clientId, $clientSecret, $enableSandbox = false)
{
    $apiContext = new ApiContext(
        new OAuthTokenCredential($clientId, $clientSecret)
    );

    $apiContext->setConfig([
        'mode' => $enableSandbox ? 'sandbox' : 'live'
    ]);

    return $apiContext;
}