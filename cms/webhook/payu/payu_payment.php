<?php

require_once "../../../vendor/autoload.php";

Class PayUGateway {

    static public function payu_curl($api_url, $data) {

        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);
        return $result;
    }

    static public function payu_payment() {

        $api_key = $_ENV['PAYU_API_KEY'];
        $merchant_id = $_ENV['PAYU_MERCHANT_ID'];
        $account_id = $_ENV['PAYU_ACCOUNT_ID'];
        $api_url = $_ENV['PAYU_API_URL'];
        $response_url = $_ENV['PAYU_RESPONSE_URL'];
        $confirmation_url = $_ENV['PAYU_CONFIRMATION_URL'];

        $reference_code = 'ORD-' . time();
        $amount = $_POST['amount'];
        $currency = 'COP';

        // Generar firma (según PayU docs)
        $signature = md5("$api_key~$merchant_id~$reference_code~$amount~$currency");

        // Datos de transacción
        $data = [
            "language" => "es",
            "command" => "SUBMIT_TRANSACTION",
            "merchant" => [
                "apiKey" => $api_key,
                "apiLogin" => $_ENV['PAYU_API_LOGIN']
            ],
            "transaction" => [
                "order" => [
                    "accountId" => $account_id,
                    "referenceCode" => $reference_code,
                    "description" => "Pago de prueba",
                    "language" => "es",
                    "signature" => $signature,
                    "notifyUrl" => $confirmation_url,
                    "additionalValues" => [
                        "TX_VALUE" => ["value" => floatval($amount), "currency" => $currency]
                    ],
                    "buyer" => [
                        "fullName" => $_POST['name'],
                        "emailAddress" => $_POST['email']
                    ]
                ],
                "payer" => [
                    "fullName" => $_POST['name'],
                    "emailAddress" => $_POST['email']
                ],
                "creditCard" => [
                    "number" => "4111111111111111", // Tarjeta de prueba
                    "securityCode" => "123",
                    "expirationDate" => "2025/12",
                    "name" => "APPROVED"
                ],
                "extraParameters" => ["INSTALLMENTS_NUMBER" => 1],
                "type" => "AUTHORIZATION_AND_CAPTURE",
                "paymentMethod" => "VISA",
                "paymentCountry" => "CO",
                "deviceSessionId" => session_id(),
                "ipAddress" => $_SERVER['REMOTE_ADDR'],
                "cookie" => "pt1t38347bs6jc9ruv2ecpv7o2",
                "userAgent" => $_SERVER['HTTP_USER_AGENT']
            ],
            "test" => true
        ];

        // Llamar API PayU
        // $ch = curl_init($api_url);
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        // curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $response = curl_exec($ch);
        // curl_close($ch);

        // $result = json_decode($response, true);
        $result = PayUGateway::payu_curl($api_url, $data);

        if (isset($result['transactionResponse']['state']) && $result['transactionResponse']['state'] === 'APPROVED') {

            header("Location: ../public/success.php");
            exit;
        }
        else {

            echo "<pre>";
            echo "Respuesta de PayU:<br>";
            print_r($result);
            echo "</pre>";
        }
    }
}

?>
