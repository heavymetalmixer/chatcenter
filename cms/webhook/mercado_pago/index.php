<?php

require_once "../../../vendor/autoload.php";

use Dotenv\Dotenv;


$test_env = Dotenv::createImmutable("../../../");
$test_env->load();


use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
// use MercadoPago\Exceptions\MPApiException;
// use MercadoPago\Resources\Preference;

// function authenticate() {

//     // Autenticación
//     $access_token = $_ENV['MERCADOPAGO_ACCESS_TOKEN'];
//     MercadoPagoConfig::setAccessToken(".$access_token.");
//     MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);
// }

// function create_preference_request($items, $payer) : array {

//     $payment_methods = [
//         "excluded_payment_methods" => [],
//         "installments" => 12,
//         "default_installments" => 1
//     ];

//     $back_urls = array(
//         "success" => "mercadopago.success",
//         "failure" => "mercadopago.failed"
//     );

//     $request = array(
//         "items" => $items,
//         "payer" => $payer,
//         "payment_methods" => $payment_methods,
//         "back_urls" => $back_urls,
//         "statement_descriptor" => "NAME_DISPLAYED_IN_USER_BILLING",
//         "external_reference" => "1234567890",
//         "expires" => false,
//         "auto_return" => "approved"
//     );

//     return $request;
// }

// function create_payment_preference() : ?Preference {

//     // Datos de los productos a comprar
//     $product1 = array(
//         "id" => "12345674980",
//         "title" => "Product 1 Title",
//         "description" => "Product 1 Description",
//         "currency_id" => "COP",
//         "quantity" => 12,
//         "unit_price" => 9.90
//     );

//     $product2 = array(
//         "id" => "9012345678",
//         "title" => "Product 2 Title",
//         "description" => "Product 2 Description",
//         "currency_id" => "COP",
//         "quantity" => 5,
//         "unit_price" => 19.90
//     );

//     $items = array($product1, $product2);

//     // Se adquieren los datos del comprador (función propia)
//     // $user = getSessionUser();

//     // $payer = array(
//     //     "name" => $user->name,
//     //     "surname" => $user->surname,
//     //     "email" => $user->email,
//     // );

//     $payer = array(
//         "name" => "John",
//         "surname" => "Caro",
//         "email" => "asdfiunsjdfn@gmail.com"
//     );

//     // Se crea el objecto de tipo request para ser enviado a la API de Mercado Pago
//     $request = create_preference_request($items, $payer);

//     $client = new PreferenceClient();

//     try {

//         // Se envía el request a la API
//         $preference = $client->create($request);
//         return $preference;
//     }
//     catch(MPApiException $error) {

//         echo '<pre>$error: '; print_r($error); echo '</pre>';
//         return null;
//     }
// }

// $preference = create_payment_preference();

// // $client = new PreferenceClient();

// // $preference = $client->create([

// //     "items" => array(
// //         array(
// //             "id" => "DEP-0001",
// //             "title" => "Balon de futbol",
// //             "quantity" => 1,
// //             "unit_price" => 550
// //         )
// //     ),

// //     "statement_descriptor" => "Mi tienda de Prueba",
// //     "external_reference" => "MTP001"
// // ]);

// // echo implode($preference);
// // echo '<pre>$preference '; print_r($preference); echo '</pre>';

$test_access_token = $_ENV['MERCADOPAGO_TEST_ACCESS_TOKEN'];
$public_key = $_ENV['MERCADOPAGO_PUBLIC_KEY'];

MercadoPagoConfig::setAccessToken($test_access_token);
MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);

$client = new PreferenceClient();
$preference = $client->create([
    "back_urls" => array(
        "success" => "https://test.com/success",
        "failure" => "https://test.com/failure",
        "pending" => "https://test.com/pending"
    ),
    "auto_return" => "approved",
    "items" => array(
        array(
            "id" => "0001",
            "title" => "Mi producto",
            "quantity" => 1,
            "unit_price" => 2000
        )
    )
]);

// echo $preference;
// echo '<pre>$preference '; print_r($preference); echo '</pre>';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Mi Integración con Checkout Pro</title>
</head>
<body>

    <!-- Contenido de tu página -->


    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <script>
        // Tu código JavaScript irá aquí

        const publicKey = "<?php echo $public_key; ?>";
        const preferenceId = "<?php echo $preference->id; ?>";

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

</body>
</html>
