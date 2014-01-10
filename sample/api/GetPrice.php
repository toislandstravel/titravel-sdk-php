<?php
/**
 * This sample demonstrates how to get
 * price calculation for a property
 *
 * API action: getPrice
 */

require __DIR__ . '/../bootstrap.php';
use TiTravel\Api\Prices;


/**
 * Retrive the cities list using optional
 * filters and your API credentials
 * (see bootstrap.php for credentials creation)
 */
try {
    $params = array(
        'language' => 'en',
        'property_id' => 11316,
        'arrival_date' => '2014-07-12',
        'departure_date' => '2014-07-19',
        'adults' => 2,
        'children_ages' => array(1, 7, 13, 17),
        'pets' => 1,
    );
    $price = Prices::getPrice($params, $apiCredentials);
} catch (Exception $ex) {
    echo 'Exception:', $ex->getMessage(), PHP_EOL;
    exit(1);
}
?>
<html>
<head>
<meta charset="utf-8">
<title>Get property price calculation</title>
</head>
<body>
    <strong>Got price for reservation:</strong>
    <pre><?php print_r($params);?></pre>
    <strong>Price:</strong>
    <pre><?php print_r($price);?></pre>
    <a href='../index.htm'>Back</a>
</body>
</html>