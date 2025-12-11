<?php
  class RegisterController {
    public function showRegistrationPage() {
      $pageTitle = "Register";
      include 'app/views/register.php';
    }
}
?>