<?php
require_once './app/modelos/modeloPropiedades.php';
require_once './app/vistas/vistaJSON.php';

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
        $columnasValidas = ['id_propiedad', 'nombre', 'precio', 'categoria', 'talle', 'cantidad'];
        
        if (!in_array($columna,  $columnasValidas)) {
            $this->vista->response("Columna invalida", 400);
            return;
        }

        if ($orden != 'asc' && $orden != 'desc') {
            $this->vista->response("El orden debe ser 'asc' o 'desc'", 400);
            return;
        }

        $propiedades = $this->modelo->getPropiedades($columna, $orden);
         if ($propiedades) {
            $this->vista->response($propiedades, 200);
        } else {
            $this->vista->response("No hay propiedades", 404);
        }
    }

    public function listarPropiedad() {
        $id_propiedad = $_GET['id_propiedad'] ; 
        $propiedades = $this->modelo->getPropiedadPorID($id_propiedad);
         if ($propiedades) {
            $this->vista->response($propiedades, 200);
        } else {
            $this->vista->response("No hay propiedad con ese ID", 404);
        }
    }

    public function updatePropiedad($params) {
        $id = $params[':ID'];

        // Verificar si existe
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