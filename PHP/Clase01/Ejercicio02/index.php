<?php
//Ejercicio 02 - Gonzalo Zafferano

/*
Aplicación No 2 (Mostrar fecha y estación)
Obtenga la fecha actual del servidor (función date) y luego imprímala dentro de la página con
distintos formatos (seleccione los formatos que más le guste). Además indicar que estación del
año es. Utilizar una estructura selectiva múltiple.
 */

echo date("d/m/y") . "</br>";
echo date("D-M-Y") . "</br>";

$dia = date("d");
$mes = date("m");

switch($mes)
{ 
    case 1:
    case 2:
    case 3:
        if($mes < 3 || ($mes == 3 && $dia < 21))
        {
            echo "Verano";
        }
        else{
            echo "Otoño";
        }
        break;
    case 4:
    case 5:
    case 6:
        if($mes < 6 || ($mes == 6 && $dia < 21))
        {
            echo "Otoño";
        }
        else{
            echo "Invierno";
        }
        break;
    case 7:
    case 8:
    case 9:
        if($mes < 9 || ($mes == 9 && $dia < 21))
        {
            echo "Invierno";
        }
        else{
            echo "Primavera";
        }
        break;
    default:
        if($mes < 12 || ($mes == 12 && $dia < 21))
        {
            echo "Primavera";
        }
        else{
            echo "Verano";
        }
        break;
}

?>