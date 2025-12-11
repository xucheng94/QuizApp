<?php

require_once __DIR__ . '/../config/database.php';

class Quiz
{
    private $conn;

    public function __construct()
    {
        $this->conn = getDBConnection();
    }

    public function getAllQuizzesWithSubject()
    {
        $sql = "SELECT q.id, q.title, q.subject_id, s.title AS subject_title
                FROM quizzes q
                JOIN subjects s ON q.subject_id = s.id
                ORDER BY q.sort_order ASC";

        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getQuizzesBySubject($subjectId)
    {
        $sql = "SELECT * FROM quizzes WHERE subject_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $subjectId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function findById($id)
    {
        $sql = "SELECT id, title, explanation, difficulty, sort_order, subject_id
                FROM quizzes
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function createQuiz($subjectId, $title, $difficulty, $explanation = "")
    {
        $sql = "INSERT INTO quizzes (subject_id, title, difficulty, explanation, sort_order)
            VALUES (?, ?, ?, ?, ?)";

        $sortOrder = time();

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isssi", $subjectId, $title, $difficulty, $explanation, $sortOrder);

        if (!$stmt->execute()) {
            return false;
        }

        return $this->conn->insert_id;
    }

    public function updateQuiz(int $quizId, string $title, string $difficulty, string $explanation)
    {
        $sql = "UPDATE quizzes 
             SET title = ?, difficulty = ?, explanation = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssi", $title, $difficulty, $explanation, $quizId);

        return $stmt->execute();
    }


    public function deleteQuiz($quizId)
    {
        $sql = "DELETE FROM quizzes WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $quizId);

        return $stmt->execute();
    }

}

?>