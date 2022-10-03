<?php

/*
Alumno: Zafferano Gonzalo

Aplicación No 18 (Auto - Garage)
Crear la clase Garage que posea como atributos privados:

_razonSocial (String)
_precioPorHora (Double)
_autos (Autos[], reutilizar la clase Auto del ejercicio anterior)

Realizar un constructor capaz de poder instanciar objetos pasándole como parámetros:

i. La razón social.
ii. La razón social, y el precio por hora.

//OK
Realizar un método de instancia llamado “MostrarGarage”, que no recibirá parámetros y
que mostrará todos los atributos del objeto.

//OK
Crear el método de instancia “Equals” que permita comparar al objeto de tipo Garaje con un
objeto de tipo Auto. Sólo devolverá TRUE si el auto está en el garaje.

//Ok. Agrega 4 y rechaza 2 porque ya estan dichas marcas en el garage (equals de Auto).
Crear el método de instancia “Add” para que permita sumar un objeto “Auto” al “Garage”
(sólo si el auto no está en el garaje, de lo contrario informarlo).
Ejemplo: $miGarage->Add($autoUno);


Crear el método de instancia “Remove” para que permita quitar un objeto “Auto” del
“Garage” (sólo si el auto está en el garaje, de lo contrario informarlo).
Ejemplo: $miGarage->Remove($autoUno);

En testGarage.php, crear autos y un garage. Probar el buen funcionamiento de todos los
métodos.
*/

include_once "./testGarage.php";

class Auto
{
    private $_color;
    private $_precio;
    private $_marca;
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
    {  //FORMA 1
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
}

class Garage
{
    private $_razonSocial; 
    private $_precioPorHora;
    private $_autos;

    public function __construct($razonSocial, $precioPorHora = 0)
    {
        $this->_razonSocial = $razonSocial;
        $this->_precioPorHora = $precioPorHora;
        $this->_autos = array();
    }

    function mostrarGarage()
    {
        echo "Razon social: " . $this->_razonSocial . "<br>";
        echo "Precio por hora: $" . $this->_precioPorHora . "<br>";

        foreach($this->_autos as $auto)
        {
            echo Auto::mostrarAuto($auto);
        }
    }

    
    //Crear el método de instancia “Equals” que permita comparar al objeto de tipo Garaje con un
    //objeto de tipo Auto. Sólo devolverá TRUE si el auto está en el garaje.
    function equals(Auto $auto)
    {        
        foreach($this->_autos as $autoEnGarage)
        {
            if($autoEnGarage->equals($auto))
            {
                return true;
            }
        }
        return false;
    }

    /*Crear el método de instancia “Add” para que permita sumar un objeto “Auto” al “Garage”
    (sólo si el auto no está en el garaje, de lo contrario informarlo).
    Ejemplo: $miGarage->Add($autoUno);*/
    function add(Auto $auto)
    {
        if(!($this->equals($auto)))
        {            
            array_push($this->_autos, $auto);
            echo "Agregado! ";
            echo Auto::mostrarAuto($auto); //SE ESTA EJECUTANDO ANTES SI LOS PONGO EN LA MISMA LINEA.
            return;
        }

        echo "El auto " . $auto->GetMarca() . " YA ESTA en el garage, no se ha agregado. <br>";
    }

    /*
    Crear el método de instancia “Remove” para que permita quitar un objeto “Auto” del
    “Garage” (sólo si el auto está en el garaje, de lo contrario informarlo).
    Ejemplo: $miGarage->Remove($autoUno);*/
    function remove($auto)
    {
        if(isset($auto))
        {
            
            for($i = 0; $i < count($this->_autos); $i++)
            {
                if($this->_autos[$i]->equals($auto))
                {
                    //Argumentos:
                    //Array a recortar.
                    //Indice donde empezar.
                    //Cuantos elementos.
                    //Reemplazo en esa posicion.
                    array_splice($this->_autos, $i, 1);    
                    
                    //array_splice($this->_autos, array_search($auto, $this->_autos), 1);
                    
                    echo "Auto eliminado - ";
                    echo Auto::mostrarAuto($auto);                           
                    return;

                }
            }
            
            echo "El auto NO ESTA en el garage <br>";
        }
    }
}
?>