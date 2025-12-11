<?php
$pageTitle = "Subjects";
$pageCSS = "/quiz_app/assets/css/subjects.css";
include 'app/views/layouts/header.php';
?>

<section class="container">
    <h1 class="page-title">
        Subjects taught by 
        <span class="highlight">
            <?= htmlspecialchars($instructor['first_name'] . " " . $instructor['last_name']) ?>
        </span>
    </h1>

    <div class="subjects-grid">
        <?php foreach ($subjects as $subject): ?>
            <a 
              class="subject-card glass"
              href="/quiz_app/?route=quizzes&subject_id=<?= (int)$subject['id'] ?>"
            >
                <strong class="title"><?= htmlspecialchars($subject['title']) ?></strong>
                <p class="details"><?= htmlspecialchars($subject['subject_details'] ?? '') ?></p>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<?php include 'app/views/layouts/footer.php'; ?>
