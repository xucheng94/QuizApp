<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Subject.php';
require_once __DIR__ . '/../models/User.php';

class SubjectsController extends Controller
{
    public function showSubjects()
    {
        if (!isset($_GET['instructor_id'])) {
            echo "Instructor ID missing.";
            return;
        }

        $instructorId = (int)$_GET['instructor_id'];

        $userModel = new User();
        $subjectModel = new Subject();

        $instructor = $userModel->findById($instructorId);
        if (!$instructor || !$instructor['is_admin']) {
            echo "Instructor not found.";
            return;
        }

        $subjects = $subjectModel->getSubjectsByAdmin($instructorId);

        $this->view('subjects', [
            'instructor' => $instructor,
            'subjects' => $subjects,
            'pageTitle' => "Subjects by " . $instructor['first_name'],
            'pageCSS' => "/quiz_app/assets/css/subjects.css"
        ]);
    }
}
?>