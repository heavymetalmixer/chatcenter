<?php

require_once "../../../vendor/autoload.php";

use Dotenv\Dotenv;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;

$test_env = Dotenv::createImmutable("../../../");
$test_env->load();

$environment = $_ENV['MERCADOPAGO_SANDBOX_ENVIRONMENT'];

if ($environment == $_ENV['MERCADOPAGO_SANDBOX_ENVIRONMENT'])
{
    $access_token = $_ENV['MERCADOPAGO_TEST_ACCESS_TOKEN'];
}
elseif ($environment == $_ENV['MERCADOPAGO_PRODUCTION_ENVIRONMENT'])
{
    $access_token = $_ENV['MERCADOPAGO_PROD_ACCESS_TOKEN'];
}
else
{
    throw new Exception("INVALID MERCADO PAGO KEY! Please, check the .env file to choose the wright one.", 1);
}

MercadoPagoConfig::setAccessToken($access_token);
$date_time = new DateTimeImmutable();
$seed = $date_time->format(DATE_ATOM);

$notification = file_get_contents("php://input");
$log_err = 'notifications_error.log';
file_put_contents("notifications_raw.log", $seed." INPUT: ".$notification."\n", FILE_APPEND);

// Se intenta decodificar la notificación entrante, y si falla, se lanza una excepción
try
{
    $data = json_decode($notification, true, 512, JSON_THROW_ON_ERROR);
}
catch(JsonException $e)
{
    file_put_contents(
        $log_err,
        $seed." Invalid JSON: ".$e->getMessage()."\nInput: ".$notification."\n\n",
        FILE_APPEND
    );

    http_response_code(400);
    echo "Invalid JSON: ".$e->getMessage();
    exit;
}

http_response_code(200);


$payment_id = null;

// Formato nuevo: { type: "payment.created", data: { id: XXX } }
if (isset($data['type']) && $data['type'] === 'payment')
{
    try
    {
        $payment_id = $data['data']['id'];
        file_put_contents("pagos.txt",
            $seed." INFO: \n".json_encode($data, JSON_PRETTY_PRINT)."\n\n",
            FILE_APPEND
        );

        $payment_client = new PaymentClient();
        $payment = $payment_client->get($payment_id);
        file_put_contents("pagos.txt",
            $seed." PAGO: \n".json_encode($payment, JSON_PRETTY_PRINT)."\n\n",
            FILE_APPEND
        );
    }
    catch(Exception $e)
    {
        file_put_contents($log_err,
            $seed." ERROR: \n".$e->getMessage()."\n\n",
            FILE_APPEND
        );

        error_log($e->getMessage());
    }
}

// Formato antiguo (topic=payment): resource = payment_id
elseif (isset($data['topic']) && $data['topic'] === 'payment' && !empty($data['resource']))
{
    try
    {
        $payment_id = $data['resource'];
        file_put_contents("pagos.txt",
            $seed." INFO: \n".json_encode($data, JSON_PRETTY_PRINT)."\n\n",
            FILE_APPEND
        );

        $payment_client = new PaymentClient();
        $payment = $payment_client->get($payment_id);
        file_put_contents("pagos.txt",
            $seed." PAGO: \n".json_encode($payment, JSON_PRETTY_PRINT)."\n\n",
            FILE_APPEND
        );
    }
    catch(Exception $e)
    {
        file_put_contents($log_err,
            $seed." ERROR: \n".$e->getMessage()."\n\n",
            FILE_APPEND
        );

        error_log($e->getMessage());
    }
}

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
