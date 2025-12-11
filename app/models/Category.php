<?php

require_once __DIR__ . '/../config/database.php';

class Category
{
    private $conn;

    public function __construct()
    {
        $this->conn = getDBConnection();
    }

    public function findById(int $id)
    {
        $sql = "SELECT * FROM subject_categories WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getAllCategories()
    {
        $sql = "SELECT id, title, description FROM subject_categories ORDER BY id ASC";
        $result = $this->conn->query($sql);

        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
}


?>