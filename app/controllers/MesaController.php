<?php

    require_once 'models/mesa.php';
    require_once './interfaces/IApiUsable.php';

    class MesaController extends Mesa implements IApiUsable
    {

        public function insertar($request, $response, $args) 
        {
            $parametros = $request->getParsedBody();

            if(isset($parametros['codigoMesa']) && isset($parametros['estado'])) 
            {
                $codigoMesa = $parametros['codigoMesa'];
                $estado = $parametros['estado'];

                $mesa = new Mesa();
                $mesa->codigoMesa = $codigoMesa; 
                $mesa->estado = $estado;
                $mesa->crearMesa();

                $payload = json_encode(array("Mensaje" => "Mesa creada con exito"));
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

            if(isset($parametros['codigoMesa']) && isset($parametros['estado'])) 
            {
                $codigoMesa = $parametros['codigoMesa'];
                $estado = $parametros['estado'];

                $mesa = new Mesa();
                $mesa->codigoMesa = $codigoMesa;
                $mesa->estado = $estado;
                $mesa->modificarMesa();

                $payload = json_encode(array("Mensaje" => "Mesa modificada con exito"));
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

            if(isset($parametros['codigoMesa'])) 
            {
                $codigoMesa = $parametros['codigoMesa'];
                Mesa::borrarMesa($codigoMesa);

                $payload = json_encode(array("mensaje" => "Mesa borrada con exito"));
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
            $lista = Mesa::obtenerTodos();
            $payload = json_encode(array("listaProductos" => $lista));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

    }

?>