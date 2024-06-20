<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as Response;

class AuthMiddleware
{
  
    public function __invoke(Request $request, RequestHandler $handler): Response
    {   
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);

        try 
        {
            AutentificadorJWT::VerificarToken($token);
            $response = $handler->handle($request);
        } 
        catch (Exception $e) 
        {
            $response = new Response();
            $payload = json_encode(array('mensaje' => 'ERROR: Hubo un error con el TOKEN' . $e));
            $response->getBody()->write($payload);
        }
        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function verificarToken(Request $request, RequestHandler $handler): Response
    {
        $header = $request->getHeaderLine('Authorization');

        if($header)
        {
            $token = trim(explode("Bearer", $header)[1]);
        }
        else
        {
            $token = '';
        }

        try {
            AutentificadorJWT::VerificarToken($token);
            $response = $handler->handle($request);
        } catch (Exception $e) {
            $response = new Response();
            $payload = json_encode(array('mensaje' => 'ERROR: Hubo un error con el TOKEN'));
            $response->getBody()->write($payload);
        }
        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function verificarRol(Request $request, RequestHandler $handler, array $rolesPermitidos): Response
    {
        $header = $request->getHeaderLine('Authorization');

        if ($header) 
        {
            $token = trim(explode("Bearer", $header)[1]);
        } 
        else 
        {
            $token = '';
        }

        try {
            $data = AutentificadorJWT::ObtenerData($token);

            if (in_array($data->ocupacion, $rolesPermitidos)) 
            {
                $response = $handler->handle($request);
            } 
            else 
            {
                $response = new Response();
                $payload = json_encode(array('mensaje' => 'ERROR: No tienes permisos suficientes'));
                $response->getBody()->write($payload);
            }
        } 
        catch (Exception $e) 
        {
            $response = new Response();
            $payload = json_encode(array('mensaje' => 'ERROR: Hubo un error con el TOKEN' . $e));
            $response->getBody()->write($payload);
        }

        return $response->withHeader('Content-Type', 'application/json');
    }
}
