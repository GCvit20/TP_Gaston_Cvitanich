<?php
 require_once './models/usuario.php';
 require_once './utils/AutenticatorJWT.php';


 class LoginController extends Usuario
 {

    public static function verificarUsuario($request, $response, $args)
    {
        $params = $request->getParsedBody();

        if (!isset($params['nombreUsuario']) || !isset($params['clave'])) 
        {
            $payload = json_encode(array('Error' => 'Faltan parametros: nombreUsuario y/o clave'));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json')->write($payload);
        }

        $nombreUsuario = $params['nombreUsuario'];
        $clave = $params['clave'];
        
        $usuario = Usuario::ObtenerUsuarioPorNombreUsuario($nombreUsuario);

        if (!$usuario) 
        {
            $payload = json_encode(array('Error' => 'Usuario invalido'));
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json')->write($payload);
        }

        if(password_verify($clave, $usuario->clave))
        {
            $usuarioData = array(
                'id' => $usuario->id,
                'nombreUsuario' => $usuario->nombreUsuario,
                'clave' => $usuario->clave,
                'ocupacion' => $usuario->ocupacion
            );

            $token = AutentificadorJWT::CrearToken($usuarioData);
            $payload = json_encode(array('Token' => $token));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
        else 
        {
            $payload = json_encode(array('Error' => 'Se produjo un error durante la autenticación'));
            $response->getBody()->write($payload);
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
        }
    }
 }
?>