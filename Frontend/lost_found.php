<?php require_once 'api_client.php'; require_login();
if($_SERVER['REQUEST_METHOD']==='POST'){
  $kind=$_POST['kind'];
  $data=['ItemDetails'=>$_POST['itemDetails'],'Location'=>$_POST['location']];
  if(!empty($_FILES['image']['tmp_name'])) $data['image']=new CURLFile($_FILES['image']['tmp_name'], $_FILES['image']['type'], $_FILES['image']['name']);
  api_request('POST', $kind==='lost'?'/lostfound/lost':'/lostfound/found', $data, true);
}
$lost = api_request('GET','/lostfound/lost')['data'] ?? [];
$found = api_request('GET','/lostfound/found')['data'] ?? [];
include 'includes/header.php'; ?>
<h4>Lost & Found</h4>
<form method="post" enctype="multipart/form-data" class="row g-2 mb-3">
  <div class="col-2"><select class="form-select" name="kind"><option value="lost">Lost</option><option value="found">Found</option></select></div>
  <div class="col"><input class="form-control" name="itemDetails" placeholder="Item details" required></div>
  <div class="col"><input class="form-control" name="location" placeholder="Location" required></div>
  <div class="col"><input class="form-control" type="file" name="image"></div>
  <div class="col-2"><button class="btn btn-primary w-100">Submit</button></div>
</form>
<div class="row"><div class="col-md-6"><h5>Lost Items</h5><ul class="list-group"><?php foreach($lost as $i) echo '<li class="list-group-item">'.$i['itemDetails'].' @ '.$i['location'].'</li>'; ?></ul></div>
<div class="col-md-6"><h5>Found Items</h5><ul class="list-group"><?php foreach($found as $i) echo '<li class="list-group-item">'.$i['itemDetails'].' @ '.$i['location'].'</li>'; ?></ul></div></div>
<?php include 'includes/footer.php'; ?>
