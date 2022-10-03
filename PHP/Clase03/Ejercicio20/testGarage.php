<?php

/*
En testGarage.php, crear autos y un garage. Probar el buen funcionamiento de todos
los métodos.
*/

$autoUno = new Auto("Ford", "Rojo", 300000);
$autoDos = new Auto("VW", "Verde", 124000);
$autoTres = new Auto("Chevrolet", "Azul", 1);
$autoCuatro = new Auto("AlfaRomeo", "Azul", 2);
$autoCinco = new Auto("Fiat", "Azul", 120000, date("d/M/y"));

$garage = new Garage("Zeta", 1350);

$garage->add($autoUno);
$garage->add($autoDos);
$garage->add($autoTres);
$garage->add($autoCuatro);
$garage->add($autoCinco);

Garage::AltaGarage($garage);

$garageLeido = Garage::LeerGarage();

echo "<br><br>Leemos<br>";
$garageLeido->mostrarGarage();
echo "Fin lectura<br><br>";

?>