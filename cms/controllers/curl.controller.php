<?php

class CurlController{

    /*=============================================
    Peticiones a la API
    =============================================*/

    static public function request($url,$method,$fields) {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api-chatcenter.com/'.$url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $fields,
            CURLOPT_HTTPHEADER => array(
                'Authorization: gsdfgdfhdsfhsdfgh4332465dfhdfgh34sdgsdfg345AFSGFghdrfh4'
            ),
        ));

        $response = curl_exec($curl);
        // echo '<br>$response'; print_r($response); echo '<br>';

        curl_close($curl);
        $response = json_decode($response);
        // echo '<br>$response'; print_r($response); echo '<br>';

        return $response;


        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => 'http://api-chatcenter.com/' . $url,
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => $method,
        //     CURLOPT_POSTFIELDS => $fields,
        //     CURLOPT_HTTPHEADER => array(
        //         'Authorization: gsdfgdfhdsfhsdfgh4332465dfhdfgh34sdgsdfg345AFSGFghdrfh4'
        //     ),
        // ));

        // $response = curl_exec($curl);
        // $error = curl_error($curl);

        // curl_close($curl);

        // if ($error) {
        //     echo '<pre>$error '; print_r($error); echo '</pre>';

        //     return (object) [
        //         'status' => 500,
        //         'results' => 'cURL Error #: ' . $error
        //     ];
        // }

        // return json_decode($response);
    }

    /*=============================================
    Peticiones a la API de ChatGPT
    =============================================*/

    static public function chatGPT($messages,$token,$org) {

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "model": "gpt-5",
            "messages": '.$messages.'}',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$token,
            'OpenAI-Organization: '.$org,
            'Content-Type: application/json'
          ),
        ));

        // echo '<pre>curl_setopt_array($curl, $array) '; print_r(curl_setopt_array($curl, $array)); echo '</pre>';

        $response = curl_exec($curl);

        // echo '<pre>$response '; print_r($response); echo '</pre>';
        // return;

        curl_close($curl);
        $response = json_decode($response);

        // echo '<pre>$response '; print_r($response); echo '</pre>';
        // return;

        return $response->choices[0]->message->content;
    }

    /*=============================================
    Peticiones a la API de WS
    =============================================*/

    static public function apiWS($getApiWS,$json) {

        if (str_contains($json,'{')) {

            $json = $json;
            $endpoint = 'https://graph.facebook.com/v22.0/'.$getApiWS->id_number_whatsapp.'/messages';
            $method = 'POST';

        }
        else {

            $endpoint = 'https://graph.facebook.com/v22.0/'.explode("_",$json)[0];
            $idArchive = explode("_",$json)[0];

            if (count(explode("_",$json)) > 1) {

                $ajax = "../";
            }
            else {

                $ajax = "";
            }

            $json = array();
            $method = 'GET';
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS =>$json,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$getApiWS->token_whatsapp,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($response);

        if ($method == 'POST') {

            return $response;
        }
        else {

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $response->url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer '.$getApiWS->token_whatsapp,
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $contentType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);

            if ($httpcode == 200) {

                $filename = $ajax.'views/assets/ws/'.$idArchive.'.'.explode("/",$contentType)[1];

                file_put_contents($filename, $response);

                return $filename;
            }
        }
    }
}
