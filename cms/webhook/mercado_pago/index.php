<?php

require_once "../../../vendor/autoload.php";

use Dotenv\Dotenv;
$test_env = Dotenv::createImmutable("../../../");
$test_env->load();

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
// echo '<pre>$preference '; print_r($preference); echo '</pre>';

$environment = $_ENV['MERCADOPAGO_SANDBOX_ENVIRONMENT'];

if ($environment == $_ENV['MERCADOPAGO_SANDBOX_ENVIRONMENT'])
{
    $access_token = $_ENV['MERCADOPAGO_TEST_ACCESS_TOKEN'];
    $public_key = $_ENV['MERCADOPAGO_TEST_PUBLIC_KEY'];
}
elseif ($environment == $_ENV['MERCADOPAGO_PRODUCTION_ENVIRONMENT'])
{
    $access_token = $_ENV['MERCADOPAGO_PROD_ACCESS_TOKEN'];
    $public_key = $_ENV['MERCADOPAGO_PROD_PUBLIC_KEY'];
}
else
{
    throw new Exception("INVALID MERCADO PAGO KEY! Please, check the .env file to choose the wright one.", 1);
}

$folder_path = $_ENV['MERCADOPAGO_FOLDER_PATH'];

MercadoPagoConfig::setAccessToken($access_token);
MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);

$client = new PreferenceClient();

// Para que las diferentes opciones de pago funcionen correctamente
// se debe poner un cierto monto mínimo que Mercado Pago no especifica.
// Por ser de Colombia yo puse 30.000 y funciona bien
$items = [
    [
        "id" => "DEP-0001",
        "title" => "Balón de Fútbol",
        "description" => "Balón de Futbol clásico, marca Golty",
        "picture_url" => "",
        "category_id" => "Deportes",
        "quantity" => 1,
        "unit_price" => 30000,
        "currency_id" => "COP"
    ],
    [
        "id" => "DEP-0002",
        "title" => "Tenis deportivos",
        "quantity" => 1,
        "unit_price" => 30000,
        "currency_id" => "COP"
    ]
];

$back_urls = array(
    "success" => $folder_path."success.php",
    "failure" => $folder_path."failure.php",
    "pending" => $folder_path."pending.php"
);

$notification_url = $folder_path."notifications.php";

// Para auto_return los valores pueden ser "approved", "declined" o "pending"
// TODO: Investigar por qué "debvisa" no excluye las tarjetas débito de VISA
// "ticket" es efectivo y formas de pago similares como Efecty
// "installments" es la cantidad máxima de cuotas para pagar
// "wallet_purchase" no admite pagar si no se está usando cuenta de Mercado Pago
// Por lo general al finalizar una compra el pago puede ser aprobado, rechazado o pendiente,
// con "binary_mode" en true solo se puede aprovado o rechazado
$preference = $client->create([
    "notification_url" => $notification_url,
    "back_urls" => $back_urls,
    "auto_return" => "approved",
    "items" => $items,
    "payment_methods" => [
        /*"excluded_payment_methods" => [
            [
                "id" => "visa"
            ],
            [
                "id" => "amex"
            ]
        ],
        "excluded_payment_types" => [
            [
                "id" => "debit card"
            ],
            [
                "id" => "ticket"
            ]
        ],*/
        "installments" => 10
    ],
    //"purpose" => "wallet_purchase",
    //"binary_mode" => true,
    "shipments" => [
        "cost" => 5000,
        "mode" => "not_specified"
    ],
    "statement_descriptor" => "Dpartes",
    "external_reference" => "CDP001"
]);

// echo '<pre>$preference: '; print_r($preference); echo '</pre><br><br>';

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
                preferenceId: '<?php echo $preference->id; ?>',
                redirectMode: 'self',
            },
            customization: {
                texts: {
                    action: 'buy',
                    valueProp: 'security_details'
                },
                visual: {
                    buttonBackground: 'default', // default, black, blue, white
                    borderRadius: '24px', // 6px
                    buttonHeight: '60px', // 48px o más
                    valuePropColor: 'black' // gray
                }
            }
        });

    </script>

</body>
</html>
