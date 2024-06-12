<?php

    require_once 'models/productos.php';
    require_once './interfaces/IApiUsable.php';

    class ProductosController extends Producto implements IApiUsable
    {

        public function insertar($request, $response, $args) 
        {
            $parametros = $request->getParsedBody();

            if(isset($parametros['nombre']) && isset($parametros['sector']) && isset($parametros['precio']) && isset($parametros['tiempo']))
            {
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
            }
            else
            {
                // Si falta alguno de los parámetros, generar un mensaje de error
                $payload = json_encode(array("mensaje" => "Faltan parámetros obligatorios"));
                $response = $response->withStatus(400); // Código de estado 400 para "Bad Request"
            }

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function modificar($request, $response, $args) 
        {
            $parametros = $request->getParsedBody();

            if(isset($parametros['id']) && isset($parametros['nombre']) && isset($parametros['sector']) && isset($parametros['precio']) && isset($parametros['tiempo']))
            {
                $id = $parametros['id'];
                $nombre = $parametros['nombre'];
                $sector = $parametros['sector'];
                $precio = $parametros['precio'];
                $tiempo = $parametros['tiempo'];

                $producto = new Producto();
                $producto->id = $id;
                $producto->nombre = $nombre; 
                $producto->sector = $sector; 
                $producto->precio = $precio;
                $producto->tiempo = $tiempo;
                $producto->modificarProducto();

                $payload = json_encode(array("Mensaje" => "Producto modificado con exito"));
            }
            else
            {
                $payload = json_encode(array("Mensaje" => "Faltan parámetros obligatorios"));
                $response = $response->withStatus(400); 
            }

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function borrar($request, $response, $args) 
        {
            $parametros = $request->getParsedBody();

            if(isset($parametros['id']))
            {
                $productoId = $parametros['id'];
                Producto::borrarProducto($productoId);
            }
            else
            {
                $payload = json_encode(array("Mensaje" => "Faltan parámetros obligatorios"));
                $response = $response->withStatus(400);
            }

            $productoId = $parametros['id'];
            Producto::borrarProducto($productoId);

            $payload = json_encode(array("Mensaje" => "Producto borrado con exito"));

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