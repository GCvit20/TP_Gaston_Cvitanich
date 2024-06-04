<?php

    require_once 'db/AccesoDatos.php';

    class Pedido
    {
        public $id;
        public $codigoPedido; //alfanumerico 5 caracteres
        public $estado;
        public $tiempo;
        public $precioFinal;
        public $foto;
        public $nombreCliente;

        public function crearPedido()
        {
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO mesa (codigoPedido, estado, tiempo, precioFinal, foto, nombreCliente) VALUES (:codigoPedido, :estado, :tiempo, :precioFinal, :foto, :nombreCliente)");
            $consulta->bindValue(':codigoPedido', $this->codigoPedido, PDO::PARAM_INT);
            $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
            $consulta->bindValue(':tiempo', $this->tiempo, PDO::PARAM_STR);
            $consulta->bindValue(':precioFinal', $this->precioFinal, PDO::PARAM_INT);
            $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR); //chequear
            $consulta->bindValue(':nombreCliente', $this->nombreCliente, PDO::PARAM_STR);
            $consulta->execute();

            return $objAccesoDatos->obtenerUltimoId();
        }

        public static function obtenerTodos()
        {
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT id,estado,tiempo,codigoPedido,precioFinal,foto,nombreCliente FROM pedido");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_CLASS, 'pedido');
        }

        public static function obtenerPedido($pedido)
        {
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT id,estado,tiempo,codigoPedido,precioFinal,foto,nombreCliente FROM pedido WHERE codigoPedido = :codigoPedido");
            $consulta->bindValue(':codigoPedido', $pedido, PDO::PARAM_INT);
            $consulta->execute();

            return $consulta->fetchObject('Pedido');
        }

        public static function modificarPedido($codigoPedido, $estado, $tiempo, $precioFinal, $foto, $nombreCliente)
        {
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("UPDATE mesa SET codigoPedido = :codigoPedido, estado = :estado, tiempo = :tiempo, precioFinal = :precioFinal, foto = :foto, nombreCliente = :nombreCliente  WHERE id = :id");
            $consulta->bindValue(':estado', $estado, PDO::PARAM_STR);
            $consulta->bindValue(':tiempo', $tiempo, PDO::PARAM_STR);
            $consulta->bindValue(':codigoPedido', $codigoPedido, PDO::PARAM_INT);
            $consulta->bindValue(':precioFinal', $precioFinal, PDO::PARAM_INT);
            $consulta->bindValue(':foto', $foto, PDO::PARAM_STR); //chequear
            $consulta->bindValue(':nombreCliente', $nombreCliente, PDO::PARAM_STR);
            //$consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
            $consulta->execute();
        }

        public static function borrarPedido($pedido)
        {
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("UPDATE mesa SET fechaBaja = :fechaBaja WHERE id = :id");
            $fecha = new DateTime(date("d-m-Y"));
            $consulta->bindValue(':id', $pedido, PDO::PARAM_INT);
            $consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d H:i:s'));
            $consulta->execute();
        }
    }

?>