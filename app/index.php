<?php

    // Error Handling
    error_reporting(-1);
    ini_set('display_errors', 1);

    use Illuminate\Support\Arr;
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Factory\AppFactory;
    use Slim\Routing\RouteCollectorProxy;
    use Slim\Routing\RouteContext;

    require __DIR__ . '/../vendor/autoload.php';
    require_once 'controllers/UsuarioController.php';
    require_once 'controllers/PedidoController.php';
    require_once 'controllers/ProductosController.php';
    require_once 'controllers/MesaController.php';
    require_once 'controllers/LoginController.php';
    require_once 'middlewares/AuthMiddleware.php';
    require_once 'utils/AutenticatorJWT.php';


    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad();

    $app = AppFactory::create();

    // Add error middleware
    $app->addErrorMiddleware(true, true, true);

    // Add parse body
    $app->addBodyParsingMiddleware();

    //Panel adm

    $app->group('/administrador', function(RouteCollectorProxy $group) 
    {
    
        $group->group('/usuario', function(RouteCollectorProxy $groupUsuario) 
        {
            $groupUsuario->post('[/]', \UsuarioController::class . ':insertar')->add(function ($request, $handler) { return \AuthMiddleware::verificarRol($request, $handler, ['admin']); });
            $groupUsuario->put('[/]', \UsuarioController::class . ':modificar')->add(function ($request, $handler) { return \AuthMiddleware::verificarRol($request, $handler, ['admin']); });
            $groupUsuario->delete('[/]', \UsuarioController::class . ':borrar')->add(function ($request, $handler) { return \AuthMiddleware::verificarRol($request, $handler, ['admin']); });
            $groupUsuario->get('[/]', \UsuarioController::class . ':listarTodos')->add(function ($request, $handler) { return \AuthMiddleware::verificarRol($request, $handler, ['admin']); });
        });
    
        $group->group('/producto', function(RouteCollectorProxy $groupProducto) 
        {
            $groupProducto->post('[/]', \ProductosController::class . ':insertar')->add(function ($request, $handler) { return \AuthMiddleware::verificarRol($request, $handler, ['admin']); });
            $groupProducto->put('[/]', \ProductosController::class . ':modificar')->add(function ($request, $handler) { return \AuthMiddleware::verificarRol($request, $handler, ['admin']); });
            $groupProducto->delete('[/]', \ProductosController::class . ':borrar')->add(function ($request, $handler) { return \AuthMiddleware::verificarRol($request, $handler, ['admin']); });
            $groupProducto->get('[/]', \ProductosController::class . ':listarTodos')->add(function ($request, $handler) { return \AuthMiddleware::verificarRol($request, $handler, ['admin']); });
        });
    
        $group->group('/mesa', function(RouteCollectorProxy $groupMesa) 
        {
            $groupMesa->post('[/]', \MesaController::class . ':insertar')->add(function ($request, $handler) { return \AuthMiddleware::verificarRol($request, $handler, ['admin', 'mozo']); });
            $groupMesa->put('[/]', \MesaController::class . ':modificar')->add(function ($request, $handler) { return \AuthMiddleware::verificarRol($request, $handler, ['admin']); });
            $groupMesa->delete('[/]', \MesaController::class . ':borrar')->add(function ($request, $handler) { return \AuthMiddleware::verificarRol($request, $handler, ['admin', 'mozo']); });
            $groupMesa->get('[/]', \MesaController::class . ':listarTodos')->add(function ($request, $handler) { return \AuthMiddleware::verificarRol($request, $handler, ['admin', 'mozo']); });
        });
    
        $group->group('/pedido', function(RouteCollectorProxy $groupPedido) 
        {
            $groupPedido->post('[/]', \PedidoController::class . ':insertar')->add(function ($request, $handler) { return \AuthMiddleware::verificarRol($request, $handler, ['admin','mozo']); });
            $groupPedido->put('[/]', \PedidoController::class . ':modificar')->add(function ($request, $handler) { return \AuthMiddleware::verificarRol($request, $handler, ['admin', 'mozo']); });
            $groupPedido->delete('[/]', \PedidoController::class . ':borrar')->add(function ($request, $handler) { return \AuthMiddleware::verificarRol($request, $handler, ['admin']); });
            $groupPedido->get('[/]', \PedidoController::class . ':listarTodos')->add(function ($request, $handler) { return \AuthMiddleware::verificarRol($request, $handler, ['admin','mozo']); });
        });
    
    })->add(\AuthMiddleware::class . ':verificarToken');
    

    $app->group('/jwt', function(RouteCollectorProxy $group)
    {
        $group->post('[/crearToken]', function(Request $request, Response $response)
        {
            $parametros = $request->getParsedBody();

            $usuario = $parametros['usuario'];
            $perfil = $parametros['perfil'];
            $alias = $parametros['alias'];

            $datos = array('usuario' => $usuario,'perfil' => $perfil, 'alias' => $alias);

            $token = AutentificadorJWT::CrearToken($datos);
            $payload = json_encode(array('jwt' => $token));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');

        });

        $group->get('/verificarToken', function (Request $request, Response $response) 
        {
            $header = $request->getHeaderLine('Authorization');
            $token = trim(explode("Bearer", $header)[1]);
            $esValido = false;
        
            try 
            {
              AutentificadorJWT::verificarToken($token);
              $esValido = true;
            } 
            catch (Exception $e) 
            {
              $payload = json_encode(array('error' => $e->getMessage()));
            }
        
            if ($esValido) 
            {
              $payload = json_encode(array('valid' => $esValido));
            }
        
            $response->getBody()->write($payload);
            return $response ->withHeader('Content-Type', 'application/json');
        });

        $group->get('/devolverPayLoad', function (Request $request, Response $response) 
        {
            $header = $request->getHeaderLine('Authorization');
            $token = trim(explode("Bearer", $header)[1]);
        
            try 
            {
                $payload = json_encode(array('payload' => AutentificadorJWT::ObtenerPayLoad($token)));
            } 
            catch (Exception $e) 
            {
                $payload = json_encode(array('error' => $e->getMessage()));
            }
        
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        });
    });

    // JWT en login
    $app->group('/auth', function (RouteCollectorProxy $group) 
    {
        $group->post('/login', \LoginController::class . ':verificarUsuario');
        $group->post('/registrarse', \LoginController::class . ':crearToken');
    });

    $app->get('[/]', function (Request $request, Response $response) 
    {    
        $payload = json_encode(array("mensaje" => "La comanda"));
        
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->run();
   
?>