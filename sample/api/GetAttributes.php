<?php
/**
 * This sample demonstrates how to get
 * the available attributes list
 *
 * API action: attributes
 */

require __DIR__ . '/../bootstrap.php';
use TiTravel\Api\Attributes;


/**
 * Retrive the attributes list using optional
 * filters and your API credentials
 * (see bootstrap.php for credentials creation)
 */
try {
    $params = array(
        'language' => 'en',
        'category_id' => null,
    );
    $attributes = Attributes::all($params, $apiCredentials);
} catch (Exception $ex) {
    echo 'Exception:', $ex->getMessage(), PHP_EOL;
    exit(1);
}
?>
<html>
<head>
<meta charset="utf-8">
<title>Get attributes</title>
</head>
<body>
    <div>Got <?php echo $attributes->getCount(); ?> matching attributes categories</div>
    <pre><?php print_r($attributes->toArray());?></pre>
    <a href='../index.htm'>Back</a>
</body>
</html>