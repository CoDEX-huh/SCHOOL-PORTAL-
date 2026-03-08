<?php require_once 'api_client.php'; require_role('Professor');
if($_SERVER['REQUEST_METHOD']==='POST'){
  $data=['SubjectId'=>$_POST['subjectId'],'Title'=>$_POST['title'],'ScheduleAt'=>$_POST['scheduleAt']];
  if(!empty($_FILES['file']['tmp_name'])) $data['file']=new CURLFile($_FILES['file']['tmp_name'], $_FILES['file']['type'], $_FILES['file']['name']);
  api_request('POST','/lms/exams',$data,true);
}
$subjects = api_request('GET','/lms/subjects')['data'] ?? [];
$exams = api_request('GET','/lms/exams')['data'] ?? [];
include 'includes/header.php'; ?>
<h4>Upload Exam / Quiz</h4>
<form method="post" enctype="multipart/form-data" class="mb-3">
<select class="form-select mb-2" name="subjectId"><?php foreach($subjects as $s) echo '<option value="'.$s['id'].'">'.$s['name'].'</option>'; ?></select>
<input class="form-control mb-2" name="title" placeholder="Exam title" required>
<input class="form-control mb-2" type="datetime-local" name="scheduleAt" required>
<input class="form-control mb-2" type="file" name="file">
<button class="btn btn-primary">Save Exam</button>
</form>
<ul class="list-group"><?php foreach($exams as $e) echo '<li class="list-group-item">'.$e['title'].' @ '.$e['scheduleAt'].'</li>'; ?></ul>
<?php include 'includes/footer.php'; ?>
