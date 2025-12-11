<?php
    $pageTitle = "Log In";
    $pageCSS = "/quiz_app/assets/css/login.css";
    $pageJS = "/quiz_app/assets/js/login.js";
    include 'app/views/layouts/header.php';
?>

    <section class="hero">
        <div class="container">
            <h1>Login Account</h1>
            <p class="sub">Hello, welcome back to your account</p>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="card" style="max-width:560px;margin:0 auto">
                <form id="loginForm" action="/quiz_app/?route=login" method="POST" novalidate>
                <div class="field">
                <label>Email</label>
            <input type="email" name="email" id="email" placeholder="you@example.com" required>
            </div>
            <div class="field">
                <label>Password</label>
                <input type="password" name="password" id="pw" placeholder="••••••••" required>
            </div>
                <button class="btn btn-primary btn-wide" type="submit">Log In</button>
            </form>

            </div>
        </div>
    </section>

    <!-- Popup -->
    <div id="popup" role="status" aria-live="polite">Login successful! Redirecting…</div>

    <?php include 'app/views/layouts/footer.php'; ?>
</body>
</html>
