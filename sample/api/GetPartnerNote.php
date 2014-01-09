<?php
/**
 * This sample demonstrates how to get
 * the B2B partner note
 *
 * API action: getproperty
 */

require __DIR__ . '/../bootstrap.php';
use TiTravel\Api\PartnerNote;


/**
 * Retreive the B2B partner note
 */
try {
    $params = array(
        'language' => 'en',
    );
    $note = PartnerNote::get($params, $apiCredentials);
} catch (Exception $ex) {
    echo 'Exception:', $ex->getMessage(), PHP_EOL;
    exit(1);
}
?>
<html>
<head>
<title>Get partner note</title>
</head>
<body>
    <div>Got partner note:</div>
    <pre><?php print_r($note->note);?></pre>
    <a href='../index.htm'>Back</a>
</body>
</html>