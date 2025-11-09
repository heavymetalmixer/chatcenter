<?php


require_once '../../../vendor/autoload.php';

$input = file_get_contents('php://input');
$event = json_decode($input, true);

echo '<pre>$input: '; print_r($input); echo '</pre><br><br>';
echo '<pre>$event: '; print_r($event); echo '</pre><br><br>';

$date_time = new DateTimeImmutable();
$seed = $date_time->format(DATE_ATOM);

// file_put_contents(__DIR__ . '/../logs/wompi_webhook.log', $seed . " " . $input . "\n", FILE_APPEND);
file_put_contents('wompi_webhook.log', $seed . " " . $input . "\n", FILE_APPEND);

if (isset($event['data']['transaction']) && $event['event'] == "transaction.updated") {

    $transaction_response = $event['data']['transaction'];
    $status_response = $transaction_response['status'];
    $reference_response = $transaction_response['reference'];

    // Actualizar en la base de datos según el estado
    // Ejemplo: UPDATE orders SET status = '$status' WHERE reference = '$reference';

    http_response_code(200);
    echo '<br><pre>$transation_response: '; print_r($transaction_response); echo '</pre><br><br>';
    echo "OK<br>";
}
else {

    http_response_code(400);
    echo "The transaction failed to be completed<br>";
}

?>
