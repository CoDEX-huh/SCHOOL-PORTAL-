<?php require_once 'api_client.php'; require_role('Admin');
if($_SERVER['REQUEST_METHOD']==='POST') api_request('POST','/lms/subjects',$_POST);
$subjects = api_request('GET','/lms/subjects')['data'] ?? [];
$courses = api_request('GET','/lms/courses')['data'] ?? [];
$users = api_request('GET','/admin/users')['data'] ?? [];
include 'includes/header.php'; ?>
<h4>Subjects</h4>
<form method="post" class="row g-2 mb-3">
  <div class="col"><input class="form-control" name="name" placeholder="Subject name" required></div>
  <div class="col"><select class="form-select" name="courseId"><?php foreach($courses as $c) echo '<option value="'.$c['id'].'">'.$c['name'].'</option>'; ?></select></div>
  <div class="col"><select class="form-select" name="professorId"><option value="">No Professor</option><?php foreach($users as $u) if(($u['role']['name']??'')==='Professor') echo '<option value="'.$u['id'].'">'.$u['fullName'].'</option>'; ?></select></div>
  <div class="col"><button class="btn btn-success">Save</button></div>
</form>
<ul class="list-group"><?php foreach($subjects as $s) echo '<li class="list-group-item">'.$s['name'].' ('.$s['course']['name'].') - Prof: '.($s['professor']['fullName']??'Unassigned').'</li>'; ?></ul>
<?php include 'includes/footer.php'; ?>
