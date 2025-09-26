<div class='booking'>
  <p><strong>Day:</strong> <?= htmlspecialchars($booking->day) ?></p>
  <p><strong>House:</strong> <?= htmlspecialchars($booking->house()->name ?? 'Unknown') ?></p>
  <?php if ($booking->number_of_guests): ?>
    <p><strong>Guests:</strong> <?= htmlspecialchars($booking->number_of_guests) ?></p>
  <?php endif; ?>
</div>