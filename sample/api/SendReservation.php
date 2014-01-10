<?php
/**
 * This sample demonstrates how to send
 * a property reservation request
 *
 * API action: set
 */

require __DIR__ . '/../bootstrap.php';
use TiTravel\Api\Reservation;


/**
 * Send a property reservation request using your API credentials
 * (see bootstrap.php for credentials creation)
 */
try {
    $reservationForm = array(
        'type' => Reservation::TYPE_RESERVATION,
        'lang' => 'en',
        'property_id' => 11316,
        'name' => 'Name',
        'surname' => 'Surname',
        'date_arrival' => '2014-07-12',
        'date_departure' => '2014-07-19',
        'person_adult' => 2,
        'children_ages' => array(1, 7, 13, 17),
        'pets' => 1,
        'phone' => '+0123456789',
        'email' => 'foo@bar.com',
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
    Reservation::send($params, $apiCredentials);
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
    <strong>Reservation request successfully sent:</strong>
    <pre><?php print_r($reservationForm);?></pre>
    <strong>Confirmation return URL:</strong>
    <pre><?php print_r($reservationForm['return_url']); ?></pre>
    <a href='../index.htm'>Back</a>
</body>
</html>