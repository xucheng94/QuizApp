<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Quiz.php';
require_once __DIR__ . '/../models/Question.php';
require_once __DIR__ . '/../models/Subject.php';
require_once __DIR__ . '/../models/Answer_Option.php';
require_once __DIR__ . '/../models/QuizSession.php';
require_once __DIR__ . '/../models/QuizSessionAnswer.php';

class QuizController extends Controller
{
    public function showQuizPage()
    {
        if (!isset($_GET['quiz_id'])) {
            echo "Quiz ID missing.";
            return;
        }

        $userId = $_SESSION['user_id'] ?? null;
        $quizId = (int)$_GET['quiz_id'];

        $userModel = new User();
        $quizModel = new Quiz();
        $questionModel = new Question();
        $subjectModel = new Subject();


        $user = $userModel->findById($userId);
        $quiz = $quizModel->findById($quizId);
        $subject = $subjectModel->findById($quiz['subject_id']);
        if (!$quiz) {
            echo "Quiz not found.";
            return;
        }

        $questions = $questionModel->getQuestionsByQuiz($quizId);
        $questionCount = count($questions);

        if ($user['is_admin'] == 1) {
            //Admins go to manage page
            $this->view('manage_quiz', [
                'pageTitle' => 'Manage Quiz',
                'quiz'      => $quiz,
                'questions' => $questions,
            ]);
        }
        
        $this->view('quiz_page', [
            'user' => $user,
            'quiz' => $quiz,
            'questionCount' => $questionCount,
            'subject' => $subject
        ]);
    }

    public function startQuiz()
    {
        Auth::requireLogin();

        if (!isset($_GET['quiz_id'])) {
            echo "Quiz ID missing.";
            return;
        }

        $quizId = (int)$_GET['quiz_id'];

        $questionModel = new Question();
        $questions = $questionModel->getQuestionsByQuiz($quizId);

        if (empty($questions)) {
            echo "Quiz has no questions.";
            return;
        }

        $sessionModel = new QuizSession();
        $sessionId = $sessionModel->createInitialSession($_SESSION['user_id'], $quizId);

        // Reset quiz session data
        $_SESSION['quiz'][$quizId] = [
            'current_index' => 0,
            'answers' => [],
            'session_id' => $sessionId
        ];

        header("Location: /quiz_app/?route=quiz_take&quiz_id=".$quizId);
        exit;
    }

    public function takeQuiz()
    {
        Auth::requireLogin();

        if (!isset($_GET['quiz_id'])) {
        echo "Quiz ID missing.";
        return;
        }

        $quizId = (int)$_GET['quiz_id'];

        if (!isset($_SESSION['quiz'][$quizId])) {
            header("Location: /quiz_app/?route=quiz_start&quiz_id=".$quizId);
            exit;
        }

        $currentIndex = $_SESSION['quiz'][$quizId]['current_index'];

        $questionModel = new Question();
        $optionModel = new Option();

        $questions = $questionModel->getQuestionsByQuiz($quizId);

        if ($currentIndex >= count($questions)) {
            header("Location: /quiz_app/?route=quiz_submit&quiz_id=".$quizId);
            exit;
        }

        $question = $questions[$currentIndex];
        $options = $optionModel->getOptionsByQuestion($question['id']);

        $this->view('student_quiz_take', [
            'quizId' => $quizId,
            'question' => $question,
            'options' => $options,
            'currentIndex' => $currentIndex,
            'totalQuestions' => count($questions)
        ]);
    }

    public function processAnswer()
    {
        Auth::requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return;
    }

    $quizId = (int)$_POST['quiz_id'];
    $questionId = (int)$_POST['question_id'];
    $answerId = (int)$_POST['answer'];

    if (!isset($_SESSION['quiz'][$quizId])) {
        header("Location: /quiz_app/?route=quiz_start&quiz_id=".$quizId);
        exit;
    }

    $sessionId = $_SESSION['quiz'][$quizId]['session_id'];

    $optionModel = new Option();
    $sessionAnswerModel = new QuizSessionAnswer();

    $selectedOption = $optionModel->getOptionById($answerId);
    $isCorrect = ($selectedOption && $selectedOption['is_correct'] == 1);

    // --- Store answer in DB ---

    $sessionAnswerModel->recordAnswer(
        $sessionId,
        $questionId,
        $answerId,
        $isCorrect
    );

    $_SESSION['quiz'][$quizId]['answers'][$questionId] = $answerId;
    $_SESSION['quiz'][$quizId]['current_index']++;

    header("Location: /quiz_app/?route=quiz_take&quiz_id=".$quizId);
    exit;
}

    public function submitQuiz()
{
    Auth::requireLogin();

    if (!isset($_GET['quiz_id'])) {
        return;
    }

    $quizId = (int)$_GET['quiz_id'];

    // Make sure quiz session exists
    if (!isset($_SESSION['quiz'][$quizId])) {
        header("Location: /quiz_app/?route=quiz&quiz_id=".$quizId);
        exit;
    }

    $sessionId = $_SESSION['quiz'][$quizId]['session_id'];

    // --- Load models ---
    require_once __DIR__ . '/../models/QuizSession.php';
    require_once __DIR__ . '/../models/QuizSessionAnswer.php';

    $sessionModel = new QuizSession();
    $sessionAnswerModel = new QuizSessionAnswer();

    // --- Compute final score from DB ---
    $score = $sessionAnswerModel->countCorrect($sessionId);

    // --- Update final quiz session ---
    $sessionModel->completeSession($sessionId, $score);

    // --- Clean up memory ---
    unset($_SESSION['quiz'][$quizId]);

    // --- Redirect to results ---
    header("Location: /quiz_app/?route=quiz_result&session_id=" . $sessionId);
    exit;
}


public function showResultPage()
{
    if (!isset($_GET['session_id'])) {
        echo "Session ID missing.";
        return;
    }

    $sessionId = (int)$_GET['session_id'];

    require_once __DIR__ . '/../models/QuizSession.php';
    $sessionModel = new QuizSession();
    $quizModel = new Quiz();
    $questionModel = new Question();

    $session = $sessionModel->findById($sessionId);
    if (!$session) {
        echo "Session not found.";
        return;
    }

    $quiz = $quizModel->findById($session['quiz_id']);
    $questions = $questionModel->getQuestionsByQuiz($session['quiz_id']);
    $totalQuestions = count($questions);



    $this->view('quiz_result', [
        'session' => $session,
        'quiz' => $quiz,
        'totalQuestions' => $totalQuestions
    ]);
}

   

}
?>
