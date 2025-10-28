<?php

require_once "../../../vendor/autoload.php";
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;

class MercadoPago {

    // Type POST
    static public function create_preference() {

        $access_token = $_ENV['MERCADOPAGO_ACCESS_TOKEN'];
        MercadoPagoConfig::setAccessToken(".$access_token.");

        $client = new PreferenceClient();

        // $preference = $client->create([
        //     "back_urls"=>array(
        //         "success" => "https://test.com/success",
        //         "failure" => "https://test.com/failure",
        //         "pending" => "https://test.com/pending"
        //     ),
        //     "differential_pricing" => array(
        //         "id" => 1,
        //     ),
        //     "expires" => false,
        //     "items" => array(
        //         array(
        //             "id" => "1234",
        //             "title" => "Dummy Title",
        //             "description" => "Dummy description",
        //             "picture_url" => "https://www.myapp.com/myimage.jpg",
        //             "category_id" => "car_electronics",
        //             "quantity" => 2,
        //             "currency_id" => "COP",
        //             "unit_price" => 100
        //         )
        //     ),
        //     "marketplace_fee" => 0,
        //     "payer" => array(
        //         "name" => "Test",
        //         "surname" => "User",
        //         "email" => "your_test_email@example.com",
        //         "phone" => array(
        //             "area_code" => "11",
        //             "number" => "4444-4444"
        //         ),
        //         "identification" => array(
        //             "type" => "CPF",
        //             "number" => "19119119100"
        //         ),
        //         "address" => array(
        //             "zip_code" => "06233200",
        //             "street_name" => "Street",
        //             "street_number" => "123"
        //         )
        //     ),
        //     "additional_info" => "Discount: 12.00",
        //     "auto_return" => "all",
        //     "binary_mode" => true,
        //     "external_reference" => "1643827245",
        //     "marketplace" => "none",
        //     "notification_url" => "https://notificationurl.com",
        //     "operation_type" => "regular_payment",
        //     "payment_methods" => array(
        //         "default_payment_method_id" => "master",
        //         "excluded_payment_types" => array(
        //             array(
        //                 "id" => "visa"
        //             )
        //         ),
        //         "excluded_payment_methods" => array(
        //             array(
        //                 "id" => ""
        //             )
        //         ),
        //         "installments" => 5,
        //         "default_installments" => 1
        //     ),
        //     "shipments" >= array(
        //         "mode" => "custom",
        //         "local_pickup" => false,
        //         "default_shipping_method" => null,
        //         "free_methods" => array(
        //             array(
        //                 "id" => 1
        //             )
        //         ),
        //         "cost" => 10,
        //         "free_shipping" => false,
        //         "dimensions" => "10x10x20,500",
        //         "receiver_address" => array(
        //             "zip_code" => "06000000",
        //             "street_number" => "123",
        //             "street_name" => "Street",
        //             "floor" => "12",
        //             "apartment" => "120A",
        //             "city_name" => "Rio de Janeiro",
        //             "state_name" => "Rio de Janeiro",
        //             "country_name" => "Brasil"
        //         )
        //     ),
        //     "statement_descriptor" => "Test Store",
        // ]);

        $preference = $client->create([

            "items" =>[
                [
                    "id" => "DEP-0001",
                    "title" => "Balon de futbol",
                    "quantity" => 1,
                    "unit_price" => 550
                ]
            ],

            "statement_descriptor" => "Mi tienda de Prueba",
            "external_reference" => "MTP001"
        ]);

        // echo implode($preference);
        echo '<pre>$preference '; print_r($preference); echo '</pre>';

        /*
        Ejemplo de respuesta:
        {
            "collector_id": 202809963,
            "items": [
                {
                "title": "Dummy Item",
                "description": "Multicolor Item",
                "currency_id": "COP",
                "quantity": 1,
                "unit_price": 10
                }
            ],
            "payer": {
                "phone": {},
                "identification": {
                "type": "NIT"
                },
                "address": {}
            },
            "back_urls": {
                "success": "https://test.com/success",
                "pending": "https://test.com/pending",
                "failure": "https://test.com/failure"
            },
            "auto_return": "approved",
            "payment_methods": {
                "excluded_payment_methods": [
                {}
                ],
                "excluded_payment_types": [
                {}
                ]
            },
            "client_id": "6295877106812064",
            "marketplace": "MP-MKT-6295877106812064",
            "marketplace_fee": 0,
            "shipments": {
                "receiver_address": {}
            },
            "notification_url": "https://notificationurl.com",
            "statement_descriptor": "MERCADOPAGO",
            "expiration_date_from": "2022-11-17T09:37:52.000-04:00",
            "expiration_date_to": "2022-11-17T10:37:52.000-05:00",
            "date_created": "2022-11-17T10:37:52.000-05:00",
            "id": "202809963-920c288b-4ebb-40be-966f-700250fa5370",
            "init_point": "https://www.mercadopago.com/mla/checkout/start?pref_id=202809963-920c288b-4ebb-40be-966f-700250fa5370",
            "preference_expired": true,
            "sandbox_init_point": "https://sandbox.mercadopago.com/mla/checkout/pay?pref_id=202809963-920c288b-4ebb-40be-966f-700250fa5370",
            "metadata": {}
        }

        */
    }

    // TODO: Implement
    // Type GET
    static public function search_preferences() {


    }

    // TODO: Implement
    // Type Get
    static public function get_preference() {


    }

    // TODO: Implement
    // Type PUT
    static public function update_preference() {


    }
}

?>
