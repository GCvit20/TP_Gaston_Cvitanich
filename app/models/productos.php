<?php

    require_once 'db/AccesoDatos.php';
    
    class Producto
    {
        public $id;
        public $nombre; //agregar
        public $sector;
        public $precio;
        public $tiempo; 

        public function crearProducto()
        {
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO productos (nombre,sector, precio, tiempo) VALUES (:nombre, :sector, :precio, :tiempo)");
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':sector', $this->sector, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
            $consulta->bindValue(':tiempo', $this->tiempo, PDO::PARAM_STR);
            $consulta->execute();

            return $objAccesoDatos->obtenerUltimoId();
        }

        public static function obtenerTodos()
        {
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT id, nombre, sector, precio, tiempo FROM productos");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_CLASS, 'Producto');
        }

        public static function obtenerProducto($producto)
        {
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT id,nombre,sector,precio,tiempo  FROM productos WHERE id = :id");
            $consulta->bindValue(':id', $producto, PDO::PARAM_STR);
            $consulta->execute();

            return $consulta->fetchObject('Producto');
        }

        public function modificarProducto()
        {
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("UPDATE productos SET nombre = :nombre, sector = :sector, precio = :precio, tiempo = :tiempo WHERE id = :id");
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':sector', $this->sector, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
            $consulta->bindValue(':tiempo', $this->tiempo, PDO::PARAM_STR);
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