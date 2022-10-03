<?php

/*
Alumno: Zafferano Gonzalo

Aplicación No 26 (RealizarVenta)
Archivo: RealizarVenta.php
método:POST

Recibe los datos del producto(código de barra), del usuario (el id )y la cantidad de ítems,
por POST .
Verificar que el usuario y el producto exista y tenga stock.
crea un ID autoincremental(emulado, puede ser un random de 1 a 10.000).
carga los datos necesarios para guardar la venta en un nuevo renglón.
Retorna un :
“venta realizada”Se hizo una venta
“no se pudo hacer“si no se pudo hacer
Hacer los métodos necesaris en las clases
*/

include_once "altaProducto.php";
include_once "registro.php";

if(isset($_POST["code"]) && isset($_POST["userId"]) && isset($_POST["count"]))
{
    $code = $_POST["code"];
    $count = $_POST["count"];
    $userId = $_POST["userId"];

    $user = Usuario::UserExists($userId);
    $product = Product::ProductExist($code);

    //var_dump($user);
    //var_dump($product);

    if(isset($user) && isset($product) && $product->ProductStock() > $count)
    {
        $sale = new venta($userId, $code, $count);
        if(venta::saveSale($sale))
        {
            echo "Venta exitosa!";
        }
        else{
            echo "No se ha podido generar la venta";
        }
    }
    else{
        echo "Usuario o producto no existe (o no hay stock)";
    }
}

class venta{
    private $productCode;
    private $userId;
    private $count;
    private $id;

    public function __construct($userId, $productCode, $count)
    {
        $this->id = random_int(1,10000);
        $this->userId = $userId;
        $this->productCode = $productCode;
        $this->count = $count;
    }

    public static function GetSaleCSV($sale)
    {
        //var_dump($sale);
        return $sale->userId .",". $sale->productCode .",". $sale->count .",". $sale->id . PHP_EOL;
    }

    public static function saveSale($sale)
    {
        try
        {
            $file = fopen("sales.csv", "a+");

            $data = venta::GetSaleCSV($sale);

            fputs($file, $data);      

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
        echo "<br>No se pudo guardar la venta.<br>";
        return false;
    }
}

?>