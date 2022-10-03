<?php
//Ejercicio 09 - Zafferano Gonzalo

/*
Aplicación No 9 (Arrays asociativos)
Realizar las líneas de código necesarias para generar un Array asociativo $lapicera, que
contenga como elementos: ‘color’, ‘marca’, ‘trazo’ y ‘precio’. Crear, cargar y mostrar tres
lapiceras.
*/

$lapicera = array();
$lapicera[0]["marca"] = "Bic";
$lapicera[0]["color"] = "Rojo";
$lapicera[0]["trazo"] = "Fino";
$lapicera[0]["precio"] = 90;

$lapicera[1]["marca"] = "Sharpie";
$lapicera[1]["color"] = "Azul";
$lapicera[1]["trazo"] = "Grueso";
$lapicera[1]["precio"] = 190;

$lapicera[2]["marca"] = "Birome";
$lapicera[2]["color"] = "Verde";
$lapicera[2]["trazo"] = "medio";
$lapicera[2]["precio"] = 50;

foreach($lapicera as $unaLapicera)
{
    echo "Lapicera: ".$unaLapicera["marca"] ." ".$unaLapicera["color"]." ".$unaLapicera["trazo"]." ".$unaLapicera["precio"]."<br>";
}



?>
