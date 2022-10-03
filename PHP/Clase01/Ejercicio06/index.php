<?php
//Ejercicio 06 - Zafferano Gonzalo

/*
Aplicación No 6 (Carga aleatoria)
Definir un Array de 5 elementos enteros y asignar a cada uno de ellos un número (utilizar la
función rand). Mediante una estructura condicional, determinar si el promedio de los números
son mayores, menores o iguales que 6. Mostrar un mensaje por pantalla informando el
resultado.
*/

$array = array(rand(0,100),rand(0,100),rand(0,100),rand(0,100),rand(0,100));

$acumulador = 0;


for($i = 0; $i < count($array); $i++)
{
    $acumulador += $array[$i];
}

$resultado = $acumulador / count($array);

if($resultado % 2 > 6)
{
    echo "El promedio es mayor a 6<br>";
}
else if($resultado % 2 < 6)
{    
    echo "El promedio es menor a 6<br>";
}
else{
    echo "El promedio es igual a 6<br>";
}

echo "El resultado es ".$acumulador;
echo "<br>El promedio es ".$resultado;

?>