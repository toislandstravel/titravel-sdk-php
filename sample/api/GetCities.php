<?php
/**
 * This sample demonstrates how to get
 * the available cities list
 *
 * API action: getcities
 */

require __DIR__ . '/../bootstrap.php';
use TiTravel\Api\Cities;


/**
 * Retrive the cities list using optional
 * filters and your API credentials
 * (see bootstrap.php for credentials creation)
 */
try {
    $params = array(
        'language' => 'en',
    );
    $cities = Cities::all($params, $apiCredentials);
} catch (Exception $ex) {
    echo 'Exception:', $ex->getMessage(), PHP_EOL;
    exit(1);
}
?>
<html>
<head>
<meta charset="utf-8">
<title>Get cities</title>
</head>
<body>
    <div>Got <?php echo $cities->getCount(); ?> matching cities</div>
    <pre><?php print_r($cities->toArray());?></pre>
    <a href='../index.htm'>Back</a>
</body>
</html>