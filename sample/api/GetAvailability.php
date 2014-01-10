<?php
/**
 * This sample demonstrates how to get
 * the properties availability period list
 *
 * API action: getavailability
 */

require __DIR__ . '/../bootstrap.php';
use TiTravel\Api\Availabilities;


/**
 * Retrive the properties availability dates using optional
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
        'range' => null,
    );
    $availabilties = Availabilities::all($params, $apiCredentials);
} catch (Exception $ex) {
    echo 'Exception:', $ex->getMessage(), PHP_EOL;
    exit(1);
}
?>
<html>
<head>
<title>Get properties availability dates</title>
</head>
<body>
    <div>Got  availability dates for <?php echo $availabilties->getCount(); ?> matching properties</div>
    <pre><?php print_r($availabilties->toArray());?></pre>
    <a href='../index.htm'>Back</a>
</body>
</html>