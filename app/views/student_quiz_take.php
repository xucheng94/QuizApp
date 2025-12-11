<?php
$pageTitle = "Question ".($currentIndex+1)." of ".$totalQuestions;
$pageCSS   = "/quiz_app/assets/css/quiz.css";
include 'app/views/layouts/header.php';
?>

<section class="container">

    <h2 class="page-title">Question <?= $currentIndex+1 ?> of <?= $totalQuestions ?></h2>

    <p class="question-text">
        <?= htmlspecialchars($question['question_text']) ?>
    </p>

    <form method="POST" action="/quiz_app/?route=quiz_take_process">
        <input type="hidden" name="quiz_id" value="<?= $quizId ?>">
        <input type="hidden" name="question_id" value="<?= $question['id'] ?>">

        <?php foreach ($options as $o): ?>
            <div class="option">
                <label>
                    <input type="radio" name="answer" value="<?= $o['id'] ?>" required>
                    <?= htmlspecialchars($o['option_text']) ?>
                </label>
            </div>
        <?php endforeach; ?>

        <button class="btn btn-primary">
            <?= ($currentIndex+1 == $totalQuestions) ? "Submit Quiz" : "Next" ?>
        </button>
    </form>

</section>

<?php include 'app/views/layouts/footer.php'; ?>
