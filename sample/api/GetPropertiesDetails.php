<?php
/**
 * This sample demonstrates how to get
 * the properties detailed list
 *
 * API action: getproperty
 */

require __DIR__ . '/../bootstrap.php';
use TiTravel\Api\Properties;


/**
 * Retreive the properties list using optional
 * filters and your API credentials
 * (see bootstrap.php for credentials creation)
 */
try {
    $params = array(
        'language' => 'en',
        'page' => 1,
        'city_id' => null,
        'category_id' => null,
        'property_id' => null,
        'property_ids' => null,
        'range' => null,
    );
    $properties = Properties::all($params, $apiCredentials);
} catch (Exception $ex) {
    echo 'Exception:', $ex->getMessage(), PHP_EOL;
    exit(1);
}
$count = $properties->getCount();
$page = $properties->getPage();
$countPerPage = $properties->getResultsPerPageLimit();
$start = $countPerPage * ($page - 1) + 1;
?>
<html>
<head>
<meta charset="utf-8">
<title>Get properties details</title>
</head>
<body>
    <div>Got <?php echo $start, ' to ', $start + $count - 1, " ($count)"; ?> out of
    <?php echo $properties->getCountTotal(); ?> total matching properties<br>
    Page: <?php echo $page; ?> / <?php echo $properties->getPageMax(); ?></div>
    Max. items per page: <?php echo $countPerPage; ?><br><br>
    Retreived properties:</div>
    <pre><?php print_r($properties->toArray());?></pre>
    <a href='../index.htm'>Back</a>
</body>
</html>