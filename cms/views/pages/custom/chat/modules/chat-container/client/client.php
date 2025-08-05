<?php 

/*=============================================
Traemos la info API WS
=============================================*/

$url = "whatsapps?linkTo=status_whatsapp&equalTo=1";
$method = "GET";
$fields = array();

$getApiWS = CurlController::request($url,$method,$fields);

if($getApiWS->status == 200){

  $getApiWS = $getApiWS->results[0];

}

/*=============================================
preguntamos si viene una respuesta interactivas
=============================================*/

if(isset(json_decode($value->client_message)->id) && isset(json_decode($value->client_message)->text)){

	$value->client_message = json_decode($value->client_message)->text;

/*=============================================
preguntamos si viene una respuesta de imagen
=============================================*/

}else if(isset(json_decode($value->client_message)->type) && json_decode($value->client_message)->type == "image"){

	/*=============================================
	Traer foto con ID a través de la API de WS
	=============================================*/

	$archive = CurlController::apiWS($getApiWS,json_decode($value->client_message)->id);
	
	$value->client_message = '<a href="'.$archive.'" target="_blank"><img src="'.$archive.'" class="img-fluid rounded"></a><br>'.urldecode(json_decode($value->client_message)->caption);

}else{

	$value->client_message = $value->client_message;
}

?>

<div class="msg user">
	<div class="pt-2" style="max-width:300px"><?php echo $value->client_message ?></div> <br>
	<span class="small text-muted float-end">
		<?php echo TemplateController::formatDate(6,$value->date_updated_message) ?>	
	</span>
</div>