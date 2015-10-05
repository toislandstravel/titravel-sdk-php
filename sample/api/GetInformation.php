<?php
/**
 * This sample demonstrates how to get
 * the available attributes list
 *
 * API action: information
 */

require __DIR__ . '/../bootstrap.php';
use TiTravel\Api\Information;


/**
 * Retrive the attributes list using optional
 * filters and your API credentials
 * (see bootstrap.php for credentials creation)
 */
try {
  $information = Information::get($apiCredentials);
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
    <h1>Get default year</h1>
    <p>Default year <?php echo $information->getDefaultYear(); ?></p>
    <p>PricelistYears <pre><?php var_dump($information->getPricelistYears()); ?></pre></p>
  </body>
</html>
