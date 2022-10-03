<?php

/*
ALUMNO: ZAFFERANO GONZALO

Aplicación No 29( Login con bd)
Archivo: Login.php
método:POST
Recibe los datos del usuario(clave,mail )por POST ,
crear un objeto y utilizar sus métodos para poder verificar si es un usuario registrado en la
base de datos,
Retorna un :
“Verificado” si el usuario existe y coincide la clave también.
“Error en los datos” si esta mal la clave.
“Usuario no registrado si no coincide el mail“
Hacer los métodos necesarios en la clase usuario.
*/

function Iniciar()
{
    if(isset($_POST["clave"]) && isset($_POST["mail"]))
    {
        $mail = $_POST["mail"];
        $clave = $_POST["clave"];
    
        echo Usuario::ValidarUsuario($clave, $mail);
    }
}

class Usuario
{
    public $clave;
    public $mail;

    public function __construct($clave = null, $mail = null)
    {
        if(isset($clave) && isset($mail))
        {
            $this->clave = $clave;
            $this->mail = $mail;
        }
    }

    public static function TraerUsuariosDeBBDD()
    {
        $objetoAccesoADatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoADatos->RetornarConsulta("SELECT clave, mail from Usuarios");
        $consulta->execute();

        $listaDeUsuarios = $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");

        return $listaDeUsuarios;
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
        $listaUsuarios = Usuario::TraerUsuariosDeBBDD();

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