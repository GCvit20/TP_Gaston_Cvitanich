<?php

    // Error Handling
    error_reporting(-1);
    ini_set('display_errors', 1);

    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Server\RequestHandlerInterface;
    use Slim\Factory\AppFactory;
    use Slim\Routing\RouteCollectorProxy;
    use Slim\Routing\RouteContext;

    require __DIR__ . '/../vendor/autoload.php';
    require_once 'controllers/UsuarioController.php';
    require_once 'controllers/PedidoController.php';
    require_once 'controllers/ProductosController.php';
    require_once 'controllers/MesaController.php';

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad();

    $app = AppFactory::create();

    // Add error middleware
    $app->addErrorMiddleware(true, true, true);

    // Add parse body
    $app->addBodyParsingMiddleware();

    $app->group('/usuario', function(RouteCollectorProxy $group)
    {
        $group->post('[/]', \UsuarioController::class . ':insertar');
        $group->put('[/]', \UsuarioController::class . ':modificar');
        $group->delete('[/]', \UsuarioController::class . ':borrar');
        $group->get('[/]', \UsuarioController::class . ':listarTodos');
    });

    
    $app->group('/producto', function(RouteCollectorProxy $group)
    {
        $group->post('[/]', \ProductosController::class . ':insertar');
        $group->put('[/]', \ProductosController::class . ':modificar');
        $group->delete('[/]', \ProductosController::class . ':borrar');
        $group->get('[/]', \ProductosController::class . ':listarTodos');
    });

    $app->group('/mesa', function(RouteCollectorProxy $group)
    {
        $group->post('[/]', \MesaController::class . ':insertar');
        $group->put('[/]', \MesaController::class . ':modificar');
        $group->delete('[/]', \MesaController::class . ':borrar');
        $group->get('[/]', \MesaController::class . ':listarTodos');
    });

    $app->group('/pedido', function(RouteCollectorProxy $group)
    {
        $group->post('[/]', \PedidoController::class . ':insertar');
        $group->put('[/]', \PedidoController::class . ':modificar');
        $group->delete('[/]', \PedidoController::class . ':borrar');
        $group->get('[/]', \PedidoController::class . ':listarTodos');
    });

    $app->get('[/]', function (Request $request, Response $response) 
    {    
        $payload = json_encode(array("mensaje" => "La comanda"));
        
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->run();
   
?>