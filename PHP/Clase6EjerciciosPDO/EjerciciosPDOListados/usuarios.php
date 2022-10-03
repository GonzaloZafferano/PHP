<?php

//ALUMNO: ZAFFERANO GONZALO

class Usuarios
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
    

    public static function MostrarUsuario($usuario)
    {
        return "$usuario->id, $usuario->nombre, $usuario->apellido, $usuario->mail, $usuario->clave, $usuario->localidad, $usuario->fecha_de_registro";
    }

    public static function TraerTodosLosUsuarios()
	{        
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select * from usuarios");
        $consulta->execute();			
        $listaUsuarios = $consulta->fetchAll(PDO::FETCH_CLASS, "Usuarios");	
        
        $mensaje = "<ul>";
        
        foreach($listaUsuarios as $usuario)
        {
            $mensaje .= "<li>";

            $mensaje .= self::MostrarUsuario($usuario);

            $mensaje .= "</li>";
        }
        $mensaje .= "</ul>";

        return $mensaje;
	}

    public static function OrdenarUsuarios($ascendente)
    {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 

        if($ascendente)
        {
            $consulta =$objetoAccesoDato->RetornarConsulta("select * from usuarios order by usuarios.nombre");

        }
        else{
            $consulta =$objetoAccesoDato->RetornarConsulta("select * from usuarios order by usuarios.nombre desc");
        }

        $consulta->execute();

        $listaUsuarios = $consulta->fetchAll(PDO::FETCH_CLASS, "Usuarios");	
        
        $mensaje = "<ul>";
        
        foreach($listaUsuarios as $usuario)
        {
            $mensaje .= "<li>";

            $mensaje .= self::MostrarUsuario($usuario);

            $mensaje .= "</li>";
        }
        $mensaje .= "</ul>";

        echo $mensaje;
    }

    public static function TraerTodosLosUsuariosFiltrando($filtro)
	{        
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select * from usuarios where nombre like CONCAT('%', :filtro, '%') or apellido like CONCAT('%', :filtro2, '%')");
        $consulta->bindValue(':filtro', $filtro, PDO::PARAM_STR);        
        $consulta->bindValue(':filtro2', $filtro, PDO::PARAM_STR);        
        $consulta->execute();			
        
        $listaUsuarios = $consulta->fetchAll(PDO::FETCH_CLASS, "Usuarios");	
        
        $mensaje = "<ul>";
        
        foreach($listaUsuarios as $usuario)
        {
            $mensaje .= "<li>";

            $mensaje .= self::MostrarUsuario($usuario);

            $mensaje .= "</li>";
        }

        $mensaje .= "</ul>";

        echo $mensaje;
	}
}



?>