<?php


/*
ALUMNO: ZAFFERANO GONZALO

Aplicación No 28 ( Listado BD)
Archivo: listado.php
método:GET
Recibe qué listado va a retornar(ej:usuarios,productos,ventas)
cada objeto o clase tendrán los métodos para responder a la petición
devolviendo un listado <ul> o tabla de html <table>

*/

//http://localhost:8080/PHP/Clase06/Ejercicio28/listado.php?listado=ventas
//http://localhost:8080/PHP/Clase06/Ejercicio28/listado.php?listado=productos
//http://localhost:8080/PHP/Clase06/Ejercicio28/listado.php?listado=usuarios


function Iniciar()
{
    if(isset($_GET["listado"]))
    {
        switch($_GET["listado"])
        {
            case "usuarios":
                echo Usuarios::TraerTodosLosUsuarios();
                break;
            case "productos":
                echo Productos::TraerTodosLosProductos();
                break;
            case "ventas":
                echo Ventas::TraerTodasLasVentas();
                break;
        }
    }

}



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
}


class Productos{
    public $id;
    public $nombre;
    public $codigo_de_barra;
    public $tipo;
    public $stock;
    public $precio; 
    public $fecha_de_creacion;
    public $fecha_de_modificacion;


    function __construct($id = null, $nombre = null, $codigo_de_barra = null, $tipo = null, $stock = null, $precio = null, $fecha_de_creacion = null, $fecha_de_modificacion = null)
    {
        if(isset($id) &&
            isset($nombre) &&
            isset($codigo_de_barra) &&
            isset($tipo) &&
            isset($stock) &&
            isset($precio) &&
            isset($fecha_de_creacion) &&
            isset($fecha_de_modificacion))
            {
                $this->id = $id;
                $this->nombre = $nombre;
                $this->codigo_de_barra = $codigo_de_barra;
                $this->tipo = $tipo;
                $this->stock = $stock;
                $this->precio = $precio;
                $this->fecha_de_creacion = $fecha_de_creacion;
                $this->fecha_de_modificacion = $fecha_de_modificacion;
            }
    }

    public static function MostrarProducto($producto)
    {
        return "$producto->id, $producto->nombre, $producto->codigo_de_barra, $producto->tipo, $producto->stock, $producto->precio, $producto->fecha_de_creacion, $producto->fecha_de_modificacion";
    }

    public static function TraerTodosLosProductos()
	{
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select * from productos");
        $consulta->execute();			
        $listaProductos = $consulta->fetchAll(PDO::FETCH_CLASS, "Productos");	
        
        $mensaje = "<ul>";

        foreach($listaProductos as $producto)
        {
            $mensaje .= "<li>";

            $mensaje .= self::MostrarProducto($producto);

            $mensaje .= "</li>";
        }
        $mensaje .= "</ul>";

        return $mensaje;
	}
}

class Ventas{

    public $id;
    public $id_producto;
    public $id_usuario;
    public $cantidad;
    public $fecha_venta; 
    
    function __construct($id = null, $id_producto = null, $id_usuario = null, $cantidad = null, $fecha_venta = null)
    {
        if(isset($id) &&
            isset($id_producto) &&
            isset($id_usuario) &&
            isset($cantidad) &&
            isset($fecha_venta))
        {
            $this->id = $id;
            $this->id_producto = $id_producto;
            $this->id_usuario = $id_usuario;
            $this->cantidad = $cantidad;
            $this->fecha_venta = $fecha_venta;
        }
    }
    
    public static function MostrarVenta($venta)
    {
        return "$venta->id, $venta->id_producto, $venta->id_usuario, $venta->cantidad, $venta->fecha_venta";
    }

    public static function TraerTodasLasVentas()
	{
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select * from ventas");
        $consulta->execute();			
        $listaVentas = $consulta->fetchAll(PDO::FETCH_CLASS, "Ventas");	
        
        $mensaje = "<ul>";

        if(isset($listaVentas))
        {
            foreach($listaVentas as $venta)
            {
                //var_dump($venta);
                $mensaje .= "<li>";

                $mensaje .= self::MostrarVenta($venta);

                $mensaje .= "</li>";
            }
        }
        $mensaje .= "</ul>";

        return $mensaje;
	}
}









?>