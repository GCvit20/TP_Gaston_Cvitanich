<?php

require_once 'models/usuario.php';
require_once 'db/AccesoDatos.php';

use Firebase\JWT\JWT;

    class AutentificadorJWT
    {        
        private static function obtenerClaveSecreta()
        {
            $objDataAccess = AccesoDatos::obtenerInstancia();
            $query = $objDataAccess->prepararConsulta("SELECT claveSecreta FROM config WHERE id = 1");
            $query->execute();
            $claveSecreta = $query->fetchColumn();

            if ($claveSecreta === false) 
            {
                throw new Exception("No se pudo obtener la clave secreta de la base de datos.");
            }
            
            return $claveSecreta;
        }

        private static function obtenerEncriptacion()
        {
            $objDataAccess = AccesoDatos::obtenerInstancia(); 
            $query = $objDataAccess->prepararConsulta("SELECT tipoEncriptacion FROM config WHERE id = 1");
            $query->execute();
            $tipoEncriptacion = $query->fetchColumn();

            if ($tipoEncriptacion === false) 
            {
                throw new Exception("No se pudo obtener el tipo de encriptacion de la base de datos.");
            }

            //debemos convertirlo en array por que las bibliotecas JWT esperan un array de algoritmos de encriptación
            $tipoEncriptacionArray = explode(',', $tipoEncriptacion);
            
            return $tipoEncriptacionArray;
        }

        public static function CrearToken($datos)
        {
            $ahora = time();
            $payload = array(
                'iat' => $ahora,
                'exp' => $ahora + (60000),
                'aud' => self::Aud(),
                'data' => $datos,
                'app' => "Test JWT"
            );
            
            $claveSecreta = self::obtenerClaveSecreta();
            return JWT::encode($payload, $claveSecreta);
        }

        public static function VerificarToken($token)
        {
            if (empty($token)) {
                throw new Exception("El token esta vacio.");
            }
            try {
                $decodificado = JWT::decode(
                    $token,
                    self::obtenerClaveSecreta(),
                    self::obtenerEncriptacion()
                );
            } catch (Exception $e) 
            {
                throw $e;
            }
            if ($decodificado->aud !== self::Aud()) 
            {
                throw new Exception("No es el usuario valido");
            }
        }


        public static function ObtenerPayLoad($token)
        {
            if (empty($token)) {
                throw new Exception("El token esta vacio.");
            }
            return JWT::decode(
                $token,
                self::obtenerClaveSecreta(),
                self::obtenerEncriptacion()
            );
        }

        public static function ObtenerData($token)
        {
            return JWT::decode(
                $token,
                self::obtenerClaveSecreta(),
                self::obtenerEncriptacion()
            )->data;
        }

        private static function Aud()
        {
            $aud = '';

            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $aud = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $aud = $_SERVER['REMOTE_ADDR'];
            }

            $aud .= @$_SERVER['HTTP_USER_AGENT'];
            $aud .= gethostname();

            return sha1($aud);
        }
    }

?>