<?php
$pageTitle = htmlspecialchars($category['title']);
$pageCSS   = "/quiz_app/assets/css/category.css";
include 'app/views/layouts/header.php';
?>

<!-- ===== Hero / Header ===== -->
<section class="hero">
    <div class="container">
        <h1><?= htmlspecialchars($category['title']) ?></h1>

        <?php if (!empty($category['description'])): ?>
            <p class="sub"><?= nl2br(htmlspecialchars($category['description'])) ?></p>
        <?php else: ?>
            <p class="sub">Explore subjects under this category.</p>
        <?php endif; ?>
    </div>
</section>

<!-- ===== Breadcrumb ===== -->
<section class="container">
    <nav class="breadcrumb" style="margin-bottom: 1.5rem;">
        <a href="/quiz_app/">Home</a>
        <span>/</span>
        <a href="/quiz_app/?route=categories">Categories</a>
        <span>/</span>
        <span><?= htmlspecialchars($category['title']) ?></span>
    </nav>

    <h2 class="section-title">Subjects in this category</h2>
    <p class="section-sub">Choose a subject to explore its quizzes.</p>

    <!-- Optional admin-only button -->
    <?php if (!empty($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
        <div class="toolbar">
            <a class="btn btn-primary" href="/quiz_app/?route=manage">
                Manage Subjects / Quizzes
            </a>
        </div>
    <?php endif; ?>

    <!-- ===== Subjects Grid ===== -->
    <div class="subjects-grid">
        <?php if (empty($subjects)): ?>
            <p>No subjects found under this category.</p>
        <?php else: ?>
            <?php foreach ($subjects as $s): ?>
                <a 
                    class="subject-card"
                    href="/quiz_app/?route=subject_quizzes&subject_id=<?= (int)$s['id'] ?>"
                >
                    <strong class="title"><?= htmlspecialchars($s['title']) ?></strong>

                    <?php if (!empty($s['subject_details'])): ?>
                        <p class="details"><?= htmlspecialchars($s['subject_details']) ?></p>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<?php include 'app/views/layouts/footer.php'; ?>
</body>
</html>

