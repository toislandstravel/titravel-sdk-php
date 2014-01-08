<?php
/**
 * This sample demonstrates how to get
 * the properties list with basic info
 * on their last update date
 *
 * API action: getproperty
 */

require __DIR__ . '/../bootstrap.php';
use TiTravel\Api\Properties;


/**
 * Retrive the properties list using optional
 * filters and your API credentials
 * (see bootstrap.php for credentials creation)
 */
try {
    $params = array(
        'city_id' => 226,
        'category_id' => null,
    );
    $properties = Properties::all($params, $apiCredentials);
} catch (Exception $ex) {
    echo "Exception:" . $ex->getMessage() . PHP_EOL;
    exit(1);
}
?>
<html>
<head>
<title>Get properties basic info list</title>
</head>
<body>
    <div>Got <?php echo $properties->getCount(); ?> matching properties</div>
    <pre><?php var_dump($properties->toArray());?></pre>
    <a href='../index.htm'>Back</a>
</body>
</html>