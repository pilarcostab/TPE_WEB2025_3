
<?php
class modeloPropietario {
    private $db;

    public function __construct($db) {
        $this->db = $this->db = new PDO('mysql:host=localhost;dbname=db_alquilertemp;charset=utf8', 'root', '');
    }

    public function obtenerPropietarioPorId($id) {
        $query = $this->db->prepare('SELECT * FROM propietarios WHERE id_propietario = ?');
        $query->execute([$id]);
        $propietario = $query->fetch(PDO::FETCH_ASSOC);
        return $propietario;
    }

    public function agregarPropietario($id_propiedad, $nombre, $telefono, $mail) {
        $query = $this->db->prepare('INSERT INTO propietarios (id_propiedad, nombre, telefono, mail) VALUES (?, ?, ?, ?)');
        $query->execute([$id_propiedad, $nombre, $telefono, $mail]);
    }

}
