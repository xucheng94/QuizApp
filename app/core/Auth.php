<?php

  class Auth
  {
    public static function requireLogin()
    {
      if (session_status() === PHP_SESSION_NONE) {
        session_start();
      }

      if (empty($_SESSION['user_id'])) {
        header('Location: /quiz_app/?route=login&redirect=' . urlencode($_SERVER['REQUEST_URI']));
        exit;
      }

    }

    public static function requireAdmin()
    {
      if (session_status() === PHP_SESSION_NONE) {
        session_start();
      }

      if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
        header("Location: /quiz_app/?route=login&error=admin_required");
        exit;
      }
    }
  }

  ?>