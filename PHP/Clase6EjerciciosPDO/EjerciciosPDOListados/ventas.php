<?php

//ALUMNO: ZAFFERANO GONZALO

include_once("./AccesoADatos.php");

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


    public static function ObtenerComprasEntreDosCantidades($cantidad1, $cantidad2)
	{
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select * from ventas where ventas.cantidad BETWEEN :a and :b");

        $consulta->bindValue(':a',$cantidad1, PDO::PARAM_INT);
        $consulta->bindValue(':b',$cantidad2, PDO::PARAM_INT);

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

        echo $mensaje;
	}


    public static function MostrarPrimerosProductosEnviados($cantidad)
    {      
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
 
        $consulta =$objetoAccesoDato->RetornarConsulta("select * from ventas ORDER by ventas.fecha_venta asc LIMIT :cantidad");
        $consulta->bindValue(':cantidad',$cantidad, PDO::PARAM_INT);

        $consulta->execute();
        			
        $listaProductos = $consulta->fetchAll(PDO::FETCH_CLASS, "Ventas");	
        
        $mensaje = "<ul>";
        
        foreach($listaProductos as $productos)
        {
            $mensaje .= "<li>";

            $mensaje .= self::MostrarVenta($productos);

            $mensaje .= "</li>";
        }
        $mensaje .= "</ul>";

        echo $mensaje;
    }


    public static function MostrarCantidadProductosVendidosEntreDosFechas($fechaInicial, $fechaFinal)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
 
        $consulta =$objetoAccesoDato->RetornarConsulta("select SUM(ventas.cantidad) as cantidad from ventas where ventas.fecha_venta BETWEEN :f1 and :f2");
        $consulta->bindValue(':f1',$fechaInicial, PDO::PARAM_STR);
        $consulta->bindValue(':f2',$fechaFinal, PDO::PARAM_STR);

        $consulta->execute();
        			
        $cantidadVendida = $consulta->fetch(PDO::FETCH_OBJ);	
        //var_dump($cantidadVendida);   

        echo "Cantidad: " . $cantidadVendida->cantidad . "<br>";
    }



    public static function MostrarNombreUsuarioyProductoDeCadaVenta()
	{
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select usuarios.nombre as nombreUsuario, productos.nombre as nombreProducto,  ventas.id from ventas inner JOIN usuarios on usuarios.id = ventas.id_usuario INNER JOIN productos on ventas.id_producto = productos.id;");

        $consulta->execute();			
        $listaVentas = $consulta->fetchAll(PDO::FETCH_CLASS, "Ventas");	
        
        $mensaje = "<ul>";

        if(isset($listaVentas))
        {            
            foreach($listaVentas as $venta)
            {
                //var_dump($venta);
                $mensaje .= "<li>";

                $mensaje .= $venta->nombreUsuario . " - " . $venta->nombreProducto . " - " . $venta->id;

                $mensaje .= "</li>";
            }
        }
        $mensaje .= "</ul>";

        echo $mensaje;
	}

    public static function MostrarPrecioPorVenta()
    {       
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta(" select (ventas.cantidad * productos.precio) as cantidad from ventas INNER JOIN productos on ventas.id_producto = productos.id;");

        $consulta->execute();			
        $listaVentas = $consulta->fetchAll(PDO::FETCH_CLASS);	
        
        $mensaje = "<ul>";

        if(isset($listaVentas))
        {            
            foreach($listaVentas as $venta)
            {
                //var_dump($venta);
                $mensaje .= "<li>";

                $mensaje .= "Precio: $" . $venta->cantidad;

                $mensaje .= "</li>";
            }
        }
        $mensaje .= "</ul>";

        echo $mensaje;
    }

    public static function MostrarCantidadDeProductoVendidoPorUsuario($idusuario, $idproducto)
    {
             
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
 
        $consulta =$objetoAccesoDato->RetornarConsulta("select SUM(ventas.cantidad) as cantidad from ventas where ventas.id_usuario = :idusuario and ventas.id_producto = :idproducto");
        $consulta->bindValue(':idusuario',$idusuario, PDO::PARAM_INT);
        $consulta->bindValue(':idproducto',$idproducto, PDO::PARAM_INT);

        $consulta->execute();
        			
        $productosVendidos = $consulta->fetch(PDO::FETCH_OBJ);	
        
        echo "Se vendieron '" . $productosVendidos->cantidad . "' unidades del producto, por el usuario.<br>";
    }
    

    public static function ObtenerProductosVendidosPorUsuarioDeLocalidad($localidad)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
 
        $consulta =$objetoAccesoDato->RetornarConsulta("select productos.nombre, usuarios.localidad from ventas inner join productos on ventas.id_producto = productos.id inner join usuarios on ventas.id_usuario = usuarios.id where usuarios.localidad = :localidad;");
        $consulta->bindValue(':localidad',$localidad, PDO::PARAM_INT);

        $consulta->execute();
        			
        $listaVentas = $consulta->fetchAll(PDO::FETCH_OBJ);	
        
        $mensaje = "<ul>";

        if(isset($listaVentas))
        {            
            foreach($listaVentas as $venta)
            {
                //var_dump($venta);
                $mensaje .= "<li>";

                $mensaje .= "Productos: $" . $venta->nombre . ". Localidad de usuario: " . $venta->localidad . "<br>";

                $mensaje .= "</li>";
            }
        }
        $mensaje .= "</ul>";

        echo $mensaje;
    }

    public static function MostrarVentasEntreDosFechas($fechaInicial, $fechaFinal)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
 
        $consulta =$objetoAccesoDato->RetornarConsulta("select * from ventas where ventas.fecha_venta BETWEEN :f1 and :f2");
        $consulta->bindValue(':f1',$fechaInicial, PDO::PARAM_STR);
        $consulta->bindValue(':f2',$fechaFinal, PDO::PARAM_STR);

        $consulta->execute();
        
        $listaDeVentas = $consulta->fetchAll(PDO::FETCH_CLASS, "Ventas");	
        
        $mensaje = "<ul>";
        
        foreach($listaDeVentas as $ventas)
        {
            $mensaje .= "<li>";

            $mensaje .= self::MostrarVenta($ventas);

            $mensaje .= "</li>";
        }
        $mensaje .= "</ul>";

        echo $mensaje;
    }
}


?>