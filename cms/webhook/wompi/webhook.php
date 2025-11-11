<?php

$date_time = new DateTimeImmutable();
$seed = $date_time->format(DATE_ATOM);

$log_debug = 'wompi_debug.log';
$log_ok = 'wompi_webhook.log';
$log_err = 'wompi_webhook_error.log';

$input = file_get_contents('php://input');
$method = $_SERVER['REQUEST_METHOD'] ?? 'N/A';

// Log de toda la petición
file_put_contents($log_debug, print_r([
    'time'=> $seed,
    'method' => $method,
    'uri' => $_SERVER['REQUEST_URI'] ?? '',
    'content_type' => $_SERVER['CONTENT_TYPE'] ?? '(none)',
    'raw_input' => $input
], true)."\n\n", FILE_APPEND);

// Solo se aceptan peticiones de tipo POST. Esto es para prevenir la segunda
// de tipo GET que Wompi manda y no tiene body
if ($method !== 'POST') {

    http_response_code(200);
    echo "Webhook endpoint active (GET request ignored)";
    exit;
}

$event = null;

// Guardar el JSON obtenido en un array
try {

    $event = json_decode($input, true, 512, JSON_THROW_ON_ERROR);
}
catch(JsonException $e) {

    file_put_contents(
        $log_err,
        $seed." Invalid JSON: ".$e->getMessage()."\nInput: ".$input."\n\n",
        FILE_APPEND
    );

    http_response_code(400);
    echo "Invalid JSON: ".$e->getMessage();
    exit;
}

file_put_contents('wompi_parsed.log', print_r($event, true), FILE_APPEND);

if (isset($event['event']) && $event['event'] === "transaction.updated" && isset($event['data']['transaction'])) {

    $transaction_response = $event['data']['transaction'];
    $status_response = $transaction_response['status'] ?? '(sin status)';
    $reference_response = $transaction_response['reference'] ?? '(sin referencia)';
    $id = $transaction_response['id'] ?? '(sin id)';

    // Se guarda el log limpio
    file_put_contents(
        $log_ok,
        sprintf(
            "[%s] OK id=%s ref=%s status=%s\n",
            $seed,
            $id,
            $reference_response,
            $status_response
        ),
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
