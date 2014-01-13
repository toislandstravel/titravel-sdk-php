<?php
/**
 * This sample demonstrates how to send
 * a property reservation request
 *
 * API action: sendreservation
 */

require __DIR__ . '/../bootstrap.php';
use TiTravel\Api\Reservation;


/**
 * Send a property reservation request using your API credentials
 * (see bootstrap.php for credentials creation)
 */
try {
    $reservationForm = array(
        // enter your email
        'email' => '',
        'type' => Reservation::TYPE_RESERVATION,
        'lang' => 'en',
        'property_id' => 11316,
        'name' => 'My name',
        'surname' => 'My surname',
        'date_arrival' => '2014-07-12',
        'date_departure' => '2014-07-19',
        'person_adult' => 2,
        'children_ages' => array(1, 7, 13, 17),
        'pets' => 1,
        'phone' => '+0123456789',
        'message' => 'Message, question',
        'country' => 'Croatia',
        'return_url' => dirname('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']).
            '/ConfirmReservation.php',
    );
    $params = array(
        'language' => 'en',
        'property_id' => 11316,
        'data' => base64_encode(serialize($reservationForm)),
    );
    $returnUrl = Reservation::send($params, $apiCredentials);
} catch (Exception $ex) {
    echo 'Exception:', $ex->getMessage(), PHP_EOL;
    exit(1);
}
?>
<html>
<head>
<meta charset="utf-8">
<title>Send property reservation request</title>
</head>
<body>
    <strong>Reservation request sent succesfully:</strong>
    <pre><?php print_r($reservationForm);?></pre>
    <strong>Confirmation URL:</strong>
    <pre><?php print_r($returnUrl);?></pre>
    <a href='../index.htm'>Back</a>
</body>
</html>