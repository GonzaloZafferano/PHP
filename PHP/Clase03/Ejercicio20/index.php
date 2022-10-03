<?php


/*
Alumno: Zafferano Gonzalo

Aplicación No 20 (Auto - Garage)
Crear la clase Garage que posea como atributos privados:

_razonSocial (String)
_precioPorHora (Double)
_autos (Autos[], reutilizar la clase Auto del ejercicio anterior)
Realizar un constructor capaz de poder instanciar objetos pasándole como

parámetros: i. La razón social.
ii. La razón social, y el precio por hora.

Realizar un método de instancia llamado “MostrarGarage”, que no recibirá parámetros y
que mostrará todos los atributos del objeto.

Crear el método de instancia “Equals” que permita comparar al objeto de tipo Garaje con un
objeto de tipo Auto. Sólo devolverá TRUE si el auto está en el garaje.

Crear el método de instancia “Add” para que permita sumar un objeto “Auto” al “Garage”
(sólo si el auto no está en el garaje, de lo contrario informarlo).
Ejemplo: $miGarage->Add($autoUno);

Crear el método de instancia “Remove” para que permita quitar un objeto “Auto” del
“Garage” (sólo si el auto está en el garaje, de lo contrario informarlo). Ejemplo:
$miGarage->Remove($autoUno);

Crear un método de clase para poder hacer el alta de un Garage y, guardando los datos en un
archivo garages.csv.

Hacer los métodos necesarios en la clase Garage para poder leer el listado desde el archivo
garage.csv
Se deben cargar los datos en un array de garage.

En testGarage.php, crear autos y un garage. Probar el buen funcionamiento de todos
los métodos.
*/

include "./testGarage.php";

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

    public function getMarca()
    {
        return $this->_marca;
    }

    public function getColor()
    {
        return $this->_color;
    }

    public function getPrecio()
    {        
        return $this->_precio;
    }

    public function getFecha()
    {
        return $this->_fecha;
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

     /*Crear un método de clase para poder hacer el alta de un Auto, guardando los datos en un
    archivo autos.csv.*/
    static function AltaAuto(Auto $auto, string $ruta)
    {           
        //FORMA 1
        if($auto && $ruta)
        {            
            //PHP_EOL - SALTO DE LINEA
            //ESTA FORMA (MANUAL) ME PERMITE DARLE UN ORDEN A LOS ELEMENTOS EN EL CSV.
            $autoSerializado = $auto->_marca . "," . $auto->_color . "," .  $auto->_precio . "," . $auto->_fecha . PHP_EOL; 

            $archivo = null;

            try{
                $archivo = fopen($ruta, "a+");
        
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

    /*
    Crear un método de clase para poder hacer el alta de un Garage y, guardando los datos en un
    archivo garages.csv.
    */
    static function AltaGarage(Garage $garage)
    {
        if($garage)
        {
            $archivo = null;
            try{
                $archivo = fopen("garages.csv", "a+");

               $datosDeGarageSerializado = $garage->_razonSocial . "," . $garage->_precioPorHora . PHP_EOL; 

                foreach($garage->_autos as $auto)
                {
                    $datosDeGarageSerializado .= $auto->getMarca() . "," . $auto->getColor() . "," .  $auto->getPrecio() . "," . $auto->getFecha() . PHP_EOL; 
                }

               fputs($archivo, $datosDeGarageSerializado);
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
        }
    }

    /*
    Hacer los métodos necesarios en la clase Garage para poder leer el listado desde el archivo
    garage.csv
    Se deben cargar los datos en un array de garage.
    */
    static function LeerGarage()
    {
        $garageParaLeer = null;
        $archivo = null;
        try{
            $archivo = fopen("garages.csv", "r");

            $primerIngreso = false;

            while(!feof($archivo))
            {
                $cadena = fgets($archivo);                            

                if($cadena && !empty($cadena))
                {
                    $datos = explode(",", $cadena);

                    if(!$primerIngreso && (count($datos)== 2))
                    {
                        //Si no pongo global, va a interpretar que 
                        //la variable "$garageParaLeer" es creada y usada aqui mismo.
                        global $garageParaLeer;

                        $garageParaLeer = new Garage($datos[0], $datos[1]);
                        
                        $primerIngreso = true;
                    }
                    else if(count($datos)== 4){                        
                        global $garageParaLeer;

                        $auto = new Auto($datos[0], $datos[1], $datos[2], $datos[3]);
                        array_push($garageParaLeer->_autos, $auto);                        
                    }
                }
            }

        }
        catch(Exception $ex)
        {
            echo "Ha ocurrido un error: " . $ex->getMessage();
        }
        finally{
            if($archivo)
            {
                fclose($archivo);
            }
        }
        return $garageParaLeer;
    }
}
?>