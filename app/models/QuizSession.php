<?php

require_once __DIR__ . '/../config/database.php';

class QuizSession
{
    private $conn;

    public function __construct()
    {
        $this->conn = getDBConnection();
    }

    public function createSession(int $userId, int $quizId, int $score)
    {
        $sql = "INSERT INTO quiz_sessions (user_id, quiz_id, score)
                VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $userId, $quizId, $score);
        $stmt->execute();

        return $this->conn->insert_id;
    }

    public function createInitialSession(int $userId, int $quizId)
    {
        $sql = "INSERT INTO quiz_sessions (user_id, quiz_id, score, session_status)
                VALUES (?, ?, 0, 'in_progress')";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $userId, $quizId);
        $stmt->execute();

        return $this->conn->insert_id;
    }

    public function completeSession(int $sessionId, int $score)
    {
        $sql = "UPDATE quiz_sessions
                SET score = ?, session_status = 'completed'
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $score, $sessionId);
        return $stmt->execute();
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM quiz_sessions WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>