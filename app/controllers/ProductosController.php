<?php

    require_once 'models/productos.php';
    require_once './interfaces/IApiUsable.php';

    class ProductosController extends Producto implements IApiUsable
    {

        public function insertar($request, $response, $args) 
        {
            $parametros = $request->getParsedBody();

            $nombre = $parametros['nombre'];
            $sector = $parametros['sector'];
            $precio = $parametros['precio'];
            $tiempo = $parametros['tiempo'];

            $producto = new Producto();
            $producto->nombre = $nombre; 
            $producto->sector = $sector; 
            $producto->precio = $precio;
            $producto->tiempo = $tiempo;
            $producto->crearProducto();

            $payload = json_encode(array("mensaje" => "Producto creado con exito"));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function modificar($request, $response, $args) 
        {
            $parametros = $request->getParsedBody();

            $nombre = $parametros['nombre'];
            $sector = $parametros['sector'];
            $precio = $parametros['precio'];
            $tiempo = $parametros['tiempo'];

            $producto = new Producto();
            $producto->nombre = $nombre; 
            $producto->sector = $sector; 
            $producto->precio = $precio;
            $producto->tiempo = $tiempo;
            $producto->modificarProducto();

            $payload = json_encode(array("mensaje" => "Producto modificado con exito"));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function borrar($request, $response, $args) 
        {
            $parametros = $request->getParsedBody();

            $pedidoId = $parametros['id'];
            Producto::borrarProducto($pedidoId);

            $payload = json_encode(array("mensaje" => "Pedido borrado con exito"));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function listarTodos($request, $response, $args) 
        {
            $lista = Producto::obtenerTodos();
            $payload = json_encode(array("listaProductos" => $lista));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

    }

?>