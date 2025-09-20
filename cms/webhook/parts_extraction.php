<?php

Class PartsExtraction {

    /* Extracts all the product links from the bussines database and puts them inside the project's */
    static public function copy_products_links() {

        // ******************************************************************************************
        //
        // Extract each of the variables needed to connect to the dpartes db from chatcenter db
        //
        // ******************************************************************************************

        $chatcenter_host_name = 'localhost';
        $chatcenter_user_name = 'root';
        $chatcenter_password = '';
        $chatcenter_database = 'chatcenter';
        $chatcenter_port = 80;
        $chatcenter_table = 'dpartes';
        $chatcenter_column = 'id_dpart';
        $chatcenter_row = null;

        $pdo_connection = null;
        $result = null;

        try {

            $pdo_connection = new PDO("mysql:host=".$chatcenter_host_name.";dbname".$chatcenter_database.";charset=utf8mb4", $chatcenter_user_name, $chatcenter_password);

            // Set the PDO error mode to exception
            $pdo_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Print host information
            echo "Connect Successfully. Host info: ".$pdo_connection->getAttribute(constant("PDO::ATTR_CONNECTION_STATUS")); echo '<br>';

            $query = $pdo_connection->prepare("SELECT * FROM ".$chatcenter_database.".".$chatcenter_table." WHERE ".$chatcenter_column."='1';");
            print_r($query);
            echo '<br><br>';
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            // if ($result) {

            //     foreach ($result as $key => $value) {

            //         echo '<br>';
            //         print_r($value);
            //         echo '<br>';
            //     }
            // }
            // else {

            //     $formMessage = "Invalid column or row<br>";
            // }

            $query->closeCursor();
        }
        catch(PDOException $e) {

            die("ERROR: " . $e->getMessage());
        }


        $result = $result[0]; // Get the associative array inside $results[0]

        // Host name variable
        echo '<br>';
        $dpartes_host_name = $result["host_dpart"];
        // print_r($dpartes_host_name);

        // User name variable
        echo '<br>';
        $dpartes_user_name = $result["user_dpart"];
        // print_r($dpartes_user_name);

        // Password variable
        echo '<br>';
        $dpartes_password = $result["password_dpart"];
        // print_r($dpartes_password);

        // Database variable
        echo '<br>';
        $dpartes_database = $result["database_dpart"];
        // print_r($dpartes_database);

        // Port variable
        echo '<br>';
        $dpartes_port = $result["port_dpart"];
        // print_r($dpartes_port);
        echo '<br><br><br>';

        $pdo_connection = null; // Cierra la conexión

        $result = null;


        // ******************************************************************************************
        //
        // Extract product links from the bussiness database and add "https://dpartes.com/repuesto/"
        // to the beginning of each link
        //
        // ******************************************************************************************

        $dpartes_table = 'slugs';
        $dpartes_column = 'tipo';
        $dpartes_column_slug = 'slug';

        try {

            $pdo_connection = new PDO("mysql:host=".$dpartes_host_name.";dbname".$dpartes_database.";charset=utf8mb4", $dpartes_user_name, $dpartes_password);

            // Set the PDO error mode to exception
            $pdo_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Print host information
            echo "Connect Successfully. Host info: ".$pdo_connection->getAttribute(constant("PDO::ATTR_CONNECTION_STATUS")); echo '<br>';

            $query = $pdo_connection->prepare("SELECT ".$dpartes_column_slug." FROM ".$dpartes_database.".".$dpartes_table." WHERE ".$dpartes_column."='RPTO';");
            print_r($query);
            echo '<br><br>';
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            $links_arr = array();
            $links_str = null;

            if ($result) {

                for ($index = 0; $index < count($result); $index++) {

                    $links_str = $result[$index]['slug'];
                    $links_str = "https://dpartes.com/repuesto/".$links_str;
                    array_push($links_arr, $links_str);

                    //echo "<br><br>";
                }

                print_r($links_arr);
                echo "<br><br>";
                print($links_arr[0]);
            }
            else {

                $formMessage = "Invalid column or row<br>";
            }

            $query->closeCursor();
        }
        catch(PDOException $e) {

            die("ERROR: " . $e->getMessage());
        }

        $pdo_connection = null; // Cierra la conexión


        // ******************************************************************************************
        //
        // Insert product links into the project's database
        //
        // ******************************************************************************************

        $chatcenter_table = 'parts';
        $chatcenter_column = 'link_part';

        try {

            $pdo_connection = new PDO("mysql:host=".$chatcenter_host_name.";dbname".$chatcenter_database.";charset=utf8mb4", $chatcenter_user_name, $chatcenter_password);

            // Set the PDO error mode to exception
            $pdo_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Print host information
            echo "Connect Successfully. Host info: ".$pdo_connection->getAttribute(constant("PDO::ATTR_CONNECTION_STATUS")); echo '<br><br><br>';

            foreach ($links_arr as $link) {

                $query = $pdo_connection->prepare("USE ".$chatcenter_database."; INSERT INTO ".$chatcenter_table."(".$chatcenter_column.") VALUES('".$link."');");
                print_r($query);
                echo '<br><br>';
                $query->execute();
            }

            $query->closeCursor();
        }
        catch(PDOException $e) {

            die("ERROR: " . $e->getMessage());
        }

        $pdo_connection = null; // Cierra la conexión


        return;
    }
}

?>
