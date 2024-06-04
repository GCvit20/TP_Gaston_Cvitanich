<?php

    require_once 'models/pedido.php';
    //Recibe los datos, instancia el modelo y se encarga de llamar a los metodos del modelo.

    class PedidoController 
    {

        public function insertarPedido($codigoPedido, $estado, $tiempo, $precioFinal, $foto, $nombreCliente) 
        {
            $pedido = new Pedido(); //instancia el pedido

            //asigna los campos
            $pedido->codigoPedido = $codigoPedido; 
            $pedido->estado = $estado;
            $pedido->tiempo = $tiempo;
            $pedido->precioFinal = $precioFinal;
            $pedido->foto = $foto;
            $pedido->nombreCliente = $nombreCliente;

            return $pedido->crearPedido();
        }

        public function modificarPedido($codigoPedido, $estado, $tiempo, $precioFinal, $foto, $nombreCliente) 
        {
            $pedido = new Pedido();
            $pedido->codigoPedido = $codigoPedido; 
            $pedido->estado = $estado;
            $pedido->tiempo = $tiempo;
            $pedido->precioFinal = $precioFinal;
            $pedido->foto = $foto;
            $pedido->nombreCliente = $nombreCliente;
            //return $pedido->modificarProducto();
        }

        public function borrarPedido($id) 
        {
            $pedido = new Pedido();
            $pedido->id = $id;
            return $pedido->borrarPedido($id);
        }

        public function listarPedidos() 
        {
            return Pedido::obtenerTodos();
        }

    }

?>