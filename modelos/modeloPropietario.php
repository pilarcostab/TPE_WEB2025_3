
<?php
class modeloPropietario {
    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=db_alquilertemp;charset=utf8', 'root', '');
    }

    public function obtenerPropietarioPorId($id) {
        $query = $this->db->prepare('SELECT * FROM propietarios WHERE id_propietario = ?');
        $query->execute([$id]);
        $propietario = $query->fetch(PDO::FETCH_ASSOC);
        return $propietario;
    }

    public function agregarPropietario($nombre, $telefono, $mail) {
        $query = $this->db->prepare('INSERT INTO propietarios (nombre, telefono, mail) VALUES (?, ?, ?)');
        $query->execute([$nombre, $telefono, $mail]);
    }

    public function filtrarPropietarios($filtros) {
        $sql = "SELECT * FROM propietarios WHERE 1=1";
        $params = [];

        if (!empty($filtros['nombre'])) {
            $sql .= " AND nombre LIKE ?";
            $params[] = '%' . $filtros['nombre'] . '%';
        }
        if (!empty($filtros['telefono'])) {
            $sql .= " AND telefono = ?";
            $params[] = $filtros['telefono'];
        }
        if (!empty($filtros['mail'])) {
            $sql .= " AND mail LIKE ?";
            $params[] = '%' . $filtros['mail'] . '%';
        }

        $query = $this->db->prepare($sql);
        $query->execute($params);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPropietariosPaginados($limite, $offset) {
        $sql = "SELECT * FROM propietarios LIMIT :limite OFFSET :offset";
        $query = $this->db->prepare($sql);

        $query->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $query->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarPropietarios() {
        $query = $this->db->prepare("SELECT COUNT(*) AS total FROM propietarios");
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        return (int)$row['total'];
    }
}