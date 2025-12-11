<?php
$pageTitle = "Manage Subject";
$pageCSS   = "/quiz_app/assets/css/manage.css";
include 'app/views/layouts/header.php';
?>

<section class="container">

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="/quiz_app/?route=manage">Manage</a>
        <span>/</span>

        <a href="/quiz_app/?route=manage_category&category_id=<?= (int)$category['id'] ?>">
            <?= htmlspecialchars($category['title']) ?>
        </a>
        <span>/</span>

        <span><?= htmlspecialchars($subject['title']) ?></span>
    </nav>

    <h1 class="page-title"><?= htmlspecialchars($subject['title']) ?></h1>
    <p class="sub">Quizzes under this subject.</p>

    <div class="toolbar">
        <a class="btn btn-primary" 
           href="/quiz_app/?route=manage_create_quiz&subject_id=<?= (int)$subject['id'] ?>">
           + New Quiz
        </a>
    </div>

    <div class="quizzes-grid">
        <?php if (empty($quizzes)): ?>
            <p>No quizzes yet. Click "New Quiz" to create one.</p>
        <?php else: ?>
            <?php foreach ($quizzes as $quiz): ?>
                <a 
                  class="quiz-card"
                  href="/quiz_app/?route=manage_quiz&quiz_id=<?= (int)$quiz['id'] ?>"
                >
                    <strong class="title"><?= htmlspecialchars($quiz['title']) ?></strong>

                    <?php if (!empty($quiz['difficulty'])): ?>
                        <p class="meta">Difficulty: <?= htmlspecialchars($quiz['difficulty']) ?></p>
                    <?php endif; ?>

                    <?php if (!empty($quiz['explanation'])): ?>
                        <p class="details"><?= htmlspecialchars($quiz['explanation']) ?></p>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</section>

<?php include 'app/views/layouts/footer.php'; ?>

