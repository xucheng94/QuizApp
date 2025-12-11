<?php
$pageTitle = htmlspecialchars($subject['title']) . " — Quizzes";
$pageCSS   = "/quiz_app/assets/css/quizzes.css";
include 'app/views/layouts/header.php';
?>

<section class="container">

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="/quiz_app/">Home</a>
        <span>/</span>
        <a href="/quiz_app/?route=categories">Categories</a>
        <span>/</span>
        <span><?= htmlspecialchars($subject['title']) ?></span>
    </nav>

    <h1 class="page-title"><?= htmlspecialchars($subject['title']) ?> — Quizzes</h1>
    <p class="sub">Choose a quiz to begin.</p>

    <!-- Student-side “Add Quiz” link should NOT appear -->
    <!-- Only admins see the create quiz button -->
    <?php if (!empty($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
        <div class="toolbar">
            <a class="btn btn-primary"
               href="/quiz_app/?route=manage_create_quiz&subject_id=<?= (int)$subject['id'] ?>">
                + New Quiz
            </a>
        </div>
    <?php endif; ?>

    <div class="quizzes-grid">
        <?php if (empty($quizzes)): ?>
            <p>No quizzes available yet for this subject.</p>
        <?php else: ?>
            <?php foreach ($quizzes as $quiz): ?>
                <a class="quiz-card"
                   href="/quiz_app/?route=quiz&quiz_id=<?= (int)$quiz['id'] ?>">
                    
                    <strong class="title"><?= htmlspecialchars($quiz['title']) ?></strong>

                    <p class="meta">
                        Difficulty: <?= htmlspecialchars($quiz['difficulty']) ?>
                    </p>

                    <?php if (!empty($quiz['explanation'])): ?>
                        <p class="details"><?= htmlspecialchars($quiz['explanation']) ?></p>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</section>

<?php include 'app/views/layouts/footer.php'; ?>


