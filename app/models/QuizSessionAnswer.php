<?php

require_once __DIR__ . '/../config/database.php';

class QuizSessionAnswer
{
    private $conn;

    public function __construct()
    {
        $this->conn = getDBConnection();
    }

    /**
     * Record a student's answer for a question in a quiz session.
     * If the student changes their answer, overwrite the existing row.
     */
    public function recordAnswer(int $sessionId, int $questionId, int $selectedOptionId, bool $isCorrect)
    {
        // Check if an answer already exists for this question in this session
        $checkSql = "
            SELECT id FROM quiz_session_answers
            WHERE session_id = ? AND question_id = ?
            LIMIT 1
        ";
        
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bind_param("ii", $sessionId, $questionId);
        $checkStmt->execute();
        $existing = $checkStmt->get_result()->fetch_assoc();

        if ($existing) {
            // Update existing answer (overwrite logic)
            $updateSql = "
                UPDATE quiz_session_answers
                SET selected_option_id = ?, is_correct = ?, created_at = NOW()
                WHERE id = ?
            ";

            $isCorrectInt = $isCorrect ? 1 : 0;

            $updateStmt = $this->conn->prepare($updateSql);
            $updateStmt->bind_param("iii", $selectedOptionId, $isCorrectInt, $existing['id']);
            return $updateStmt->execute();
        }

        // Otherwise insert a new answer
        $insertSql = "
            INSERT INTO quiz_session_answers (session_id, question_id, selected_option_id, is_correct)
            VALUES (?, ?, ?, ?)
        ";

        $isCorrectInt = $isCorrect ? 1 : 0;

        $stmt = $this->conn->prepare($insertSql);
        $stmt->bind_param("iiii", $sessionId, $questionId, $selectedOptionId, $isCorrectInt);
        return $stmt->execute();
    }

    /**
     * Fetch all answers for a quiz session
     */
    public function getAnswersBySession(int $sessionId)
    {
        $sql = "
            SELECT 
                a.id,
                a.session_id,
                a.question_id,
                a.selected_option_id,
                a.is_correct,
                a.created_at,
                
                q.question_text,
                o.option_text AS selected_option_text

            FROM quiz_session_answers a
            JOIN questions q ON a.question_id = q.id
            JOIN answer_options o ON a.selected_option_id = o.id
            WHERE a.session_id = ?
            ORDER BY a.id ASC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $sessionId);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Count number of correct answers in a session
     */
    public function countCorrect(int $sessionId)
    {
        $sql = "
            SELECT COUNT(*) AS correct
            FROM quiz_session_answers
            WHERE session_id = ? AND is_correct = 1
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $sessionId);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();
        return (int)$result['correct'];
    }
}

?>
