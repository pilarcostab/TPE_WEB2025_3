<?php
class modeloPropiedades {
    private $db;

    public function __construct() {
        $this->db = $this->db = new PDO('mysql:host=localhost;dbname=db_alquilertemp;charset=utf8', 'root', '');
    }

    public function getPropiedades() {
        $query = $this->db->prepare('SELECT * FROM propiedades');
        $query->execute();
        $propiedades =  $query->fetchAll(PDO::FETCH_OBJ);

        return $propiedades; 
    }

    public function getPropiedadPorID($id_propiedad){
        $query = $this->db->prepare('SELECT * FROM propiedades WHERE id_propiedad = ?');
        $query->execute([$id_propiedad]);
        $propiedad = $query->fetch(PDO::FETCH_OBJ);
        return $propiedad;
    }


    public function getPropiedadesOrdenHabitaciones($sentido) {
        $sentido = strtoupper($sentido);
        if ($sentido !== "ASC" && $sentido !== "DESC") {
            $sentido = "ASC";
        }
        $query = $this->db->prepare("SELECT * FROM propiedades ORDER BY habitaciones $sentido");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getPropiedadesPorMetrosCuadrados($metros) {
        $query = $this->db->prepare("SELECT * FROM propiedades WHERE metros_cuadrados > ?");
        $query->execute([$metros]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    public function getPropiedadesPorPropietario($id_propietario) {
        $query = $this->db->prepare("SELECT * FROM propiedades WHERE id_propietario_fk = ? ");
        $query->execute([$id_propietario]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    public function getPropiedadesPorTipo($tipo_propiedad){
        $tipo_propiedad = strtoupper($tipo_propiedad);
        $query = $this->db->prepare("SELECT * FROM propiedades WHERE tipo_propiedad = ? ");
        $query->execute([$tipo_propiedad]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function updatePropiedad($id_propiedad, $id_propietario, $tipo_propiedad, $ubicacion, $habitaciones, $metros_cuadrados) {
        $query = $this->db->prepare('UPDATE propiedades SET id_propietario_fk = ?, tipo_propiedad = ?, ubicacion = ?, habitaciones = ?, metros_cuadrados = ? WHERE id_propiedad = ?');
        $query->execute([$id_propietario, $tipo_propiedad, $ubicacion, $habitaciones, $metros_cuadrados, $id_propiedad]);
    }

}