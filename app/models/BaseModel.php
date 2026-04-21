<?php
class BaseModel {
    protected $pdo;
    protected $table;

    public function __construct($table) {
        global $pdo;
        $this->pdo = $pdo;
        $this->table = $table;
    }

    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function findBy($column, $value) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE $column = ?");
        $stmt->execute([$value]);
        return $stmt->fetch();
    }

    public function findAll() {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }

    public function insert($data) {
        $columns = implode(',', array_keys($data));
        $placeholders = str_repeat('?,', count($data) - 1) . '?';
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} ($columns) VALUES ($placeholders)");
        $stmt->execute(array_values($data));
        return $this->pdo->lastInsertId();
    }

    public function update($id, $data) {
        $set = implode('=?,', array_keys($data)) . '=?';
        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET $set WHERE id = ?");
        $stmt->execute(array_merge(array_values($data), [$id]));
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
    }
}
?>