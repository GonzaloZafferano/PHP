<?php

//Ejercicio 04 - Zafferano Gonzalo

/*Aplicación No 4 (Calculadora)
Escribir un programa que use la variable $operador que pueda almacenar los símbolos
matemáticos: ‘+’, ‘-’, ‘/’ y ‘*’; y definir dos variables enteras $op1 y $op2. De acuerdo al
símbolo que tenga la variable $operador, deberá realizarse la operación indicada y mostrarse el
resultado por pantalla.
*/

$operador = "/";
$op1 = 5;
$op2 = 3;

switch($operador)
{
    case "+":
        echo  5+3;
        break;
    case "-":
        echo  5-3;
        break;
    case "*":
        echo  5*3;
        break;
    case "/":
        if($op2 != 0)
        {
            echo  5/3;
        }
        else{
            echo "No se puede dividir por 0";
        }
        break;
}

?>