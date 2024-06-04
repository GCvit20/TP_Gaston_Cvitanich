<?php

    use Slim\Factory\AppFactory;
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Routing\RouteCollectorProxy;
    
    require_once 'controllers/UsuarioController.php';
    require_once 'controllers/PedidoController.php';
    require_once 'controllers/ProductosController.php';
    require_once 'controllers/MesaController.php';
    require_once '../vendor/autoload.php';

    try
    {
        $app = AppFactory::create();

        $app->group('/usuario', function(RouteCollectorProxy $group)
        {
            $group->post('[/]', \UsuarioController::class . ':insertarUsuario');
            $group->get('[/]', \UsuarioController::class . ':listarUsuarios');
        });

        $app->group('/producto', function(RouteCollectorProxy $group)
        {
            $group->post('[/]', \ProductosController::class . ':insertarProducto');
            $group->get('[/]', \ProductosController::class . ':listarProductos');
        });

        $app->group('/mesa', function(RouteCollectorProxy $group)
        {
            $group->post('[/]', \MesaController::class . ':insertarMesa');
            $group->get('[/]', \MesaController::class . ':listarMesas');
        });

        $app->group('/pedido', function(RouteCollectorProxy $group)
        {
            $group->post('[/]', \PedidoController::class . ':insertarPedido');
            $group->get('[/]', \PedidoController::class . ':listarPedidos');
        });

        $app->run();
    }
    catch(Exception $e)
    {
        echo "Error: " .$e->getMessage();
    }
?>
