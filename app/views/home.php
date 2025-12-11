<?php
$pageTitle = "Home";
$pageCSS = "/quiz_app/assets/css/home.css";
$pageJS = "/quiz_app/assets/js/home.js";
include 'app/views/layouts/header.php';
?>


    <section class="hero">
      <div class="container">
        <div class="hero-grid">
          <div>
            <span class="badge">🎯 Interactive Learning</span>
            <h1>Sharpen your knowledge.</h1>
            <p>
              Explore categories, get instant feedback, and track progress on
              your personal dashboard. Visual language follows the app template,
              adapted for desktop layout.
            </p>
            <div class="cta-row">
              <a class="btn btn-primary" href="/#quizzes">Get Started</a>
              <a class="btn btn-ghost" href="/quiz_app/?route=help">Read Help</a>
            </div>
            <!-- <div class="hero-card" style="margin-top: 18px">
              <strong>For teachers:</strong> create and upload quizzes in
              <a
                href="/quiz_app/?route=manage"
                style="color: #fff; text-decoration: underline"
                >Manage</a
              >.
            </div> -->
          </div>
        </div>
      </div>
    </section>

    <!-- ===== Highlights ===== -->
    <section>
      <div class="container">
        <h2 class="section-title">Why Quizone?</h2>
        <p class="section-sub">
          Fast feedback, clean UI, and data you can act on.
        </p>
        <div class="features">
          <article class="card">
            <div style="font-size: 22px">⚡</div>
            <h3>Instant Feedback</h3>
            <p>Auto-check answers and show scores immediately.</p>
          </article>
          <article class="card">
            <div style="font-size: 22px">📊</div>
            <h3>Progress Tracking</h3>
            <p>See attempts, best scores, and trends in your dashboard.</p>
          </article>
          <article class="card">
            <div style="font-size: 22px">🏆</div>
            <h3>Leaderboard</h3>
            <p>Climb ranks and motivate learning with friendly competition.</p>
          </article>
        </div>
      </div>
    </section>

    <!-- ===== Popular Categories ===== -->
    <section id="quizzes">
      <div class="container">
        <h2 class="section-title">Popular Categories</h2>
        <p class="section-sub">Pick a topic and start a 10–20 question set.</p>

        <div class="grid cols-3">
          <a class="cat" href="/quiz_app/?route=category&category_id=1">
            <img
              src="https://via.placeholder.com/800x360?text=Image+Placeholder"
              alt="Placeholder image"
            />
            <strong>Math Genius Test</strong>
            <div class="meta">
              <span>20 Questions</span><span>Beginner</span>
            </div>
          </a>
          <a class="cat" href="/quiz_app/?route=category&category_id=2">
            <img
              src="https://via.placeholder.com/800x360?text=Image+Placeholder"
              alt="Placeholder image"
            />
            <strong>Ultimate Science</strong>
            <div class="meta"><span>20 Questions</span><span>Mixed</span></div>
          </a>
          <a class="cat" href="/quiz_app/?route=category&category_id=3">
            <img
              src="https://via.placeholder.com/800x360?text=Image+Placeholder"
              alt="Placeholder image"
            />
            <strong>History Buff</strong>
            <div class="meta">
              <span>15 Questions</span><span>Intermediate</span>
            </div>
          </a>
        </div>

        <div style="text-align: center; margin-top: 22px">
          <a class="btn btn-primary" href="/quiz_app/?route=quizzes">Browse All Quizzes</a>
        </div>
      </div>
    </section>

    <!-- ===== Footer ===== -->
    <?php include 'app/views/layouts/footer.php'; ?>
  </body>
</html>
