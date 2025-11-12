<?php
require_once './app/modelos/modeloPropieatio.php';
require_once './app/vistas/vistaJSON.php';

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

        $this->modelo->agregarPropietario($id_propiedad, $nombre, $telefono, $mail);
        return $this->vista->response("Propietario agregado correctamente", 201);
    }





}