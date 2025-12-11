<?php

require_once __DIR__ . '/../config/database.php';

class Question
{
    private $conn;
    public $dion;

    public function __construct()
    {
        $this->conn = $dbConnection ?: getDBConnection();
    }

    public function findById(int $id)
    {
        $sql = "SELECT id, quiz_id, question_text, sort_order 
                FROM questions 
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function getQuestionsByQuiz(int $quizId)
    {
        $sql = "SELECT id, quiz_id, question_text, sort_order 
                FROM questions 
                WHERE quiz_id = ?
                ORDER BY sort_order ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $quizId);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function createQuestion(int $quizId, string $questionText, string $explanation = null)
    {
        $sql = "INSERT INTO questions (quiz_id, question_text, sort_order)
                VALUES (?, ?, ?)";

        // A simple ordering system: new items always come last
        $sortOrder = time();

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isi", $quizId, $questionText, $sortOrder);

        if (!$stmt->execute()) {
            return false;
        }

        return $this->conn->insert_id;
    }

    public function updateQuestion(int $questionId, string $questionText, string $explanation = null)
    {
        $sql = "UPDATE questions 
                SET question_text = ? 
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $questionText, $questionId);

        return $stmt->execute();
    }

    public function deleteQuestion(int $questionId)
    {
        $sql = "DELETE FROM questions WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $questionId);

        return $stmt->execute();
    }
}
