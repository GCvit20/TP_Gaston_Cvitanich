<?php

    require_once 'models/mesa.php';
    require_once './interfaces/IApiUsable.php';

    class MesaController extends Mesa implements IApiUsable
    {

        public function insertar($request, $response, $args) 
        {
            $parametros = $request->getParsedBody();

            $codigoMesa = $parametros['codigoMesa'];
            $estado = $parametros['estado'];

            $mesa = new Mesa();
            $mesa->codigoMesa = $codigoMesa; 
            $mesa->estado = $estado;
            $mesa->crearMesa();

            $payload = json_encode(array("mensaje" => "Mesa creada con exito"));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function modificar($request, $response, $args) 
        {
            $parametros = $request->getParsedBody();

            $codigoMesa = $parametros['codigoMesa'];
            $estado = $parametros['estado'];

            $mesa = new Mesa();
            $mesa->codigoMesa = $codigoMesa; 
            $mesa->estado = $estado;
            $mesa->modificarMesa();

            $payload = json_encode(array("mensaje" => "Mesa creada con exito"));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function borrar($request, $response, $args) 
        {
            $parametros = $request->getParsedBody();

            $pedidoId = $parametros['id'];
            Mesa::borrarMesa($pedidoId);

            $payload = json_encode(array("mensaje" => "Mesa borrado con exito"));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function listarTodos($request, $response, $args) 
        {
            $lista = Mesa::obtenerTodos();
            $payload = json_encode(array("listaProductos" => $lista));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

    }

?>