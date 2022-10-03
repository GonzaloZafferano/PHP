<?php

/*
ALUMNO: ZAFFERANO GONZALO

Aplicación No 30 ( AltaProducto BD)
Archivo: altaProducto.php
método:POST

Recibe los datos del producto(código de barra (6 cifras) ,nombre ,tipo, stock, precio) por POST,
carga la fecha de creación y crear un objeto ,se debe utilizar sus métodos para poder
verificar si es un producto existente,
si ya existe el producto se le suma el stock , de lo contrario se agrega .
Retorna un :
“Ingresado” si es un producto nuevo
“Actualizado” si ya existía y se actualiza el stock.
“no se pudo hacer“si no se pudo hacer
Hacer los métodos necesarios en la clase
*/

function Iniciar()
{
    if(isset($_POST["codigo_de_barra"]) &&
        isset($_POST["nombre"]) &&
        isset($_POST["tipo"]) &&
        isset($_POST["stock"]) &&
        isset($_POST["precio"]))
    {
        $codigo_de_barra = $_POST["codigo_de_barra"];
        $nombre = $_POST["nombre"];
        $precio = $_POST["precio"];
        $stock = $_POST["stock"];
        $tipo = $_POST["tipo"];
    
        $product = Product::ExisteProductoEnBBDD($codigo_de_barra);
        
        if(isset($product))
        {
            $product->AddStock($stock);
        }
        else{
            $product = new Product(0, $nombre, $tipo, $stock, $precio, $codigo_de_barra);
        }
    
        echo Product::SaveOrUpdate($product);
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

    public static function SaveOrUpdate($product)
    {        
        try{
            $message = "";
            $productoDAO = AccesoDatos::dameUnObjetoAcceso();
            
            if(isset($product) && $product->id == 0)
            {
                $consulta = $productoDAO->RetornarConsulta("insert into productos (codigo_de_barra, nombre, precio, tipo, stock, fecha_de_creacion, fecha_de_modificacion) values 
                (:codigo_de_barra, :nombre, :precio, :tipo, :stock, :fecha_de_creacion, :fecha_de_modificacion)");
			
                $consulta->bindValue(':codigo_de_barra',$product->codigo_de_barra, PDO::PARAM_INT);
				$consulta->bindValue(':nombre',$product->nombre, PDO::PARAM_STR);
				$consulta->bindValue(':tipo',$product->tipo, PDO::PARAM_STR);
				$consulta->bindValue(':precio',$product->precio, PDO::PARAM_INT);
				$consulta->bindValue(':stock',$product->stock, PDO::PARAM_INT);
				$consulta->bindValue(':fecha_de_creacion', date("Y/m/d"), PDO::PARAM_STR);
				$consulta->bindValue(':fecha_de_modificacion',date("Y/m/d"), PDO::PARAM_STR); 
                $consulta->execute();

                $message = "<br>Alta exitosa<br>";           
            }
            else{
                $consulta = $productoDAO->RetornarConsulta("UPDATE productos set stock = :stock, fecha_de_modificacion = :fecha_de_modificacion where id = :id");
				
                $consulta->bindValue(':id',$product->id, PDO::PARAM_INT);
				$consulta->bindValue(':stock',$product->stock, PDO::PARAM_INT);
				$consulta->bindValue(':fecha_de_modificacion',date("Y/m/d"), PDO::PARAM_STR);
                $consulta->execute();
              
                $message = "<br>Modificacion exitosa!<br>";
            }
        }
        catch(Exception $ex)
        {
            $message = "<br>No se pudieron guardar los cambios: " . $ex->getMessage() . "<br>";
        }
        return $message;
    }



    public function AddStock($stock)
    {
        $this->stock += $stock;
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









?>