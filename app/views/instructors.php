<?php
$pageTitle = "Instructors";
$pageCSS = "/quiz_app/assets/css/instructor.css";
include 'app/views/layouts/header.php';
?>

<section class="container">
    <h1 class="page-title">Choose an Instructor</h1>
    <p class="sub">Select an instructor to browse their subjects.</p>

    <div class="instructor-grid">
        <?php foreach ($instructors as $instructor): ?>
            <a 
              class="instructor-card glass" 
              href="/quiz_app/?route=subjects&instructor_id=<?= (int)$instructor['id'] ?>"
            >
                <div class="avatar">
                    <img src="https://api.dicebear.com/7.x/initials/svg?seed=<?= urlencode($instructor['first_name']) ?>" alt="avatar">
                </div>

                <strong class="name">
                    <?= htmlspecialchars($instructor['first_name'] . " " . $instructor['last_name']) ?>
                </strong>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<?php include 'app/views/layouts/footer.php'; ?>
