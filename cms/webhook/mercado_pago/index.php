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

MercadoPagoConfig::setAccessToken($test_access_token);
MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);

$client = new PreferenceClient();

$item = array(
    "id" => "0001",
    "title" => "Producto CDP",
    "quantity" => 1,
    "unit_price" => 150,
    "currency_id" => "COP"
);

$back_urls = array(
    "success" => "https://371300c171c4.ngrok-free.app/chatcenter/cms/webhook/mercado_pago/success.php",
    "failure" => "https://371300c171c4.ngrok-free.app/chatcenter/cms/webhook/mercado_pago/failure.php",
    "pending" => "https://371300c171c4.ngrok-free.app/chatcenter/cms/webhook/mercado_pago/pending.php"
);

$notification_url = "https://371300c171c4.ngrok-free.app/chatcenter/cms/webhook/mercado_pago/notifications.php";

$preference = $client->create([
    "back_urls" => $back_urls,
    "auto_return" => "approved",
    "items" => array($item),
    "notification_url" => $notification_url
]);

$preference_id = $preference->id;

// echo $preference;
// echo '<pre>$preference '; print_r($preference); echo '</pre>';

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Integración con Checkout Pro</title>


</head>
<body>

    <!-- Contenido de tu página -->

    <h3>Mercado Pago</h3>

    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <script>
        // Tu código JavaScript irá aquí

        const publicKey = "<?php echo $public_key; ?>";
        const preferenceId = "<?php echo $preference_id; ?>";

        // Inicializa el SDK de Mercado Pago
        const mp = new MercadoPago(publicKey);

        const bricksBuilder = mp.bricks();

        const renderWalletBrick = async (bricksBuilder) => {
            await bricksBuilder.create("wallet", "walletBrick_container", {
                initialization: {
                    preferenceId: "<PREFERENCE_ID>",
                }
            });
        };

        renderWalletBrick(bricksBuilder);
    </script>
    <div id="walletBrick_container"></div>

    </script>

</body>
</html>
