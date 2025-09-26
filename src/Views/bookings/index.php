<h1>Book-My-House</h1>
<p><a href="/bookings/new">Book the house!</a></p>
<p>
  ...or check whether the house is booked already
  <a href="/query/new">here!</a>
</p>

<p>
  ...or check the statistics page
  <a href="/statistics">here!</a>
</p>

<h2>The full list of bookings:</h2>
<div class='bookings'>
  <?php if (!empty($bookings)): ?>
    <?php foreach ($bookings as $booking): ?>
      <?php include __DIR__ . '/_booking.php'; ?>
    <?php endforeach; ?>
  <?php else: ?>
    There is no booking yet.
  <?php endif; ?>
</div>