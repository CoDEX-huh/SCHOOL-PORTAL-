<?php require_once 'api_client.php'; require_role('Professor');
if($_SERVER['REQUEST_METHOD']==='POST') api_request('POST','/lms/grades',$_POST);
$exams = api_request('GET','/lms/exams')['data'] ?? [];
$enroll = api_request('GET','/lms/enrollments')['data'] ?? [];
$grades = api_request('GET','/lms/grades')['data'] ?? [];
include 'includes/header.php'; ?>
<h4>Input Scores</h4>
<form method="post" class="row g-2 mb-3">
  <div class="col"><select class="form-select" name="examId"><?php foreach($exams as $e) echo '<option value="'.$e['id'].'">'.$e['title'].'</option>'; ?></select></div>
  <div class="col"><select class="form-select" name="studentId"><?php foreach($enroll as $e) echo '<option value="'.$e['studentId'].'">'.$e['student']['fullName'].'</option>'; ?></select></div>
  <div class="col"><input class="form-control" name="score" placeholder="Score" required></div>
  <div class="col"><input class="form-control" name="maxScore" value="100" required></div>
  <div class="col"><button class="btn btn-success">Save</button></div>
</form>
<table class="table"><tr><th>Student</th><th>Exam</th><th>Score</th></tr><?php foreach($grades as $g) echo '<tr><td>'.($g['student']['fullName']??'').'</td><td>'.$g['exam']['title'].'</td><td>'.$g['score'].'/'.$g['maxScore'].'</td></tr>'; ?></table>
<?php include 'includes/footer.php'; ?>
