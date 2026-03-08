<?php require_once 'api_client.php'; require_role('Student');
$grades = api_request('GET','/lms/grades')['data'] ?? [];
include 'includes/header.php'; ?>
<h4>My Grades</h4>
<table class="table table-bordered"><tr><th>Exam</th><th>Score</th><th>Percent</th></tr>
<?php foreach($grades as $g): $p=$g['maxScore']?round(($g['score']/$g['maxScore'])*100,2):0; ?>
<tr><td><?=$g['exam']['title']?></td><td><?=$g['score']?>/<?=$g['maxScore']?></td><td><?=$p?>%</td></tr>
<?php endforeach; ?>
</table>
<?php include 'includes/footer.php'; ?>
