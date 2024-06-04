<?php

    require_once 'models/usuario.php';
    //Recibe los datos, instancia el modelo y se encarga de llamar a los metodos del modelo.

    class UsuarioController 
    {

        public function insertarUsuario($nombreEmpleado, $ocupacion) 
        {
            $usuario = new Usuario(); //instancia el usuario

            //asigna los campos
            $usuario->nombreEmpleado = $nombreEmpleado; 
            $usuario->ocupacion = $ocupacion;

            return $usuario->crearUsuario();
        }

        public function modificarUsuario($nombreEmpleado, $ocupacion) 
        {
            $usuario = new Usuario();
            $usuario->nombreEmpleado = $nombreEmpleado; 
            $usuario->ocupacion = $ocupacion;
            return $usuario->modificarUsuario();
        }

        public function borrarCd($id) 
        {
            $usuario = new Usuario();
            $usuario->id = $id;
            return $usuario->borrarUsuario($id);
        }

        public function listarUsuarios() 
        {
            return Usuario::obtenerTodos();
        }

        public function buscarUsuarioPorId($id) 
        {
            $retorno = Usuario::obtenerUsuario($id);
            if($retorno === false) { // Validamos que exista y si no mostramos un error
                $retorno =  ['error' => 'No existe ese id'];
            }
            return $retorno;
        }
    }

?>