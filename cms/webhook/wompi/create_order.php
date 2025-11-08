<?php

require_once "../../../vendor/autoload.php";

header('Content-Type: application/json');

use Dotenv\Dotenv;
$test_env = Dotenv::createImmutable("../../../");
$test_env->load();

$wompi_environment = $_ENV['WOMPI_ENVIRONMENT'];
$public_key = $_ENV['WOMPI_TEST_PUBLIC_KEY'];
$integrity_secret = $_ENV['WOMPI_TEST_INTEGRITY_SECRET'];

$folder_path = $_ENV['WOMPI_FOLDER_PATH'];
$redirection_url = $folder_path."redirection.php";

// Al crear un objeto DateTimeInmutable sin argumentos se usa la fecha y hora local
// con la respetiva zona horaria, en el caso de Colombia esta es -05:00
$date_time = new DateTimeImmutable();

// DATE_ATOM es el formato para fechas bajo ISO-8601
// También se podría usar simplemente $seed = date('c') pero
// como es una metodología más antigua podría ser más propensa a bugs
$seed = $date_time->format(DATE_ATOM);

// Número al azar y codificado en Base 64
$random_raw_bytes = random_bytes(32); // random_bytes es parte de Random\Randomizer, y es más seguro que la función rand()
$random_b64_bytes = base64_encode($random_raw_bytes);

// La referencia debe ser un código irrepetible y creado por el negocio
$reference = "ORD-".$seed.$random_b64_bytes;
$amount_in_cents = 5000000; // 50.000 COP
$currency = "COP";

// Se le añaden $expiration_minutes minutos a $date_time para obtener la fecha de expiración
// que se pone en $expiration_date y se formatea como ISO-8601
// Cabe aclarar que este es el único parámetro opcional de los usados para la "firma"
$expiration_minutes = 30;
$expiration_date = $date_time->modify("+'.$expiration_minutes.' minutes");
$expiration_date = $expiration_date->format(DATE_ATOM);

// sha256("<Referencia><Monto><Moneda><FechaExpiracion><SecretoIntegridad>")
// Si se usa el parámetro expiration-time, se cambia a esto: sha256("<Referencia><Monto><Moneda><FechaExpiracion><SecretoIntegridad>")
$signature = hash("sha256", $reference.$amount_in_cents.$currency.$expiration_date.$integrity_secret);

// (Opcional) Guarda en base de datos aquí
// INSERT INTO orders (reference, amount, status) VALUES (...)

$transation = json_encode([
    'public_key' => $public_key,
    'currency' => $currency,
    'amount_in_cents' => $amount_in_cents,
    'reference' => $reference,
    'signature' => $signature,
    'redirect_url' => $redirection_url,
    'expiration_time' => $expiration_date
]);

?>
