<?php

    require_once 'controllers/UsuarioController.php';
    require_once 'controllers/PedidoController.php';
    require_once 'controllers/ProductosController.php';
    require_once 'controllers/MesaController.php';

    try
    {
        //La vista se encarga de traer los datos y llamar al controler

        $UsuarioController = new UsuarioController();
        $ProductoController = new ProductosController();
        $MesaController = new MesaController();
        $PedidoController = new PedidoController();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') //Select
        {
            if (isset($_GET['action'])) 
            {
                switch ($_GET['action']) 
                {
                    case 'listar usuarios':
                        $usuario = $UsuarioController->listarUsuarios();
                        echo json_encode($usuario);
                        break;
                    case "listar productos":
                        $producto = $ProductoController->listarProductos();
                        echo json_encode($producto);
                        break;
                    case "listar mesas":
                        $mesa = $MesaController->listarMesas();
                        echo json_encode($mesa);
                        break;
                    case "listar pedidos":
                        $pedido = $PedidoController->listarPedidos();
                        echo json_encode($pedido);
                        break;
                }
            } 
            else 
            {
                echo json_encode(['error' => 'Falta el parametro action']);
            }
        } 
        elseif ($_SERVER['REQUEST_METHOD'] === 'POST') //Insert
        {
            if (isset($_GET['action'])) 
            {
                switch ($_GET['action']) 
                {
                    case 'insertar usuario':
                        if (isset($_POST['nombreEmpleado']) && isset($_POST['ocupacion'])) 
                        {
                            $resultado = $UsuarioController->insertarUsuario($_POST['nombreEmpleado'], $_POST['ocupacion']);
                            echo json_encode(['resultado' => $resultado]);
                        } 
                        else 
                        {
                            echo json_encode(['error' => 'Faltan parámetros']);
                        }
                        break;
                    case 'insertar producto':
                        if (isset($_POST['tipoProductos']) && isset($_POST['precio']) && isset($_POST['tiempo'])) 
                        {
                            $resultado = $ProductoController->insertarProducto($_POST['tipoProductos'], $_POST['precio'], $_POST['tiempo']);
                            echo json_encode(['resultado' => $resultado]);
                        } 
                        else 
                        {
                            echo json_encode(['error' => 'Faltan parámetros']);
                        }
                        break;
                    case 'insertar mesa':
                        if (isset($_POST['codigoMesa']) && isset($_POST['estado'])) 
                        {
                            $resultado = $MesaController->insertarMesa($_POST['codigoMesa'], $_POST['estado']);
                            echo json_encode(['resultado' => $resultado]);
                        } 
                        else 
                        {
                            echo json_encode(['error' => 'Faltan parámetros']);
                        }
                        break;
                        case 'insertar pedido':
                            if (isset($_POST['codigoPedido']) && isset($_POST['estado']) && isset($_POST['tiempo']) && isset($_POST['precioFinal']) && isset($_POST['foto']) && isset($_POST['nombreCliente'])) 
                            {
                                $resultado = $PedidoController->insertarPedido($_POST['codigoPedido'], $_POST['estado'], $_POST['tiempo'], $_POST['precioFinal'],$_POST['foto'],$_POST['nombreCliente']);
                                echo json_encode(['resultado' => $resultado]);
                            } 
                            else 
                            {
                                echo json_encode(['error' => 'Faltan parámetros']);
                            }
                            break;            
                    default:
                        echo json_encode(['error' => 'Accion no valida']);
                        break;
                }
            } 
            else 
            {
                echo json_encode(['error' => 'Falta el parametro action']);
            }
        } 
    }
    catch(PDOException $e)
    {
        echo "Error: " .$e->getMessage();
    }
?>
