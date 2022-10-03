<?php

/*
ALUMNO: Zafferano Gonzalo

Parte 5 - Ejercicios con POO + Archivos

Aplicación No 19 (Auto)
Realizar una clase llamada “Auto” que posea los siguientes atributos

privados: _color (String)
_precio (Double)
_marca (String).
_fecha (DateTime)

Realizar un constructor capaz de poder instanciar objetos pasándole como

parámetros: i. La marca y el color.
ii. La marca, color y el precio.
iii. La marca, color, precio y fecha.

Realizar un método de instancia llamado “AgregarImpuestos”, que recibirá un doble
por parámetro y que se sumará al precio del objeto.

Realizar un método de clase llamado “MostrarAuto”, que recibirá un objeto de tipo “Auto”
por parámetro y que mostrará todos los atributos de dicho objeto.

Crear el método de instancia “Equals” que permita comparar dos objetos de tipo “Auto”. Sólo
devolverá TRUE si ambos “Autos” son de la misma marca.

Crear un método de clase, llamado “Add” que permita sumar dos objetos “Auto” (sólo si son
de la misma marca, y del mismo color, de lo contrario informarlo) y que retorne un Double con
la suma de los precios o cero si no se pudo realizar la operación.
Ejemplo: $importeDouble = Auto::Add($autoUno, $autoDos);

Crear un método de clase para poder hacer el alta de un Auto, guardando los datos en un
archivo autos.csv.
Hacer los métodos necesarios en la clase Auto para poder leer el listado desde el archivo
autos.csv
Se deben cargar los datos en un array de autos.

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

include "./testAuto.php";

class Auto
{
    private $_marca;
    private $_color;
    private $_precio;
    private $_fecha;

    public function __construct($marca, $color, $precio = 0, $fecha = "Sin fecha")
    {
        $this->_color = $color;
        $this->_marca = $marca;
        $this->_precio = $precio;
        $this->_fecha = $fecha;    
    }

    public function GetMarca()
    {
        return $this->_marca;
    }

    function agregarImpuestos($impuesto)
    {  
        //FORMA 1
        //SI NO PONGO GLOBAL, ME DA ERROR, PORQUE INTERPRETA QUE 
        //LA VARIABLE "$_precio" LA ESTOY CREANDO ACA, Y LE INTENTO ACUMULAR VALORES 
        //ANTES DE INICIALIZARLA.
        global $_precio; //INDICO QUE LA VARIABLE VIENE DE AFUERA, NO ESTA SIENDO CREADA ACA.
        $_precio += $impuesto;

        //FORMA 2
       // $this->_precio += $impuesto;
    }

    static function mostrarAuto(Auto $auto)
    {
        echo "Color: " . $auto->_color .". Marca: ". $auto->_marca . ". Precio: $" . $auto->_precio . ". Fecha: ". $auto->_fecha ."<br>";
    }

    function equals(Auto $auto)
    {
        return strcasecmp($this->_marca, $auto->_marca) == 0;
    }

    static function add(Auto $primerAuto, Auto $segundoAuto)
    {
        if(strcasecmp($primerAuto->_marca, $segundoAuto->_marca) == 0 && 
           strcasecmp($primerAuto->_color, $segundoAuto->_color) == 0)
        {
            return $primerAuto->_precio + $segundoAuto->_precio;
        }
        echo "AVISO: Los autos no son iguales, no se pueden sumar. <br>";
        return 0;
    }

    /*Crear un método de clase para poder hacer el alta de un Auto, guardando los datos en un
    archivo autos.csv.*/
    static function AltaAuto(Auto $auto)
    {   
        
        //FORMA 1
        if($auto)
        {            
            //PHP_EOL - SALTO DE LINEA
            //ESTA FORMA (MANUAL) ME PERMITE DARLE UN ORDEN A LOS ELEMENTOS EN EL CSV.
            $autoSerializado = $auto->_marca . "," . $auto->_color . "," .  $auto->_precio . "," . $auto->_fecha . PHP_EOL; 

            $archivo = null;

            try{
                $archivo = fopen("autos.csv", "a+");
        
                fputs($archivo, $autoSerializado);
            }
            catch(Exception $ex){
                echo "Ha ocurrido un error: " . $ex->getMessage();
            }
            finally
            {
                if($archivo)
                {
                    fclose($archivo);
                }
            }
        }
        
        
        /*
        //FORMA 2
        if($auto)
        {
            $archivo = null;
            try{
                $archivo = fopen("autos.csv", "a+");

                //"get_object_vars()" 
                //OBTIENE LAS VARIABLES EN EL MISMO ORDEN EN QUE FUERON DECLARADAS.
                //TENER MUCHO CUIDADO! Porque se guardaran las variables en el CSV con el ORDEN
                //que les dé la funcion "get_object_vars()"
                fputs($archivo, implode(",", get_object_vars($auto)) . PHP_EOL);
            }
            catch(Exception $ex){ 
                echo "Ha ocurrido un error: " . $ex->getMessage();
            }
            finally
            {
                if($archivo)
                {
                    fclose($archivo);
                }
            }
        }
        */
    }

    /*
    Hacer los métodos necesarios en la clase Auto para poder leer el listado desde el archivo
    autos.csv
    Se deben cargar los datos en un array de autos.*/
    static function LeerArrayDeAutos()
    {
        $autos = array();
        $archivo = null;
        try
        {
            $archivo = fopen("autos.csv", "r");

            while(!feof($archivo)) 
            {
                $cadena = fgets($archivo);

                if($cadena && !empty($cadena))
                {
                    $datos = explode(",", $cadena);

                    $auto = new Auto($datos[0], $datos[1], $datos[2], $datos[3]);

                    array_push($autos, $auto);
                }
            }
        }
        catch(Exception $ex)
        {
            echo "Ha ocurrido un error: " . $ex->getMessage(); 
        }
        finally
        {
            if($archivo)
            {
                fclose($archivo);
            }
        }

        return $autos;
    }
}

?>
