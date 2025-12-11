<?php
$pageTitle = "Create New Quiz";
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
        <span>Create Quiz</span>
    </nav>

    <h1 class="page-title">Create Quiz</h1>
    <p class="sub">Add a new quiz under the subject <strong><?= htmlspecialchars($subject['title']) ?></strong>.</p>

    <form class="form" action="/quiz_app/?route=manage_create_quiz" method="POST">

        <input type="hidden" name="subject_id" value="<?= (int)$subject['id'] ?>">

        <!-- Quiz Title -->
        <div class="form-group">
            <label>Quiz Title</label>
            <input 
                type="text" 
                name="title" 
                placeholder="Enter quiz title" 
                required
            >
        </div>

        <!-- Difficulty -->
        <div class="form-group">
            <label>Difficulty</label>
            <select name="difficulty" required>
                <option value="Beginner">Beginner</option>
                <option value="Intermediate">Intermediate</option>
                <option value="Advanced">Advanced</option>
                <option value="Mixed" selected>Mixed</option>
            </select>
        </div>

        <!-- Explanation -->
        <div class="form-group">
            <label>Explanation (optional)</label>
            <textarea 
                name="explanation" 
                rows="4" 
                placeholder="Short description of the quiz"
            ></textarea>
        </div>

        <!-- Actions -->
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Create Quiz</button>

            <a class="btn btn-light" 
               href="/quiz_app/?route=manage_subject&subject_id=<?= (int)$subject['id'] ?>">
                Cancel
            </a>
        </div>

    </form>

</section>

<?php include 'app/views/layouts/footer.php'; ?>

