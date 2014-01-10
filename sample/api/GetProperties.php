<?php
/**
 * This sample demonstrates how to get
 * the properties list with basic info
 * on their last update date
 *
 * API action: getproperty
 */

require __DIR__ . '/../bootstrap.php';
use TiTravel\Api\PropertiesInfo;


/**
 * Retrive the properties list using optional
 * filters and your API credentials
 * (see bootstrap.php for credentials creation)
 */
try {
    $params = array(
        'city_id' => null,
        'category_id' => null,
    );
    $properties = PropertiesInfo::all($params, $apiCredentials);
} catch (Exception $ex) {
    echo 'Exception:', $ex->getMessage(), PHP_EOL;
    exit(1);
}
?>
<html>
<head>
<meta charset="utf-8">
<title>Get properties update dates</title>
</head>
<body>
    <div>Got <?php echo $properties->getCount(); ?> matching properties</div>
    <pre><?php print_r($properties->toArray());?></pre>
    <a href='../index.htm'>Back</a>
</body>
</html>