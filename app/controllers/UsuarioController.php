<?php

    require_once 'models/usuario.php';
    require_once 'interfaces/IApiUsable.php';
    //Recibe los datos, instancia el modelo y se encarga de llamar a los metodos del modelo.

    class UsuarioController extends Usuario implements IApiUsable
    {

        public function insertar($request, $response, $args) 
        {

            $parametros = $request->getParsedBody();

            $nombreEmpleado = $parametros['nombreEmpleado'];
            $ocupacion = $parametros['ocupacion'];
            
            $usuario = new Usuario();
            $usuario->nombreEmpleado = $nombreEmpleado; 
            $usuario->ocupacion = $ocupacion;
            $usuario->crearUsuario();

            $payload = json_encode(array("mensaje" => "Pedido creado con exito"));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function modificar($request, $response, $args) 
        {
            $parametros = $request->getParsedBody();

            $nombreEmpleado = $parametros['nombreEmpleado'];
            $ocupacion = $parametros['ocupacion'];

            $usuario = new Usuario();
            $usuario->nombreEmpleado = $nombreEmpleado; 
            $usuario->ocupacion = $ocupacion;
            $usuario->modificarUsuario();

            $payload = json_encode(array("mensaje" => "Pedido creado con exito"));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function borrar($request, $response, $args) 
        {
            $parametros = $request->getParsedBody();

            $pedidoId = $parametros['id'];
            Usuario::borrarUsuario($pedidoId);

            $payload = json_encode(array("mensaje" => "Pedido borrado con exito"));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function listarTodos($request, $response, $args)
        {
            $lista = Usuario::obtenerTodos();
            $payload = json_encode(array("listaUsuario" => $lista));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
        
        public function buscarUsuarioPorId($id) 
        {
            $retorno = Usuario::obtenerUsuario($id);
            if($retorno === false) { // Validamos que exista y si no mostramos un error
                $retorno =  ['error' => 'No existe ese id'];
            }
            return $retorno;
        }
    }

?>