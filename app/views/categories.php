<?php
$pageTitle = "Categories";
$pageCSS   = "/quiz_app/assets/css/categories.css";
include 'app/views/layouts/header.php';
?>

<section class="hero">
    <div class="container">
        <h1>Categories</h1>
        <p class="sub">Choose a category to explore all subjects and quizzes.</p>
    </div>
</section>

<section class="container">

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="/quiz_app/?route=home">Home</a>
        <span>/</span>
        <span>Categories</span>
    </nav>

    <h2 class="section-title">Browse Categories</h2>
    <p class="section-sub">Start your learning journey by choosing a category.</p>

    <div class="categories-grid">
        <?php if (empty($categories)): ?>
            <p>No categories found.</p>
        <?php else: ?>
            <?php foreach ($categories as $cat): ?>
                <a class="category-card"
                   href="/quiz_app/?route=category&category_id=<?= (int)$cat['id'] ?>">
                   
                    <strong class="title"><?= htmlspecialchars($cat['title']) ?></strong>

                    <?php if (!empty($cat['description'])): ?>
                        <p class="details"><?= htmlspecialchars($cat['description']) ?></p>
                    <?php endif; ?>

                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</section>

<?php include 'app/views/layouts/footer.php'; ?>
</body>
</html>
