<?php


/*
Alumno: Zafferano Gonzalo

http://localhost:8080/PHP/Clase04/Ejercicio25/altaProducto.php

Aplicación No 25 ( AltaProducto)
file: altaProducto.php
método:POST
Recibe los datos del producto(código de barra (6 sifras ),name ,type, stock, price )por POST,
crea un ID autoincremental(emulado, puede ser un random de 1 a 10.000). crear un
objeto y utilizar sus métodos para poder verificar si es un producto existente, si ya existe
el producto se le suma el stock , de lo contrario se agrega al documento en un nuevo
renglón
Retorna un :
“Ingresado” si es un producto nuevo
“Actualizado” si ya existía y se actualiza el stock.
“no se pudo hacer“si no se pudo hacer
Hacer los métodos necesarios en la clase
*/

use Product as GlobalProduct;

if(isset($_POST["code"]) &&
    isset($_POST["name"]) &&
    isset($_POST["type"]) &&
    isset($_POST["stock"]) &&
    isset($_POST["price"]))
{
    $code = $_POST["code"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $type = $_POST["type"];
    $aux = null;

    $product = Product::ProductExist($code);

    if(isset($product))
    {
        $product->AddStock($stock);
    }
    else{
        $aux = new Product($name, $type, $stock, $price, $code);
    }

    //var_dump($aux);
    Product::SaveOrUpdate($aux);
}

class Product{
    private $name;
    private $code;
    private $type;
    private $stock;
    private $price;
    private $id;
    private static $products;

    public function __construct($name, $type, $stock, $price, $code)
    {
        $this->code = $code;
        $this->name = $name;
        $this->type = $type;
        $this->stock = $stock;
        $this->price = $price;
        $this->id = random_int(1,10000);
    }

    public function AddStock($stock)
    {
        $this->stock += $stock;
    }

    public function ProductStock()
    {
        return $this->stock;
    }

    public static function ProductExist($code)
    {
        Product::$products = Product::GetProductsFromFile();

        foreach(Product::$products as $product)
        {
            if($product->code == $code)
            {
                return $product;
            }
        }
        return null;
    }

    public static function SaveOrUpdate($product = null)
    {        
        $message = "<br>Modificacion exitosa!<br>";

        if(isset($product))
        {
            array_push(Product::$products, $product); 
            $message = "<br>Alta exitosa<br>";           
           // var_dump(Product::$products);
        }

        $file = null;

        try
        {
            $file = fopen("products.csv", "w");

            //var_dump(Product::$products);
            foreach(Product::$products as $productItem)
            {
                $data = Product::GetCSVStringFromProduct($productItem);

                //var_dump(Product::$products);
                fputs($file, $data);               
            }
            echo $message;

            return true;
        }
        catch(Exception $ex)
        {
            echo "Ha ocurrido un error: " . $ex->getMessage();
        }
        finally
        {
            if(isset($file))
            {
                fclose($file);
            }
        }
        echo "<br>No se pudieron guardar los cambios.<br>";
        return false;
    }


    public static function GetCSVStringFromProduct($product)
    {
        return $product->id . "," . $product->name . "," . $product->stock . "," . $product->type . "," . $product->price . "," . $product->code .  PHP_EOL;
    }

    public static function GetProductsFromFile()
    {
        $file = null;
        $products = array();

        try{     
            //CVS          
            if(file_exists("products.csv"))
            {               
                $file = fopen("products.csv","r");

                while(!feof($file))
                {
                    $linea = fgets($file);

                    if(isset($linea) && !empty($linea))
                    {
                        //ELIMINO EL SALTO DE LINEA.
                        //1) Que borrar
                        //2) Con que reemplazar
                        //3) En que elemento reemplazar.
                        $linea = str_replace(PHP_EOL, "", $linea);

                        //HACE UN SPLIT A PARTIR DE COMAS, Y RETORNA UN ARRAY.
                        $datos = explode(",", $linea);

                        //var_dump($datos);

                        $product = new Product($datos[1], $datos[3], $datos[2], $datos[4], $datos[5]);
                        $product->id = $datos[0];

                        array_push($products, $product);
                    }
                }            
            } 
        }
        catch(Exception $ex)
        {
            echo "Ha ocurrido un error: " . $ex->getMessage(); 
        }
        finally
        {
            if(isset($file))
            {
                fclose($file);
            }
        }
        return $products;
    }
}
?>