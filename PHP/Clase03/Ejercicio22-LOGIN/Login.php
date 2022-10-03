<?php


/*
Alumno: Zafferano Gonzalo

Aplicación No 22 ( Login)
Archivo: Login.php
método:POST


Recibe los datos del usuario(clave,mail) por POST ,
crear un objeto y utilizar sus métodos para poder verificar si es un usuario registrado,
Retorna un :
“Verificado” si el usuario existe y coincide la clave también.
“Error en los datos” si esta mal la clave.
“Usuario no registrado si no coincide el mail“
Hacer los métodos necesarios en la clase usuario
*/

if(isset($_POST["clave"]) && isset($_POST["mail"]))
{
    $mail = $_POST["mail"];
    $clave = $_POST["clave"];

    echo Usuario::ValidarUsuario($clave, $mail);
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

    public static function CadenaParaListarUsuarios(Usuario $usuario)
    {
        return "Nombre: '$usuario->nombre' - Mail: '$usuario->mail' - Clave: '$usuario->clave'";
    }

    public static function AltaUsuarioEnCsv(Usuario $usuario)
    {
        $archivo = null;
        try{
            $archivo = fopen("../Ejercicio20-POST/usuarios.csv", "a+");

            $usuarioSerializado = Usuario::CadenaParaCsv($usuario);

           if(fgets($archivo, $usuarioSerializado))
           {
                echo "Alta exitosa!<br>";
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
    }

    //Lee un archivo CSV y retorna un array de usuarios.
    public static function LeerUsuario()
    {
        $archivo = null;
        $usuarios = array();

        try{
            $archivo = fopen("../Ejercicio20-POST/usuarios.csv","r");

            while(!feof($archivo))
            {
                $linea = fgets($archivo);

                if($linea && !empty($linea))
                {
                    //ELIMINO EL SALTO DE LINEA.
                    $linea = str_replace(PHP_EOL, "", $linea);

                    $datos = explode(",", $linea);

                    $usuario = new Usuario($datos[0], $datos[1], $datos[2]);

                    array_push($usuarios, $usuario);
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
        return $usuarios;
    }

    //Recibe un ARRAY. Enlista los usuarios en una lista HTML.
    public static function EnlistarUsuarios($listaUsuarios)
    {
        $cadena = "<ul>";

        foreach($listaUsuarios as $usuario)
        {
            $cadena .= "<li>";
            $cadena .= Usuario::CadenaParaListarUsuarios($usuario);
            $cadena .= "</li>";
        }

        $cadena .= "</ul>";

        return $cadena;
    }

    public static function UsuarioYClaveExiste($listaUsuarios, $clave, $mail)
    {
        foreach($listaUsuarios as $usuario)
        {
            if(strcasecmp($usuario->mail,$mail) == 0 &&
                
                //esta comparación considera mayúsculas y minúsculas.
                strcmp($usuario->clave, $clave) == 0)
            {
                return true;
            }
        }
        return false;
    }

    public static function VerificarUsuario($listaUsuarios, $mail)
    {
        foreach($listaUsuarios as $usuario)
        {     
            if(strcasecmp($usuario->mail, $mail) == 0)
            {
                return true;
            }
        }
        return false;
    }

    public static function ValidarUsuario($clave, $mail)
    {
        $listaUsuarios = Usuario::LeerUsuario();

        if(Usuario::UsuarioYClaveExiste($listaUsuarios, $clave, $mail))
        {
            return "<b style='color: green;'>Usuario VERIFICADO</b>";
        }
        else if(Usuario::VerificarUsuario($listaUsuarios, $mail))
        {
            return "<b style='color: red;'>Error en los datos (clave invalida)</b>"; //FALLO LA CLAVE.
        }
        else{
            return "<b style='color: red;'>Usuario NO REGISTRADO (mail invalido)</b>";
        }
    }
}





?>