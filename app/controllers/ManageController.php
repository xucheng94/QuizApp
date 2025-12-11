<?php

require_once __DIR__ . "/../core/Controller.php";  
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../models/Subject.php';
require_once __DIR__ . '/../models/Quiz.php';
require_once __DIR__ . '/../models/Question.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Answer_Option.php';

  class ManageController extends Controller {
    public function showManagePage() {

      Auth::requireAdmin();

      $categoryModel = new Category();
      $categories = $categoryModel->getAllCategories();

      $this->view("manage", [
        
        'categories' => $categories,
      ]);
    }

    public function showQuestionPage()
    {
      Auth::requireAdmin();

      if (!isset($_GET['question_id'])) {
        echo "Question ID missing.";
        return;
      }

      $adminId = $_SESSION['user_id'];
      $questionId = (int)$_GET['question_id'];

      $questionModel = new Question();
      $optionModel = new Option();
      $quizModel = new Quiz();
      $subjectModel = new Subject();

      $question = $questionModel->findById($questionId);

      

      $quiz = $quizModel->findById($question['quiz_id']);
      

      $subject = $subjectModel->findById($quiz['subject_id']);
      $options = $optionModel->getOptionsByQuestion($questionId);

      $this->view('manage_question', [
          'pageTitle' => 'Manage Question',
          'subject'   => $subject,
          'quiz'      => $quiz,
          'question'  => $question,
          'options'   => $options,
      ]);
    }

    public function showEditQuestionPage()
    {
      Auth::requireAdmin();

      if (!isset($_GET['question_id'])) {
        echo "Question ID missing.";
        return;
      }

      $adminId = $_SESSION['user_id'];
      $questionId = (int)$_GET['question_id'];

      $questionModel = new Question();
      $optionModel = new Option();
      $quizModel = new Quiz();
      $subjectModel = new Subject();

      $question = $questionModel->findById($questionId);

      

      $quiz = $quizModel->findById($question['quiz_id']);
      

      $subject = $subjectModel->findById($quiz['subject_id']);
      $options = $optionModel->getOptionsByQuestion($questionId);

      $this->view('manage_edit_question', [
          'pageTitle' => 'Edit Question',
          'subject'   => $subject,
          'quiz'      => $quiz,
          'question'  => $question,
          'options'   => $options,
        
      ]);
    }

    public function updateQuestion()
{
    Auth::requireAdmin();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: /quiz_app/?route=manage");
        exit;
    }

    $questionId = (int)($_POST['question_id'] ?? 0);
    $quizId     = (int)($_POST['quiz_id'] ?? 0);
    $questionText = trim($_POST['question_text'] ?? '');
    $explanation  = trim($_POST['explanation'] ?? '');

    // Validate base inputs
    if ($questionId === 0 || $quizId === 0 || $questionText === '') {
        echo "Invalid request: missing required fields.";
        return;
    }

    // Collect option text
    $options = [
        trim($_POST['option_1'] ?? ''),
        trim($_POST['option_2'] ?? ''),
        trim($_POST['option_3'] ?? ''),
        trim($_POST['option_4'] ?? ''),
    ];

    // Ensure all options have text
    foreach ($options as $opt) {
        if ($opt === '') {
            echo "All four options must contain text.";
            return;
        }
    }

    // Validate correct option
    $correct = (int)($_POST['correct_option'] ?? -1);
    if ($correct < 1 || $correct > 4) {
        echo "Please select a correct answer.";
        return;
    }

    // ======================================================
    // Retrieve required data
    // ======================================================

    $quizModel     = new Quiz();
    $questionModel = new Question();
    $optionModel   = new Option();
    $subjectModel  = new Subject();

    $quiz = $quizModel->findById($quizId);
    if (!$quiz) {
        echo "Quiz not found.";
        return;
    }

    $question = $questionModel->findById($questionId);
    if (!$question) {
        echo "Question not found.";
        return;
    }

    if ((int)$question['quiz_id'] !== $quizId) {
        echo "This question does not belong to the specified quiz.";
        return;
    }

    // ======================================================
    // Load all option records
    // ======================================================
    $existingOptions = $optionModel->getOptionsByQuestion($questionId);

    if (count($existingOptions) !== 4) {
        echo "Invalid option state. Each question must have 4 options.";
        return;
    }

    // ======================================================
    // Update QUESTION
    // ======================================================
    $ok = $questionModel->updateQuestion($questionId, $questionText, $explanation);
    if (!$ok) {
        echo "Failed to update question.";
        return;
    }

    // ======================================================
    // Update OPTIONS
    // ======================================================
    foreach ($existingOptions as $index => $optRecord) {
        $text = $options[$index];
        $isCorrect = ($index + 1) === $correct;

        $success = $optionModel->updateOption($optRecord['id'], $text, $isCorrect);

        if (!$success) {
            echo "Failed to update option #".($index + 1).".";
            return;
        }
    }

    // ======================================================
    // Redirect to quiz management page
    // ======================================================
    header("Location: /quiz_app/?route=manage_quiz&quiz_id={$quizId}&msg=question_updated");
    exit;
    }

    public function deleteQuiz()
    {
      Auth::requireAdmin();

      if (!isset($_GET['quiz_id'])) {
          echo "Quiz ID missing.";
          return;
      }

      $quizId = (int)$_GET['quiz_id'];
      if ($quizId <= 0) {
          echo "Invalid Quiz ID.";
          return;
      }

      $quizModel = new Quiz();
      $subjectModel = new Subject();

      // --- Verify quiz exists ---
      $quiz = $quizModel->findById($quizId);
      if (!$quiz) {
          echo "Quiz not found.";
          return;
      }

      // Get subject for redirect after delete
      $subject = $subjectModel->findById($quiz['subject_id']);
      if (!$subject) {
          echo "Subject not found.";
          return;
      }

      // --- Delete ---
      $deleted = $quizModel->deleteQuiz($quizId);
      if (!$deleted) {
          echo "Failed to delete quiz.";
          return;
      }

      header("Location: /quiz_app/?route=manage_subject&subject_id={$subject['id']}&msg=quiz_deleted");
      exit;
  }


    public function deleteQuestion()
    {
      Auth::requireAdmin();

      if (!isset($_GET['question_id']) || !isset($_GET['quiz_id'])) {
          echo "Missing parameters.";
          return;
      }

      $questionId = (int)$_GET['question_id'];
      $quizId     = (int)$_GET['quiz_id'];

      if ($questionId <= 0 || $quizId <= 0) {
          echo "Invalid request.";
          return;
      }

      $questionModel = new Question();
      $quizModel = new Quiz();

      // --- Validate quiz ---
      $quiz = $quizModel->findById($quizId);
      if (!$quiz) {
          echo "Quiz not found.";
          return;
      }

      // --- Validate question exists ---
      $question = $questionModel->findById($questionId);
      if (!$question) {
          echo "Question not found.";
          return;
      }

      // --- Validate question belongs to quiz ---
      if ((int)$question['quiz_id'] !== $quizId) {
          echo "Mismatch: this question does not belong to the specified quiz.";
          return;
      }

      // --- Delete question (options cascade automatically) ---
      $deleted = $questionModel->deleteQuestion($questionId);

      if (!$deleted) {
          echo "Failed to delete question.";
          return;
      }

      // Redirect with success message
      header("Location: /quiz_app/?route=manage_quiz&quiz_id={$quizId}&msg=question_deleted");
      exit;
    }

    public function showCategoryPage()
    {
      Auth::requireAdmin();

      if (!isset($_GET['category_id'])) {
        echo 'Category ID missing';
        return;
      }

      $adminId = $_SESSION['user_id'];
      $categoryId = (int)$_GET['category_id'];

      $categoryModel = new Category();
      $subjectModel = new Subject();

      $category = $categoryModel->findById($categoryId);

      if (!$category) {
        echo "Category not found.";
        return;
      }

      $subjects = $subjectModel->getSubjectsByCategory($categoryId);

      $this->view('manage_category', [
          'pageTitle' => 'Manage Category',
          'category'   => $category,
          'subjects'   => $subjects,
      ]);
    }

    // /?route=manage_subject&subject_id=123
    public function showSubjectPage()
    {
      Auth::requireAdmin();

      if (!isset($_GET['subject_id'])) {
        echo 'Subject ID missing';
        return;
      }

      $adminId = $_SESSION['user_id'];
      $subjectId = (int)$_GET['subject_id'];

      $subjectModel = new Subject();
      $quizModel = new Quiz();
      $categoryModel = new Category();

      $subject = $subjectModel->findById($subjectId);

      

      $category = $categoryModel->findById($subject['category_id']);

      $quizzes = $quizModel->getQuizzesBySubject($subjectId);

      $this->view('manage_subject', [
          'pageTitle' => 'Manage Subject',
          'subject'   => $subject,
          'category'  => $category,
          'quizzes'   => $quizzes,
      ]);
    }

    // ?route=manage_quiz&quizid=456
    public function showQuizPage()
    {
      Auth::requireAdmin();

      if (!isset($_GET['quiz_id'])) {
        echo "Quiz ID missing.";
        return;
      }

      $adminId = $_SESSION['user_id'];
      $quizId = (int)$_GET['quiz_id'];

      $quizModel = new Quiz();
      $subjectModel = new Subject();
      $questionModel = new Question();

      $quiz = $quizModel->findById($quizId);

      if (!$quiz) {
        echo "Quiz not found.";
        return;
      }

      // Enforce that this quiz belongs to a subject owned by this admin
      $subject = $subjectModel->findById($quiz['subject_id']);
      
      $questions = $questionModel->getQuestionsByQuiz($quizId);

      $this->view('manage_quiz', [
          'pageTitle' => 'Manage Quiz',
          'subject'   => $subject,
          'quiz'      => $quiz,
          'questions' => $questions,
      ]);
    }

    public function showCreateSubjectPage()
    {
      Auth::requireAdmin();

      $this->view('manage_create_subject', [
        'pageTitle' => 'Create Subject',
      ]);
    }

    public function showCreateQuizPage()
    {
      Auth::requireAdmin();

      if (!isset($_GET['subject_id'])) {
        echo "Subject ID missing.";
        return;
      }

      $subjectId = (int)$_GET['subject_id'];

      $subjectModel = new Subject();
      $subject = $subjectModel->findById($subjectId);

      $this->view('manage_create_quiz', [
        'pageTitle' => 'Create Quiz',
        'subject'   => $subject,
      ]);
    }

    public function showEditQuizPage()
{
    Auth::requireAdmin();

    // --- Validate quiz_id ---
    if (!isset($_GET['quiz_id']) || (int)$_GET['quiz_id'] <= 0) {
        echo "Quiz ID missing or invalid.";
        return;
    }

    $quizId = (int)$_GET['quiz_id'];

    // --- Load models ---
    $quizModel    = new Quiz();
    $subjectModel = new Subject();

    // --- Load quiz ---
    $quiz = $quizModel->findById($quizId);

    if (!$quiz) {
        echo "Quiz not found.";
        return;
    }

    // --- Load subject (for breadcrumb + consistency) ---
    $subject = $subjectModel->findById($quiz['subject_id']);

    if (!$subject) {
        echo "Subject not found for this quiz.";
        return;
    }

    // --- Render Edit Quiz Page ---
    $this->view('manage_edit_quiz', [
        'pageTitle' => "Edit Quiz — " . htmlspecialchars($quiz['title']),
        'quiz'      => $quiz,
        'subject'   => $subject,
    ]);
}


  //   public function storeSubject()
  //   {
  //     Auth::requireAdmin();

  //     if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  //       header("Location: /quiz_app/?route=manage");
  //       exit;
  //     }

  //     $title = trim($_POST['title'] ?? '');
  //     $details = trim($_POST['subject_details'] ?? '');
  //     $adminId = (int)$_SESSION['user_id'];

  //     if ($title === '') {
  //         echo "Title is required.";
  //         return;
  //     }

  //     $subjectModel = new Subject();
  //     $result = $subjectModel->createSubject($adminId, $title, $details);

  //     if ($result) {
  //         header("Location: /quiz_app/?route=manage&msg=subject_created");
  //         exit;
  //     } else {
  //         echo "Failed to create subject.";
  //     }
  //   }

    public function storeQuiz()
    {
      Auth::requireAdmin();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: /quiz_app/?route=manage");
        exit;
    }

      $subjectId = (int)($_POST['subject_id'] ?? 0);
      $title     = trim($_POST['title'] ?? '');
      $difficulty = trim($_POST['difficulty'] ?? '');
      $explanation = trim($_POST['explanation'] ?? '');

    if ($title === '') {
        echo "Quiz title is required.";
        return;
    }

    if (!in_array($difficulty, ['Beginner','Intermediate','Advanced','Mixed'])) {
        echo "Invalid difficulty.";
        return;
    }

    $subjectModel = new Subject();
    $subject = $subjectModel->findById($subjectId);

    

    $quizModel = new Quiz();
    $quizId = $quizModel->createQuiz($subjectId, $title, $difficulty, $explanation);

    if (!$quizId) {
      echo "Failed to create quiz.";
      return;
    }

    header("Location: /quiz_app/?route=manage_quiz&quiz_id=".$quizId);
    exit;
    }
    

    public function showCreateQuestionPage()
    {
      Auth::requireAdmin();

      if (!isset($_GET['quiz_id'])) {
        echo "Quiz ID missing.";
        return;
      }

      $quizId = (int)$_GET['quiz_id'];
      $adminId = $_SESSION['user_id'];

      $quizModel = new Quiz();
      $subjectModel = new Subject();

      $quiz = $quizModel->findById($quizId);

      if (!$quiz) {
        echo "Quiz not found.";
        return;
      }

      // verify admin owns the subject that owns this quiz
      $subject = $subjectModel->findById($quiz['subject_id']);


      $this->view('manage_create_question', [
        'pageTitle' => 'Create Question',
        'quiz'      => $quiz,
        'subject'   => $subject,
      ]);
    }

  //   public function storeQuestion()
  //   {
  //     Auth::requireAdmin();

  //     if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  //         header("Location: /quiz_app/?route=manage");
  //         exit;
  //     }

  //     $quizId = (int)($_POST['quiz_id'] ?? 0);
  //     $questionText = trim($_POST['question_text'] ?? '');
  //     $explanation  = trim($_POST['explanation'] ?? '');

  //      // 4 options
  //     $options = [
  //         trim($_POST['options'] ?? ''),
  //         trim($_POST['options'] ?? ''),
  //         trim($_POST['options'] ?? ''),
  //         trim($_POST['options'] ?? ''),
  //     ];

  //     $correctOptionIndex = (int)($_POST['correct_option'] ?? -1);

  //     if ($questionText === '') {
  //         echo "Question text is required.";
  //         return;
  //     }

  //     // Ensure all 4 options have text
  //     foreach ($options as $opt) {
  //         if ($opt === '') {
  //             echo "All four option fields must be filled.";
  //             return;
  //         }
  //     }

  //     // Ensure a correct option is selected
  //     if ($correctOptionIndex < 1 || $correctOptionIndex > 4) {
  //         echo "Please select the correct answer.";
  //         return;
  //     }

  //     $quizModel = new Quiz();
  //     $quiz = $quizModel->findById($quizId);

  //     if (!$quiz) {
  //         echo "Quiz not found.";
  //         return;
  //     }


  //     $questionModel = new Question();
  //     $questionId = $questionModel->createQuestion($quizId, $questionText, $explanation);

  //     if (!$questionId || !is_int($questionId)) {
  //       echo "Failed to create question.";
  //       return;
  //     }

  //     // INSERT OPTIONS
  //     require_once __DIR__ . '/../models/Answer_Option.php';
  //     $optionModel = new Option();

  //     foreach ($options as $index => $text) {
  //         $isCorrect = ($index + 1) === $correctOptionIndex;
  //         $optionId = $optionModel->createOption($questionId, $text, $isCorrect);

  //         //Rollback conditional

  //         if (!$optionId) {
  //             echo "Failed to create answer options.";
  //             return;
  //         } 
  //     }

  //     header("Location: /quiz_app/?route=manage_quiz&quiz_id=".$quizId."&msg=question_created");
  //     exit;

  // }

  public function storeQuestion()
{
    Auth::requireAdmin();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: /quiz_app/?route=manage");
        exit;
    }

    // === Sanitize and extract inputs ===
    $quizId       = (int)($_POST['quiz_id'] ?? 0);
    $questionText = trim($_POST['question_text'] ?? '');
    $explanation  = trim($_POST['explanation'] ?? '');
    $correctIndex = (int)($_POST['correct_option'] ?? -1);

    // === Basic validation ===
    if ($quizId <= 0) {
        echo "Invalid quiz ID.";
        return;
    }

    if ($questionText === '') {
        echo "Question text is required.";
        return;
    }

    if ($correctIndex < 1 || $correctIndex > 4) {
        echo "Please select a valid correct option.";
        return;
    }

    // === Extract options safely ===
    $options = [];

    if (!isset($_POST['options']) || !is_array($_POST['options'])) {
        echo "Options data missing or malformed.";
        return;
    }

    foreach ($_POST['options'] as $index => $optionData) {
        if (!is_numeric($index)) {
            echo "Invalid option index detected.";
            return;
        }

        $text = trim($optionData['text'] ?? '');

        if ($text === '') {
            echo "All four options must be filled.";
            return;
        }

        $options[(int)$index] = $text;
    }

    if (count($options) !== 4) {
        echo "Exactly 4 answer options are required.";
        return;
    }

    // === Confirm quiz exists ===
    $quizModel = new Quiz();
    $quiz = $quizModel->findById($quizId);

    if (!$quiz) {
        echo "Quiz not found.";
        return;
    }

    // === Models ===
    $questionModel = new Question();
    require_once __DIR__ . '/../models/Answer_Option.php';
    $optionModel = new Option();

    // === Database Transaction ===
    // $conn = $questionModel->conn;  // ensure model exposes DB connection

    // $conn->begin_transaction();

    try {

        // --- Insert Question ---
        $questionId = $questionModel->createQuestion($quizId, $questionText, $explanation);

        if (!$questionId || !is_int($questionId)) {
            throw new Exception("Failed to insert question.");
        }

        // --- Insert Options ---
        foreach ($options as $index => $text) {
            $isCorrect = ($index === $correctIndex);

            $optionId = $optionModel->createOption($questionId, $text, $isCorrect);

            if (!$optionId) {
                throw new Exception("Failed inserting answer options.");
            }
        }

        // ✅ All good — commit transaction
       

        header("Location: /quiz_app/?route=manage_quiz&quiz_id=" . $quizId . "&msg=question_created");
        exit;

    } catch (Exception $e) {

        // ❌ Something failed — rollback
       

        error_log("Question creation failed: " . $e->getMessage());

        echo "An error occurred while creating the question. Please try again.";
        return;
    }
}


  public function showEditQuizForm()
  {
      Auth::requireAdmin();

      if (!isset($_GET['quiz_id'])) {
          echo "Quiz ID missing.";
          return;
      }

      $quizId = (int)$_GET['quiz_id'];

      $quizModel = new Quiz();
      $subjectModel = new Subject();

      $quiz = $quizModel->findById($quizId);
      if (!$quiz) {
          echo "Quiz not found.";
          return;
      }

      $subject = $subjectModel->findById($quiz['subject_id']);

      $this->view('manage_edit_quiz', [
          'pageTitle' => 'Edit Quiz',
          'quiz'      => $quiz,
          'subject'   => $subject
      ]);
  }

  public function updateQuiz()
  {
      Auth::requireAdmin();

      if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
          header("Location: /quiz_app/?route=manage");
          exit;
      }

      $quizId      = (int)($_POST['quiz_id'] ?? 0);
      $title       = trim($_POST['title'] ?? '');
      $difficulty  = trim($_POST['difficulty'] ?? 'Mixed');
      $explanation = trim($_POST['explanation'] ?? '');

      if ($quizId <= 0 || $title === '') {
          echo "Invalid input.";
          return;
      }

      $quizModel = new Quiz();
      $quiz = $quizModel->findById($quizId);

      if (!$quiz) {
          echo "Quiz not found.";
          return;
      }

      $updated = $quizModel->updateQuiz($quizId, $title, $difficulty, $explanation);

      if (!$updated) {
          echo "Failed to update quiz.";
          return;
      }

      header("Location: /quiz_app/?route=manage_quiz&quiz_id=".$quizId."&msg=quiz_updated");
      exit;
  }



  private function getLastInsertId()
  {
      $db = getDBConnection();
      return $db->insert_id;
  }
}

?>