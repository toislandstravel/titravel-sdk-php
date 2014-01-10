<?php
/**
 * This sample demonstrates how to get
 * price calculation for a property
 *
 * API action: getPrice
 */

require __DIR__ . '/../bootstrap.php';
use TiTravel\Api\Price;


/**
 * Retrive the cities list using optional
 * filters and your API credentials
 * (see bootstrap.php for credentials creation)
 */
try {
    $params = array(
        'language' => 'en',
    );
    $cities = Price::get($params, $apiCredentials);
} catch (Exception $ex) {
    echo 'Exception:', $ex->getMessage(), PHP_EOL;
    exit(1);
}
?>
<html>
<head>
<title>Get property price calculation</title>
</head>
<body>
    <div>Got <?php echo $cities->getCount(); ?> matching cities</div>
    <pre><?php print_r($cities->toArray());?></pre>
    <a href='../index.htm'>Back</a>
</body>
</html>