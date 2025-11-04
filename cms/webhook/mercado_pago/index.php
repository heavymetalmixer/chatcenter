<?php

require_once "../../../vendor/autoload.php";

use Dotenv\Dotenv;
$test_env = Dotenv::createImmutable("../../../");
$test_env->load();

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
// echo '<pre>$preference '; print_r($preference); echo '</pre>';

$test_access_token = $_ENV['MERCADOPAGO_TEST_ACCESS_TOKEN'];
$public_key = $_ENV['MERCADOPAGO_PUBLIC_KEY'];
$folder_path = $_ENV['MERCADOPAGO_FOLDER_PATH'];

MercadoPagoConfig::setAccessToken($test_access_token);
MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);

$client = new PreferenceClient();

// Para que las diferentes opciones de pago funcionen correctamente
// se debe poner un cierto monto mínimo que Mercado Pago no especifica.
// Por ser de Colombia yo puse 30.000 y funciona bien
$item = [
    "id" => "DEP-0001",
    "title" => "Balón de Fútbol",
    "quantity" => 1,
    "unit_price" => 30000,
    "currency_id" => "COP"
];

$back_urls = array(
    "success" => $folder_path."success.php",
    "failure" => $folder_path."failure.php",
    "pending" => $folder_path."pending.php"
);

$notification_url = $folder_path."notifications.php";

$preference = $client->create([
    "back_urls" => $back_urls,
    "auto_return" => "approved",
    "items" => [$item],
    "notification_url" => $notification_url,
    "statement_descriptor" => "Mi Tienda CDP",
    "external_reference" => "CDP001"
]);

// $preference_id = $preference->id;

// echo $preference;
// echo '<pre>$preference '; print_r($preference); echo '</pre>';

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Integración con Checkout Pro</title>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>
<body>

    <!-- Contenido de tu página -->

    <div id="wallet_container"></div>

    <script>
        const public_key = "<?php echo $public_key; ?>";
        const mp = new MercadoPago(public_key, {
            locale: 'es-CO'
        });

        mp.bricks().create("wallet", "wallet_container", {
            initialization: {
                preferenceId: '<?php echo $preference->id; ?>'
            }
        });

    </script>

</body>
</html>
