<?php require_once 'api_client.php'; require_role('Student');
if($_SERVER['REQUEST_METHOD']==='POST') api_request('POST','/lms/enrollments',['studentId'=>$_SESSION['user_id'],'subjectId'=>$_POST['subjectId']]);
$subjects = api_request('GET','/lms/subjects')['data'] ?? [];
$enroll = api_request('GET','/lms/enrollments')['data'] ?? [];
include 'includes/header.php'; ?>
<h4>Enroll Students to Subjects</h4>
<form method="post" class="mb-3">
<select class="form-select mb-2" name="subjectId"><?php foreach($subjects as $s) echo '<option value="'.$s['id'].'">'.$s['name'].'</option>'; ?></select>
<button class="btn btn-primary">Enroll</button>
</form>
<ul class="list-group"><?php foreach($enroll as $e) if($e['studentId']==$_SESSION['user_id']) echo '<li class="list-group-item">'.$e['subject']['name'].' - '.$e['status'].'</li>'; ?></ul>
<?php include 'includes/footer.php'; ?>
