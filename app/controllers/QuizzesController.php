<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../models/Quiz.php';
require_once __DIR__ . '/../models/Question.php';
require_once __DIR__ . '/../models/Subject.php';
require_once __DIR__ . '/../models/Answer_Option.php';
require_once __DIR__ . '/../models/QuizSession.php';
require_once __DIR__ . '/../models/QuizSessionAnswer.php';
require_once __DIR__ . '/../models/Category.php';

class QuizzesController extends Controller
{
   public function showQuizzesPage()
{
    $subjectId = $_GET['subject_id'] ?? null;

    // If subject filter exists → load quizzes for that subject
    if ($subjectId !== null) {

        $quizModel = new Quiz();
        $subjectModel = new Subject();

        // Load subject info
        $subject = $subjectModel->findById($subjectId);
        if (!$subject) {
            http_response_code(404);
            echo "Subject not found.";
            return;
        }

        // Load quizzes under this subject
        $quizzes = $quizModel->getQuizzesBySubject($subjectId);

        // Render SUBJECT QUIZZES PAGE
        $this->view('subject_quizzes', [
            'subject'   => $subject,
            'quizzes'   => $quizzes,
            'pageTitle' => $subject['title'] . " — Quizzes",
            'pageCSS'   => "/quiz_app/assets/css/quizzes.css",
            'pageJS'    => "/quiz_app/assets/js/quizzes.js"
        ]);

        return;
    }

    // Default: show ALL quizzes page
    $quizModel = new Quiz();
    $quizzes = $quizModel->getAllQuizzesWithSubjects();

    $categoryModel = new Category();
   

    $this->view('quizzes', [
        'quizzes' => $quizzes,
        'pageTitle' => "All Quizzes",
        'pageCSS' => "/quiz_app/assets/css/quizzes.css",
        'pageJS'  => "/quiz_app/assets/js/quizzes.js"
    ]);
}

}

?>