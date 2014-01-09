<?php
/**
 * This sample demonstrates how to get
 * the available categories list
 *
 * API action: getcategories
 */

require __DIR__ . '/../bootstrap.php';
use TiTravel\Api\Categories;


/**
 * Retrive the categories list using optional
 * filters and your API credentials
 * (see bootstrap.php for credentials creation)
 */
try {
    $params = array(
        'language' => 'en',
    );
    $categories = Categories::all($params, $apiCredentials);
} catch (Exception $ex) {
    echo 'Exception:', $ex->getMessage(), PHP_EOL;
    exit(1);
}
?>
<html>
<head>
<title>Get accomodation categories</title>
</head>
<body>
    <div>Got <?php echo $categories->getCount(); ?> matching categories</div>
    <pre><?php print_r($categories->toArray());?></pre>
    <a href='../index.htm'>Back</a>
</body>
</html>