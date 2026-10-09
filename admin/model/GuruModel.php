<?php
class GuruModel {
    private $db;
    public function __construct($db) { $this->db = $db; }

    public function getAll() {
        return $this->db->query("SELECT * FROM dataguru");
    }

    public function getById($id) {
        return $this->db->query("SELECT * FROM dataguru WHERE id_guru=$id")->fetch_assoc();
    }

    public function insert($data) {
        $stmt = $this->db->prepare("INSERT INTO dataguru (nama_guru, email, password, jurusan) VALUES (?, ?, MD5(?), ?)");
        $stmt->bind_param("ssss", $data['nama_guru'], $data['email'], $data['password'], $data['jurusan']);
        return $stmt->execute();
    }

    public function update($id, $data) {
        if (!empty($data['password'])) {
            $stmt = $this->db->prepare("UPDATE dataguru SET nama_guru=?, email=?, password=MD5(?), jurusan=? WHERE id=?");
            $stmt->bind_param("ssssi", $data['nama_guru'], $data['email'], $data['password'], $data['jurusan'], $id);
        } else {
            $stmt = $this->db->prepare("UPDATE dataguru SET nama_guru=?, email=?, jurusan=? WHERE id_guru=?");
            $stmt->bind_param("sssi", $data['nama_guru'], $data['email'], $data['jurusan'], $id);
        }
        return $stmt->execute();
    }

    public function delete($id) {
        return $this->db->query("DELETE FROM dataguru WHERE id_guru=$id");
    }
}
?>
