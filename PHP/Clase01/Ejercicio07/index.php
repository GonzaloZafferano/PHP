<?php
//Ejercicio 07 - Zafferano Gonzalo

/*
Aplicación No 7 (Mostrar impares)
Generar una aplicación que permita cargar los primeros 10 números impares en un Array.
Luego imprimir (utilizando la estructura for) cada uno en una línea distinta (recordar que el
salto de línea en HTML es la etiqueta <br/>). Repetir la impresión de los números utilizando
las estructuras while y foreach.
*/

$array = array();
$j = 0;
for($i = 0; count($array) < 10; $i++)
{
    if($i % 2 !== 0)
    {
        $array[$j] = $i;
        $j++;
    }
}

for($i = 0; $i < count($array); $i++)
{
    echo $array[$i] . "<br>";
}

echo "<br>";

foreach($array as $numero)
{
    echo $numero . "<br>";
}

echo "<br>";

$i = 0;
while($i < count($array))
{    
    echo $array[$i] . "<br>";
    $i++;
}

?>