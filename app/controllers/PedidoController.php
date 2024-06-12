<?php

    require_once 'models/pedido.php';
    require_once './interfaces/IApiUsable.php';
    //Recibe los datos, instancia el modelo y se encarga de llamar a los metodos del modelo.

    class PedidoController extends Pedido implements IApiUsable
    {

        public function insertar($request, $response, $args) 
        {
            
            $parametros = $request->getParsedBody();

            if(isset($parametros['idMesa']) && isset($parametros['codigoPedido']) && isset($parametros['estado']) && isset($parametros['precioFinal']) && isset($parametros['foto']) && isset($parametros['nombreCliente']))
            {
                $idMesa = $parametros['idMesa'];
                $codigoPedido = $parametros['codigoPedido'];
                $estado = $parametros['estado'];
                $precioFinal = $parametros['precioFinal'];
                $foto = $parametros['foto'];
                $nombreCliente = $parametros['nombreCliente'];
    
                $pedido = new Pedido(); //instancia el pedido
                $pedido->idMesa = $idMesa; 
                $pedido->codigoPedido = $codigoPedido; 
                $pedido->estado = $estado;
                $pedido->precioFinal = $precioFinal;
                $pedido->foto = $foto;
                $pedido->nombreCliente = $nombreCliente;
                $pedido->crearPedido();

                $payload = json_encode(array("Mensaje" => "Pedido creado con exito"));
            }
            else
            {
                $payload = json_encode(array("Mensaje" => "Faltan parámetros obligatorios"));
                $response = $response->withStatus(400); 
            }

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function modificar($request, $response, $args) 
        {
            
            $parametros = $request->getParsedBody();

            if(isset($parametros['codigoPedido']) && isset($parametros['estado']) && isset($parametros['precioFinal']) && isset($parametros['foto']) && isset($parametros['nombreCliente']))
            {
                //$id = $parametros['id'];
                //$idMesa = $parametros['idMesa'];
                $codigoPedido = $parametros['codigoPedido'];
                $estado = $parametros['estado'];
                $precioFinal = $parametros['precioFinal'];
                $foto = $parametros['foto'];
                $nombreCliente = $parametros['nombreCliente'];
    
                $pedido = new Pedido(); //instancia el pedido
                //$pedido->id = $id;
                //$pedido->idMesa = $idMesa; 
                $pedido->codigoPedido = $codigoPedido; 
                $pedido->estado = $estado;
                $pedido->precioFinal = $precioFinal;
                $pedido->foto = $foto;
                $pedido->nombreCliente = $nombreCliente;
                $pedido->modificarPedido();

                $payload = json_encode(array("Mensaje" => "Pedido modificado con exito"));
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

            if(isset($parametros['codigoPedido']))
            {
                $codigoPedido = $parametros['codigoPedido'];
                Pedido::borrarPedido($codigoPedido);

                $payload = json_encode(array("mensaje" => "Pedido borrado con exito"));
            }
            else
            {
                $payload = json_encode(array("Mensaje" => "Faltan parámetros obligatorios"));
                $response = $response->withStatus(400);
            }

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function listarTodos($request, $response, $args) 
        {
            $lista = Pedido::obtenerTodos();
            $payload = json_encode(array("listaPedido" => $lista));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

    }

?>