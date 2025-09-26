<h1>Book the house!</h1>

<form method="post" action="/bookings">
  <?php if (!empty($errors)): ?>
    <?php foreach ($errors as $error): ?>
      <p class='error'><?= htmlspecialchars($error) ?></p>
    <?php endforeach; ?>
  <?php endif; ?>
  
  <p>
    <label for="day">Day of booking:</label>
    <input type="date" name="day" id="day" value="<?= htmlspecialchars($booking->day ?? '') ?>" required>
  </p>
  
  <p>
    <label for="house_id">Select a place:</label>
    <select name="house_id" id="house_id" required>
      <option value="">Choose a house...</option>
      <?php foreach ($houses as $house): ?>
        <option value="<?= $house->id ?>" <?= ($booking->house_id ?? 0) == $house->id ? 'selected' : '' ?>>
          <?= htmlspecialchars($house->name) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </p>
  
  <p>
    <label for="number_of_guests">Number of guests (optional):</label>
    <input type="number" name="number_of_guests" id="number_of_guests" 
           value="<?= htmlspecialchars($booking->number_of_guests ?? '') ?>" min="1">
  </p>
  
  <p>
    <input type="submit" value="Create Booking">
  </p>
</form>

<p><a href="/">Back</a></p>