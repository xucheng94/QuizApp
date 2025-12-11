<?php
$pageTitle = "Quiz Result";
$pageCSS   = "/quiz_app/assets/css/quiz.css";
include 'app/views/layouts/header.php';
?>

<section class="container">

    <h1 class="page-title">
        <?= htmlspecialchars($quiz['title']) ?> — Result
    </h1>

    <div class="result-card">
        <p class="sub">
            You completed this quiz!
        </p>

        <div class="score-box">
            <strong>Score:</strong>
            <span class="score-value"><?= $session['score'] ?> / <?= $totalQuestions ?></span>
        </div>

        <div class="score-percentage">
            <?php
                $percentage = ($totalQuestions > 0)
                    ? round(($session['score'] / $totalQuestions) * 100)
                    : 0;
            ?>
            <p><strong>Percentage:</strong> <?= $percentage ?>%</p>
        </div>

        <div class="result-actions">
            <a class="btn btn-primary" href="/quiz_app/?route=categories">Back to Quizzes</a>
            <a class="btn btn-light" href="/quiz_app/?route=quiz&quiz_id=<?= (int)$quiz['id'] ?>">
                Retake Quiz
            </a>
        </div>
    </div>

</section>

<?php include 'app/views/layouts/footer.php'; ?>
