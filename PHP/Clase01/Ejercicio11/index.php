<?php

/*
Aplicación Nº 13 (Arrays asociativos II)
Cargar los tres arrays con los siguientes valores y luego ‘juntarlos’ en uno. Luego mostrarlo por
pantalla.
“Perro”, “Gato”, “Ratón”, “Araña”, “Mosca”
“1986”, “1996”, “2015”, “78”, “86”
“php”, “mysql”, “html5”, “typescript”, “ajax”
Para cargar los arrays utilizar la función array_push. Para juntarlos, utilizar la función
array_merge.
*/

$array = array();

array_push($array, "Perro");
array_push($array, "Gato");
array_push($array, "Raton");
array_push($array, "Araña");
array_push($array, "Mosca");

$arrayDos = array();
array_push($arrayDos, 1986);
array_push($arrayDos, 1996);
array_push($arrayDos, 2015);
array_push($arrayDos, 78);
array_push($arrayDos, 86);

$arrayTres = array();
array_push($arrayTres, "php");
array_push($arrayTres, "mysql");
array_push($arrayTres, "html5");
array_push($arrayTres, "typescript");
array_push($arrayTres, "ajax");

$arrayFinal = array_merge($array, $arrayDos, $arrayTres);

foreach($arrayFinal as $elemento)
{
    echo $elemento . "<br>";
}


?>