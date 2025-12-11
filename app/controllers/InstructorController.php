<?php

require_once __DIR__ . '/../core/Controller.php';

class InstructorController extends Controller
{
    public function showInstructors()
    {
        $userModel = $this->model('User');
        $instructors = $userModel->getInstructors();

        $this->view('instructors', [
            'instructors' => $instructors,
            'pageTitle' => "Instructors",
            'pageCSS' => "/quiz_app/assets/css/instructors.css"
        ]);
    }
}
?>