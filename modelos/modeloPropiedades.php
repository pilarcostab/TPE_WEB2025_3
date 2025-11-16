<?php
class modeloPropiedades {
    private $db;

    public function __construct() {
        $this->db = $this->db = new PDO('mysql:host=localhost;dbname=db_alquilertemp;charset=utf8', 'root', '');
    }

    public function getPropiedades($columna, $orden) {
        $sql = "SELECT * FROM propiedades ORDER BY $columna $orden";
        $query = $this->db->prepare($sql);
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

    public function updatePropiedad($id_propiedad, $id_propietario, $tipo_propiedad, $ubicacion, $habitaciones, $metros_cuadrados) {
        $query = $this->db->prepare('UPDATE propiedades SET id_propietario_fk = ?, tipo_propiedad = ?, ubicacion = ?, habitaciones = ?, metros_cuadrados = ? WHERE id_propiedad = ?');
        $query->execute([$id_propietario, $tipo_propiedad, $ubicacion, $habitaciones, $metros_cuadrados, $id_propiedad]);
    }

}