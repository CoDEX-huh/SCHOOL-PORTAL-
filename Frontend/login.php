<?php
session_start();
require_once 'api_client.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $res = api_request('POST', '/auth/login', ['username' => $_POST['username'], 'password' => $_POST['password']]);
    if ($res['status'] === 200) {
        $_SESSION['token'] = $res['data']['token'];
        $_SESSION['username'] = $res['data']['username'];
        $_SESSION['role'] = $res['data']['role'];
        $_SESSION['user_id'] = $res['data']['userId'];
        $_SESSION['full_name'] = $res['data']['fullName'];
        header('Location: dashboard.php'); exit;
    }
    $error = 'Invalid login credentials';
}
include 'includes/header.php';
?>
<div class="row justify-content-center"><div class="col-md-5">
  <div class="card"><div class="card-body">
    <h4 class="mb-3">Login</h4>
    <?php if($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
    <form method="post">
      <input class="form-control mb-2" name="username" placeholder="Username" required>
      <input class="form-control mb-3" type="password" name="password" placeholder="Password" required>
      <button class="btn btn-primary w-100">Sign In</button>
    </form>
  </div></div>
</div></div>
<?php include 'includes/footer.php'; ?>
