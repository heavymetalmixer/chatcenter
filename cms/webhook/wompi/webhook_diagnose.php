<?php
// webhook_diagnose.php - pega esto temporalmente como tu webhook

date_default_timezone_set('UTC');
$now = (new DateTimeImmutable())->format(DATE_ATOM);

// recoger raw
$raw = file_get_contents('php://input');

// medir tamaño y bytes
$raw_len = strlen($raw);
$raw_hex = '';
for ($i = 0; $i < min(2000, $raw_len); $i++) {

    $raw_hex .= sprintf("%02x ", ord($raw[$i]));
}
if ($raw_len > 2000) $raw_hex .= '... (truncated)';

// headers
$headers = function_exists('getallheaders') ? getallheaders() : $_SERVER;
$htext = "";

foreach ($headers as $key => $value) {

    $htext .= "$key: $value\n";
}

// superglobals
$post = print_r($_POST, true);

$server = print_r(array_intersect_key($_SERVER, array_flip([
    'REQUEST_METHOD','CONTENT_TYPE','CONTENT_LENGTH','HTTP_CONTENT_ENCODING','HTTP_TRANSFER_ENCODING',
    'REMOTE_ADDR','REQUEST_URI','SERVER_PROTOCOL'
])), true);

// comprobar si body parece gzipped
$is_gzip = false;
if ($raw_len >= 2 && ord($raw[0]) === 0x1f && ord($raw[1]) === 0x8b) {

    $is_gzip = true;
}

// intentar decodificar si no vacío
$json_decode_try = 'empty';

if ($raw_len > 0) {

    // show first attempt result
    $tmp = @json_decode($raw, true);
    $err = json_last_error() === JSON_ERROR_NONE ? 'OK' : json_last_error_msg();
    $json_decode_try = "len={$raw_len} result={$err}";
}
else {

    $json_decode_try = "raw is empty (length 0)";
}

// guardar log diagnóstico
$log = "=== DIAGNOSE {$now} ===\n";
$log .= "REQUEST_METHOD: {$_SERVER['REQUEST_METHOD']}\n";
$log .= "CONTENT_TYPE: " . ($_SERVER['CONTENT_TYPE'] ?? ($_SERVER['HTTP_CONTENT_TYPE'] ?? '')) . "\n";
$log .= "CONTENT_LENGTH: " . ($_SERVER['CONTENT_LENGTH'] ?? 'n/a') . "\n";
$log .= "HEADERS:\n" . $htext . "\n";
$log .= "SERVER INFO:\n" . $server . "\n";
$log .= "RAW LENGTH: {$raw_len}\n";
$log .= "RAW (first 2000 bytes as hex):\n{$raw_hex}\n";
$log .= "RAW (first 2000 bytes as text):\n" . substr($raw, 0, 2000) . "\n";
$log .= "IS_GZIP_MAGIC: " . ($is_gzip ? 'yes' : 'no') . "\n";
$log .= "JSON_DECODE_TRY: {$json_decode_try}\n";
$log .= "SUPERGLOBAL \$_POST:\n{$post}\n";
$log .= "=== END ===\n\n";

file_put_contents('wompi_diagnose.log', $log, FILE_APPEND);

// RESPUESTA AL CLIENTE (útil para pruebas)
http_response_code(200);
echo json_encode(['diagnose' => true, 'raw_len' => $raw_len, 'is_gzip' => $is_gzip]);

?>
