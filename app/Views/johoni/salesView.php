<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Sales Record</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      background-color: rgba(0, 0, 0, 0.5);
    }
  </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

<!-- Modal displayed directly on page load -->
<div class="modal show d-block" tabindex="-1" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg rounded-4">
      <div class="modal-header bg-primary text-white rounded-top-4">
        <h5 class="modal-title">View Sales Record</h5>
        <button type="button" class="btn-close btn-close-white" onclick="window.close()" aria-label="Close"></button>
      </div>
      <form enctype="multipart/form-data"  method="post">
        <div class="modal-body">
		      <div class="mb-3">
            <label for="date" class="form-label">Location</label>
            <span class="form-control-plaintext"><?=location($row->location)?></span>
          </div>
          <div class="mb-3">
            <label for="date" class="form-label">Bank</label>
            <span class="form-control-plaintext"><?=vbank($row->vbank)?></span>
          </div>
          <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <span class="form-control-plaintext"><?=$row->sdate?></span>

          </div>
          <div class="mb-3">
            <label for="total_sales" class="form-label">Total Sales</label>
            <span class="form-control-plaintext">RM <?=number_format($row->tsales, 2)?></span>
          </div>
          <div class="mb-3">
            <label for="card" class="form-label">Card</label>
            <span class="form-control-plaintext">RM <?=number_format($row->card, 2)?></span>
          </div>
          <div class="mb-3">
            <label for="card" class="form-label">Atome</label>
            <span class="form-control-plaintext">RM <?=number_format($row->atome, 2)?></span>
          </div>
          <div class="mb-3">
            <label for="card" class="form-label">OT</label>
            <span class="form-control-plaintext">RM <?=number_format($row->ot, 2)?></span>
          </div>
          <div class="mb-3">
            <label for="netcash" class="form-label">Net Cash</label>
            <span class="form-control-plaintext">RM <?=number_format($row->netcash, 2)?></span>
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <span class="form-control-plaintext"><?=$row->description?></span>
          </div>
		  <?php
		  foreach($imageResult AS $image)
		  {
			  $parts = explode('__', $image->image);
		  ?>
			  <div class="mb-3">
				<span class="form-control-plaintext"><a href="<?= base_url()?><?=$image->image?>" title="Download It"><?=isset($parts[1]) ? $parts[1] : '';?></a></span>
			  </div>	
		  <?php
		  }
		  ?>
		  
		  <?php
		  foreach($sexpenses AS $expense)
		  {
		  ?>
			<div class="mb-3">
				<label for="description" class="form-label"><?=gname($expense->groupe)?></label>
				<span class="form-control-plaintext"><?=$expense->amount?></span>
				
				<a href="<?=base_url('expenses/editView2/')?><?=$expense->Id?>">EDIT</a>
			</div>
		  <?php
		  }
		  ?>
		  <label style="" title="Click to add expenses"><a href="<?=base_url('expenses/add2/')?><?=$row->Id?>/<?=$row->sdate?>/qs">Add Expense</a></label>
        </div>
		
        <div class="modal-footer bg-light rounded-bottom-4">
          <button type="button" onclick="window.location.href='<?= base_url('editJohoniSales/' . $row->Id) ?>'" class="btn btn-primary">Update</button>
        </div>
		<!--<button type="button" class="btn btn-secondary" onclick="window.close()">Cancel</button>-->
      </form>
    </div>
  </div>
</div>

</body>
</html>
