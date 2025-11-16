<?php
require_once './modelos/modeloPropiedades.php';
require_once './vistas/vistaJSON.php';

class PropiedadesController {
    private $modelo;
    private $vista;

    public function __construct() {
        $this->modelo = new modeloPropiedades();
        $this->vista = new vistaJSON();
    }

    private function getData() {
    return json_decode(file_get_contents("php://input"));
    }

    public function listarPropiedades() {
        $columna = $_GET['columna'] ?? 'id_propiedad'; 
        $orden = strtolower($_GET['orden'] ?? 'asc');
        $pagina = $_GET['pagina'] ?? 1;
        $limite = $_GET['limite'] ?? 10;
       
        $columnasValidas = ['id_propiedad', 'id_propietario_fk', 'tipo_propiedad', 'ubicacion', 'habitaciones', 'metros_cuadrados'];
        
        if (!in_array($columna,  $columnasValidas)) {
            $this->vista->response("Columna invalida", 400);
            return;
        }
        if ($orden != 'asc' && $orden != 'desc') {
            $this->vista->response("El orden debe ser 'asc' o 'desc'", 400);
            return;
        }
        if ($pagina !== null && $limite !== null){
            $offset = ($pagina - 1) * $limite ; 
            $propiedades = $this->modelo->getPropiedadesPaginadas($columna, $orden, $limite, $offset);
            $total = $this->modelo->contarPropiedades();
            $response = ["Página" => (int)$pagina, "total_paginas" => ceil($total / $limite), "Propiedades" => $propiedades];
            } else {
                $propiedades = $this->modelo->getPropiedades($columna, $orden);
                $response = $propiedades; 
            }
         if ($propiedades) {
            $this->vista->response($response, 200);
        } else {
            $this->vista->response("No hay propiedades", 404);
        }
    }

    public function listarPropiedad($request, $response) {
    $id = $request->params->id;

    $propiedad = $this->modelo->getPropiedadPorID($id);

    if ($propiedad) {
        $this->vista->response($propiedad, 200);
    } else {
        $this->vista->response("No hay propiedad con ese ID", 404);
    }
}

    public function updatePropiedad($request, $response) {
        $id = $request->params->id;
        $propiedad = $this->modelo->getPropiedadPorID($id);
        if (!$propiedad) {
            $this->vista->response("La propiedad con ID $id no existe", 404);
            return;
        }

        // Obtener datos enviados en el body
        $body = $this->getData();

        if (
            empty($body->id_propietario_fk) ||
            empty($body->tipo_propiedad) ||
            empty($body->ubicacion) ||
            empty($body->habitaciones) ||
            empty($body->metros_cuadrados)
        ) {
            $this->vista->response("Todos los campos deben estar completos", 400);
            return;
        }

        // Actualizar
        $this->modelo->updatePropiedad(
            $id,
            $body->id_propietario_fk,
            $body->tipo_propiedad,
            $body->ubicacion,
            $body->habitaciones,
            $body->metros_cuadrados
        );

        $updated = $this->modelo->getPropiedadPorID($id);

        $this->vista->response($updated, 200);
    }

}