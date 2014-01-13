<?php
/**
 * This sample demonstrates how to get
 * the available compensations list
 *
 * API action: getcompensations
 */

require __DIR__ . '/../bootstrap.php';
use TiTravel\Api\Compensations;


/**
 * Retrive the compensations list using optional
 * filters and your API credentials
 * (see bootstrap.php for credentials creation)
 */
try {
    $params = array(
        'language' => 'en',
    );
    $compensations = Compensations::all($params, $apiCredentials);
} catch (Exception $ex) {
    echo 'Exception:', $ex->getMessage(), PHP_EOL;
    exit(1);
}
?>
<html>
<head>
<meta charset="utf-8">
<title>Get available compensations</title>
</head>
<body>
    <div>Got <?php echo $compensations->getCount(); ?> matching compensations and codes</div>
    <pre><?php print_r($compensations->toArray());?></pre>
    <a href='../index.htm'>Back</a>
</body>
</html>