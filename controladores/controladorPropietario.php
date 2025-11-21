<?php
require_once './modelos/modeloPropietario.php';
require_once './vistas/vistaJSON.php';

class PropietarioController {
    private $modelo;
    private $vista;

    public function __construct() {
        $this->modelo = new modeloPropietario();
        $this->vista = new vistaJSON();
    }

    public function obtenerPropietarioPorId($req, $res) {
        $id = $req->params->id;
        $propietario = $this->modelo->obtenerPropietarioPorId($id);

        if ($propietario) {
            return $this->vista->response($propietario, 200);
        } else {
            return $this->vista->response("El propietario con ID $id no existe", 404);
        }
    }

    public function agregarPropietario($req, $res)    {
        $nombre = $req->body->nombre ?? null;
        $telefono = $req->body->telefono ?? null;
        $mail = $req->body->mail ?? null;

        if (!$nombre || !$telefono || !$mail) {
            return $this->vista->response(" Faltan completar datos obligatorios", 400);
        }

        $this->modelo->agregarPropietario($nombre, $telefono, $mail);
        return $this->vista->response("Propietario agregado correctamente", 201);
    }

    public function filtrarPropietarios($req, $res) {
        $filtros = [
            'nombre' => $req->query->nombre ?? null,
            'telefono' => $req->query->telefono ?? null,
            'mail' => $req->query->mail ?? null
        ];

        $resultado = $this->modelo->filtrarPropietarios($filtros);

        return $this->vista->response($resultado, 200);
    }

    public function listarPropietarios($req, $res) {
        $pagina = $req->query->pagina ?? 1;
        $limite = $req->query->limite ?? 10;

        if ($pagina < 1 || $limite < 1) {
            return $this->vista->response("Parámetros de paginado inválidos", 400);
        }

        $offset = ($pagina - 1) * $limite;

        $propietarios = $this->modelo->getPropietariosPaginados($limite, $offset);
        $total = $this->modelo->contarPropietarios();

        if (!$propietarios) {
            return $this->vista->response("No hay propietarios registrados", 404);
        }

        $response = [
            "pagina" => (int)$pagina,
            "total_paginas" => ceil($total / $limite),
            "propietarios" => $propietarios
        ];

        return $this->vista->response($response, 200);
    }


}