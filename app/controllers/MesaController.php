<?php

    require_once 'models/mesa.php';

    class MesaController 
    {

        public function insertarMesa($codigoMesa, $estado) 
        {
            $mesa = new Mesa(); //instancia el mesa

            //asigna los campos
            $mesa->codigoMesa = $codigoMesa; 
            $mesa->estado = $estado;

            return $mesa->crearMesa();
        }

        public function modificarMesa($codigoMesa, $estado) 
        {
            $mesa = new Mesa();
            $mesa->codigoMesa = $codigoMesa; 
            $mesa->estado = $estado;
            //return $mesa->modificarMesa();
        }

        public function borrarMesa($id) 
        {
            $mesa = new Mesa();
            $mesa->id = $id;
            return $mesa->borrarMesa($id);
        }

        public function listarMesas() 
        {
            return Mesa::obtenerTodos();
        }

    }

?>