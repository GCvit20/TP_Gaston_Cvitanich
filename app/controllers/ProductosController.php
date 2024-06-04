<?php

    require_once 'models/productos.php';

    class ProductosController 
    {

        public function insertarProducto($tipoProductos, $precio, $tiempo) 
        {
            $producto = new Producto(); //instancia el producto

            //asigna los campos
            $producto->tipoProductos = $tipoProductos; 
            $producto->precio = $precio;
            $producto->tiempo = $tiempo;

            return $producto->crearProducto();
        }

        public function modificarProducto($tipoProductos, $precio, $tiempo) 
        {
            $producto = new Producto();
            $producto->tipoProductos = $tipoProductos; 
            $producto->precio = $precio;
            $producto->tiempo = $tiempo;
            //return $producto->modificarProducto();
        }

        public function borrarProducto($id) 
        {
            $producto = new Producto();
            $producto->id = $id;
            return $producto->borrarProducto($id);
        }

        public function listarProductos() 
        {
            return Producto::obtenerTodos();
        }

    }

?>