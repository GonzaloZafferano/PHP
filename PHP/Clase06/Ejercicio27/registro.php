<?php

/*
ALUMNO: ZAFFERANO GONZALO

Aplicación No 27 (Registro BD)
Archivo: registro.php
método:POST
Recibe los datos del usuario( nombre,apellido, clave,mail,localidad )por POST ,
crear un objeto con la fecha de registro y utilizar sus métodos para poder hacer el alta,
guardando los datos la base de datos
retorna si se pudo agregar o no.
*/


function Iniciar()
{    
    if(isset($_POST["nombre"]) &&
        isset($_POST["apellido"]) &&
        isset($_POST["clave"]) &&
        isset($_POST["mail"]) &&
        isset($_POST["localidad"]))
    {
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $clave = $_POST["clave"];
        $mail = $_POST["mail"];
        $localidad = $_POST["localidad"];
    
        $usuario = new Usuario($nombre,$apellido, $clave, $mail, $localidad);
    
        Usuario::altaUsuarioEnBBDD($usuario);
    }
}


class Usuario{

    private $nombre;
    private$apellido;
    private $clave;
    private $mail;
    private $localidad; 
    private $fecha_registro;
    private $id;

    function __construct($nombre, $apellido, $clave, $mail, $localidad)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->clave = $clave;
        $this->mail = $mail;
        $this->localidad = $localidad;
        $this->fecha_registro = date("Y/m/d"); //2022/09/27
    }
    
    public static function altaUsuarioEnBBDD($usuario)
    {
        $userDAO = AccesoDatos::dameUnObjetoAcceso();

        $consultaSQL = $userDAO->RetornarConsulta("INSERT INTO usuarios (id, nombre, apellido, clave, mail, fecha_de_registro, localidad)
         VALUES (:id, :nombre, :apellido, :clave, :mail, :fecha_registro, :localidad)");

        $consultaSQL->bindValue(':id', 0, PDO::PARAM_INT);
        $consultaSQL->bindValue(':nombre', $usuario->nombre, PDO::PARAM_STR);
        $consultaSQL->bindValue(':apellido', $usuario->apellido, PDO::PARAM_STR);
        $consultaSQL->bindValue(':clave', $usuario->clave, PDO::PARAM_INT);
        $consultaSQL->bindValue(':mail', $usuario->mail, PDO::PARAM_STR);
        $consultaSQL->bindValue(':fecha_registro', $usuario->fecha_registro, PDO::PARAM_STR); //LA BASE ES DE TIPO STRING
        $consultaSQL->bindValue(':localidad', $usuario->localidad, PDO::PARAM_STR);

        $consultaSQL->execute();
        
        if($consultaSQL->rowCount() == 1)
        {
            //RETORNA EL ULTIMO ID INSERTADO RECIENTEMENTE, NO EL ULTIMO ID QUE EXISTE EN LA BBDD.
            echo "Alta exitosa. Ultimo ID insertado : " . $userDAO->RetornarUltimoIdInsertado();
        }
        else{
            echo "Ha ocurrido un error, no se pudo hacer el alta";
        }
    }
}

?>