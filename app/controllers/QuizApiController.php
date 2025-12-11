<?php

require_once __DIR__ . '/../models/Quiz.php';

class QuizApiController
{
    public function getQuizzes()
    {
        header("Content-Type: application/json");

        $quizModel = new Quiz();
        $rows = $quizModel->getAllQuizzesWithSubject();

        // Convert DB rows -> QUIZZES format expected by JS
        $formatted = array_map(function ($q) {
            return [
                "id"    => $q['id'],
                "title" => $q['title'],
                "qs"    => (int)$q['question_count'],
                "level" => $q['level'] ?? "Mixed",   // optional
                "cat"   => $q['subject_name'],
            ];
        }, $rows);

        echo json_encode($formatted);
    }
}

?>