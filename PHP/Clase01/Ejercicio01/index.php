<?php
//Ejercicio 01 - Zafferano Gonzalo
/*
Aplicación No 1 (Sumar números)
Confeccionar un programa que sume todos los números enteros desde 1 mientras la suma no
supere a 1000. Mostrar los números sumados y al finalizar el proceso indicar cuantos números
se sumaron.
*/

$acumulador = 0;
$contador = 0;

for($i = 0; $acumulador + $i <= 1000; $i++)
{
    echo "Acumulador actual: ".$acumulador;
    $acumulador += $i;
    echo ". Numero a sumar: ".$i.". Suma actual: ".$acumulador."</br>";
    $contador++;
}

echo "Se han sumado un total de: ".$contador." numeros.</br>";
echo "El acumulado es: ".$acumulador;

?>