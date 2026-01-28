<?php

namespace ProductParsing;

require_once "../../vendor/autoload.php";
require_once "web_download.php";

//use OpenAI;
//use GuzzleHttp\Client as HttpClient;

/**
 * Usa CURL para enviar información a OpenAI
 */
function call_open_ai($payload, $api_key)
{
    $ch = curl_init("https://api.openai.com/v1/chat/completions");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $api_key"
    ]);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

/**
 * Buscar la parte especificada en la base de datos
 */
function search_part_db($pdo, $producto)
{
    $table = $_ENV["CHATCENTER_DB_TABLE"];
    $column = $_ENV["CHATCENTER_DB_COLUMN"];

    $sql = "SELECT * FROM ".$table." WHERE ".$column."=".$producto.";";
    $query = $pdo->prepare($sql);
    $query->execute();

    return $query->fetch(\PDO::FETCH_ASSOC);
}

/**
 * Crea "embeddings" para todos los productos en la tabla parts que OpenAI usará para proveer búsquedas "similares" de productos
 */
function create_embeddings()
{
    // Se obtienen las variables de entorno
    $api_key = $_ENV["OPENAI_API_KEY"];

    $host = $_ENV["CHATCENTER_DB_HOST"];
    $db_name = $_ENV["CHATCENTER_DB_NAME"];
    $user = $_ENV["CHATCENTER_DB_USER"];
    $pass = $_ENV["CHATCENTER_DB_PASSWORD"];

    $table_parts= $_ENV["CHATCENTER_DB_TABLE"];
    $column_link_part = $_ENV["CHATCENTER_DB_COLUMN_LINK"];
    $column_id_part = $_ENV["CHATCENTER_DB_COLUMN_ID"];
    $column_embedding_part = $_ENV["CHATCENTER_DB_COLUMN_EMBEDDING"];

    $openai = \OpenAI::factory()
        ->withApiKey($api_key)
        ->make();

    print_r($openai);
    echo "<br>";

    // Selecciona productos sin embedding
    $pdo = null;

    try
    {
        $pdo = new \PDO("mysql:host=".$host.";dbname=".$db_name.";charset=utf8mb4", $user, $pass, [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ]);

        // Print host information
        echo "Connect Successfully. Host info: ".$pdo->getAttribute(constant("PDO::ATTR_CONNECTION_STATUS")); echo '<br>';

        $query = $pdo->query("SELECT ".$column_id_part.", ".$column_link_part." FROM ".$table_parts." WHERE ".$column_embedding_part." IS NULL OR ".$column_embedding_part." = ''");
        $productos = $query->fetchAll(\PDO::FETCH_ASSOC);

        $query->closeCursor();
    }
    catch(\PDOException $e)
    {
        die("ERROR: " . $e->getMessage());
    }

    // foreach ($productos as $producto)
    // {
    //     echo "<br>";
    //     print_r($producto);
    //     echo "<br>";
    // }

    // return;

    if (!$productos)
    {
        echo "Todos los productos ya tienen embeddings.<br>";
        exit;
    }

    echo "Procesando ".count($productos)." productos...<br>";

    // Procesa cada producto
    foreach ($productos as $producto)
    {
        echo "Generando embedding para: {$producto["".$column_link_part.""]} (ID {$producto["".$column_id_part.""]})...<br>";

        try
        {
            // Llama a OpenAI embeddings
            $response = $openai->embeddings()->create([
                "model" => "text-embedding-3-small",  // barato y bueno para búsquedas
                "input" => $producto["".$column_link_part.""],
            ]);

            // echo "<br>";
            // print_r($response);
            // echo "<br>";

            // $vector = $response->data[0]->embedding;
            $vector = $response->embeddings[0]->embedding;
            $vectorStr = json_encode($vector);

            // Guarda el embedding en la base de datos
            $update = $pdo->prepare("UPDATE ".$table_parts." SET ".$column_embedding_part." = :".$column_embedding_part." WHERE ".$column_id_part." = :".$column_id_part."");

            $update->execute([
                ":".$column_embedding_part."" => $vectorStr,
                ":".$column_id_part."" => $producto["".$column_id_part.""]
            ]);

            echo "Embedding guardado.<br>";

            // Pequeña pausa para no saturar la API de OpenAI
            usleep(200000); // 0.2 segundos
        }
        catch (\Exception $e)
        {
            echo "Error con producto {$producto["".$column_id_part.""]}: ".$e->getMessage()."<br>";
        }
    }

    echo "Proceso completado.<br>";

    // Se cierra la conexión a la base de datos
    $pdo = null;
}

