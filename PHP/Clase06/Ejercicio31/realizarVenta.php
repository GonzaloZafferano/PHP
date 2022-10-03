<?php

/*
ALUMNO: ZAFFERANO GONZALO

Aplicación No 31 (RealizarVenta BD )
Archivo: RealizarVenta.php
método:POST
Recibe los datos del producto(código de barra), del usuario (el id )y la cantidad de ítems ,por
POST .
Verificar que el usuario y el producto exista y tenga stock.
Retorna un :
“venta realizada”Se hizo una venta
“no se pudo hacer“si no se pudo hacer
Hacer los métodos necesarios en las clases
*/

function Iniciar()
{
    if(isset($_POST["codigo"]) &&
        isset($_POST["id"]) &&
        isset($_POST["cantidad"]))
    {
        $codigo = $_POST["codigo"];
        $id_usuario = $_POST["id"];
        $cantidad = $_POST["cantidad"];
    
        $producto = Product::ExisteProductoEnBBDD($codigo);
    
        if(isset($producto) && Usuario::ExisteUsuario($id_usuario))
        {
            if($producto->ObtenerStock() >= $cantidad && Ventas::GenerarVenta($id_usuario, $codigo, $cantidad))
            {
                echo "<br>Venta realizada!</br>";
            }
            else{
                echo "<br>No se ha podido realizar la venta.</br>";
            }
        }
        else{
            echo "<br>Usuario o producto no existe.</br>";
        }
    }
}

class Product{
    private $id;
    private $nombre;
    private $codigo_de_barra;
    private $tipo;
    private $stock;
    private $precio;

    public function __construct($id = null, $nombre = null, $tipo = null, $stock = null, $precio = null, $codigo_de_barra = null)
    {
        if(isset($id) &&
        isset($nombre) &&
        isset($codigo_de_barra) &&
        isset($tipo) &&
        isset($stock) &&
        isset($precio))
        {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->codigo_de_barra = $codigo_de_barra;
            $this->stock = $stock;
            $this->precio = $precio;
            $this->tipo = $tipo;
        }
    }

    public function ObtenerStock()
    {
        return $this->stock;
    }

    public static function ExisteProductoEnBBDD($codigo_de_barra)
    {
        $listaDeProductos = Product::ObtenerProductosDeBBDD();

        foreach($listaDeProductos as $product)
        {
            if($product->codigo_de_barra == $codigo_de_barra)
            {
                return $product;
            }
        }
        return null;
    }

    public static function ObtenerProductosDeBBDD()
    {
       $productoDAO = AccesoDatos::dameUnObjetoAcceso();
       $consulta = $productoDAO->RetornarConsulta("select * from productos");
       $consulta->execute();

       $listaProductos = $consulta->fetchAll(PDO::FETCH_CLASS, "Product");
        
       return $listaProductos;
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

    public static function ExisteUsuario($id)
    {
        $listaUsuarios = Usuario::TraerTodosLosUsuarios();

        foreach($listaUsuarios as $user)
        {
            if($user->id == $id)
            {
                return true;
            }
        }
        return false;
    }
}

class Ventas{

    public $id_producto;
    public $id_usuario;
    public $cantidad;
    public $fecha_venta; 
    
    function __construct($id_producto = null, $id_usuario = null, $cantidad = null, $fecha_venta = null)
    {
        if(isset($id_producto) &&
            isset($id_usuario) &&
            isset($cantidad) &&
            isset($fecha_venta))
        {
            $this->id_producto = $id_producto;
            $this->id_usuario = $id_usuario;
            $this->cantidad = $cantidad;
            $this->fecha_venta = $fecha_venta;
        }
    }
    
    public static function GenerarVenta($id, $id_producto, $cantidad)
	{
        try{
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO ventas
            (id_producto, id_usuario, cantidad, fecha_venta) values 
            (:id, :id_producto, :cantidad, :fecha_venta)");
    
            $consulta->bindValue(':id',$id, PDO::PARAM_INT);
            $consulta->bindValue(':id_producto',$id_producto, PDO::PARAM_INT);
            $consulta->bindValue(':cantidad',$cantidad, PDO::PARAM_INT);
            $consulta->bindValue(':fecha_venta',date("Y/m/d"), PDO::PARAM_STR);
    
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