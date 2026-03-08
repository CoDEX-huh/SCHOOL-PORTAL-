<?php require_once 'api_client.php'; require_login();
if($_SERVER['REQUEST_METHOD']==='POST'){
  if(isset($_POST['status']) && $_SESSION['role']==='Admin') api_request('PUT','/lostfound/claims/'.$_POST['claimId'].'/status',['status'=>$_POST['status']]);
  else api_request('POST','/lostfound/claims',['lostItemId'=>$_POST['lostItemId']?:null,'foundItemId'=>$_POST['foundItemId']?:null,'ownershipVerification'=>$_POST['ownershipVerification']]);
}
$claims = api_request('GET','/lostfound/claims')['data'] ?? [];
$lost = api_request('GET','/lostfound/lost')['data'] ?? [];
$found = api_request('GET','/lostfound/found')['data'] ?? [];
include 'includes/header.php'; ?>
<h4>Claims</h4>
<?php if($_SESSION['role']==='Student'): ?>
<form method="post" class="row g-2 mb-3">
  <div class="col"><select class="form-select" name="lostItemId"><option value="">Lost Item</option><?php foreach($lost as $i) echo '<option value="'.$i['id'].'">'.$i['itemDetails'].'</option>'; ?></select></div>
  <div class="col"><select class="form-select" name="foundItemId"><option value="">Found Item</option><?php foreach($found as $i) echo '<option value="'.$i['id'].'">'.$i['itemDetails'].'</option>'; ?></select></div>
  <div class="col"><input class="form-control" name="ownershipVerification" placeholder="Ownership verification" required></div>
  <div class="col"><button class="btn btn-primary">Submit Claim</button></div>
</form>
<?php endif; ?>
<table class="table"><tr><th>ID</th><th>Student</th><th>Status</th><th>Verification</th><th>Action</th></tr>
<?php foreach($claims as $c): ?><tr><td><?=$c['id']?></td><td><?=$c['student']['fullName']??''?></td><td><?=$c['status']?></td><td><?=$c['ownershipVerification']?></td><td>
<?php if($_SESSION['role']==='Admin'): ?>
<form method="post" class="d-flex gap-2"><input type="hidden" name="claimId" value="<?=$c['id']?>"><select name="status" class="form-select"><option>Approved</option><option>Rejected</option><option>Pending</option></select><button class="btn btn-sm btn-success">Update</button></form>
<?php endif; ?>
</td></tr><?php endforeach; ?></table>
<?php include 'includes/footer.php'; ?>
