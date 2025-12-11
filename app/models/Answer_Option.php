<?php

require_once __DIR__ . '/../config/database.php';

class Option
{
    private $conn;

    public function __construct()
    {
        $this->conn = getDBConnection();
    }

    public function getOptionById(int $optionId)
    {
        $sql = "SELECT id, question_id, option_text, is_correct 
                FROM answer_options 
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $optionId);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function createOption(int $questionId, string $optionText, bool $isCorrect)
    {
        $sql = "INSERT INTO answer_options (question_id, option_text, is_correct)
                VALUES (?, ?, ?)";

        $correctInt = $isCorrect ? 1 : 0;

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isi", $questionId, $optionText, $correctInt);

        if (!$stmt->execute()) {
            return false;
        };

        return $this->conn->insert_id;
    }

    public function updateOption(int $optionId, string $optionText, bool $isCorrect)
    {
        $sql = "UPDATE answer_options 
                SET option_text = ?, is_correct = ? 
                WHERE id = ?";

        $correctInt = $isCorrect ? 1 : 0;

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sii", $optionText, $correctInt, $optionId);

        return $stmt->execute();
    }

    public function getOptionsByQuestion(int $questionId)
    {
        $sql = "
            SELECT id, question_id, option_text, is_correct
            FROM answer_options
            WHERE question_id = ?
            ORDER BY id ASC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $questionId);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function deleteOptionsByQuestion(int $questionId)
    {
        $sql = "DELETE FROM answer_options WHERE question_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $questionId);

        return $stmt->execute();
    }
}