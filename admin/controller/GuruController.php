<?php
include './model/GuruModel.php';
class GuruController {
    private $model;
    public function __construct($db) {
        $this->model = new GuruModel($db);
    }

    public function index() {
        $data = $this->model->getAll();
        include './view/guru_list.php';
    }

    public function create() {
        include './view/guru_form.php';
    }

    public function store($post) {
        $this->model->insert($post);
        header("Location: index.php?controller=guru");
    }

    public function edit($id) {
        $guru = $this->model->getById($id);
        include './view/guru_form.php';
    }

    public function update($id, $post) {
        $this->model->update($id, $post);
        header("Location: index.php?controller=guru");
    }

    public function delete($id) {
        $this->model->delete($id);
        header("Location: index.php?controller=guru");
    }
}
?>
