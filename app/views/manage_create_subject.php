<?php
$pageTitle = "Create Subject";
$pageCSS   = "/quiz_app/assets/css/manage.css";
include 'app/views/layouts/header.php';
?>

<section class="container">
    <nav class="breadcrumb">
        <a href="/quiz_app/?route=manage">Manage</a>
        <span>/</span>
        <span>Create Subject</span>
    </nav>

    <h1 class="page-title">New Subject</h1>
    <p class="sub">Create a new subject for your quizzes.</p>

    <form class="form" method="POST" action="/quiz_app/?route=manage_store_subject">
        <div class="form-group">
            <label for="title">Subject Title</label>
            <input type="text" id="title" name="title" required>
        </div>

        <div class="form-group">
            <label for="subject_details">Details (optional)</label>
            <textarea id="subject_details" name="subject_details" rows="4"></textarea>
        </div>

        <div class="form-actions">
            <button class="btn btn-primary">Create Subject</button>
            <a class="btn btn-light" href="/quiz_app/?route=manage">Cancel</a>
        </div>
    </form>
</section>

<?php include 'app/views/layouts/footer.php'; ?>
