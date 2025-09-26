<h1>Is it booked?</h1>

<?php if ($react_enabled ?? false): ?>
  <div id="booking-form">
    <!-- React component would be loaded here -->
    <p><em>React component not implemented in this PHP version</em></p>
  </div>
<?php else: ?>
  <form method="post" action="/query">
    <p>
      <label for="day">Select date:</label>
      <input type="date" name="day" id="day" value="<?= htmlspecialchars($day ?? date('Y-m-d')) ?>" required>
    </p>
    <p>
      <input type="submit" value="Check">
    </p>
  </form>
<?php endif; ?>

<p><a href="/">Back</a></p>

<p id='booked-result'>
  <?php if (isset($booked) && $booked === true): ?>
    The house is booked for the selected day :(
  <?php elseif (isset($booked) && $booked === false): ?>
    Yay! You can book the house on the selected day!
  <?php endif; ?>
  
  <?php if (!empty($errors)): ?>
    <?php foreach ($errors as $error): ?>
      <span class='error'><?= htmlspecialchars($error) ?></span>
    <?php endforeach; ?>
  <?php endif; ?>
</p>