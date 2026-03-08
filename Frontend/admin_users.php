<?php require_once 'api_client.php'; require_role('Admin');
if($_SERVER['REQUEST_METHOD']==='POST') api_request('POST','/admin/users',$_POST);
$users = api_request('GET','/admin/users')['data'] ?? [];
$roles = api_request('GET','/admin/roles')['data'] ?? [];
include 'includes/header.php'; ?>
<h4>Manage Users</h4>
<form method="post" class="row g-2 mb-3">
  <div class="col"><input class="form-control" name="username" placeholder="Username" required></div>
  <div class="col"><input class="form-control" name="password" placeholder="Password" required></div>
  <div class="col"><input class="form-control" name="fullName" placeholder="Full Name" required></div>
  <div class="col"><select class="form-select" name="roleId"><?php foreach($roles as $r) echo '<option value="'.$r['id'].'">'.$r['name'].'</option>'; ?></select></div>
  <div class="col"><button class="btn btn-success">Add</button></div>
</form>
<table class="table table-bordered"><tr><th>ID</th><th>Username</th><th>Name</th><th>Role</th></tr>
<?php foreach($users as $u): ?><tr><td><?=$u['id']?></td><td><?=$u['username']?></td><td><?=$u['fullName']?></td><td><?=$u['role']['name']??''?></td></tr><?php endforeach; ?>
</table>
<?php include 'includes/footer.php'; ?>
