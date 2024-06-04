<?php

    require_once 'db/AccesoDatos.php';
    
    class Producto
    {
        public $id;
        public $tipoProductos;
        public $precio;
        public $tiempo; 

        public function crearProducto()
        {
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO productos (tipoProductos, precio, tiempo) VALUES (:tipoProductos, :precio, :tiempo)");
            $consulta->bindValue(':tipoProductos', $this->tipoProductos, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
            $consulta->bindValue(':tiempo', $this->tiempo, PDO::PARAM_STR);
            $consulta->execute();

            return $objAccesoDatos->obtenerUltimoId();
        }

        public static function obtenerTodos()
        {
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT id, tipoProductos, precio, tiempo FROM productos");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_CLASS, 'productos');
        }

        public static function obtenerProducto($producto)
        {
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT id,tipoProductos,precio,tiempo  FROM productos WHERE tipoProductos = :tipoProductos");
            $consulta->bindValue(':tipoProductos', $producto, PDO::PARAM_STR);
            $consulta->execute();

            return $consulta->fetchObject('Producto');
        }

        public static function modificarProducto($tipoProductos, $precio, $tiempo)
        {
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("UPDATE productos SET tipoProductos = :tipoProductos, precio = :precio, tiempo = :tiempo WHERE id = :id");
            $consulta->bindValue(':tipoProductos', $tipoProductos, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $precio, PDO::PARAM_INT);
            $consulta->bindValue(':tiempo', $tiempo, PDO::PARAM_STR);
            //$consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
            $consulta->execute();
        }

        public static function borrarProducto($producto)
        {
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("UPDATE productos SET fechaBaja = :fechaBaja WHERE id = :id");
            $fecha = new DateTime(date("d-m-Y"));
            $consulta->bindValue(':id', $producto, PDO::PARAM_INT);
            $consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d H:i:s'));
            $consulta->execute();
        }
    }

?>