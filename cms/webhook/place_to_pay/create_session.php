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
        // returnUrl es la URL a la que se redirige al usuario una vez termina la sesión. Ocurre cuando el usuario da click en Volver al comercio.
        // userAgent: User Agent del navegador del usuario que realizará el proceso. Por ejemplo "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36"
        // TODO: Checar si "buyer" es necesario
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

        $create_session_curl = curl_init($create_url);

        curl_setopt($create_session_curl, CURLOPT_POST, true);
        curl_setopt($create_session_curl, CURLOPT_POSTFIELDS, json_encode($request_body));
        curl_setopt($create_session_curl, CURLOPT_HEADER, ["Content-Type: application/json"]);
        curl_setopt($create_session_curl, CURLOPT_RETURNTRANSFER, true);

        $raw_response = curl_exec($create_session_curl);
        curl_close($create_session_curl);

        $decoded_response = json_decode($raw_response, true);

        /*
        Ejemplo de una respuesta exitosa en JSON:
            {
                "status": {
                    "status": "OK",
                    "reason": "PC",
                    "message": "La petición se ha procesado correctamente",
                    "date": "2021-11-30T15:08:27-05:00"
                },
                "requestId": 1,
                "processUrl": "https://checkout-co.placetopay.com/session/1/cc9b8690b1f7228c78b759ce27d7e80a",
            }

        Ejemplo de respuesta fallida:
            {
                "status": {
                    "status": "FAILED",
                    "reason": 401,
                    "message": "Autenticación fallida 102",
                    "date": "2021-11-30T15:12:25-05:00"
                },
            }
        */

        if (isset($res['status']) && isset($res['processUrl']) && isset($res['requestId'])) {

            $process_url = $res['processUrl'];
            $request_id = $res['requestId'];
            // TODO: Guardar en la base de datos $reference, $request_id, y "status", con implementación dependiendo del proyecto
            // Tal vez como static public void save_session_state(string $reference, int $request_id, string $status)

            header("Location: $process_url");
            exit;
        }
        else {

            echo "<h3>Error creando sesión de pago</h3>";
            echo "<pre>" . htmlspecialchars($decoded_response) . "</pre>";
        }
    }
}

?>
