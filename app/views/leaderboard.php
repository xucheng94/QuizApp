<?php
    $pageTitle = "Leaderboard";
    $pageCSS = "/quiz_app/assets/css/leaderboard.css";
    $pageJS = "/quiz_app/assets/js/leaderboard.js";
    include 'app/views/layouts/header.php';
?>

    <section class="hero">
        <div class="container">
            <h1>Leaderboard</h1>
            <p class="sub">Top scorers this week</p>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="board">
                <div class="podium" id="podium"></div>
                <div class="list" id="list"></div>
            </div>
        </div>
    </section>

    <?php include 'app/views/layouts/footer.php'; ?>
</body>
</html>
