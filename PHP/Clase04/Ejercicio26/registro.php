<?php

/*
Alumno: ZAFFERANO GONZALO
Aplicación No 23 (Registro JSON)
Archivo: registro.php
método:POST

http://localhost:8080/PHP/Clase04/Ejercicio23/registro.php
KEY para el file: body-formData-nombreKey

Recibe los datos del usuario(nombre, clave,mail )por POST ,
crea un ID autoincremental(emulado, puede ser un random de 1 a 10.000). crear un dato
con la fecha de registro , toma todos los datos y utilizar sus métodos para poder hacer
el alta, guardando los datos en usuarios.json y subir la imagen al servidor en la carpeta
Usuario/Fotos/.
Retorna si se pudo agregar o no.
Cada usuario se agrega en un renglón diferente al anterior.
Hacer los métodos necesarios en la clase usuario.
*/

if(isset($_POST["nombre"]) && isset($_POST["clave"]) && isset($_POST["mail"]))
{
    $nombre = $_POST["nombre"];
    $mail = $_POST["mail"];
    $clave = $_POST["clave"];
   
    $usuario = new Usuario($nombre, $clave, $mail);

    Usuario::AltaUsuarioEnCsv($usuario); 

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
}
else{
    //echo "Faltan completar datos.";
}


class Usuario
{
    public $nombre;
    public $clave;
    public $mail;
    public $id;
    public $fecha;
    public static $usuarios;

    public function __construct($nombre, $clave, $mail)
    {
        if($nombre && $clave && $mail)
        {
            $this->nombre = $nombre;
            $this->clave = $clave;
            $this->mail = $mail;
            $this->id = random_int(1,10000);
            $this->fecha = date("d/m/y");
        }
    }

    public static function CadenaParaCsv(Usuario $usuario)
    {
        return "$usuario->id,$usuario->nombre,$usuario->clave,$usuario->mail,$usuario->fecha" . PHP_EOL;
    }

    public static function arrayJSON($usuarios)
    {
        return json_encode($usuarios);
    }

    public static function AltaUsuarioEnCsv(Usuario $usuario)
    {
        Usuario::$usuarios = Usuario::LeerUsuarios();        
        $archivo = null;
        try{

            //JSON
            array_push(Usuario::$usuarios, $usuario);

            $stringJSON = Usuario::arrayJSON(Usuario::$usuarios);

            //var_dump(Usuario::$usuarios);

            $archivo = fopen("./usuarios.json", "w");

            if(fputs($archivo, $stringJSON))
            {
                echo "Alta exitosa!<br>";
                return true;
            }
            else{
                echo "Ha ocurrido un error!<br>";
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
            if($archivo)
            {
                fclose($archivo);
            }
        }

        return false;
    }
    
    public static function UserExists($id)
    {
        $users = Usuario::LeerUsuarios("./usuarios.json");

        foreach($users as $user)
        {
            if($user->id == $id)
            {
                return $user;
            }
        }
        return null;
    }

    //Lee un archivo CSV y retorna un array de usuarios.
    public static function LeerUsuarios()
    {
        $archivo = null;
        $usuarios = null;

        try{

             //JSON
             $archivo = fopen("./usuarios.json","r");
             $usuarios = json_decode(fread($archivo, filesize("./usuarios.json")));
            
             //SI NO LEYO NADA (primera vez) INSTANCIO UN ARRAY.
             if($usuarios == null)
             {
                $usuarios = array();
             }

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
            if($archivo)
            {
                fclose($archivo);
            }
        }
        return $usuarios;
    }
}






?>