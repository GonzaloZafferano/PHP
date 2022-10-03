<?php

/*
Alumno: Zafferano Gonzalo

Aplicación No 20 (Registro CSV)
Archivo: registro.php
método:POST


Recibe los datos del usuario(nombre, clave,mail )por POST ,
crear un objeto y utilizar sus métodos para poder hacer el alta,
guardando los datos en <<<< usuarios.csv >>>>.
retorna si se pudo agregar o no.
Cada usuario se agrega en un renglón diferente al anterior.
Hacer los métodos necesarios en la clase usuario.
*/
if(isset($_POST["nombre"]) && 
    isset($_POST["clave"]) &&
    isset($_POST["mail"]))
{
    $nombre = $_POST["nombre"];
    $clave = $_POST["clave"];
    $mail = $_POST["mail"];
    
    $usuario = new Usuario($nombre, $clave, $mail);

    Usuario::AltaUsuarioEnCsv($usuario);
}

class Usuario
{
    private $nombre;
    private $clave;
    private $mail;

    public function __construct($nombre, $clave, $mail)
    {
        if($nombre && $clave && $mail)
        {
            $this->nombre = $nombre;
            $this->clave = $clave;
            $this->mail = $mail;
        }
    }

    public static function CadenaParaCsv(Usuario $usuario)
    {
        return "$usuario->nombre,$usuario->clave,$usuario->mail" . PHP_EOL;
    }

    public static function AltaUsuarioEnCsv(Usuario $usuario)
    {
        $archivo = null;
        try{
            $archivo = fopen("usuarios.csv", "a+");

            $usuarioSerializado = Usuario::CadenaParaCsv($usuario);

           if(fputs($archivo, $usuarioSerializado)) 
           {
                echo "Alta exitosa!<br>";
                return true;
           }
           else{
            echo "Ha ocurrido un error!<br>";           
           }

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
}

?>