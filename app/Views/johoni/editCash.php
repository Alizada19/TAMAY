<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Cash Deposit Record</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="<?=base_url()?>js/jq.js"></script>
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
        <h5 class="modal-title">Edit Cash Deposit Record</h5>
        <button type="button" class="btn-close btn-close-white" onclick="window.close()" aria-label="Close"></button>
      </div>
      <form enctype="multipart/form-data" action="<?=base_url('editCashSave/')?><?=$rid?>" method="post">
        <div class="modal-body">
          <div class="mb-3">
            <select  style="width:100%;height:40px;text-align:center;"  id="vbank" name="vbank" required>
							<?=$str2?>							
						</select>
          </div>
          <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" name="sdate" value="<?=$row->sdate?>" required>
          </div>
          <div class="mb-3">
            <label for="total_sales" class="form-label">Amount</label>
            <input type="number" step="0.01" class="form-control" name="amount" id="amount" value="<?=$row->amount?>" required>
          </div>
          <div class="mb-3">
            <label for="total_sales" class="form-label">Deduction if any</label>
            <input type="number" step="0.01" class="form-control" name="deduction" id="deduction" value="<?=$row->deduction?>" required>
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" rows="2"><?=$row->description?></textarea>
          </div>
        </div>
        <div class="modal-footer bg-light rounded-bottom-4">
		  <input type="file" name="attachments[]" id="attachments" style="width:60%;" multiple />
          <button type="submit" class="btn btn-primary">Update Record</button>
        </div>
		<!--<button type="button" class="btn btn-secondary" onclick="window.close()">Cancel</button>-->
      </form>
    </div>
  </div>
</div>

</body>
</html>
