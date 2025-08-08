<?php

Class ClientsController{

	static public function responseClients($getApiWS,$phone_message,$order_message,$type_conversation){

        $idListMenu = null;

		/*=============================================
		Orden de la conversación
		=============================================*/

		if($order_message == 0){

			/*=============================================
            Buscamos el contacto
            =============================================*/

            $url = "contacts?linkTo=phone_contact&equalTo=".$phone_message;
            $method = "GET";
            $fields = array();

            $getContact = CurlController::request($url,$method,$fields);

            if($getContact->status != 200){

            	/*=============================================
            	Creamos el contacto
            	=============================================*/

            	$url = "contacts?token=no&except=id_contact";
            	$method = "POST";
            	$fields = array(
            		"phone_contact" => $phone_message,
            		"ai_contact" => $getApiWS->ai_whatsapp,
            		"date_created_contact" => date("Y-m-d")
            	);

            	$createContact = CurlController::request($url,$method,$fields);

            }else{

            	/*=============================================
            	Actualizamos la fecha de la última conversación con el contacto
            	=============================================*/
            	$url = "contacts?id=".$getContact->results[0]->id_contact."&nameId=id_contact&token=no&except=id_contact";
            	$method = "PUT";
            	$fields = array(
            		"date_updated_contact" => date("Y-m-d H:i:s")
            	);

            	$fields = http_build_query($fields);

            	$updateContact = CurlController::request($url,$method,$fields);

            }

            /*=============================================
            Respuesta con el chatbot
            =============================================*/

            if($getApiWS->ai_whatsapp == 0){

            	/*=============================================
            	Respuesta con Plantilla Bot
            	=============================================*/

            	$responseBots = BotsController::responseBots("welcome",$getApiWS,$phone_message,$order_message,$idListMenu);
            	echo '<pre>$responseBots '; print_r($responseBots); echo '</pre>';

            }

        }else{

            /*=============================================
            Buscamos el contacto
            =============================================*/

            $url = "contacts?linkTo=phone_contact&equalTo=".$phone_message;
            $method = "GET";
            $fields = array();

            $getContact = CurlController::request($url,$method,$fields);

            /*=============================================
            Actualizamos la fecha de la última conversación con el contacto
            =============================================*/
            $url = "contacts?id=".$getContact->results[0]->id_contact."&nameId=id_contact&token=no&except=id_contact";
            $method = "PUT";
            $fields = array(
                "date_updated_contact" => date("Y-m-d H:i:s")
            );

            $fields = http_build_query($fields);

            $updateContact = CurlController::request($url,$method,$fields);

            /*=============================================
            Traer la última conversacion del cliente
            =============================================*/

            $url = "messages?linkTo=type_message,phone_message&equalTo=client,".$phone_message."&startAt=0&endAt=1&orderBy=id_message&orderMode=DESC";
            $method = "GET";
            $fields = array();

            $getMessage = CurlController::request($url,$method,$fields);

            if($getMessage->status == 200){

                $message = $getMessage->results[0];

                /*=============================================
                Si se envió la plantilla "welcome"
                =============================================*/

                if($message->template_message == '{"type":"bot","title":"welcome"}'){

                    /*=============================================
                    Si la respuesta es interactiva
                    =============================================*/

                    if($type_conversation == "interactive"){

                        /*=============================================
                         Si la respuesta es 1: Realizar pedido
                        =============================================*/

                        if(json_decode($message->client_message)->id == 1){

                            $responseBots = BotsController::responseBots("menu",$getApiWS,$phone_message,$order_message,$idListMenu);
                            echo '<pre>$responseBots '; print_r($responseBots); echo '</pre>';

                        }


                        /*=============================================
                         Si la respuesta es 2: Reservar Mesa
                        =============================================*/

                        if(json_decode($message->client_message)->id == 2){

                            $responseBots = BotsController::responseBots("reservation",$getApiWS,$phone_message,$order_message,$idListMenu);
                            echo '<pre>$responseBots '; print_r($responseBots); echo '</pre>';

                        }

                        /*=============================================
                         Si la respuesta es 3: Atención al cliente
                        =============================================*/

                        if(json_decode($message->client_message)->id == 3){

                            $responseBots = BotsController::responseBots("conversation",$getApiWS,$phone_message,$order_message,$idListMenu);
                            echo '<pre>$responseBots '; print_r($responseBots); echo '</pre>';

                        }

                    }else{

                        $responseBots = BotsController::responseBots("conversation",$getApiWS,$phone_message,$order_message,$idListMenu);
                            echo '<pre>$responseBots '; print_r($responseBots); echo '</pre>';
                    }

                }

                /*=============================================
                Si se envió la plantilla "reservation"
                =============================================*/

                if($message->template_message == '{"type":"bot","title":"reservation"}'){

                    $responseBots = BotsController::responseBots("conversation",$getApiWS,$phone_message,$order_message,$idListMenu);
                    echo '<pre>$responseBots '; print_r($responseBots); echo '</pre>';
                }

                /*=============================================
                Si se envió la plantilla "menu"
                =============================================*/

                if($message->template_message == '{"type":"bot","title":"menu"}' ||
                   $message->template_message == '{"type":"bot","title":"reset"}'){

                    /*=============================================
                    Si la respuesta es interactiva
                    =============================================*/

                    if($type_conversation == "interactive"){

                        if(is_numeric(json_decode($message->client_message)->id)){

                            $idListMenu = json_decode($message->client_message)->id;

                            $responseBots = BotsController::responseBots("listMenu",$getApiWS,$phone_message,$order_message,$idListMenu);
                            echo '<pre>$responseBots '; print_r($responseBots); echo '</pre>';

                            // CHECK LINE 191. $idListMenu is getting its value as a string and not as a number

                        }else{

                            if(json_decode($message->client_message)->id == "domicilio"){

                                $responseBots = BotsController::responseBots("delivery",$getApiWS,$phone_message,$order_message,$idListMenu);
                                echo '<pre>$responseBots '; print_r($responseBots); echo '</pre>';

                            }else{

                                $responseBots = BotsController::responseBots("conversation",$getApiWS,$phone_message,$order_message,$idListMenu);
                                echo '<pre>$responseBots '; print_r($responseBots); echo '</pre>';

                            }

                        }

                    }else{

                      $responseBots = BotsController::responseBots("conversation",$getApiWS,$phone_message,$order_message,$idListMenu);
                        echo '<pre>$responseBots '; print_r($responseBots); echo '</pre>';

                    }

                }

                /*=============================================
                Si se envió la plantilla "lista de menu"
                =============================================*/

                if($message->template_message == '{"type":"bot","title":"listMenu"}'){

                    /*=============================================
                    Si la respuesta es interactiva
                    =============================================*/

                    if($type_conversation == "interactive"){

                        $responseBots = BotsController::responseBots("reset",$getApiWS,$phone_message,$order_message,$idListMenu);
                        echo '<pre>$responseBots '; print_r($responseBots); echo '</pre>';

                    }else{

                        // if($message->client_message == "Menú" ||
                        //    $message->client_message == "menú" ||
                        //    $message->client_message == "Menu" ||
                        //    $message->client_message == "MENÚ" ||
                        //    $message->client_message == "MENU" ||
                        //    $message->client_message == "menu"){
                        if(mb_strtolower(trim($message->client_message)) == "menú" ||
                           mb_strtolower(trim($message->client_message)) == "menu") {

                            $responseBots = BotsController::responseBots("menu",$getApiWS,$phone_message,$order_message,$idListMenu);
                            echo '<pre>$responseBots '; print_r($responseBots); echo '</pre>';

                        }else{

                            $responseBots = BotsController::responseBots("conversation",$getApiWS,$phone_message,$order_message,$idListMenu);
                            echo '<pre>$responseBots '; print_r($responseBots); echo '</pre>';
                        }
                    }

                }

                /*=============================================
                Si se envió la plantilla "name"
                =============================================*/

                if($message->template_message == '{"type":"bot","title":"name"}'){

                    $responseBots = BotsController::responseBots("phone",$getApiWS,$phone_message,$order_message,$idListMenu);
                    echo '<pre>$responseBots '; print_r($responseBots); echo '</pre>';

                }

                /*=============================================
                Si se envió la plantilla "phone"
                =============================================*/

                if($message->template_message == '{"type":"bot","title":"phone"}'){

                    $responseBots = BotsController::responseBots("email",$getApiWS,$phone_message,$order_message,$idListMenu);
                    echo '<pre>$responseBots '; print_r($responseBots); echo '</pre>';

                }

                /*=============================================
                Si se envió la plantilla "email"
                =============================================*/

                if($message->template_message == '{"type":"bot","title":"email"}'){

                    $responseBots = BotsController::responseBots("address",$getApiWS,$phone_message,$order_message,$idListMenu);
                    echo '<pre>$responseBots '; print_r($responseBots); echo '</pre>';

                }

                /*=============================================
                Si se envió la plantilla "address"
                =============================================*/

                if($message->template_message == '{"type":"bot","title":"address"}'){

                    $responseBots = BotsController::responseBots("process",$getApiWS,$phone_message,$order_message,$idListMenu);
                    echo '<pre>$responseBots '; print_r($responseBots); echo '</pre>';

                }

                /*=============================================
                Si se envió la plantilla "confirmation"
                =============================================*/

                if($message->template_message == '{"type":"bot","title":"confirmation"}'){

                    /*=============================================
                    Si la respuesta es interactiva
                    =============================================*/

                    if($type_conversation == "interactive"){

                        if(json_decode($message->client_message)->id == 1){

                            $responseBots = BotsController::responseBots("checkout",$getApiWS,$phone_message,$order_message,$message->id_conversation_message);
                            echo '<pre>$responseBots '; print_r($responseBots); echo '</pre>';

                        }else{

                            $responseBots = BotsController::responseBots("conversation",$getApiWS,$phone_message,$order_message,$idListMenu);
                            echo '<pre>$responseBots '; print_r($responseBots); echo '</pre>';
                        }

                    }else{

                      $responseBots = BotsController::responseBots("conversation",$getApiWS,$phone_message,$order_message,$idListMenu);
                            echo '<pre>$responseBots '; print_r($responseBots); echo '</pre>';

                    }

                }

                /*=============================================
                Si se envió la plantilla "checkout"
                =============================================*/

                if($message->template_message == '{"type":"bot","title":"checkout"}'){

                    $responseBots = BotsController::responseBots("conversation",$getApiWS,$phone_message,$order_message,$idListMenu);
                    echo '<pre>$responseBots '; print_r($responseBots); echo '</pre>';

                }

            }

        }
	}
}
