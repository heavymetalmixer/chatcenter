<?php

require_once "../../../vendor/autoload.php";

use Dotenv\Dotenv;


$test_env = Dotenv::createImmutable("../../../");
$test_env->load();


use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;

$access_token = $_ENV['MERCADOPAGO_ACCESS_TOKEN'];
MercadoPagoConfig::setAccessToken(".$access_token.");

$client = new PreferenceClient();

$preference = $client->create([

    "items" => array(
        array(
            "id" => "DEP-0001",
            "title" => "Balon de futbol",
            "quantity" => 1,
            "unit_price" => 550
        )
    ),

    "statement_descriptor" => "Mi tienda de Prueba",
    "external_reference" => "MTP001"
]);

// echo implode($preference);
// echo '<pre>$preference '; print_r($preference); echo '</pre>';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Document</title>
</head>
<body>
    <div id="wallet_container"></div>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script>
        const mp = new MercadoPago('APP_USR-2db32874-0cdd-40e1-98cc-57d677387844', {

            locale: "es-CO"
        });

        const bricks_builder = mp.bricks();
        const render_wallet_brick = async (bricks_builder) => {

            await bricks_builder.create("wallet", "walletBrick_container", {
                initialization: { preferenceId: '<?php echo $preference->id; ?>', }
            });
        };

        render_wallet_brick(bricks_builder);
    </script>
</body>
</html>
