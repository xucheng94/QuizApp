<?php
$pageTitle = "Sign up";
$pageCSS = "/quiz_app/assets/css/register.css";
$pageJS = "/quiz_app/assets/js/register.js";
include 'app/views/layouts/header.php';
?>

    <section class="hero">
        <div class="container">
            <h1>Let’s Get Started</h1>
            <p class="sub">Provide your basic details to proceed</p>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="card" style="max-width:640px;margin:0 auto">
                <form id="regForm" action="/quiz_app/?route=register" method="POST"  novalidate>
                    <div class="field">
                        <label>First Name</label>
                        <input type="text" id="first_name" placeholder="First Name" name="first_name" required>
                    </div>
                    <div class="field">
                        <label>Last Name</label>
                        <input type="text" id="last_name" placeholder="Last Name" name="last_name" required>
                    </div>
                    <div class="field">
                        <label>Username</label>
                        <input type="text" name="username" id="username" placeholder="Choose a username" required>
                    </div>
                    <div class="field">
                        <label>Email Address</label>
                        <input type="email" id="email" placeholder="you@example.com" name="email" required>
                    </div>
                    <div class="field">
                        <label>Password</label>
                        <input type="password" id="pw" placeholder="At least 8 characters" minlength="8" name="password" required>
                    </div>
                    <button class="btn btn-primary btn-wide" type="submit">Register Account</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Popup -->
    <div id="popup" role="status" aria-live="polite">Registration successful! Redirecting…</div>

    <?php include 'app/views/layouts/footer.php'; ?>
</body>
</html>
