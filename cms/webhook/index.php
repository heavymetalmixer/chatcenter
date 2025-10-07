<?php

/*=============================================
Depurar Errores
=============================================*/


define('DIR',__DIR__);

ini_set("display_errors", 1);
ini_set("log_errors", 1);
ini_set("error_log", DIR."/php_error_log");


/*=============================================
Librerías de terceros
=============================================*/

require_once "../../vendor/autoload.php";

use Dotenv\Dotenv;


$env_vars = Dotenv::createImmutable("../../");
$env_vars->load();
// $env_vars->required("CHATCENTER_URL_API")->notEmpty();

/*=============================================
Controladores
=============================================*/

require_once "../controllers/curl.controller.php";
require_once "../controllers/clients.controller.php";
require_once "../controllers/business.controller.php";
require_once "../controllers/bots.controller.php";
require_once "../controllers/ia.controller.php";

/*=============================================
TOKEN que configuras en la plataforma de Meta
=============================================*/

$token = "1234abcd";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["hub_verify_token"])) {

    if ($_GET["hub_verify_token"] == $token) {

        echo $_GET["hub_challenge"];

        exit;
    }
    else {

        echo "Token inválido";
        exit;
    }
}

/*=============================================
Recibir respuesta de la API de WS
=============================================*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    date_default_timezone_set("America/Bogota");

//###################################################################################################

    // 1) Leer raw input
    $rawInput = file_get_contents('php://input');

    // 2) Responder 200 inmediatamente para que Meta no reintente
    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode(["ok" => true]);

    // Si PHP-FPM, esto termina respuesta al cliente pero permite seguir procesando.
    if (function_exists('fastcgi_finish_request')) {

        fastcgi_finish_request();
    }
    else {

        // fallback
        ob_flush();
        flush();
    }

    // 3) Continuar procesamiento (ahora en background del request)
    // --- parsear ---
    $data = json_decode($rawInput);

    // log compacto (opcional)
    file_put_contents("webhook_log.txt", date('c')." RAW: ".$rawInput."\n\n", FILE_APPEND);

    /* ===========================
    Extraer wa_message_id si existe
    =========================== */
    $wa_message_id = null;
    if (isset($data->entry[0]->changes[0]->value->messages[0]->id)) {

        $wa_message_id = $data->entry[0]->changes[0]->value->messages[0]->id;
    }

    /* ===========================
    Verificar duplicado en BD vía API
    (usa el endpoint que ya tienes: messages?linkTo=wa_message_id&equalTo=...)
    =========================== */
    if ($wa_message_id) {

        $checkUrl = "messages?linkTo=wa_message_id&equalTo=".$wa_message_id."&startAt=0&endAt=1";
        $check = CurlController::request($checkUrl, "GET", array());

        if ($check->status == 200 && !empty($check->results)) {

            // Ya existe: ignorar este webhook
            file_put_contents("duplicates.log", date('c')." Ignored duplicate wa_id: ".$wa_message_id."\n\n", FILE_APPEND);
            return;
        }
    }

