<?php
$pageTitle = $quiz['title'];
$pageCSS   = "/quiz_app/assets/css/quiz.css";
$pageJS    = "/quiz_app/assets/js/quiz.js";
include 'app/views/layouts/header.php';
?>

<!-- =======================
     INTRO SECTION
     ======================= -->
<section class="quiz-intro container">
    <div class="quiz-card glass">
        <h1><?= htmlspecialchars($quiz['title']) ?></h1>

        <p class="meta">
            <span><?= htmlspecialchars($quiz['subject_name']) ?></span>
            •
            <span><?= htmlspecialchars($quiz['difficulty']) ?></span>
            •
            <span><?= count($questions) ?> questions</span>
        </p>

        <?php if (empty($_SESSION['user_id'])): ?>
            <a class="btn btn-primary" 
               href="/quiz_app/?route=login&redirect=quiz&id=<?= $quiz['id'] ?>">
               Log in to start
            </a>
        <?php else: ?>
            <button id="startBtn" class="btn btn-primary">Start Quiz</button>
        <?php endif; ?>
    </div>
</section>


<!-- =======================
     QUIZ INTERFACE
     ======================= -->
<section id="quizContainer" class="quiz-container hidden container">

    <div class="quiz-card glass">
        <!-- Progress Row -->
        <div class="header-row">
            <div class="title" id="quizTitle"><?= htmlspecialchars($quiz['title']) ?></div>
            <div class="pill">
                <span id="idx">1</span> / <span id="total"><?= count($questions) ?></span>
            </div>
        </div>

        <div class="progress"><div id="bar" class="bar"></div></div>

        <!-- Question Text -->
        <div id="questionText" class="question-text"></div>

        <!-- Answer Options -->
        <div id="answerList" class="answer-list"></div>

        <!-- Navigation -->
        <div class="nav-row">
            <button id="backBtn" class="btn btn-ghost" disabled>Back</button>
            <button id="nextBtn" class="btn btn-primary">Next</button>
        </div>
    </div>
</section>


<!-- =======================
     FINISH MODAL
     ======================= -->
<div id="overlay" class="backdrop" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal">
        <h3>🎉 Finish Quiz?</h3>
        <p>You’re about to submit your answers. You can review any question before submitting.</p>

        <div class="row">
            <button class="navbtn" id="reviewBtn">Review Again</button>
            <button class="cta" id="submitBtn">Submit</button>
        </div>
    </div>
</div>


<!-- QUIZ PAYLOAD -->
<script>
    const QUIZ_DATA = {
        id: <?= (int)$quiz['id'] ?>,
        questions: <?= json_encode($questions) ?>,
        options: <?= json_encode($options) ?>,
    };
</script>

<?php include 'app/views/layouts/footer.php'; ?>
