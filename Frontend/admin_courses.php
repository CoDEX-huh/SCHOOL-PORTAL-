<?php require_once 'api_client.php'; require_role('Admin');
if($_SERVER['REQUEST_METHOD']==='POST') api_request('POST','/lms/courses',$_POST);
$courses = api_request('GET','/lms/courses')['data'] ?? [];
include 'includes/header.php'; ?>
<h4>Courses</h4>
<form method="post" class="mb-3">
  <input class="form-control mb-2" name="name" placeholder="Course name" required>
  <textarea class="form-control mb-2" name="description" placeholder="Description"></textarea>
  <button class="btn btn-primary">Save Course</button>
</form>
<ul class="list-group"><?php foreach($courses as $c) echo '<li class="list-group-item">'.$c['name'].' - '.$c['description'].'</li>'; ?></ul>
<?php include 'includes/footer.php'; ?>
