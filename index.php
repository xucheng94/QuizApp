<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// Load base controller class
require_once __DIR__ . '/app/core/Controller.php';

// Determine route
$route = $_GET['route'] ?? 'home';

switch ($route) {

    /* ============================
       HOME PAGE
       ============================ */
    case 'home':
        require_once __DIR__ . '/app/controllers/HomeController.php';
        $controller = new HomeController();
        $controller->showHomePage();
        break;


    /* ============================
       LOGIN (GET + POST)
       ============================ */
    case 'login':
        require_once __DIR__ . '/app/controllers/AuthController.php';
        $controller = new AuthController();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->login();
        } else {
            $controller->showLoginPage();
        }
        break;


    /* ============================
       REGISTER (GET + POST)
       ============================ */
    case 'register':
        require_once __DIR__ . '/app/controllers/AuthController.php';
        $controller = new AuthController();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->register();
        } else {
            $controller->showRegisterPage();
        }
        break;


    /* ============================
       LOGOUT
       ============================ */
    case 'logout':
        require_once __DIR__ . '/app/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;


    /* ============================
       QUIZZES, QUIZ, RESULTS, ETC.
       (You will refine these later)
       ============================ */
    case 'instructors':
        require_once __DIR__ . '/app/controllers/InstructorController.php';
        $controller = new InstructorController();
        $controller->showInstructors();
        break;
    
    case 'category':
        require_once __DIR__ . '/app/controllers/CategoryController.php';
        $controller = new CategoryController();
        $controller->showCategory();
        break;

    case 'categories':
        require_once __DIR__ . '/app/controllers/CategoryController.php';
        $controller = new CategoryController();
        $controller->showCategories();
        break;

    case 'manage_category':
        require_once __DIR__ . '/app/controllers/CategoryController.php';
        $controller = new CategoryController();
        $controller->showCategory();
        break;

    case 'subjects':
        require_once __DIR__ . '/app/controllers/SubjectsController.php';
        $controller = new SubjectsController();
        $controller->showSubjects();
        break;

    case 'subject_quizzes':
        require_once __DIR__ . '/app/controllers/CategoryController.php';
        $controller = new CategoryController();
        $controller->showSubjectQuizzes();
        break;

    case 'api_quizzes':
        require_once __DIR__ . '/app/controllers/QuizApiController.php';
        $controller = new QuizzesController();
        $controller->getQuizzesAPI();
        break;

    case 'quiz':
        require_once __DIR__ . '/app/controllers/QuizController.php';
        $controller = new QuizController();
        $controller->showQuizPage();
        break;

    case 'result':
        require_once __DIR__ . '/app/controllers/ResultController.php';
        $controller = new ResultController();
        $controller->showResultPage();
        break;

    case 'show_result':
        require_once __DIR__ . '/app/controllers/ShowResultController.php';
        $controller = new ShowResultController();
        $controller->showAllResults();
        break;

    /* ============================
       MANAGE (ADMIN/TEACHER ONLY)
       ============================ */
    case 'manage':
        require_once __DIR__ . '/app/controllers/ManageController.php';
        $controller = new ManageController();
        $controller->showManagePage();
        break;

    case 'manage_subject':
        require 'app/controllers/ManageController.php';
        $controller = new ManageController();
        $controller->showSubjectPage();
        break;

    case 'manage_quiz':
        require 'app/controllers/ManageController.php';
        $controller = new ManageController();
        $controller->showQuizPage();
        break;

    case 'manage_question':
        require 'app/controllers/ManageController.php';
        $controller = new ManageController();
        $controller->showQuestionPage();
        break;

    case 'manage_edit_question':
        require 'app/controllers/ManageController.php';
        $controller = new ManageController();
        $controller->showEditQuestionPage();
        break;

    // GET show create subject form    
    case 'manage_create_subject':
        require_once __DIR__ . '/app/controllers/ManageController.php';
        $controller = new ManageController();
        $controller->showCreateSubjectPage();
        break;
    
    // POST store new subject
    
    case 'manage_store_subject':
        require_once __DIR__ . '/app/controllers/ManageController.php';
        $controller = new ManageController();
        $controller->storeSubject();
        break;

    case 'manage_delete_subject':
        require_once __DIR__ . '/app/controllers/ManageController.php';
        $controller = new ManageController();
        $controller->deleteSubject();
        break;

    // GET show create quiz form

    case 'manage_create_quiz':
        require_once __DIR__ . '/app/controllers/ManageController.php';
        $controller = new ManageController();
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->storeQuiz();    // <-- CREATE quiz
    } else {
        $controller->showCreateQuizPage(); // <-- SHOW form
    }
    break;

    case 'manage_edit_quiz':
        require_once __DIR__ . '/app/controllers/ManageController.php';
        $controller = new ManageController();
        $controller->showEditQuizPage();
        break;

    case 'manage_update_quiz':
        require_once __DIR__ . '/app/controllers/ManageController.php';
        $controller = new ManageController();
        $controller->updateQuiz();
        break;

    // POST store new quiz

    // case 'manage_store_quiz':
    //     require_once __DIR__ . '/app/controllers/ManageController.php';
    //     $controller = new ManageController();
    //     $controller->storeQuiz();
    //     break;

    case 'manage_create_question':
        require_once __DIR__ . '/app/controllers/ManageController.php';
        $controller = new ManageController();
        $controller->showCreateQuestionPage();
        break;

    case 'manage_store_question':
        require_once __DIR__ . '/app/controllers/ManageController.php';
        $controller = new ManageController();
        $controller->storeQuestion();
        break;

    case 'manage_update_question':
        require_once __DIR__ . '/app/controllers/ManageController.php';
        $controller = new ManageController();
        $controller->updateQuestion();
        break;

    case 'manage_delete_question':
        require_once __DIR__ . '/app/controllers/ManageController.php';
        $controller = new ManageController();
        $controller->deleteQuestion();
        break;

    /* ===============================
        STUDENT QUIZ PAGE
       =============================== */

    case 'quiz';
        require_once __DIR__ . '/app/controllers/QuizController.php';
        $controller = new QuizController();
        $controller->showQuizPage();
        break;

    case 'quiz_start';
        require_once __DIR__ . '/app/controllers/QuizController.php';
        $controller = new QuizController();
        $controller->startQuiz();
        break;

    case 'quiz_take';
        require_once __DIR__ . '/app/controllers/QuizController.php';
        $controller = new QuizController();
        $controller->takeQuiz();
        break;

    case 'quiz_take_process';
        require_once __DIR__ . '/app/controllers/QuizController.php';
        $controller = new QuizController();
        $controller->processAnswer();
        break;

    case 'quiz_submit';
        require_once __DIR__ . '/app/controllers/QuizController.php';
        $controller = new QuizController();
        $controller->submitQuiz();
        break;

    case 'quiz_result';
        require_once __DIR__ . '/app/controllers/QuizController.php';
        $controller = new QuizController();
        $controller->showResultPage();
        break;



    /* ============================
       RANK PAGE
       ============================ */
    case 'rank':
        require_once __DIR__ . '/app/controllers/RankController.php';
        $controller = new RankController();
        $controller->showRankPage();
        break;


    /* ============================
       HELP PAGE
       ============================ */
    case 'help':
        require_once __DIR__ . '/app/controllers/HelpController.php';
        $controller = new HelpController();
        $controller->showHelpPage();
        break;


    /* ============================
       404
       ============================ */
    default:
        http_response_code(404);
        echo "404 Not Found";
        break;
}