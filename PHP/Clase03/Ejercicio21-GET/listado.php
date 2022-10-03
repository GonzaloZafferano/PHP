<?php

/*
Alumno: Zafferano Gonzalo

Aplicación No 21 ( Listado CSV y array de usuarios)
Archivo: listado.php
método:GET
Recibe qué listado va a retornar(ej:usuarios,productos,vehículos,...etc),por ahora solo tenemos
usuarios).

En el caso de usuarios carga los datos del archivo usuarios.csv.
se deben cargar los datos en un array de usuarios.
Retorna los datos que contiene ese array en una lista
<ul>
<li>Coffee</li>
<li>Tea</li>
<li>Milk</li>
</ul>
Hacer los métodos necesarios en la clase usuario
*/

$listaUsuarios = Usuario::LeerUsuario();

$cadena = Usuario::EnlistarUsuarios($listaUsuarios);

echo $cadena;

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
}



?>