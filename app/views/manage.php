<?php
$pageTitle = "Manage Quizzes";
$pageCSS   = "/quiz_app/assets/css/manage.css";
include 'app/views/layouts/header.php';
?>

<section class="container">
    <h1 class="page-title">Manage Quizzes</h1>
    <p class="sub">Select a category to manage its subjects and quizzes.</p>

    <div class="grid-3">
        <?php foreach ($categories as $cat): ?>
            <a class="category-card"
               href="/quiz_app/?route=manage_category&category_id=<?= (int)$cat['id'] ?>">
                <strong><?= htmlspecialchars($cat['title']) ?></strong>
                <p><?= htmlspecialchars($cat['description']) ?></p>
            </a>
        <?php endforeach; ?>
    </div>

</section>

<?php include 'app/views/layouts/footer.php'; ?>



