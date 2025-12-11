<!-- app/views/layouts/header.php -->
<?php
  // Start session if not already started
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  // Authentication state
  $isLoggedIn = !empty($_SESSION['user_id']);

  // Your system uses is_admin (1 = teacher/admin, 0 = student)
  $isAdmin = $_SESSION['is_admin'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title><?= htmlspecialchars($pageTitle ?? 'Quizone') ?> — Quizone</title>

    <!-- Global CSS -->
    <link rel="stylesheet" href="/quiz_app/assets/css/style.css" />

    <!-- Page-specific CSS -->
    <?php if (!empty($pageCSS)): ?>
      <link rel="stylesheet" href="<?= htmlspecialchars($pageCSS) ?>">
    <?php endif; ?>
  </head>
  <body>
    <header>
      <div class="container">
        <div class="nav">

          <!-- Logo -->
          <a class="logo" href="/quiz_app/?route=home">QUIZONE</a>

          <!-- Primary Navigation -->
          <nav class="nav-links" aria-label="Primary">

            <a href="/quiz_app/?route=home">Home</a>

            <!-- Student-only: Take a Quiz -->
            <?php if ($isLoggedIn && !$isAdmin): ?>
              <a href="/quiz_app/?route=quizzes">Take a Quiz</a>
            <?php endif; ?>

            <!-- Student-only: Instructors -->
            <?php if ($isLoggedIn && !$isAdmin): ?>
              <a href="/quiz_app/?route=instructors">Instructors</a>
            <?php endif; ?>

            <!-- Admin/Teacher-only: Manage Quizzes -->
            <?php if ($isLoggedIn && $isAdmin): ?>
              <a href="/quiz_app/?route=manage">Manage Quizzes</a>
            <?php endif; ?>

            <a href="/quiz_app/?route=rank">Rank</a>
            <a href="/quiz_app/?route=help">Help</a>

          </nav>

          <!-- Right Side (Auth Buttons) -->
          <div class="nav-right">

            <?php if (!$isLoggedIn): ?>
              <!-- When logged OUT -->
              <a class="btn btn-ghost" href="/quiz_app/?route=login">Log in</a>
              <a class="btn btn-primary" href="/quiz_app/?route=register">Sign up</a>

            <?php else: ?>
              <!-- When logged IN -->
              <a class="btn btn-primary" href="/quiz_app/?route=logout">Logout</a>
            <?php endif; ?>

          </div>

        </div>
      </div>
    </header>
