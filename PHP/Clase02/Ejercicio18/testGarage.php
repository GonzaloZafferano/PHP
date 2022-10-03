<?php


/*
Alumno: Zafferano Gonzalo

En testGarage.php, crear autos y un garage. Probar el buen funcionamiento de todos los
métodos.*/

$autoUno = new Auto("Ford", "Rojo", 300000);
$autoDos = new Auto("VW", "Verde", 124000);

$autoTres = new Auto("Chevrolet", "Azul", 1);
$autoCuatro = new Auto("Ford", "Azul", 2);

$autoCinco = new Auto("Fiat", "Azul", 120000, date("d/M/y"));

$garage = new Garage("Zeta", 1350);

//Uno ok
//dos ok
//tres ok
//Uno de nuevo debe decir que no
//cuatro debe decir que no, porque el garage ya tiene Ford 
//cinco ok
$garage->add($autoUno);
$garage->add($autoDos);
$garage->add($autoTres);
$garage->add($autoUno);
$garage->add($autoCuatro);
$garage->add($autoCinco);

echo "<br>";
echo "<br>";
//OK
$garage->mostrarGarage();
echo "<br>";
echo "<br>";

$garage->remove($autoTres); //DEBE ELIMINAR
$garage->remove($autoUno); //DEBE ELIMINAR.
$garage->remove($autoCuatro); //NO ESTA EN EL GARAGE (pero si esta antes, eliminaria el UNO porque tiene el mismo nombre).
$garage->remove($autoDos); //DEBE ELIMINAR
$garage->remove($autoUno); //YA NO ESTA EN EL GARAGE.

echo "<br>";
echo "<br>";
//OK
$garage->mostrarGarage();

?>