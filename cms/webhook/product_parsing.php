<?php

Class ProductParsing {

    // =============================
    // Función para llamar a OpenAI
    // =============================
    static public function callOpenAI($payload, $apiKey) {

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

        return json_decode($response, true);
    }

    // ================================================
    // Buscar la parte especificada en la base de datos
    // ================================================
    static public function buscar_parte_db($pdo, $producto) {

        $sql = "SELECT * FROM chatcenter.parts WHERE link_part=".$producto.";";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    static public function parse_product($apiKey, $model, $client_message) {

        // ==========================
        // Configuración
        // ==========================
        // $apiKey = "TU_API_KEY_OPENAI";
        // $model  = "gpt-4o-mini";
        // $client_message = "Hola, tienen zapatos Nike talla 42?";

        // Conexión a MySQL
        $pdo = new PDO("mysql:host=localhost;dbname=chatcenter;charset=utf8mb4", "root", "", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // ==========================
        // Detectar producto
        // ==========================
        $payload1 = [
            "model" => $model,
            "messages" => [
                [
                    "role" => "system",
                    "content" => "Eres un detector de intención de productos.
                    Responde SOLO en JSON con el formato: {\"producto\": \"...\"}
                    o {\"producto\": null} si no hay producto."
                ],
                ["role" => "user", "content" => $client_message]
            ]
        ];

        $respuesta1 = ProductParsing::callOpenAI($payload1, $apiKey);
        $productoDetectado = null;

        if (isset($respuesta1["choices"][0]["message"]["content"])) {

            $jsonContent = $respuesta1["choices"][0]["message"]["content"];
            $parsed = json_decode($jsonContent, true);

            if ($parsed && isset($parsed["producto"])) {

                $productoDetectado = $parsed["producto"];
            }
        }

        $infoProducto = $productoDetectado ? ProductParsing::buscar_parte_db($pdo, $productoDetectado) : null;

        // ==============================
        // Generar respuesta final con AI
        // ==============================
        if ($infoProducto) {

            $infoAnalizada = "Nombre: {$infoProducto['nombre']}\n".
                            "Descripción: {$infoProducto['descripcion']}\n".
                            "Precio: {$infoProducto['precio']} COP\n".
                            "Link: {$infoProducto['link']}";

            $payload2 = [
                "model" => $model,
                "messages" => [
                    ["role" => "system", "content" => "Eres un vendedor amable que responde dudas de productos."],
                    ["role" => "user", "content" => "El cliente preguntó por: $productoDetectado"],
                    ["role" => "assistant", "content" => "Aquí tienes la información del producto:\n$infoAnalizada\n\nGenera una respuesta breve y amable para el cliente."]
                ]
            ];

            $respuesta2 = ProductParsing::callOpenAI($payload2, $apiKey);
            $mensajeFinal = $respuesta2["choices"][0]["message"]["content"] ?? "No se pudo generar la respuesta.";
        }
        else {

            $mensajeFinal = "Lo siento, no encontré el producto que buscabas. ¿Quieres que te muestre alternativas?";
        }

        // ==========================
        // Enviar a WhatsApp
        // ==========================
        // Aquí llamas a tu archivo `curl.controller.php`
        // Simulación:
        function enviarWhatsApp($numeroCliente, $mensaje) {

            echo "📩 Mensaje enviado a $numeroCliente:\n$mensaje\n";
        }

        // Simulamos envío
        enviarWhatsApp("+573001112233", $mensajeFinal);
    }
}


?>
