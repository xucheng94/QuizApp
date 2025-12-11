<?php
$pageTitle = "Create Question";
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
        <a href="/quiz_app/?route=manage_quiz&quiz_id=<?= (int)$quiz['id'] ?>">
            <?= htmlspecialchars($quiz['title']) ?>
        </a>
        <span>/</span>
        <span>Create Question</span>
    </nav>

    <h1 class="page-title">New Question</h1>
    <p class="sub">Add a new question to <strong><?= htmlspecialchars($quiz['title']) ?></strong>.</p>

    <form class="form" action="/quiz_app/?route=manage_store_question" method="POST">

        <input type="hidden" name="quiz_id" value="<?= (int)$quiz['id'] ?>">

        <!-- Question Text -->
        <div class="form-group">
            <label for="question_text">Question Text</label>
            <textarea 
              id="question_text" 
              name="question_text" 
              rows="4" 
              placeholder="Enter your question here..." 
              required
            ></textarea>
        </div>

        <h3 style="color: var(--accent); margin-top: 2rem;">Answer Options</h3>
        <p class="small">Provide 4 possible answers. Select which one is correct.</p>

        <!-- Loop of 4 answer options -->
        <?php for ($i = 1; $i <= 4; $i++): ?>
            <div class="option-create-card">
                <div class="form-group">
                    <label>Option <?= $i ?></label>
                    <input 
                      type="text" 
                      name="options[<?= $i ?>][text]" 
                      placeholder="Enter option <?= $i ?>" 
                      required
                    >
                </div>

                <label class="radio-inline">
                    <input 
                        type="radio" 
                        name="correct_option" 
                        value="<?= $i ?>" 
                        required
                    >
                    Mark as correct
                </label>
            </div>
        <?php endfor; ?>

        <!-- Actions -->
        <div class="form-actions" style="margin-top: 2rem;">
            <button class="btn btn-primary" type="submit">Create Question</button>

            <a class="btn btn-light"
               href="/quiz_app/?route=manage_quiz&quiz_id=<?= (int)$quiz['id'] ?>">
                Cancel
            </a>
        </div>

    </form>

</section>

<?php include 'app/views/layouts/footer.php'; ?>


