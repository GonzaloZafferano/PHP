<?php

/*
Alumno: Zafferano Gonzalo

Aplicación No 12 (Invertir palabra)
Realizar el desarrollo de una función que reciba un Array de caracteres y que invierta el orden
de las letras del Array.
Ejemplo: Se recibe la palabra “HOLA” y luego queda “ALOH”.
*/
$retorno = invertirPalabra(array("H", "O","L","A"));


foreach($retorno as $letra)
{
    echo $letra;
}


function invertirPalabra($palabra)
{
    $palabraInvertida = array();

    for($i = count($palabra) -1; $i >= 0; $i--)
    {
        array_push($palabraInvertida, $palabra[$i]);
    }

    return $palabraInvertida;
}

?>