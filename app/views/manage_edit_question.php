<?php
$pageTitle = "Edit Question";
$pageCSS   = "/quiz_app/assets/css/manage.css";
include 'app/views/layouts/header.php';
?>

<section class="container">

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="/quiz_app/?route=manage">Manage</a>
        <span>/</span>

        <a href="/quiz_app/?route=manage_quiz&quiz_id=<?= (int)$quiz['id'] ?>">
            <?= htmlspecialchars($quiz['title']) ?>
        </a>
        <span>/</span>

        <span>Edit Question</span>
    </nav>

    <h1 class="page-title">Edit Question</h1>
    <p class="sub">Modify the question and its answer options.</p>

    <form class="form" action="/quiz_app/?route=manage_update_question" method="POST">

        <input type="hidden" name="question_id" value="<?= (int)$question['id'] ?>">
        <input type="hidden" name="quiz_id" value="<?= (int)$quiz['id'] ?>">

        <!-- Question Text -->
        <div class="form-group">
            <label>Question Text</label>
            <textarea 
                name="question_text" 
                rows="3"
                required
            ><?= htmlspecialchars($question['question_text']) ?></textarea>
        </div>

        <!-- Explanation -->
        <div class="form-group">
            <label>Explanation (optional)</label>
            <textarea 
                name="explanation" 
                rows="3"
                placeholder="Shown after the student finishes the quiz"
            ><?= htmlspecialchars($question['explanation'] ?? '') ?></textarea>
        </div>

        <hr>

        <h3>Answer Options</h3>

        <?php foreach ($options as $index => $opt): ?>
          <div class="option-edit-card">
            <div class="form-group">
                <label>
                    Option <?= $index + 1 ?>
                    <input 
                        type="radio" 
                        name="correct_option" 
                        value="<?= $index + 1 ?>"
                        style="margin-left:10px"
                        <?= $opt['is_correct'] ? 'checked' : '' ?>
                    >
                    <span class="small">Correct answer</span>
                </label>

                <input 
                    type="text"
                    name="option_<?= $index + 1 ?>"
                    value="<?= htmlspecialchars($opt['option_text']) ?>"
                    required
                >
            </div>
        </div>
        <?php endforeach; ?>

        <!-- Actions -->
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
