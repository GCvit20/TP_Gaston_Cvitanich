<?php
interface IApiUsable
{
	public function insertar($request, $response, $args);
	public function borrar($request, $response, $args);
	public function modificar($request, $response, $args);
	public function listarTodos($request, $response, $args);
}