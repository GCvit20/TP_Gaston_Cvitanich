<?php

    require_once 'db/AccesoDatos.php';

    class Mesa
    {
        public $id;
        public $codigoMesa; //Unico 5 caracteres
        public $estado;

        public function crearMesa()
        {
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO mesa (codigoMesa, estado) VALUES (:codigoMesa, :estado)");
            $consulta->bindValue(':codigoMesa', $this->codigoMesa, PDO::PARAM_INT);
            $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
            $consulta->execute();

            return $objAccesoDatos->obtenerUltimoId();
        }

        public static function obtenerTodos()
        {
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT id, codigoMesa, estado FROM mesa WHERE fechaBaja IS NULL");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_CLASS, 'mesa');
        }

        public static function obtenerMesa($mesa)
        {
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT id,codigoMesa,estado FROM productos WHERE codigoMesa = :codigoMesa");
            $consulta->bindValue(':codigoMesa', $mesa, PDO::PARAM_INT);
            $consulta->execute();

            return $consulta->fetchObject('Mesa');
        }

        public function modificarMesa()
        {
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("UPDATE mesa SET estado = :estado WHERE codigoMesa = :codigoMesa");
            $consulta->bindValue(':codigoMesa', $this->codigoMesa, PDO::PARAM_STR);
            $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
            //$consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
            $consulta->execute();
        }

        public static function borrarMesa($mesa)
        {
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("UPDATE mesa SET fechaBaja = :fechaBaja WHERE codigoMesa = :codigoMesa");
            $fecha = new DateTime(date("d-m-Y"));
            $consulta->bindValue(':codigoMesa', $mesa, PDO::PARAM_INT);
            $consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d'));
            $consulta->execute();
        }
    }
   
?>