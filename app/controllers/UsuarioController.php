<?php

    require_once 'models/usuario.php';
    require_once 'interfaces/IApiUsable.php';
    //Recibe los datos, instancia el modelo y se encarga de llamar a los metodos del modelo.

    class UsuarioController extends Usuario implements IApiUsable
    {

        public function insertar($request, $response, $args) 
        {
            $parametros = $request->getParsedBody();

            // Verificar si los parámetros esperados están presentes
            if(isset($parametros['nombreUsuario']) && isset($parametros['clave']) && isset($parametros['ocupacion'])) 
            {
                $nombreUsuario = $parametros['nombreUsuario'];
                $clave = $parametros['clave'];
                $ocupacion = $parametros['ocupacion'];

                $usuario = new Usuario();
                $usuario->nombreUsuario = $nombreUsuario; 
                $usuario->clave = $clave;
                $usuario->ocupacion = $ocupacion;
                $usuario->crearUsuario();

                $payload = json_encode(array("Mensaje" => "Usuario creado con exito"));
            } 
            else 
            {
                // Si falta alguno de los parámetros, generar un mensaje de error
                $payload = json_encode(array("Mensaje" => "Faltan parámetros obligatorios"));
                $response = $response->withStatus(400); // Código de estado 400 para "Bad Request"
            }

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }


        public function modificar($request, $response, $args) 
        {
            $parametros = $request->getParsedBody();

            if(isset($parametros['id']) && isset($parametros['nombreUsuario']) && isset($parametros['clave']) && isset($parametros['ocupacion'])) 
            {
                $id = $parametros['id'];
                $nombreUsuario = $parametros['nombreUsuario'];
                $clave = $parametros['clave'];
                $ocupacion = $parametros['ocupacion'];

                $usuario = new Usuario();
                $usuario->id = $id;
                $usuario->nombreUsuario = $nombreUsuario; 
                $usuario->clave = $clave;
                $usuario->ocupacion = $ocupacion;
                $usuario->modificarUsuario();

                $payload = json_encode(array("Mensaje" => "Usuario modificado con exito"));
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
                $usuarioId = $parametros['id'];
                Usuario::borrarUsuario($usuarioId);

                $payload = json_encode(array("Mensaje" => "Usuario borrado con exito"));
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
            $lista = Usuario::obtenerTodos();
            $payload = json_encode(array("listaUsuario" => $lista));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function buscarUsuarioPorId($id) 
        {
            $retorno = Usuario::obtenerUsuario($id);
            if($retorno === false) { // Validamos que exista y si no mostramos un error
                $retorno =  ['Error' => 'No existe ese id'];
            }
            return $retorno;
        }
    }

?>