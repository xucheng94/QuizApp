<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Subject.php';
require_once __DIR__ . '/../models/Quiz.php';

class CategoryController extends Controller
{
    public function showCategory()
    {
        if (!isset($_GET['category_id'])) {
            echo "Category ID missing.";
            return;
        }

        $categoryId = (int)$_GET['category_id'];

        $categoryModel = new Category();
        $subjectModel = new Subject();

        $category = $categoryModel->findById($categoryId);
        if (!$category) {
            echo "Category not found.";
            return;
        }

        $subjects = $subjectModel->getSubjectsByCategory($categoryId);

        $this->view('category_page', [
            'category' => $category,
            'subjects' => $subjects,
            'pageTitle' => $category['title'] . " — Subjects"
        ]);
    }

    public function showCategories()
    {
        $categoryModel = new Category();
        $categories = $categoryModel->getAllCategories();

        $this->view('categories', [
            'categories' => $categories,
            'pageTitle' => "Categories",
            'pageCSS'   => "/quiz_app/assets/css/categories.css",
            'pageJS'    => "/quiz_app/assets/js/categories.js"
        ]);
    }   

    public function showSubjectQuizzes()
    {
        if (!isset($_GET['subject_id'])) {
            echo "Subject ID missing.";
            return;
        }

        $subjectId = (int)$_GET['subject_id'];

        $subjectModel = new Subject();
        $quizModel = new Quiz();

        $subject = $subjectModel->findById($subjectId);
        if (!$subject) {
            echo "Subject not found.";
            return;
        }

        $quizzes = $quizModel->getQuizzesBySubject($subjectId);

        $this->view('subject_quizzes', [
            'subject' => $subject,
            'quizzes' => $quizzes,
            'pageTitle' => $subject['title'] . " — Quizzes" 
        ]);
    }
}

?>