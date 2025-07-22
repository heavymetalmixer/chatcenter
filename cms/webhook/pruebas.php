<?php

/*=============================================
Depurar Errores
=============================================*/

define('DIR',__DIR__);

ini_set("display_errors", 1);
ini_set("log_errors", 1);
ini_set("error_log", DIR."/php_error_log");

/*=============================================
Controladores
=============================================*/

require_once "../controllers/curl.controller.php";
require_once "../controllers/clients.controller.php";
require_once "../controllers/bots.controller.php";

/*=============================================
Simulación del contenido JSON
=============================================*/

$input = '{"object":"whatsapp_business_account","entry":[{"id":"1435203277506567","changes":[{"value":{"messaging_product":"whatsapp","metadata":{"display_phone_number":"15556588621","phone_number_id":"661536270384648"},"contacts":[{"profile":{"name":"John Caro Molina"},"wa_id":"573014115327"}],"messages":[{"from":"573014115327","id":"wamid.HBgMNTczMDE0MTE1MzI3FQIAEhgUM0ZFQTExNjUzMTJGQ0I0ODExMjAA","timestamp":"1753136348","text":{"body":"Hello there"},"type":"text"}]},"field":"messages"}]}]}';

/*=============================================
Convierte el JSON a array asociativo
=============================================*/

$data = json_decode($input);
// echo '<pre>$data '; print_r($data); echo '</pre>';

// return;

/*=============================================
Variables iniciales
=============================================*/

$type_message = null;
$id_whatsapp_message = null;
$client_message	= null;
$phone_message	= null;
$order_message = 0;
$type_conversation = null;

/*=============================================
Tipo de mensajes
=============================================*/

if(isset($data->entry[0]->changes[0]->value->messages)){

	$type_message = "client";

}

if(isset($data->entry[0]->changes[0]->value->statuses)){

	$type_message = "business";

}

echo '<pre>$type_message '; print_r($type_message); echo '</pre>';

/*=============================================
Capturar la API Cloud
=============================================*/

$url = "whatsapps?linkTo=id_number_whatsapp&equalTo=".$data->entry[0]->changes[0]->value->metadata->phone_number_id;
$method = "GET";
$fields = array();

$getApiWS = CurlController::request($url,$method,$fields);

if($getApiWS->status == 200){

	$getApiWS = $getApiWS->results[0];
	$id_whatsapp_message = $getApiWS->id_whatsapp;

}

echo '<pre>$id_whatsapp_message '; print_r($id_whatsapp_message); echo '</pre>';

/*=============================================
Capturar mensaje del cliente
=============================================*/

if($type_message == "client"){

	$phone_message = $data->entry[0]->changes[0]->value->messages[0]->from;

	/*=============================================
	Cuando capturamos un texto
	=============================================*/

	if(isset($data->entry[0]->changes[0]->value->messages[0]->text)){

		$client_message = $data->entry[0]->changes[0]->value->messages[0]->text->body;

		$type_conversation = "text";
	}

	/*=============================================
	Capturando una imagen
	=============================================*/

	if(isset($data->entry[0]->changes[0]->value->messages[0]->image)){

		if(isset($data->entry[0]->changes[0]->value->messages[0]->image->caption)){

			$caption = $data->entry[0]->changes[0]->value->messages[0]->image->caption;

		}else{

			$caption = "";
		}

		$client_message = '{"type":"image","mime":"'.$data->entry[0]->changes[0]->value->messages[0]->image->mime_type.'","id":"'.$data->entry[0]->changes[0]->value->messages[0]->image->id.'","caption":"'.$caption.'"}';

		$type_conversation = "image";
	}

	/*=============================================
	Capturando un video
	=============================================*/

	if(isset($data->entry[0]->changes[0]->value->messages[0]->video)){

		if(isset($data->entry[0]->changes[0]->value->messages[0]->video->caption)){

			$caption = $data->entry[0]->changes[0]->value->messages[0]->video->caption;

		}else{

			$caption = "";
		}

		$client_message = '{"type":"video","mime":"'.$data->entry[0]->changes[0]->value->messages[0]->video->mime_type.'","id":"'.$data->entry[0]->changes[0]->value->messages[0]->video->id.'","caption":"'.$caption.'"}';

		$type_conversation = "video";
	}

	/*=============================================
	Capturando un audio
	=============================================*/

	if(isset($data->entry[0]->changes[0]->value->messages[0]->audio)){

		$client_message = '{"type":"audio","mime":"'.$data->entry[0]->changes[0]->value->messages[0]->audio->mime_type.'","id":"'.$data->entry[0]->changes[0]->value->messages[0]->audio->id.'"}';

		$type_conversation = "audio";

	}

	/*=============================================
	Capturando un documento
	=============================================*/

	if(isset($data->entry[0]->changes[0]->value->messages[0]->document)){

		if(isset($data->entry[0]->changes[0]->value->messages[0]->document->caption)){

			$caption = $data->entry[0]->changes[0]->value->messages[0]->document->caption;

		}else{

			$caption = "";
		}

		$client_message = '{"type":"document","mime":"'.$data->entry[0]->changes[0]->value->messages[0]->document->mime_type.'","id":"'.$data->entry[0]->changes[0]->value->messages[0]->document->id.'","caption":"'.$caption.'"}';

		$type_conversation = "document";
	}



	echo '<pre>$client_message '; print_r($client_message); echo '</pre>';
	echo '<pre>$phone_message '; print_r($phone_message); echo '</pre>';

	/*=============================================
	Llevar el orden de los mensajes
	=============================================*/

	$url = "messages?linkTo=phone_message&equalTo=".$phone_message."&startAt=0&endAt=1&orderBy=id_message&orderMode=DESC";

	$getMessages = CurlController::request($url,$method,$fields);

	if($getMessages->status == 200){

		$order_message = $getMessages->results[0]->order_message + 1;

	}

	/*=============================================
	Guardar mensaje del cliente
	=============================================*/

	$url = "messages?token=no&except=id_message";
	$method = "POST";
	$fields = array(
		"type_message" => $type_message,
		"id_whatsapp_message" => $id_whatsapp_message,
		"client_message" => $client_message,
		"phone_message" => $phone_message,
		"order_message" => $order_message,
		"date_created_message" => date("Y-m-d")
	);

	$saveMessage = CurlController::request($url,$method,$fields);

	if($saveMessage->status == 200){

		/*=============================================
		Responder al cliente
		=============================================*/

		$responseClients = ClientsController::responseClients($getApiWS,$phone_message,$order_message,$type_conversation);
		echo '<pre>$responseClients '; print_r($responseClients); echo '</pre>';

	}

}

