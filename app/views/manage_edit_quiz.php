<?php
$pageTitle = "Edit Quiz";
$pageCSS   = "/quiz_app/assets/css/manage.css";
include 'app/views/layouts/header.php';
?>

<section class="container">

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="/quiz_app/?route=manage">Manage</a>
        <span>/</span>
        <a href="/quiz_app/?route=manage_subject&subject_id=<?= (int)$subject['id'] ?>">
            <?= htmlspecialchars($subject['title']) ?>
        </a>
        <span>/</span>
        <span>Edit Quiz</span>
    </nav>

    <h1 class="page-title">Edit Quiz</h1>
    <p class="sub">Modify quiz details below.</p>

    <form class="form" action="/quiz_app/?route=manage_update_quiz" method="POST">

        <input type="hidden" name="quiz_id" value="<?= (int)$quiz['id'] ?>">

        <!-- Quiz Title -->
        <div class="form-group">
            <label>Quiz Title</label>
            <input 
                type="text" 
                name="title" 
                value="<?= htmlspecialchars($quiz['title']) ?>"
                required
            >
        </div>

        <!-- Difficulty -->
        <div class="form-group">
            <label>Difficulty</label>
            <select name="difficulty">
                <?php 
                $difficulties = ['Beginner', 'Intermediate', 'Advanced', 'Mixed'];
                foreach ($difficulties as $d): ?>
                    <option value="<?= $d ?>" <?= $quiz['difficulty'] === $d ? 'selected' : '' ?>>
                        <?= $d ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Explanation -->
        <div class="form-group">
            <label>Explanation (optional)</label>
            <textarea name="explanation" rows="4"><?= htmlspecialchars($quiz['explanation']) ?></textarea>
        </div>

        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save Changes</button>

            <a class="btn btn-light"
               href="/quiz_app/?route=manage_quiz&quiz_id=<?= (int)$quiz['id'] ?>">
                Cancel
            </a>
        </div>

    </form>

</section>

<?php include 'app/views/layouts/footer.php'; ?>
