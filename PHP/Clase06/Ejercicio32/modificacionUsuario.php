<?php

/*
ALUMNO: ZAFFERANO GONZALO

Aplicación No 32(Modificacion BD)
Archivo: ModificacionUsuario.php
método:POST
Recibe los datos del usuario(nombre, clavenueva, clavevieja,mail )por POST ,
crear un objeto y utilizar sus métodos para poder hacer la modificación,
guardando los datos la base de datos
retorna si se pudo agregar o no.
Solo pueden cambiar la clave


*/


function Iniciar()
{    
    if(isset($_POST["nombre"]) &&
        isset($_POST["clavenueva"]) &&
        isset($_POST["clavevieja"]) &&
        isset($_POST["mail"]))
    {
        $nombre = $_POST["nombre"];
        $claveVieja = $_POST["clavevieja"];
        $claveNueva = $_POST["clavenueva"];
        $mail = $_POST["mail"];
    
        $usuario = Usuario::ExisteUsuario($nombre, $mail, $claveVieja);
    
        if(isset($usuario))
        {
            if(Usuario::ModificarUsuario($usuario->id, $claveNueva))
            {
                echo "Contraseña cambiada con exito!";
            }
        }
        else{
            echo "No existe el usuario";
        }
    
    }
}
    

class Usuario
{
    public $nombre;
    public $apellido;
    public $clave;
    public $mail;
    public $localidad; 
    public $fecha_de_registro;
    public $id;
    
    public function __construct($id = NULL, $nombre = NULL, $apellido = NULL, $clave = NULL, $mail = NULL, $fecha_de_registro = NULL, $localidad = NULL)
    {
        if(isset($id) &&
        isset($nombre) &&
        isset($apellido) &&
        isset($clave) &&
        isset($mail) &&
        isset($fecha_de_creacion) &&
        isset($localidad))
        {
            $this->id = $id;
            $this->fecha_de_registro = $fecha_de_registro;
            $this->nombre = $nombre;
            $this->apellido = $apellido;
            $this->clave = $clave;
            $this->mail = $mail;
            $this->localidad = $localidad;
        }      
    }
    
    public static function TraerTodosLosUsuarios()
	{        
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select * from usuarios");
        $consulta->execute();			
        $listaUsuarios = $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");	
        
        return $listaUsuarios;
	}

    public static function ExisteUsuario($nombre, $mail, $clave)
    {
        //$listaUsuarios = Usuario::TraerTodosLosUsuarios();
        $usuarioDAO = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $usuarioDAO->RetornarConsulta("SELECT * FROM usuarios where nombre = :nombre and mail = :mail and clave = :clave");

        $consulta->bindValue(':nombre',$nombre, PDO::PARAM_STR);
        $consulta->bindValue(':clave',$clave, PDO::PARAM_INT);
        $consulta->bindValue(':mail',$mail, PDO::PARAM_STR);

        $consulta->execute();

        if($consulta->rowCount() == 1)
        { 
            $usuario= $consulta->fetchObject("Usuario");

            return $usuario;
        }
        return null;
    }

    public static function ModificarUsuario($id, $nuevaPassword)
    {
        try{
            $usuarioDAO = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $usuarioDAO->RetornarConsulta("UPDATE usuarios set clave = :clave WHERE id = :id");
    
            $consulta->bindValue(':id',$id, PDO::PARAM_INT);
            $consulta->bindValue(':clave',$nuevaPassword, PDO::PARAM_INT);
    
            $consulta->execute();

            return true;
        }
        catch(Exception $ex)
        {
            return false;
        }
    }
}







?>