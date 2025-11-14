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
        $propiedades = $this->modelo->getPropiedades();
         if ($propiedades) {
            $this->vista->response($propiedades, 200);
        } else {
            $this->vista->response("No hay propiedades", 404);
        }
    }

    public function listarPropiedadesPorHabitaciones() {
        $sentido = $_GET['sentido'] ?? 'ASC';
        $propiedades = $this->modelo->getPropiedadesOrdenHabitaciones($sentido);
        $this->vista->response($propiedades, 200);
    }

    public function listarPropiedadesPorMetrosCuadrados() {
        $metros = $_GET['metros_cuadrados'] ?? null ;

        if ($metros === null) {
            $this->vista->response("Debes enviar ?metros_cuadrados=valor", 400);
            return;
        }

        $propiedades = $this->modelo->getPropiedadesPorMetrosCuadrados($metros);
        if ($propiedades) {
            $this->vista->response($propiedades, 200);
        } else {
            $this->vista->response("No hay propiedades de mas de $metros metros cuadrados", 404);
        }
    }

    public function listarPropiedadesPorPropietario() {
        $id_propietario = $_GET['id_propietario_fk'] ?? null ;
      
        if ($id_propietario === null) {
            $this->vista->response("Debes enviar ?id_propietario_fk=ID", 400);
            return;
        }

        $propiedades = $this->modelo->getPropiedadesPorPropietario($id_propietario);
        if ($propiedades) {
            $this->vista->response($propiedades, 200);
        } else {
            $this->vista->response("No hay propiedades de ese propietario",  404);
        }
    }

    public function listarPropiedadesPorTipoPropiedad() {
        $tipo_propiedad = $_GET['tipo_propiedad'] ?? null ;

        if ($tipo_propiedad === null) {
            $this->vista->response("Debes enviar un tipo de propiedad)", 400);
            return;
        }
        $propiedades = $this->modelo->getPropiedadesPorTipo($tipo_propiedad);
        
        if($propiedades) {
            $this->vista->response($propiedades, 200);
        } else {
            $this->vista->response("No hay propiedades de ese tipo" ,  404);
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