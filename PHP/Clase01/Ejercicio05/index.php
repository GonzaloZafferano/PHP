<?php

//Ejercicio 05 - Zafferano Gonzalo
/*
Aplicación No 5 (Números en letras)
Realizar un programa que en base al valor numérico de una variable $num, pueda mostrarse
por pantalla, el nombre del número que tenga dentro escrito con palabras, para los números
entre el 20 y el 60.
Por ejemplo, si $num = 43 debe mostrarse por pantalla “cuarenta y tres”.
*/

$num = 33;

$decenaOriginal = (int)($num / 10);
$unidad = $num - ($decenaOriginal *10);

echo $decenaOriginal;
echo $unidad;
echo "</br>";
$decena = $decenaOriginal;

switch($unidad)
{
    case 1:
        $unidad = "UNO";
        break;
    case 2:
        $unidad = "DOS";
        break;
    case 3:
        $unidad = "TRES";
        break;
    case 4:
        $unidad = "CUATRO";
        break;
    case 5:
        $unidad = "CINCO";
        break;
    case 6:
        $unidad = "SEIS";
        break;
    case 7:
        $unidad = "SIETE";
        break;
    case 8:
        $unidad = "OCHO";
        break;
    case 9:
        $unidad = "NUEVE";
        break;
}

switch($decena)
{
    case 2:
        if($unidad === 0)
        {
            $decena = "VEINTE";
        }
        else{
            $decena = "VEINTI";
        }
        break;
    case 3:
        $decena = "TREINTA";
        break;
    case 4:
        $decena = "CUARENTA";
        break;
    case 5:
        $decena = "CINCUENTA";
        break;
    case 6:
        $decena = "SESENTA";
        break;    
}

if($unidad === 0)
{
    echo $decena;
}
else if($decenaOriginal === 2){
    echo $decena . " " . $unidad;
}
else if($decenaOriginal > 2)
{
    echo $decena . " Y " . $unidad;
}
?>