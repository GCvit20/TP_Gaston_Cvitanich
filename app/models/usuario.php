<?php

require_once 'db/AccesoDatos.php';

class Usuario
{
    public $id;
    public $nombreUsuario;
    public $clave;
    public $ocupacion;
    public $fechaBaja;

    public function crearUsuario()
    {
        
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO usuario (nombreUsuario, clave, ocupacion) VALUES (:nombreUsuario, :clave, :ocupacion)");
        $claveHash = password_hash($this->clave, PASSWORD_DEFAULT);
        $consulta->bindValue(':nombreUsuario', $this->nombreUsuario, PDO::PARAM_STR);
        $consulta->bindValue(':ocupacion', $this->ocupacion, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $claveHash);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, nombreUsuario, ocupacion FROM usuario WHERE fechaBaja IS NULL");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
    }

    public static function obtenerUsuario($usuario)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, nombreUsuario, ocupacion FROM usuario WHERE nombreUsuario = :nombreUsuario");
        $consulta->bindValue(':nombreUsuario', $usuario, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Usuario');
    }

    public static function obtenerClave($usuario)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, nombreUsuario, clave, ocupacion FROM usuario WHERE nombreUsuario = :nombreUsuario");
        $consulta->bindValue(':clave', $usuario, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Usuario');
    }

    public function modificarUsuario()
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE usuario SET nombreUsuario = :nombreUsuario, clave = :clave, ocupacion = :ocupacion WHERE id = :id");
        $consulta->bindValue(':nombreUsuario', $this->nombreUsuario, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(':ocupacion', $this->ocupacion, PDO::PARAM_STR);
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->execute();
    }

    public static function borrarUsuario($usuario)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE usuario SET fechaBaja = :fechaBaja WHERE id = :id");
        $fecha = new DateTime(date("d-m-Y"));
        $consulta->bindValue(':id', $usuario, PDO::PARAM_INT);
        $consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d'));
        $consulta->execute();
    }

    public static function ObtenerUsuarioPorNombreUsuario($nombreUsuario)
    {
        $objDataAccess = AccesoDatos::obtenerInstancia();
        $query = $objDataAccess->prepararConsulta("SELECT * FROM usuario WHERE nombreUsuario = :nombreUsuario");
        $query->bindValue(':nombreUsuario', $nombreUsuario, PDO::PARAM_STR);
        $query->execute();
        $usuario = $query->fetchObject('Usuario');

        if (!$usuario) {
            return null;
        }
        
        return $usuario;
    }
}