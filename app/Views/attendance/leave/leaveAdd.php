<form id="form1" method="post" action="<?=base_url('codeigniter/public/')?>paymentAddc">
	<input type="hidden" name="ptype" value="1">
	<div class="container mt-5">
		<table class="table table-bordered table-striped custom-table">
			<thead>
				<tr>
					<th colspan="2" class="text-center">Leave Request Form</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="4">
						<select class="form-select form-select-sm" id="status" name="status" onchange="changeRequire(this.value);" tabindex="1005">
							<option value="0">Leave Type</option>
							<?=$leaveTypes?>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<select class="form-select form-select-sm" id="bname" name="bname" tabindex="1005" required>
							<option value="">Select Bank</option>
							
						</select>
					</td>
				</tr>
				<tr>
					<td style="width: 25%;">Due Date:</td>
					<td colspan="3">
						<input class="form-control form-control-sm" name="ddate" id="ddate" type="date" required />
					</td>
				</tr>
				<tr>
					<td>Cheque No:</td>
					<td colspan="3">
						<input class="form-control form-control-sm" name="cno" id="cno" type="text" placeholder="No" required />
					</td>
				</tr>
				<tr>
					<td>Amount:</td>
					<td colspan="3">
						<input class="form-control form-control-sm" name="amount" id="amount" type="text" placeholder="RM 0" required />
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<select class="form-select form-select-sm" id="pto" name="pto" required>
							<option value="">Pay To</option>
							
						</select>
					</td>
				</tr>
				<tr>
					<td>Invoice No:</td>
					<td colspan="3">
						<input class="form-control form-control-sm" name="invNo" id="invNo" type="text" placeholder="Invoice No" />
					</td>
				</tr>
				<tr>
					<td>Remark:</td>
					<td colspan="3">
						<input class="form-control form-control-sm" name="remark" id="remark" type="text" placeholder="Remark" />
					</td>
				</tr>
			</tbody>
		</table>
		
		<div class="submit-btn" style="margin-bottom:10px;">
			<button class="btn btn-primary btn-sm">Save</button>
		</div>
	</div>
</form>	