/**
 * Función de similitud coseno
 */
function cosine_similarity(array &$vecA, array &$vecB): float
{
    $dot = 0.0;
    $normA = 0.0;
    $normB = 0.0;

    foreach ($vecA as $i => $val)
    {
        $dot += $val * $vecB[$i];
        $normA += $val ** 2;
        $normB += $vecB[$i] ** 2;
    }

    return $dot / (sqrt($normA) * sqrt($normB));
}

/**
 * Recibe la petición de un producto desde OpenAI, se busca su enlance en la base de datos, se descarga como texto plano y se envía de vuelta a OpenAI
 */
function parse_product_manual()
{
    // Se obtienen las variables de entorno
    $api_key = $_ENV["OPENAI_API_KEY"];
    $model = $_ENV["OPENAI_CHATGPT_MODEL"]; // O "gpt-5" si lo tienes disponible

    $host = $_ENV["CHATCENTER_DB_HOST"];
    $db_name = $_ENV["CHATCENTER_DB_NAME"];
    $user = $_ENV["CHATCENTER_DB_USER"];
    $pass = $_ENV["CHATCENTER_DB_PASSWORD"];

    $column_link_part = $_ENV["CHATCENTER_DB_COLUMN_LINK"];

    $client_message = "Hola, tienen zapatos Nike talla 42?";

    // Conexión a MySQL
    $pdo = new \PDO("mysql:host=".$host.";dbname=".$db_name.";charset=utf8mb4", $user, $pass, [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
    ]);

    // Detecta el producto
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

    $respuesta1 = call_open_ai($payload1, $api_key);
    $productoDetectado = null;

    if (isset($respuesta1["choices"][0]["message"]["content"]))
    {
        $jsonContent = $respuesta1["choices"][0]["message"]["content"];
        $parsed = json_decode($jsonContent, true);

        if ($parsed && isset($parsed["producto"]))
        {
            $productoDetectado = $parsed["producto"];
        }
    }

    $infoProducto = $productoDetectado ? search_part_db($pdo, $productoDetectado) : null;

    // Se cierra la conexión a la base de datos
    $pdo = null;

    // Genera la respuesta con AI
    if ($infoProducto)
    {
        $infoAnalizada = "Nombre: {$infoProducto['nombre']}\n".
                        "Descripción: {$infoProducto['descripcion']}\n".
                        "Precio: {$infoProducto['precio']} COP\n".
                        "Link: {".$infoProducto["".$column_link_part.""]."}";

        $payload2 = [
            "model" => $model,
            "messages" => [
                ["role" => "system", "content" => "Eres un vendedor amable que responde dudas de productos."],
                ["role" => "user", "content" => "El cliente preguntó por: $productoDetectado"],
                ["role" => "assistant", "content" => "Aquí tienes la información del producto:\n$infoAnalizada\n\nGenera una respuesta breve y amable para el cliente."]
            ]
        ];

        $respuesta2 = call_open_ai($payload2, $api_key);
        $mensajeFinal = $respuesta2["choices"][0]["message"]["content"] ?? "No se pudo generar la respuesta.";
    }
    else
    {
        $mensajeFinal = "Lo siento, no encontré el producto que buscabas. ¿Quieres que te muestre alternativas?";
    }

    // Envía la respuesta de OpenAI a WhatsApp
    // TODO: Llamar curl.controller.php aquí
    // Simulación:
    function enviarWhatsApp($numeroCliente, $mensaje)
    {
        echo "Mensaje enviado a $numeroCliente:\n$mensaje\n";
    }

    // Simulamos envío
    enviarWhatsApp("+573001112233", $mensajeFinal);
}

/**
 * En teoría hace lo mismo que product_parsing_manual() pero usando las librerías OpenAI-PHP y GuzzletHttp
 */
