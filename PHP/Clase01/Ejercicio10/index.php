<?php
//Ejercicio 10 - Zafferano Gonzalo

/*
Aplicación No 10 (Arrays de Arrays)
Realizar las líneas de código necesarias para generar un Array asociativo y otro indexado que
contengan como elementos tres Arrays del punto anterior cada uno. Crear, cargar y mostrar los
Arrays de Arrays.
*/

$asociativoUno = array();
$asociativoUno["marca"] = "Bic";
$asociativoUno["color"] = "Rojo";
$asociativoUno["trazo"] = "Fino";
$asociativoUno["precio"] = 90;

$asociativoDos = array();
$asociativoDos["marca"] = "Sharpie";
$asociativoDos["color"] = "Azul";
$asociativoDos["trazo"] = "Grueso";
$asociativoDos["precio"] = 190;

$asociativoTres = array();
$asociativoTres["marca"] = "Birome";
$asociativoTres["color"] = "Verde";
$asociativoTres["trazo"] = "medio";
$asociativoTres["precio"] = 50;

$arrayIndexado[0] = $asociativoUno;
$arrayIndexado[1] = $asociativoDos;
$arrayIndexado[2] = $asociativoTres;

foreach($arrayIndexado as $elemento)
{
    echo "Lapicera: ".$elemento["marca"] ." ".$elemento["color"]." ".$elemento["trazo"]." ".$elemento["precio"]."<br>";
}

?>