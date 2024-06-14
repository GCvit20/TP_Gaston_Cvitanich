<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as ResponseClass;

class AuthMiddleware
{
    private $perfil = "";

    public function __construct($perfil) 
    {
        $this->perfil = $perfil;
    }
    
    public function __invoke(Request $request, RequestHandler $requesthandler): ResponseClass
    {   
        $response = new ResponseClass();
        $parametros = $request->getQueryParams();

        if (isset($parametros['credenciales'])) 
        {
            $credenciales = $parametros['credenciales'];

            if($credenciales == $this->perfil)
            {
                $response = $requesthandler->handle($request);
            }
            else 
            {
                $response->getBody()->write(json_encode((array("Error" => "La credencial '{$credenciales}' no tiene acceso"))));
            }
        }
        else
        {
            $response->getBody()->write(json_encode((array("Error" => "No hay credenciales"))));
        }

        return $response;
    }
}
