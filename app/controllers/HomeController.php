<?php
  require_once __DIR__ . '/../core/Controller.php';

  class HomeController extends Controller {
    public function showHomePage() {
      $this->view('home', [
        'pageTitle' => 'Home',
        'pageCSS' => '/quiz_app/assets/css/home.css',
        'pageJS' => '/quiz_app/assets/js/home.js'
      ]);
    }
  }
?>