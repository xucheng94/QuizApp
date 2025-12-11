<?php
  class ShowRankController {
    public function showRankPage() {
      $pageTitle = "Leaderboard";
      include 'app/views/leaderboard.php';
    }
  }