function parse_product_3rd_party()
{
    // Se obtienen las variables de entorno
    $api_key = $_ENV["OPENAI_API_KEY"];
    $model = $_ENV["OPENAI_CHATGPT_MODEL"]; // O "gpt-5" si lo tienes disponible

    $host = $_ENV["CHATCENTER_DB_HOST"];
    $db_name = $_ENV["CHATCENTER_DB_NAME"];
    $user = $_ENV["CHATCENTER_DB_USER"];
    $pass = $_ENV["CHATCENTER_DB_PASSWORD"];

    $table = $_ENV["CHATCENTER_DB_TABLE"];
    $column_link_part = $_ENV["CHATCENTER_DB_COLUMN_LINKs"];

    $openai = \OpenAI::factory()
        ->withApiKey($api_key)
        ->make();

    // Mensaje de prueba del "cliente"
    $mensajeCliente = "Hola, tienen válvula de escape tvs?";

    // Detecta el producto con OpenAI
    $response = $openai->chat()->create([
        'model' => $model,
        'messages' => [
            [
                'role' => 'system',
                'content' => 'Eres un detector de intención de productos.
                Devuelve SOLO JSON en formato {"producto": "..."} o {"producto": null}.'
            ],
            ['role' => 'user', 'content' => $mensajeCliente],
        ],
    ]);

    $jsonContent = $response['choices'][0]['message']['content'] ?? '{}';
    $parsed = json_decode($jsonContent, true);
    $producto = $parsed['producto'] ?? null;

    // Busca el producto en la base de datos
    $info_producto = null;
    $pdo = null;

    if ($producto)
    {
        $pdo = new \PDO("mysql:host=".$host.";dbname=".$db_name.";charset=utf8mb4", $user, $pass, [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ]);

        $query = $pdo->prepare("SELECT * FROM ".$table." WHERE ".$column_link_part." LIKE :producto LIMIT 1");
        $query->execute([':producto' => "%$producto%"]);
        $info_producto = $query->fetch(\PDO::FETCH_ASSOC);

        print_r($info_producto[$column_link_part]); echo "<br><br>";
    }

    // Se cierra la conexión a la base de datos
    $pdo = null;

    // Obtiene el link del producto y extrae su texto
    if ($info_producto && isset($info_producto[$column_link_part]))
    {
        $http = new \GuzzleHttp\Client();
        $resource = $http->get($info_producto[$column_link_part]);
        $content = (string) $resource->getBody();

        // Simplificado: quitar HTML
        $texto_extraido = strip_tags($content);
    }

    // Analiza el texto extraido con OpenAI y genera la respuesta
    if ($texto_extraido)
    {
        $response2 = $openai->chat()->create([
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => 'Eres un vendedor amable.'],
                ['role' => 'user', 'content' => "El cliente preguntó por: $producto"],
                ['role' => 'assistant', 'content' => "Aquí está la información del producto:\n$texto_extraido\n\nGenera una respuesta amable y clara para el cliente."]
            ],
        ]);

        $mensaje_final = $response2['choices'][0]['message']['content'] ?? "No se pudo generar respuesta.";
    }
    else
    {
        $mensaje_final = "Lo siento, no encontré información sobre ese producto.";
    }

    // Enviar por WhatsApp
    // TODO: Llamar curl.controller.php aquí
    // Simulación:
    echo "Respuesta al cliente:<br><br>$mensaje_final<br>";
}

/**
 * Otra funciona para hacer parsing, pero esta puede "leer e interpretar" si el cliente
 * menciona algo similar a un producto, pero no exactamente lo que hay en la base de datos.
 * Cabe mencionar que crea un embedding nuevo para cada mensaje del cliente, pero no
 * lo introduce en la base de datos, solo se usa para ese momento
 */
