<?php

    require_once 'db/AccesoDatos.php';

    class Pedido
    {
        public $id;
        public $idMesa;
        public $codigoPedido; //alfanumerico 5 caracteres
        public $estado;
        public $tiempoEstimado;
        public $precioFinal;
        public $foto;
        public $nombreCliente;

        public function crearPedido()
        {
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO pedido (idMesa, codigoPedido, estado, tiempoEstimado, precioFinal, foto, nombreCliente) VALUES (:idMesa, :codigoPedido, :estado, :tiempoEstimado, :tiempo, :precioFinal, :foto, :nombreCliente)");
            $consulta->bindValue(':idMesa', $this->idMesa, PDO::PARAM_INT);
            $consulta->bindValue(':codigoPedido', $this->codigoPedido, PDO::PARAM_INT);
            $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
            $consulta->bindValue(':tiempoEstimado', $this->estado, PDO::PARAM_INT);
            $consulta->bindValue(':precioFinal', $this->precioFinal, PDO::PARAM_INT);
            $consulta->bindValue(':foto', $this->foto);
            $consulta->bindValue(':nombreCliente', $this->nombreCliente, PDO::PARAM_STR);
            $consulta->execute();

            return $objAccesoDatos->obtenerUltimoId();
        }

        public static function obtenerTodos()
        {
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT id,idMesa,codigoPedido,estado,tiempoEstimado,precioFinal,foto,nombreCliente FROM pedido WHERE fechaBaja IS NULL");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
        }

        public static function obtenerPedido($pedido)
        {
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT id,idMesa,codigoPedido,estado,tiempoEstimado,precioFinal,foto,nombreCliente FROM pedido WHERE codigoPedido = :codigoPedido");
            $consulta->bindValue(':codigoPedido', $pedido, PDO::PARAM_INT);
            $consulta->execute();

            return $consulta->fetchObject('Pedido');
        }

        public function modificarPedido()
        {
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("UPDATE pedido SET estado = :estado, tiempoEstimado = :tiempoEstimado, precioFinal = :precioFinal, foto = :foto, nombreCliente = :nombreCliente  WHERE codigoPedido = :codigoPedido");
            $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
            $consulta->bindValue(':tiempoEstimado', $this->estado, PDO::PARAM_INT);
            $consulta->bindValue(':precioFinal', $this->precioFinal, PDO::PARAM_INT);
            $consulta->bindValue(':foto', $this->foto);
            $consulta->bindValue(':nombreCliente', $this->nombreCliente, PDO::PARAM_STR);
            $consulta->bindValue(':codigoPedido', $this->codigoPedido, PDO::PARAM_STR);

            $consulta->execute();
        }

        public static function borrarPedido($pedido)
        {
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("UPDATE pedido SET fechaBaja = :fechaBaja WHERE codigoPedido = :codigoPedido");
            $fecha = new DateTime(date("d-m-Y"));
            $consulta->bindValue(':codigoPedido', $pedido, PDO::PARAM_INT);
            $consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d'));
            $consulta->execute();
        }
    }

?>