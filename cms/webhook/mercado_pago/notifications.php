<?php

require_once "../../../vendor/autoload.php";

use Dotenv\Dotenv;
$test_env = Dotenv::createImmutable("../../../");
$test_env->load();

// Obtain the x-signature value from the header
$x_signature = $_SERVER['HTTP_X_SIGNATURE'];
$x_request_id = $_SERVER['HTTP_X_REQUEST_ID'];

// Obtain Query params related to the request URL
$query_params = $_GET;

// Extract the "data.id" from the query params
$data_id = isset($query_params['data.id']) ? $query_params['data.id'] : '';

// Separating the x-signature into parts
$parts = explode(',', $x_signature);

// Initializing variables to store ts and hash
$ts = null;
$hash = null;

// Iterate over the values to obtain ts and v1
foreach ($parts as $part) {

    // Split each part into key and value
    $keyValue = explode('=', $part, 2);

    if (count($keyValue) == 2) {

        $key = trim($keyValue[0]);
        $value = trim($keyValue[1]);

        if ($key === "ts") {

            $ts = $value;
        }
        elseif ($key === "v1") {

            $hash = $value;
        }
    }
}

// Obtain the secret key for the user/application from Mercadopago developers site
$secret = $_ENV['MERCADOPAGO_SECRET_KEY'];

// Generate the manifest string
$manifest = "id:'.$data_id.';request-id:'.$x_request_id.';ts:'.$ts.';";

// Create an HMAC signature defining the hash type and the key as a byte array
$sha = hash_hmac('sha256', $manifest, $secret);

if ($sha === $hash) {

    // HMAC verification passed
    echo "HMAC verification passed<br>";
}
else {

    // HMAC verification failed
    echo "HMAC verification failed<br>";
}

$url = "https://api.example.com/data";
$response = file_get_contents($url);
echo $response;

http_response_code(200);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications Page</title>
</head>
<body>

</body>
</html>
