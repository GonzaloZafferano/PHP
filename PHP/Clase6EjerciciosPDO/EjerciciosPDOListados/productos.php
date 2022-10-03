<?php

//ALUMNO: ZAFFERANO GONZALO

include_once("./AccesoADatos.php");

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

    public static function OrdenarProductos($ascendente)
    {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 

        if($ascendente)
        {
            $consulta =$objetoAccesoDato->RetornarConsulta("select * from productos order by productos.nombre");

        }
        else{
            $consulta =$objetoAccesoDato->RetornarConsulta("select * from productos order by productos.nombre desc");
        }

        $consulta->execute();
        			
        $listaProductos = $consulta->fetchAll(PDO::FETCH_CLASS, "Productos");	
        
        $mensaje = "<ul>";
        
        foreach($listaProductos as $productos)
        {
            $mensaje .= "<li>";

            $mensaje .= self::MostrarProducto($productos);

            $mensaje .= "</li>";
        }
        $mensaje .= "</ul>";

        echo $mensaje;
    }



}

?>