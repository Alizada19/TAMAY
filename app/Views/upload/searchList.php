<div style="margin-top: 10%;">
	<form id="form1" method="post" enctype="multipart/form-data" action="#">
	
		<div>
			<input type="date" name="sdate" id="sdate"  value="<?=$sdate?>" style="width:20%; height:30px;	text-align:center;">
		</div>
		<div>
			<input type="date" name="edate" id="edate"  value="<?=$edate?>" style="width:20%; height:30px;	text-align:center;margin-top:5px;margin-bottom:5px;">
		</div>
		
	</form>	
			<input type="submit" value="Search by date" name="btn_result" onclick="submitForm('<?=base_url('codeigniter/public/searchExcel')?>')" style="width:110px;" class="btn btn-primary line"></button>
			
			<input type="submit" value="Ungroup" name="btn_result" onclick="submitForm('<?=base_url('codeigniter/public/ungroup')?>')" style="width:100px;" class="btn btn-primary line"></button>
			
			<!--<input type="submit" value="Chart" name="btn_result" onclick="submitForm('<?//=base_url('codeigniter/public/schart')?>')" style="width:100px;" class="btn btn-primary line"></button>-->
			<input type="submit" value="Group by Category" name="btn_result" onclick="submitForm('<?=base_url('codeigniter/public/gcategory')?>')" style="width:160px;" class="btn btn-primary line"></button>
			
			<input type="submit" value="Chart" name="btn_result" onclick="submitForm('<?=base_url('codeigniter/public/schart')?>')" style="width:100px;" class="btn btn-primary line"></button>
			
			<a title="Upload excel file" target="_blank" href="<?=base_url('codeigniter/public/excel')?>"><input type="button" name="btn_result" style="width:150px;" class="btn btn-primary line" value="Upload Excel File"  /></a>
			
	
			
	
	
	
	<div id="mainDive">
	<div style="width:98%; margin-right:1%; margin-left:1%;">	
		<div style="text-align:center; font-weight:bold;font-size: 18px;">
			List of stocks grouped by category and date
		</div>
		<table class="table table-bordered table-hover">
			<thead>
				<tr style="font-weight:bold;">
					<td>Date</td>
					<td>Category Name</td>
					<td>Cost</td>
					<td>Day cost</td>
				</tr>
			</thead>
			<tbody>		
				<?php $i = 1; foreach ($grouped as $date => $data): ?>
					<?php
						$first = true;
						$rowCount = count($data['categories']);
					?>
					<?php foreach ($data['categories'] as $category => $cost): ?>
						<tr>
							<?php if ($first): ?>
								<td rowspan="<?= $rowCount ?>"><?= esc(date_format(date_create($date), 'd-m-Y')) ?></td>
								<?php $first = false; ?>
							<?php endif; ?>
							<td><?= esc($category) ?></td>
							<td>RM <?= number_format($cost, 2) ?></td>
							<?php if ($category === array_key_last($data['categories'])): ?>
								<td><strong>RM <?= number_format($data['total'], 2) ?></strong></td>
							<?php endif; ?>
						</tr>
					<?php endforeach; ?>
				<?php endforeach; ?>

				<tr style="font-weight:bold;">
					<td colspan="3">Total cost</td>
					<td>RM <?=number_format($total->cost, 2)?></td>
				</tr>
			</tbody>
		</table>
		<div>
			<input type="submit" value="Export PDF" name="btn_result" onclick="submitForm('<?=base_url('codeigniter/public/uploadexcel/Printpdf')?>')" style="width:100px;" class="btn btn-primary line"></button>
		</div>	
	</div>
	</div>
</div>
<script>
function submitForm(actionUrl) {
    let form = document.getElementById("form1");
	form.action = actionUrl;

	let openInNewTab = actionUrl.includes('Printpdf');

	if (openInNewTab) {
		form.target = "_blank";
	} else {
		form.removeAttribute("target"); // or form.target = "";
	}

	form.submit();
}
</script>