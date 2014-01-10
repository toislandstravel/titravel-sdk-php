<?php
/**
 * This sample demonstrates how to get
 * the properties price list
 *
 * API action: getprices
 */

require __DIR__ . '/../bootstrap.php';
use TiTravel\Api\Prices;

/**
 * Retrive the properties price lists using optional
 * filters and your API credentials
 * (see bootstrap.php for credentials creation)
 */
try {
    $params = array(
        'language' => 'en',
        'city_id' => null,
        'category_id' => null,
        'property_id' => null,
        'property_ids' => null,
        // fetch only the first 100 records for testing
        'range' => '1-100',
    );
    $prices = Prices::all($params, $apiCredentials);
} catch (Exception $ex) {
    echo 'Exception:', $ex->getMessage(), PHP_EOL;
    exit(1);
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Get properties price list</title>
</head>
<body>
    <div>Got prices for <?php echo $prices->getCount(); ?> matching properties</div>
    <pre><?php print_r($prices->toArray());?></pre>
    <a href='../index.htm'>Back</a>
</body>
</html>