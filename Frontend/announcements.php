<?php require_once 'api_client.php'; require_login();
if($_SERVER['REQUEST_METHOD']==='POST' && $_SESSION['role']==='Admin') api_request('POST','/admin/announcements',$_POST);
$list = api_request('GET','/lostfound/announcements')['data'] ?? [];
include 'includes/header.php'; ?>
<h4>Announcements</h4>
<?php if($_SESSION['role']==='Admin'): ?>
<form method="post" class="mb-3">
<input class="form-control mb-2" name="title" placeholder="Title" required>
<textarea class="form-control mb-2" name="content" placeholder="Content" required></textarea>
<button class="btn btn-primary">Post</button>
</form>
<?php endif; ?>
<?php foreach($list as $a): ?><div class="card mb-2"><div class="card-body"><h5><?=$a['title']?></h5><p><?=$a['content']?></p><small><?=$a['publishAt']?></small></div></div><?php endforeach; ?>
<?php include 'includes/footer.php'; ?>
