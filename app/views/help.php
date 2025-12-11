<?php
  $pageTitle = "Help & Tutorials";
  $pageCSS = "/quiz_app/assets/css/help.css";
  $pageJS = "/quiz_app/assets/js/help.js";
  include 'app/views/layouts/header.php';
?>

    <div class="container">
      <h1>Help & Tutorials</h1>
      <p class="small">
        This page explains how to use Quizone as a student and as a
        teacher/admin.
      </p>

      <div class="grid">
        <div class="card">
          <h2>Getting Started (Students)</h2>
          <ol>
            <li>
              Click <strong>Sign up</strong> to create an account (or
              <strong>Log in</strong> if you already have one).
            </li>
            <li>
              Go to <strong>Quizzes</strong> on the homepage and pick a
              category.
            </li>
            <li>
              Answer questions and click <strong>Submit</strong> to see instant
              results.
            </li>
            <li>Open <strong>Rank</strong> to view the leaderboard.</li>
          </ol>
        </div>

        <div class="card">
          <h2>Account & Profile</h2>
          <ul>
            <li>
              Update profile info from your user menu (avatar in the header
              after login).
            </li>
            <li>
              Your past scores and trends are visible on the dashboard (if
              enabled by your course).
            </li>
          </ul>
        </div>
      </div>

      <div class="card">
        <h2>Create a Quiz (Teachers / Admin)</h2>
        <ol>
          <li>
            Open <strong><a href="/manage.html">Manage</a></strong
            >.
          </li>
          <li>Fill in <em>Quiz Meta</em>: Title, Category, Difficulty.</li>
          <li>Click <strong>+ Add Question</strong> to add a new question.</li>
          <li>Enter four options and check exactly one correct option.</li>
          <li>Repeat for all questions in your set.</li>
          <li>
            Click <strong>Export JSON</strong> to download a quiz file. This
            file can later be imported back or uploaded to your course
            site/server.
          </li>
        </ol>
        <div class="notice">
          Tip: Keep question stems concise. Avoid ambiguous options. For math,
          consider including LaTeX or images (feature depends on your server
          build).
        </div>
      </div>

      <div class="grid">
        <div class="card">
          <h2>Import / Upload a Quiz (JSON)</h2>
          <p>
            You can import a quiz JSON file in <strong>Manage</strong> via the
            file picker. The JSON schema is:
          </p>
          <pre>
{
  "meta": {
    "title": "Algebra Basics",
    "category": "Math",
    "difficulty": "Beginner"
  },
  "questions": [
    {
      "question": "If 2x + 5 = 15, what is x?",
      "options": ["12", "5", "7", "24"],
      "correctIndex": 1
    }
  ]
}</pre
          >
          <p class="small">Fields:</p>
          <ul class="small">
            <li><code>title</code>: string</li>
            <li><code>category</code>: string</li>
            <li>
              <code>difficulty</code>: "Beginner" | "Intermediate" | "Advanced"
            </li>
            <li><code>questions[n].options</code>: array of 4 strings</li>
            <li><code>questions[n].correctIndex</code>: 0–3</li>
          </ul>
        </div>

        <div class="card">
          <h2>Import / Upload a Quiz (CSV)</h2>
          <p>CSV is supported for quick import. Use the following columns:</p>
          <pre>
question, optionA, optionB, optionC, optionD, correct
What is 2+2?,2,3,4,5,C
The capital of Australia?,Sydney,Melbourne,Canberra,Perth,C</pre
          >
          <ul class="small">
            <li>
              <code>correct</code> must be one of
              <kbd>A</kbd>/<kbd>B</kbd>/<kbd>C</kbd>/<kbd>D</kbd>.
            </li>
            <li>
              Avoid commas inside cells. If needed, wrap the field in quotes.
            </li>
          </ul>
        </div>
      </div>

      <div class="card">
        <h2>Best Practices</h2>
        <ul>
          <li>
            Balance difficulty across questions; start with easier warm-ups.
          </li>
          <li>Keep option lengths similar to reduce guessing by length.</li>
          <li>
            For accessibility, ensure sufficient color contrast and include alt
            text for any images.
          </li>
        </ul>
      </div>

      <div class="card">
        <h2>Troubleshooting</h2>
        <ul>
          <li>
            <strong>Import failed (JSON):</strong> Validate JSON using an online
            linter. Ensure <code>correctIndex</code> is an integer 0–3.
          </li>
          <li>
            <strong>Import failed (CSV):</strong> Check the column order and
            that <code>correct</code> is A/B/C/D.
          </li>
          <li>
            <strong>Images not showing:</strong> Use absolute URLs or host
            images under your project’s <code>/images</code> path.
          </li>
        </ul>
      </div>

      <p class="small">
        Need more help? Contact your course coordinator or open an issue in your
        team repository.
      </p>
    </div>

    <?php include 'app/views/layouts/footer.php'; ?>
  </body>
</html>
