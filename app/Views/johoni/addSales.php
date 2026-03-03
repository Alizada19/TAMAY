<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Sales Record</title>
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
        <h5 class="modal-title">Add Sales Record</h5>
        <button type="button" class="btn-close btn-close-white" onclick="window.close()" aria-label="Close"></button>
      </div>
      <form enctype="multipart/form-data" action="<?=base_url('johoniSaveSales')?>" method="post">
        <div class="modal-body">
		      <div class="mb-3">
            <select  style="width:100%;height:40px;text-align:center;"  id="location" name="location" required>
							<?=$str?>							
						</select>
          </div>
          <div class="mb-3">
            <select  style="width:100%;height:40px;text-align:center;"  id="vbank" name="vbank" required>
							<?=$str2?>							
						</select>
          </div>
          <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" name="date" required>
          </div>
          <div class="mb-3">
            <label for="total_sales" class="form-label">Total Sales</label>
            <input type="number" step="0.01" class="form-control" name="total_sales" id="tsales" required>
          </div>
          <div class="mb-3">
            <label for="card" class="form-label">Card</label>
            <input type="number" step="0.01" class="form-control" name="card" id="card" value="0">
          </div>
          <div class="mb-3">
            <label for="card" class="form-label">Atome</label>
            <input type="number" step="0.01" class="form-control" name="atome" id="atome" value="0">
          </div>
          <div class="mb-3">
            <label for="card" class="form-label">OT</label>
            <input type="number" step="0.01" class="form-control" name="ot" id="ot" value="0">
          </div>
          <div class="mb-3">
            <label for="netcash" class="form-label">Net Cash</label>
            <input type="number" step="0.01" class="form-control" name="netcash" id="netCash" onfocus="getNetCash();">
          </div>
		  <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" rows="2"></textarea>
          </div>
        </div>
        <div class="modal-footer bg-light rounded-bottom-4">
		  <label for="description" class="form-label">Sales Book</label>
		  <input type="file" name="attachments[]" id="attachments" style="width:60%;" multiple />
        </div>
		<div class="modal-footer bg-light rounded-bottom-4">
			<button type="submit" class="btn btn-primary" onclick="getNetCash();">Next</button>
		</div>
		<!--<button type="button" class="btn btn-secondary" onclick="window.close()">Cancel</button>-->
      </form>
    </div>
  </div>
</div>
<script>
function getNetCash()
{ 
	var stotal = $("#tsales").val();
	var scard = $("#card").val();
	var atome = $("#atome").val();
	var ot = $("#ot").val();
	var total;
	if(stotal == '')
	{
		total = 0;
	}
	if(stotal == '')
	{   
		total = 0;
	}	
	total = parseFloat(stotal) - (parseFloat(scard) + parseFloat(atome) + parseFloat(ot));
	total = parseFloat(total.toFixed(2));
	$("#netCash").val(total);
}
</script>
</body>
</html>
