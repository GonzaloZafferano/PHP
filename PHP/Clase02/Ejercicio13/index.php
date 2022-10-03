<?php

/*
Alumno: Zafferano Gonzalo

Aplicación No 13 (Invertir palabra)
Crear una función que reciba como parámetro un string ($palabra) y un entero ($max). La
función validará que la cantidad de caracteres que tiene $palabra no supere a $max y además
deberá determinar si ese valor se encuentra dentro del siguiente listado de palabras válidas:
“Recuperatorio”, “Parcial” y “Programacion”. Los valores de retorno serán:
1 si la palabra pertenece a algún elemento del listado.
0 en caso contrario.
*/

$retorno = validarPalabra("Recuperatorio", 20);
echo "Retorno= " . $retorno . "<br>";

$retorno = validarPalabra("Parcial", 2);
echo "Retorno= " . $retorno . "<br>";

$retorno = validarPalabra("Programar", 20);
echo "Retorno= " . $retorno . "<br>";

function validarPalabra($palabra, $max)
{
    $listaDePalabrasValidas = array("Recuperatorio", "Parcial", "Programacion");

    if(mb_strlen($palabra) <= $max)
    {
        foreach($listaDePalabrasValidas as $palabraValida)
        {
            if(strcasecmp($palabra, $palabraValida) == 0)
            {
                return 1;
            }
        }
    }
    return 0;
}

?>