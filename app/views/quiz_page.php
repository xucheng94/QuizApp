<?php
$pageTitle = htmlspecialchars($quiz['title']);
$pageCSS   = "/quiz_app/assets/css/quiz.css";
include 'app/views/layouts/header.php';
?>

<section class="container">

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="/quiz_app/">Home</a>
        <span>/</span>
        <a href="/quiz_app/?route=subject_quizzes&subject_id=<?= (int)$quiz['subject_id'] ?>">
            <?= htmlspecialchars($subject['title']) ?>
        </a>
        <span>/</span>
        <span><?= htmlspecialchars($quiz['title']) ?></span>
    </nav>

    <!-- Title -->
    <h1 class="page-title"><?= htmlspecialchars($quiz['title']) ?></h1>

    <!-- Explanation -->
    <?php if (!empty($quiz['explanation'])): ?>
        <p class="sub"><?= nl2br(htmlspecialchars($quiz['explanation'])) ?></p>
    <?php else: ?>
        <p class="sub">This quiz contains <?= $questionCount ?> questions.</p>
    <?php endif; ?>

    <!-- Metadata -->
    <div class="quiz-meta">
        <p><strong>Difficulty:</strong> <?= htmlspecialchars($quiz['difficulty']) ?></p>
        <p><strong>Total Questions:</strong> <?= $questionCount ?></p>
    </div>

    <!-- Actions -->
    <div class="quiz-actions">
        
        <!-- Admin-only button -->
        <?php if (!empty($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
            <a class="btn btn-secondary" 
               href="/quiz_app/?route=manage_quiz&quiz_id=<?= (int)$quiz['id'] ?>">
                Manage Quiz
            </a>
        <?php endif; ?>

        <!-- Start Quiz -->
        <a class="btn btn-primary" 
           href="/quiz_app/?route=quiz_start&quiz_id=<?= (int)$quiz['id'] ?>">
            Start Quiz
        </a>
    </div>

</section>

<?php include 'app/views/layouts/footer.php'; ?>

