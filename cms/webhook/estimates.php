<?php

// "estimates" es "cotizaciones" en inglés
namespace estimates;

// define("estimates\TEST", "3"); // Run-time constant
const TEST = 3; // 'Compile-time' constant

$estimate = array();

function test_function(&$arr)
{
    // $arr["first"]++;
    // $arr["second"]++;
    // $arr["third"]++;

    $estimate = [];

    $product1 =
    [
        "name" => "Black Eagle",
        "brand" => "AKT",
        "price" => 500,
        "part_number" => "45431816186161",
        "sku" => "SGUFGHY8148141CV",
        "amount" => 1,
        "origin_country" => "Colombia"
    ];

    array_push($estimate, $product1);
    // $estimate[0] = $product1;
    echo "The array inside the function is: <br>"; print_r($estimate); echo "<br><br>";

    $product2 =
    [
        "name" => "Orange Tubby",
        "brand" => "BMW",
        "price" => 800,
        "part_number" => "90118143632228",
        "sku" => "YHDFFFHGGYJ95856198",
        "amount" => 3,
        "origin_country" => "Germany"
    ];

    $element_amount = array_push($estimate, $product2);
    // $estimate[1] = $product2;
    echo "The array inside the function after the PUSH is: <br>"; print_r($estimate); echo "<br><br>";

    array_push($estimate, "This is a test string");
    echo "The array inside the function after the STRING PUSH is: <br>"; print_r($estimate); echo "<br><br>";

    echo "The amount of elements inside the array is: <br>"; print_r(count($estimate)); echo "<br><br>";
}

function add_product(&$product)
{
    $product1 =
    [
        "name" => $product->name,
        "brand" => $product->brand,
        "price" => $product->price,
        "part_number" => $product->part_number,
        "sku" => $product->sku,
        "amount" => $product->amount,
        "origin_country" => $product->origin_country
    ];

    // $estimate->
}

function create_estimate_link(&$estimate)
{

}

?>
