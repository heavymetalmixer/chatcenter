<?php

Class WebDownload {

    // =======================================================
    // Si no es un link de Google Drive, devuelve el original.
    // =======================================================
    static public function get_direct_download_url($url) {

        // Caso: https://drive.google.com/file/d/FILE_ID/view?usp=sharing
        if (preg_match("/drive\.google\.com\/file\/d\/([^\/]+)\//", $url, $matches)) {

            $file_id = $matches[1];
            return "https://drive.google.com/uc?export=download&id=" . $file_id;
        }

        // Caso: https://drive.google.com/open?id=FILE_ID
        if (preg_match("/drive\.google\.com\/open\?id=([^&]+)/", $url, $matches)) {

            $file_id = $matches[1];
            return "https://drive.google.com/uc?export=download&id=" . $file_id;
        }

        // Caso: https://drive.google.com/uc?id=FILE_ID&export=download
        if (preg_match("/drive\.google\.com\/uc\?id=([^&]+)/", $url, $matches)) {

            $file_id = $matches[1];
            return "https://drive.google.com/uc?export=download&id=" . $file_id;
        }

        // Si no es un link de Google Drive, devolverá el mismo sin modificarlo
        return $url;
    }

    static public function copy_web($apiKey, $model, $url) {

        // Configuración
        $apiKey = ""; // Pon tu API Key aquí
        $model  = "gpt-5"; // o "gpt-5" si lo tienes disponible
        $url    = "https://drive.google.com/file/d/1ZCtA6ZXc1RlRp6GxfdLluGUDuzrw-9yC/view?usp=sharing";
        https://drive.google.com/uc?export=download&id=1ZCtA6ZXc1RlRp6GxfdLluGUDuzrw-9yC Este es el link directo que debe entregar la función
        $url = WebDownload::get_direct_download_url($url);

        // Descargar archivo a temporal
        $tempFile = tempnam(sys_get_temp_dir(), 'download_');
        file_put_contents($tempFile, file_get_contents($url));

        // Detectar MIME
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $tempFile);
        finfo_close($finfo);

        // Extraer texto básico sin librerías
        $text = "";

        if (strpos($mime, "html") !== false) {

            // HTML
            $html = file_get_contents($url);
            $text = strip_tags($html);
        }
        elseif (strpos($mime, "plain") !== false) {

            // TXT
            $text = file_get_contents($tempFile);
        }
        elseif (strpos($mime, "pdf") !== false) {

            // PDF simple (solo texto plano, no imágenes)
            $pdfContent = file_get_contents($tempFile);

            // Eliminar caracteres binarios
            $text = preg_replace('/[^(\x20-\x7F)\x0A\x0D]/','', $pdfContent);
        }
        elseif (strpos($mime, "word") !== false || strpos($mime, "officedocument") !== false) {

            // DOCX → es un zip con XML
            $zip = new ZipArchive;

            if ($zip->open($tempFile) === true) {

                $xmlContent = $zip->getFromName("word/document.xml");
                $zip->close();
                $text = strip_tags($xmlContent);
            }
        }
        else {

            $text = "[Tipo de archivo no soportado nativamente]";
        }

        // Recortar si es muy largo
        // $maxLength = 5000;

        // if (strlen($text) > $maxLength) {

        //     $text = substr($text, 0, $maxLength) . "... [contenido truncado]";
        // }

        // Preparar payload para OpenAI
        $payload = [
            "model" => $model,
            "messages" => [
                ["role" => "system", "content" => "Eres un asistente que analiza documentos descargados."],
                ["role" => "user", "content" => "He descargado el archivo desde $url.\n\nAquí está su contenido:\n\n$text\n\nPor favor, resume lo más importante."]
            ]
        ];

        // Hacer petición con cURL
        $ch = curl_init("https://api.openai.com/v1/chat/completions");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer $apiKey"
        ]);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

        $response = curl_exec($ch);
        curl_close($ch);

        // Decodificar respuesta
        $data = json_decode($response, true);

        // Mostrar la salida de OpenAI
        if (isset($data['choices'][0]['message']['content'])) {

            echo "Respuesta del modelo:\n\n";
            echo $data['choices'][0]['message']['content'];
        }
        else {

            echo "Error en la API:\n\n";
            print_r($data);
        }

        // Limpiar temporal
        unlink($tempFile);
    }
}

?>