function pase_with_embeddings(&$mensaje_cliente)
{
    // Primero se definen las variables de entorno
    $api_key = $_ENV["OPENAI_API_KEY"];
    $model = $_ENV["OPENAI_CHATGPT_MODEL"];

    $host = $_ENV["CHATCENTER_DB_HOST"];
    $db_name = $_ENV["CHATCENTER_DB_NAME"];
    $user = $_ENV["CHATCENTER_DB_USER"];
    $pass = $_ENV["CHATCENTER_DB_PASSWORD"];

    $table_parts= $_ENV["CHATCENTER_DB_TABLE"];
    $column_link_part = $_ENV["CHATCENTER_DB_COLUMN_LINK"];
    $column_id_part = $_ENV["CHATCENTER_DB_COLUMN_ID"];
    $column_description_part = $_ENV["CHATCENTER_DB_COLUMN_DESCRIPTION"];
    $column_embedding_part = $_ENV["CHATCENTER_DB_COLUMN_EMBEDDING"];

    $openai = \OpenAI::factory()
        ->withApiKey($api_key)
        ->make();

    // Se crea un objeto PDO para conectarse a la base de datos
    $pdo = new \PDO("mysql:host=".$host.";dbname=".$db_name.";charset=utf8mb4", $user, $pass, [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
    ]);

    // Simulación de mensaje del cliente
    // $mensaje_cliente = "hola, tienen válvula de escape tvs?"

    // Se obtiener embedding del mensaje del cliente
    $response_embedding = $openai->embeddings()->create([
        "model" => "text-embedding-3-small",
        "input" => $mensaje_cliente,
    ]);

    $consulta_vector = &$response_embedding->embeddings[0]->embedding;

    // Busca el producto más similar en la base de datos del proyecto
    $query = $pdo->query("SELECT ".$column_id_part.", ".$column_description_part.", ".$column_link_part.", ".$column_embedding_part." FROM ".$table_parts." WHERE ".$column_embedding_part." IS NOT NULL");
    $productos = &$query->fetchAll(\PDO::FETCH_ASSOC);

    // Se cierra la conexión a la base de datos
    $pdo = null;

    $mejor_producto = null;
    $mejor_score = -1;

    foreach ($productos as $producto)
    {
        $producto_vector = json_decode($producto[$column_embedding_part], true);

        if (!$producto_vector) continue;

        $score = cosine_similarity($consulta_vector, $producto_vector);

        if ($score > $mejor_score)
        {
            $mejor_score = $score;
            $mejor_producto = $producto;
        }
    }

    // Elimina la referencia de $productos a $query->fetchAll(\PDO::FETCH_ASSOC) para evitar bugs
    unset($productos);

    // Elimina la referencia de $consulta_vector a $response_embedding->embeddings[0]->embedding para evitar bugs
    unset($consulta_vector);

    // print_r($mejor_producto);
    // echo "<br>";

    // return;

    // Se extrae el texto dentro del link. OpenAI no puede analizar páginas web por si mismo
    $texto_extraido = "";

    if ($mejor_producto && isset($mejor_producto[$column_link_part]))
    {
        $texto_extraido = \WebDownload\copy_web($mejor_producto[$column_link_part]);
    }

    // Se genera la respuesta que se va a enviar a OpenAI
    $mensaje_final = "";

    if ($texto_extraido)
    {
        $response2 = $openai->chat()->create([
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => 'Eres un vendedor amable y experto en productos.'],
                ['role' => 'user', 'content' => "El cliente preguntó por: {".$mensaje_cliente."}"],
                ['role' => 'assistant', 'content' => "Aquí está la información del producto más relevante encontrado ({".$mejor_producto[$column_link_part]."}):\n".$texto_extraido."\n\nGenera una respuesta clara y amigable para el cliente."]
            ],
        ]);

        $mensaje_final = $response2["choices"][0]["message"]["content"] ?? "No se pudo generar la respuesta.";
    }
    else
    {
        $mensaje_final = "Lo siento, no encontré información sobre ese producto.";
        return null;
    }

    // Respuesta simulada. Aquí sería el retorno de la función. Dentro de mejor_producto debería ir el nombre, pero por ahora uso el link
    // echo "Producto detectado: ".($mejor_producto[$column_link_part] ?? "Ninguno")."<br>";
    // echo "Link: ".($mejor_producto['link'] ?? "N/A")."<br>";
    // echo "Respuesta final al cliente:<br><br>".$mensaje_final."<br>";

    return $mensaje_final;
}


?>
