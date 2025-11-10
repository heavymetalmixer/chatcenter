<?php

// --- Log completo para depuración ---
$logFile = 'wompi_debug.log';
$logData = [
    'time' => date('c'),
    'method' => $_SERVER['REQUEST_METHOD'] ?? 'N/A',
    'uri' => $_SERVER['REQUEST_URI'] ?? 'N/A',
    'content_type' => $_SERVER['CONTENT_TYPE'] ?? '(no content type)',
    'content_length' => $_SERVER['CONTENT_LENGTH'] ?? '(no content length)',
    'headers' => getallheaders(),
    'raw_input' => file_get_contents('php://input')
];

file_put_contents($logFile, print_r($logData, true) . "\n\n", FILE_APPEND);

http_response_code(200);
echo "Webhook OK";

// Solo se aceptan peticiones de tipo POST. Esto es para prevenir la segunda
// de tipo GET que Wompi manda y no tiene body
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    http_response_code(200);
    echo "Webhook endpoint active (GET request ignored)";
    exit;
}

$date_time = new DateTimeImmutable();
$seed = $date_time->format(DATE_ATOM);

$input = file_get_contents('php://input');

try {

    $event = json_decode($input, true, 512, JSON_THROW_ON_ERROR);
}
catch(JsonException $e) {

    file_put_contents(
        'wompi_webhook_error.log',
        '['.$seed."] Error JSON: ".$e->getMessage().PHP_EOL."Contenido: ".$input.PHP_EOL,
        FILE_APPEND
    );

    http_response_code(400);
    echo "Invalid JSON: ".$e->getMessage();

    exit;
}

if (isset($event['data']['transaction']) && $event['event'] === "transaction.updated") {

    $transaction_response = $event['data']['transaction'];
    $status_response = $transaction_response['status'];
    $reference_response = $transaction_response['reference'];

    // Se guarda el log limpio
    file_put_contents(
        'wompi_webhook.log',
        '['.$seed.'] '." OK ref={$reference} status={$status}".PHP_EOL,
        FILE_APPEND
    );

    // Actualizar en la base de datos según el estado
    // Ejemplo: UPDATE orders SET status = '$status' WHERE reference = '$reference';

    http_response_code(200);
    echo '<br><pre>$transation_response: '; print_r($transaction_response); echo '</pre><br><br>';
    echo "OK<br>";
}
else {

    http_response_code(400);
    echo "Invalid event structure";
}

?>
