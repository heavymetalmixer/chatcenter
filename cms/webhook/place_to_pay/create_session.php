<?php

require_once "../../../vendor/autoload.php";

Class PlaceToPayGateway {

    static public function placetopay_payment(string $currency = "COP", string $locale = "es_CO") {

        $login = $_ENV['PLACETOPAY_LOGIN'];
        $secret_key = $_ENV['PLACETOPAY_SECRET_KEY'];

        // Al crear un objeto DateTimeInmutable sin argumentos se usa la fecha y hora local
        // con la respetiva zona horaria, en el caso de Colombia esta es -05:00
        $date_time = new DateTimeImmutable();

        // DATE_ATOM es el formato para fechas bajo ISO-8601
        // También se podría usar simplemente $seed = date('c') pero
        // como es una metdología más antigua podría ser más propensa a bugs
        $seed = $date_time->format(DATE_ATOM);

        // Número al azar y codificado en Base 64
        $nonce_raw_bytes = random_bytes(16); // random_bytes es parte de Random\Randomizer, y es más seguro que la función rand()
        $nonce = base64_encode($nonce_raw_bytes);

        $tran_key = base64_encode(hash("sha256", $nonce_raw_bytes.$seed.$secret_key, true));

        // Datos necesarios para la autenticación que debe hacerse para cada petición
        // En caso de presentarse un error visite este link para más información: https://docs.placetopay.dev/checkout/authentication/
        $auth = [
            "login" => $login,
            "tranKey" => $tran_key,
            "nonce" => $nonce,
            "seed" => $seed
        ];

        $reference = $_POST['reference']; // Referencia única de pago, 32 caracteres
        $description = $_POST['description']; // Descripción de la compra, hasta 250 caracteres
        $amount = floatval($_POST['amount']);

        // Datos para el pago
        // currency es la moneda seleccionada. Por defecto es Pesos Colombianos como COP
        $payment = [
            "reference" => $reference,
            "description" => $description,
            "ammount" => [
                "currency" => $currency,
                "total" => $amount
            ]
        ];

        // Se le añaden $expiration_minutes minutos a $date_time para obtener la fecha de expiration
        // que se pone en $expiration_date y se formatea como ISO-8601
        // Cabe aclarar que $expiration_minutes cómo mínimo debe ser 5 minutos, por defecto son 30
        $expiration_minutes = 30;
        $expiration_date = $date_time->modify("+'.$expiration_minutes.' minutes");
        $expiration_date = $expiration_date->format(DATE_ATOM);

        $create_url = $_ENV['PLACETOPAY_CREATE_URL'];
        $return_url = $_ENV['PLACETOPAY_RETURN_URL'];
        $notify_url = $_ENV['PLACETOPAY_NOTIFY_URL'];

        // Esta será toda la información que se enviará a PlacetoPay
        // locale contiene el idioma y país. Por defecto se pone Español y Colombia como es_CO
        $request_body = [
            "locale" => $locale,
            "auth" => $auth,
            "payment" => $payment,
            "expiration" => $expiration_date,
            "returnUrl" => $return_url,
            "ipAddress" => $_SERVER['REMOTE_ADDR'],
            "userAgent" => $_SERVER['HTTP_USER_AGENT'],
            "notifyUrl" => $notify_url
        ];
    }
}

?>
