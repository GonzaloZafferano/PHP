<?php

/*
Alumno: Zafferano Gonzalo

Aplicación No 24 ( Listado JSON y array de usuarios)
Archivo: listado.php
método:GET
Recibe qué listado va a retornar(ej:usuarios,productos,vehículos,...etc),por ahora solo tenemos
usuarios).

En el caso de usuarios carga los datos del archivo usuarios.json.
se deben cargar los datos en un array de usuarios.
Retorna los datos que contiene ese array en una lista
<ul>
<li>apellido, nombre,foto</li>
<li>apellido, nombre,foto</li>
</ul>
Hacer los métodos necesarios en la clase usuario
*/

/*
LE PASO LA RUTA POR LA URL (GET)
http://localhost:8080/PHP/Clase04/Ejercicio24/listado.php?ruta=./usuarios.json

KEY para el file (si uso POST): body-formData-nombreKey


*/
if(isset($_GET["ruta"]))
{
    $ruta = $_GET["ruta"];

    echo Usuario::EnlistarUsuarios($ruta);
}

if(isset($_POST["nombre"]) && isset($_POST["apellido"]))
{
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
   
    //LA RUTA "Usuarios/Fotos/" DEBE EXISTIR DE ANTES.
    //$_FILES["body-formData-nombreKey"] ES UN ARRAY CON 5 ELEMENTOS:
    //name, tmp_name, error, size, type.
    //Este array mencionado DEBE TENER el mismo nombre que la KEY del body.
    $destino = "Usuarios/Fotos/".$_FILES["body-formData-nombreKey"]["name"];

    //ME LLEVO EL ARCHIVO QUE ESTA EN UNA CARPETA TEMPORAL, 
    //A UN DESTINO PERMANENTE EN EL SERVIDOR.
    //SI NO LO HAGO, EL ARCHIVO VA A DESAPARECER EN CUALQUIER MOMENTO, PORQUE ES TEMPORAL.
    if(move_uploaded_file($_FILES["body-formData-nombreKey"]["tmp_name"], $destino))
    {
        echo "Se ha movido el archivo a: " . $destino;
    }
    else{
        var_dump($_FILES["body-formData-nombreKey"]["error"]);
    }
       
    $usuario = new Usuario($nombre, $apellido, $destino);

    //USADO PARA LAS ALTAS
    Usuario::AltaUsuarioEnCsv($usuario, $ruta); 
    
    echo Usuario::EnlistarUsuarios($ruta);

}



class Usuario
{
    public $nombre;
    public $apellido;
    public $destino;

    public function __construct($nombre, $apellido, $destino)
    {
        if($nombre && $apellido)
        {
            $this->nombre = $nombre;
            $this->apellido = $apellido;
            $this->destino = $destino;
        }
    }

    public static function EnlistarUsuarios($ruta)
    {
        $usuarios = Usuario::LeerUsuarios($ruta);        
        $lista = "";
        $lista .= "<ul>";

        //var_dump($usuarios);

        if(isset($usuarios))
        {
            foreach($usuarios as $usuario)
            {
                if(isset($usuario))
                {
                    $lista .= "<li>";
                    $lista .= $usuario->nombre . " - " . $usuario ->apellido . " - ". $usuario->destino;
                    $lista .= "</li>";
                }
            }
        }

        $lista .= "</ul>";

        return $lista;
    }

    public static function CadenaParaCsv(Usuario $usuario)
    {
        return "$usuario->id,$usuario->nombre,$usuario->clave,$usuario->mail,$usuario->fecha" . PHP_EOL;
    }

    public static function arrayJSON($usuarios)
    {
        return json_encode($usuarios);
    }

    public static function AltaUsuarioEnCsv(Usuario $usuario, $ruta)
    {       
        $usuarios = Usuario::LeerUsuarios($ruta);    

        $archivo = null;
        try{
            //JSON
            array_push($usuarios, $usuario);

            $stringJSON = Usuario::arrayJSON($usuarios);

           // var_dump($usuarios);

            $archivo = fopen($ruta, "w");

            if(fputs($archivo, $stringJSON))
            {
                echo "<br>Alta exitosa!<br>";

                return true;
            }
            else{
                echo "<br>Ha ocurrido un error!<br>";
            }


            //CSV
            /*

            $archivo = fopen("usuarios.csv", "a+");

            $usuarioSerializado = Usuario::CadenaParaCsv($usuario);

           if(fputs($archivo, $usuarioSerializado))
           {
                echo "Alta exitosa! </br>";
                return true;
           }
           else{
            echo "Ha ocurrido un error!</br>";
           }

           */

        }catch(Exception $ex)
        {
            echo "Ha ocurrido un error: " . $ex->getMessage();
        }
        finally
        {
            if(isset($archivo))
            {
                fclose($archivo);
            }
        }

        return false;
    }

    //Lee un archivo CSV y retorna un array de usuarios.
    public static function LeerUsuarios($ruta)
    {
        $archivo = null;
        $usuarios = null;

        //echo $ruta;
        //echo "<br>./usuarios.json";

        try{            
            //JSON
            //if(file_exists("./usuarios.json"))
            if(file_exists($ruta))
            {
                //$archivo = fopen("./usuarios.json","r");
                $archivo = fopen($ruta,"r");

                //HACERLO EN 2 PASOS, ES DECIR, 
                //NO PASAR DIRECTAMENTE EL RETORNO DE FREAD() AL JSON_DECODE().
                //$cadena = fread($archivo, filesize("./usuarios.json"));
                $cadena = fread($archivo, filesize($ruta));

               /*
                echo "<br>---<br>---";
                var_dump($cadena);
                echo "---<br>---<br>";
                */
                
                $usuarios = json_decode($cadena);
                
            }
            else{
                //SI NO LEYO NADA (primera vez) INSTANCIO UN ARRAY.
                if($usuarios == null)
                {
                    $usuarios = array();                        
                }                    
            }
                
            //var_dump($usuarios);

            //CVS
            /*
            $archivo = fopen("usuarios.csv","r");

            while(!feof($archivo))
            {
                $linea = fgets($archivo);

                if($linea && !empty($linea))
                {
                    //ELIMINO EL SALTO DE LINEA.
                    $linea = str_replace(PHP_EOL, "", $linea);

                    $datos = explode(",", $linea);

                    $usuario = new Usuario($datos[1], $datos[2], $datos[3]);
                    $usuario->id = $datos[0];
                    $usuario->fecha = $datos[4];

                    array_push($usuarios, $usuario);
                }
            }

            */
        }
        catch(Exception $ex)
        {
            echo "Ha ocurrido un error: " . $ex->getMessage(); 
        }
        finally
        {
            if(isset($archivo))
            {
                fclose($archivo);
            }
        }
        return $usuarios;
    }
}






?>