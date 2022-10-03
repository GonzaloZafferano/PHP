<?php

//ALUMNO: ZAFFERANO GONZALO

//Aplicación No 33

if(isset($_GET["archivo"]))
{
    switch($_GET["archivo"])
    {
        case "registro":
            include("./Ejercicio27/AccesoADatos.php");  
            include_once("./Ejercicio27/registro.php");
            Iniciar();
            break;
        case "listado":
            include("./Ejercicio28/listado.php");
            include("./Ejercicio28/AccesoADatos.php");    
            Iniciar();
            break;
        case "login":
            include("./Ejercicio29/AccesoADatos.php");    
            include_once("./Ejercicio29/login.php");
            Iniciar();
            break;
        case "altaProducto":
            include("./Ejercicio30/AccesoADatos.php");    
            include_once("./Ejercicio30/altaProducto.php");
            Iniciar();
            break;
        case "realizarVenta":
            include("./Ejercicio31/AccesoADatos.php");    
            include_once("./Ejercicio31/realizarVenta.php");
            Iniciar();
            break;
        case "modificarUsuario":
            include("./Ejercicio32/AccesoADatos.php");    
            include_once("./Ejercicio32/modificacionUsuario.php");
            Iniciar();
            break;
        case "modificarProducto":
            include("./Ejercicio33/AccesoADatos.php");    
            include_once("./Ejercicio33/modificacionproducto.php");
            Iniciar();
            break;
    }       
}





?>