//###################################################################################################

    /*=============================================
    // Obtén el contenido JSON
    =============================================*/

    $input = file_get_contents('php://input');

    file_put_contents("webhook_log.txt", $input."\n\n", FILE_APPEND);

    /*=============================================
    Convierte el JSON a array asociativo
    =============================================*/

    $data = json_decode($input);
    // echo '<pre>$data '; print_r($data); echo '</pre>';

    // return;

    /*=============================================
    Variables iniciales
    =============================================*/

    $id_conversation_message = null;
    $type_message = null;
    $status_message = null;
    $id_whatsapp_message = null;
    $client_message	= null;
    $phone_message	= null;
    $template_message = null;
    $order_message = 0;
    $type_conversation = null;
    $expiration_message = null;

    /*=============================================
    Tipo de mensajes
    =============================================*/

    if (isset($data->entry[0]->changes[0]->value->messages)) {

        $type_message = "client";
    }

    if (isset($data->entry[0]->changes[0]->value->statuses)) {

        $type_message = "business";
        $status_message = $data->entry[0]->changes[0]->value->statuses[0]->status;
    }

    // echo '<pre>$status_message '; print_r($status_message); echo '</pre>';
    // echo '<pre>$type_message '; print_r($type_message); echo '</pre>';

    // return;

    /*=============================================
    Capturar la API Cloud
    =============================================*/

    $url = "whatsapps?linkTo=id_number_whatsapp&equalTo=".$data->entry[0]->changes[0]->value->metadata->phone_number_id;
    $method = "GET";
    $fields = array();

    $getApiWS = CurlController::request($url,$method,$fields);

    if ($getApiWS->status == 200) {

        $getApiWS = $getApiWS->results[0];
        $id_whatsapp_message = $getApiWS->id_whatsapp;
    }

    echo '<pre>$id_whatsapp_message '; print_r($id_whatsapp_message); echo '</pre>';

    /*=============================================
    Capturar mensaje del cliente
    =============================================*/

    if ($type_message == "client") {

        $phone_message = $data->entry[0]->changes[0]->value->messages[0]->from;

        /*=============================================
        Cuando capturamos un texto
        =============================================*/

        if (isset($data->entry[0]->changes[0]->value->messages[0]->text)) {

            $client_message = $data->entry[0]->changes[0]->value->messages[0]->text->body;

            $type_conversation = "text";
        }

        /*=============================================
        Capturando una imagen
        =============================================*/

        if (isset($data->entry[0]->changes[0]->value->messages[0]->image)) {

            if (isset($data->entry[0]->changes[0]->value->messages[0]->image->caption)) {

                $caption = $data->entry[0]->changes[0]->value->messages[0]->image->caption;
            }
            else {

                $caption = "";
            }

            $client_message = '{"type":"image","mime":"'.$data->entry[0]->changes[0]->value->messages[0]->image->mime_type.'","id":"'.$data->entry[0]->changes[0]->value->messages[0]->image->id.'","caption":"'.$caption.'"}';

            $type_conversation = "image";
        }

        /*=============================================
        Capturando un video
        =============================================*/

        if (isset($data->entry[0]->changes[0]->value->messages[0]->video)) {

            if (isset($data->entry[0]->changes[0]->value->messages[0]->video->caption)) {

                $caption = $data->entry[0]->changes[0]->value->messages[0]->video->caption;
            }
            else {

                $caption = "";
            }

            $client_message = '{"type":"video","mime":"'.$data->entry[0]->changes[0]->value->messages[0]->video->mime_type.'","id":"'.$data->entry[0]->changes[0]->value->messages[0]->video->id.'","caption":"'.$caption.'"}';

            $type_conversation = "video";
        }

        /*=============================================
        Capturando un audio
        =============================================*/

        if (isset($data->entry[0]->changes[0]->value->messages[0]->audio)) {

            $client_message = '{"type":"audio","mime":"'.$data->entry[0]->changes[0]->value->messages[0]->audio->mime_type.'","id":"'.$data->entry[0]->changes[0]->value->messages[0]->audio->id.'"}';

            $type_conversation = "audio";
        }

        /*=============================================
        Capturando un documento
        =============================================*/

        if (isset($data->entry[0]->changes[0]->value->messages[0]->document)) {

            if (isset($data->entry[0]->changes[0]->value->messages[0]->document->caption)) {

                $caption = $data->entry[0]->changes[0]->value->messages[0]->document->caption;
            }
            else {

                $caption = "";
            }

            $client_message = '{"type":"document","mime":"'.$data->entry[0]->changes[0]->value->messages[0]->document->mime_type.'","id":"'.$data->entry[0]->changes[0]->value->messages[0]->document->id.'","caption":"'.$caption.'"}';

            $type_conversation = "document";
        }

        /*=============================================
        Capturando respuesta interactiva
        =============================================*/

        if (isset($data->entry[0]->changes[0]->value->messages[0]->interactive)) {

            $type_conversation = "interactive";

            /*=============================================
            Respuesta interacción de botón
            =============================================*/

            if (isset($data->entry[0]->changes[0]->value->messages[0]->interactive->button_reply)) {

                $client_message = '{"id":"'.$data->entry[0]->changes[0]->value->messages[0]->interactive->button_reply->id.'","text":"'.$data->entry[0]->changes[0]->value->messages[0]->interactive->button_reply->title.'"}';
            }

            /*=============================================
            Respuesta interacción de lista
            =============================================*/

            if (isset($data->entry[0]->changes[0]->value->messages[0]->interactive->list_reply)) {

                $client_message = '{"id":"'.$data->entry[0]->changes[0]->value->messages[0]->interactive->list_reply->id.'","text":"'.$data->entry[0]->changes[0]->value->messages[0]->interactive->list_reply->title.'"}';
            }
        }

        echo '<pre>$client_message '; print_r($client_message); echo '</pre>';
        echo '<pre>$phone_message '; print_r($phone_message); echo '</pre>';

//####################################################  MODIFIED BLOCK BEGINS  ##########################################################

        /*=============================================
        Llevar el orden de los mensajes
        =============================================*/

        $url = "messages?linkTo=phone_message&equalTo=".$phone_message."&startAt=0&endAt=1&orderBy=id_message&orderMode=DESC";

        $getMessages = CurlController::request($url, $method, $fields);

        if ($getMessages->status == 200) {

            if ($getMessages->results[0]->expiration_message < date("Y-m-d H:i:s")) {

                $order_message = 0;
                $id_conversation_message = null;
                $expiration_message = "0000-00-00 00:00:00";

                $url = "messages?id=".$phone_message."&nameId=phone_message&token=no&except=id_message";
                $method = "PUT";
                $fields = array(
                    "initial_message" => 0
                );

                $fields = http_build_query($fields);

                $updateMessage = CurlController::request($url, $method, $fields);
            }
            else {

                $order_message = $getMessages->results[0]->order_message + 1;
                $id_conversation_message = $getMessages->results[0]->id_conversation_message;
                $expiration_message = $getMessages->results[0]->expiration_message;
            }

            $template_message = $getMessages->results[0]->template_message;
        }

        /*=============================================
        Guardar mensaje del cliente
        =============================================*/

        $url = "messages?token=no&except=id_message";
        $method = "POST";
        // $fields = array(
        //     "id_conversation_message" => $id_conversation_message,
        //     "type_message" => $type_message,
        //     "id_whatsapp_message" => $id_whatsapp_message,
        //     "client_message" => $client_message,
        //     "phone_message" => $phone_message,
        //     "template_message" => $template_message,
        //     "order_message" => $order_message,
        //     "expiration_message" => $expiration_message,
        //     "initial_message" => 1,
        //     "date_created_message" => date("Y-m-d")
        // );

        // Añadido wa_message_id para la detección de mensajes de cliente duplicados
        $fields = array(
            "id_conversation_message" => $id_conversation_message,
            "type_message" => $type_message,
            "id_whatsapp_message" => $id_whatsapp_message,
            "client_message" => $client_message,
            "phone_message" => $phone_message,
            "template_message" => $template_message,
            "order_message" => $order_message,
            "expiration_message" => $expiration_message,
            "initial_message" => 1,
            "wa_message_id" => $wa_message_id,
            "date_created_message" => date("Y-m-d")
        );

//####################################################  MODIFIED BLOCK ENDS  ##########################################################

        $saveMessage = CurlController::request($url,$method,$fields);

        // if($saveMessage->status == 200){

        //     /*=============================================
        //     Responder al cliente
        //     =============================================*/

        //     $responseClients = ClientsController::responseClients($getApiWS,$phone_message,$order_message,$type_conversation, $client_message);
        //     echo '<pre>$responseClients '; print_r($responseClients); echo '</pre>';
        // }

        if (isset($saveMessage->status) && $saveMessage->status == 200) {

            // Respuesta normal: Procesar
            $responseClients = ClientsController::responseClients($getApiWS,$phone_message,$order_message,$type_conversation, $client_message);
        }
        else {

            // Si el backend devuelve algo distinto (p.e. 409 o mensaje de duplicado)
            file_put_contents("duplicates.log", date('c').' save message failed: '.json_decode($saveMessage)."\n\n", FILE_APPEND);
        }
    }

    /*=============================================
    Capturar mensaje del negocio
    =============================================*/

    if ($type_message == "business" && $status_message == "sent") {

        /*=============================================
        Capturar el número de teléfono
        =============================================*/

        $phone_message = $data->entry[0]->changes[0]->value->statuses[0]->recipient_id;
        echo '<pre>$phone_message '; print_r($phone_message); echo '</pre>';

//####################################################  MODIFIED BLOCK BEGINS  ##########################################################

        /*=============================================
        Capturar id conversación y fecha de expiración
        =============================================*/

        $url = "messages?linkTo=phone_message,type_message&equalTo=".$phone_message.",client&select=id_conversation_message,expiration_message&orderBy=id_message&orderMode=DESC";
        $method = "GET";
        $fields = array();

        $getIdConversation = CurlController::request($url,$method,$fields);

        if ($getIdConversation->status == 200) {

            $getIdConversation = $getIdConversation->results[0];

            if ($getIdConversation->id_conversation_message == null) {

                /*=============================================
                Capturar id de la conversación
                =============================================*/

                $idConversation = $data->entry[0]->changes[0]->value->statuses[0]->conversation->id;
                echo '<pre>$idConversation '; print_r($idConversation); echo '</pre>';

                /*=============================================
                Capturar fecha de vencimiento
                =============================================*/

                $expireConversation = $data->entry[0]->changes[0]->value->statuses[0]->conversation->expiration_timestamp;
                $expireConversation = new DateTime("@$expireConversation");
                $expireConversation = $expireConversation->format('Y-m-d H:i:s');
                echo '<pre>$expireConversation '; print_r($expireConversation); echo '</pre>';
            }
            else {

                $idConversation = $getIdConversation->id_conversation_message;
                $expireConversation = $getIdConversation->expiration_message;

                echo '<pre>$idConversation '; print_r($idConversation); echo '</pre>';
                echo '<pre>$expireConversation '; print_r($expireConversation); echo '</pre>';
            }
        }

//####################################################  MODIFIED BLOCK ENDS  ##########################################################

        /*=============================================
        Traer la última respuesta del negocio
        =============================================*/

        $url = "messages?linkTo=type_message,phone_message&equalTo=business,".$phone_message."&orderBy=id_message&orderMode=DESC&startAt=0&endAt=1";
        $method  = "GET";
        $fields = array();

        $getMessage = CurlController::request($url,$method,$fields);

        if ($getMessage->status == 200) {

            $getMessage = $getMessage->results[0];

            /*=============================================
            Actualizar última respuesta del negocio
            =============================================*/

            $url = "messages?id=".$getMessage->id_message."&nameId=id_message&token=no&except=id_message";
            $method = "PUT";
            $fields = array(
                "id_conversation_message" => $idConversation,
                "expiration_message" => $expireConversation
            );

            $fields = http_build_query($fields);

            $updateMessage = CurlController::request($url,$method,$fields);

            if ($updateMessage->status == 200) {

                /*=============================================
                Respuestas del negocio
                =============================================*/

                $responseBusiness = BusinessController::responseBusiness($idConversation,$getApiWS,$phone_message,$getMessage->order_message);
                echo '<pre>$responseBusiness '; print_r($responseBusiness); echo '</pre>';
            }
        }
    }
}

?>
