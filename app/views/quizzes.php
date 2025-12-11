<?php
$pageTitle = $pageTitle ?? "Quizzes";
$pageCSS   = "/quiz_app/assets/css/quizzes.css";
$pageJS    = "/quiz_app/assets/js/quizzes.js";
include 'app/views/layouts/header.php';
?>

<section class="container">
    <?php if ($mode === 'browse'): ?>

        <h1>Browse All Quizzes</h1>
        <p class="sub">Search across all quizzes in the system.</p>

        <div class="search">
            <input id="q" placeholder="Search quizzes…">
            <span>🔎</span>
        </div>

        <div class="pills">
            <span class="pill" data-cat="All">All</span>
            <span class="pill" data-cat="Math">Math</span>
            <span class="pill" data-cat="Science">Science</span>
            <span class="pill" data-cat="History">History</span>
        </div>

        <div id="list" class="grid"></div>

    <?php else: ?>

        <h1><?= htmlspecialchars($subject['title']) ?></h1>
        <p class="sub">Quizzes for this subject.</p>

        <div class="grid subject-mode-list">
            <?php foreach ($quizzes as $quiz): ?>
                <a 
                  class="card"
                  href="/quiz_app/?route=quiz&quiz_id=<?= (int)$quiz['id'] ?>"
                >
                    <img 
                        src="https://via.placeholder.com/800x360?text=<?= urlencode($quiz['difficulty']) ?>" 
                        alt=""
                    >
                    <strong><?= htmlspecialchars($quiz['title']) ?></strong>
                    <div class="meta">
                        <span><?= (int)$quiz['sort_order'] ?> Questions?</span>
                        <span><?= htmlspecialchars($quiz['difficulty']) ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</section>

<?php include 'app/views/layouts/footer.php'; ?>

