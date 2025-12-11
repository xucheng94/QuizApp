<?php
$pageTitle = "Manage Question";
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
        <a href="/quiz_app/?route=manage_quiz&quiz_id=<?= (int)$quiz['id'] ?>">
            <?= htmlspecialchars($quiz['title']) ?>
        </a>
        <span>/</span>
        <span>Manage Question</span>
    </nav>

    <h1 class="page-title">Manage Question</h1>

    <!-- QUESTION BLOCK -->
    <div class="question-card">
        <h2 style="margin:0 0 10px"><?= htmlspecialchars($question['question_text']) ?></h2>

        <div class="q-actions">
            <a class="btn btn-primary btn-small"
               href="/quiz_app/?route=manage_edit_question&question_id=<?= (int)$question['id'] ?>">
                Edit Question
            </a>

            <a class="btn btn-danger btn-small"
               href="/quiz_app/?route=manage_delete_question&question_id=<?= (int)$question['id'] ?>&quiz_id=<?= (int)$quiz['id'] ?>"
               onclick="return confirm('Are you sure you want to delete this question and all its options?');">
                Delete Question
            </a>
        </div>
    </div>


    <!-- OPTIONS SECTION -->
    <h2 style="margin-top: 2rem;">Answer Options</h2>

    <div class="options-grid">
        <?php if (empty($options)): ?>
            <p>No answer options yet. Click “Add Option”.</p>

        <?php else: ?>
            <?php foreach ($options as $opt): ?>
                <div class="option-card">

                    <strong class="text"><?= htmlspecialchars($opt['option_text']) ?></strong>

                    <?php if ($opt['is_correct']): ?>
                        <span class="badge-correct">Correct Answer</span>
                    <?php endif; ?>

                    <div class="opt-actions">
                        <a class="btn btn-small btn-light"
                           href="/quiz_app/?route=manage_edit_option&option_id=<?= (int)$opt['id'] ?>">
                            Edit
                        </a>

                        <a class="btn btn-small btn-danger"
                           href="/quiz_app/?route=manage_delete_option&option_id=<?= (int)$opt['id'] ?>"
                           onclick="return confirm('Delete this option?');">
                            Delete
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</section>

<?php include 'app/views/layouts/footer.php'; ?>
