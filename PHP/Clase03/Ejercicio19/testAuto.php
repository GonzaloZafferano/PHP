<?php

/*
En testAuto.php:
● Crear dos objetos “Auto” de la misma marca y distinto color.
● Crear dos objetos “Auto” de la misma marca, mismo color y distinto precio.
● Crear un objeto “Auto” utilizando la sobrecarga restante.
● Utilizar el método “AgregarImpuesto” en los últimos tres objetos, agregando $ 1500
al atributo precio.
● Obtener el importe sumado del primer objeto “Auto” más el segundo y mostrar el
resultado obtenido.
● Comparar el primer “Auto” con el segundo y quinto objeto e informar si son iguales o
no.
● Utilizar el método de clase “MostrarAuto” para mostrar cada los objetos impares (1, 3,
5)
*/


$autoUno = new Auto("Ford", "Rojo", 300000);
$autoDos = new Auto("Ford", "Verde", 124000);

$autoTres = new Auto("Ford", "Azul", 1);
$autoCuatro = new Auto("Ford", "Azul", 2);

$autoCinco = new Auto("Fiat", "Azul", 120000, date("d/M/y"));

$autoTres->agregarImpuestos(1500);
$autoCuatro->agregarImpuestos(1500);
$autoCinco->agregarImpuestos(1500);

Auto::AltaAuto($autoUno);
Auto::AltaAuto($autoDos);
Auto::AltaAuto($autoTres);
Auto::AltaAuto($autoCuatro);
Auto::AltaAuto($autoCinco);

$autos = Auto::LeerArrayDeAutos();

foreach($autos as $auto)
{
    echo Auto::mostrarAuto($auto);
}

?>