<?php require_once 'api_client.php'; require_login(); include 'includes/header.php'; ?>
<div class="p-4 bg-white rounded shadow-sm">
  <h3>Welcome, <?php echo htmlspecialchars($_SESSION['full_name'] ?? 'User'); ?></h3>
  <p>Role: <strong><?php echo htmlspecialchars($_SESSION['role']); ?></strong></p>
  <p>Use the menu to access LMS, Lost & Found, Claims, and Admin tools.</p>
</div>
<?php include 'includes/footer.php'; ?>
