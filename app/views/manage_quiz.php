<?php
$pageTitle = "Manage Quiz";
$pageCSS   = "/quiz_app/assets/css/manage.css";
include 'app/views/layouts/header.php';
?>

<section class="container">

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="/quiz_app/?route=manage">Manage</a>
        <span>/</span>
        <a href="/quiz_app/?route=manage_subject&subject_id=<?= (int)$subject['id'] ?>">
            <?= htmlspecialchars($subject['title']) ?>
        </a>
        <span>/</span>
        <span><?= htmlspecialchars($quiz['title']) ?></span>
    </nav>

    <h1 class="page-title"><?= htmlspecialchars($quiz['title']) ?></h1>
    <p class="sub">
        Difficulty: <strong><?= htmlspecialchars($quiz['difficulty']) ?></strong>
        <?php if (!empty($quiz['explanation'])): ?>
            <br><?= htmlspecialchars($quiz['explanation']) ?>
        <?php endif; ?>
    </p>

    <!-- ACTIONS -->
    <div class="toolbar">
        <a class="btn btn-primary" 
           href="/quiz_app/?route=manage_create_question&quiz_id=<?= (int)$quiz['id'] ?>">
            + Add Question
        </a>

        <a class="btn btn-light"
           href="/quiz_app/?route=manage_edit_quiz&quiz_id=<?= (int)$quiz['id'] ?>">
            Edit Quiz
        </a>

        <a class="btn btn-danger"
           href="/quiz_app/?route=manage_delete_quiz&quiz_id=<?= (int)$quiz['id'] ?>"
           onclick="return confirm('Are you sure you want to delete this quiz? This action is permanent.')">
            Delete Quiz
        </a>
    </div>

    <h2 style="margin-top: 2rem;">Questions</h2>

    <div class="questions-grid">
        <?php if (empty($questions)): ?>
            <p>No questions found for this quiz. Click “Add Question”.</p>
        <?php else: ?>
            <?php foreach ($questions as $q): ?>
                <div class="question-card">
                    <strong class="title">
                        <?= htmlspecialchars($q['question_text']) ?>
                    </strong>

                    <div class="q-actions">
                        <a class="btn btn-small btn-primary"
                           href="/quiz_app/?route=manage_question&question_id=<?= (int)$q['id'] ?>">
                           Manage
                        </a>

                        <a class="btn btn-small btn-light"
                           href="/quiz_app/?route=manage_edit_question&question_id=<?= (int)$q['id'] ?>">
                           Edit
                        </a>

                        <a class="btn btn-small btn-danger"
                           href="/quiz_app/?route=manage_delete_question&question_id=<?= (int)$q['id'] ?>&quiz_id=<?= (int)$quiz['id'] ?>"
                           onclick="return confirm('Delete this question? All options will also be removed.')">
                           Delete
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</section>

<?php include 'app/views/layouts/footer.php'; ?>



