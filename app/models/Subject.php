<?php

require_once __DIR__ . '/../config/database.php';

class Subject
{
    private $conn;

    public function __construct()
    {
        $this->conn = getDBConnection();
    }

    /**
     * Fetch ALL subjects (used for global listing)
     */
    public function getAllSubjects()
    {
        $sql = "SELECT id, title FROM subjects ORDER BY sort_order ASC";
        $result = $this->conn->query($sql);

        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    /**
     * Fetch subjects belonging to a specific admin
     */

    public function findById($id)
    {
        $sql = "SELECT id, title, subject_details, category_id
                FROM subjects
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function createSubject($adminId, $title, $details = '')
    {
        $sql = "INSERT INTO subjects (user_id, title, subject_details, sort_order)
                VALUES (?, ?, ?, ?)";

        // A simple ordering system: new items always come last
        $sortOrder = time();

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("issi", $adminId, $title, $details, $sortOrder);

        return $stmt->execute();
    }

    public function getSubjectsByCategory($categoryId)
    {
        $sql = "SELECT id, title, category_id, subject_details, sort_order 
                FROM subjects 
                WHERE category_id = ? 
                ORDER BY sort_order ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
}

?>
