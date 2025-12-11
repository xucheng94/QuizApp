<!-- app/views/layouts/footer.php -->
    <footer>
      <div class="container">
        <div class="footer-content">
          <div>© <span id="y"></span> Quizone</div>
          <div style="display: flex; gap: 16px">
            <a href="/quiz_app/?route=rank">Leaderboard</a>
            <a href="/quiz_app/?route=help">Help</a>
            <a href="/quiz_app/?route=manage">Manage</a>
          </div>
        </div>
      </div>
    </footer>

    <?php if (!empty($pageJS)): ?>
      <script src="<?= htmlspecialchars($pageJS) ?>"></script>
    <?php endif; ?>
  </body>
</html>