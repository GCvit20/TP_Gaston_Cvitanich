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

    // Set base path
    $app->setBasePath('/app');

    // Add error middleware
    $app->addErrorMiddleware(true, true, true);

    // Add parse body
    $app->addBodyParsingMiddleware();

    $app->group('/usuario', function(RouteCollectorProxy $group)
    {
        $group->post('[/]', \UsuarioController::class . ':insertar');
        $group->get('[/]', \UsuarioController::class . ':listarTodos');
    });

    
    $app->group('/producto', function(RouteCollectorProxy $group)
    {
        $group->post('[/]', \ProductosController::class . ':insertar');
        $group->get('[/]', \ProductosController::class . ':listarTodos');
    });

    $app->group('/mesa', function(RouteCollectorProxy $group)
    {
        $group->post('[/]', \MesaController::class . ':insertar');
        $group->get('[/]', \MesaController::class . ':listarTodos');
    });

    $app->group('/pedido', function(RouteCollectorProxy $group)
    {
        $group->post('[/]', \PedidoController::class . ':insertar');
        $group->get('[/]', \PedidoController::class . ':listarTodos');
    });

    $app->get('[/]', function (Request $request, Response $response) {    
        $payload = json_encode(array("mensaje" => "Slim Framework 4 PHP"));
        
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->run();
   
?>