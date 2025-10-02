<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
	<tr>
	 <th colspan="2" style="width:100%;background-color:#b3d7ff87;text-align:center;">Cheque Entry Form</th>
	</tr>
	<tr>
		<td colspan="4" style="width:100%;background-color:#b3d7ff87;">
			<select  style="background-color:#b3d7ff87;width:100%;font-size:20px;"  id="status" name="status" onchange="changeRequire(this.value);" tabindex="1005">
				<option value="1">Issued</option>			
				<option value="10">Not Issued</option>			
			</select>
		</td>
	</tr>
	<tr>
		<td colspan="4" style="width:100%;background-color:#b3d7ff87;">
			<select  style="background-color:#b3d7ff87;width:100%;font-size:20px;"  id="bname" name="bname"  tabindex="1005" required>
				<option value="">Select Bank</option>
				<?=$bstr?>				
			</select>
		</td>
	</tr>
	<tr>
	 <td style="width:10%;background-color:#b3d7ff87;">Due Date:</td>
	 <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="ddate" id="ddate" type="date" onblur="makeCapital(this.value,'ddate')" required /></td>
	</tr>
	<tr>
	  <td style="width:10%;background-color:#b3d7ff87;">Cheque No:</td>
	  <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="cno" id="cno" type="text" placeholder="No" onblur="makeCapital(this.value,'cno')" required /></td>
	</tr>
	</tr>
	<tr>
	  <td style="width:10%;background-color:#b3d7ff87;">Amount:</td>
	  <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="amount" id="amount" type="text" placeholder="RM 0" onblur="makeCapital(this.value,'amount')" required /></td>
	</tr>
	<tr>
		<td colspan="4" style="width:100%;background-color:#b3d7ff87;">
			<select  style="background-color:#b3d7ff87;width:100%;font-size:20px;"  id="pto" name="pto"  tabindex="1005" required>
				<option value="">Pay To</option>
				<?=$str?>											
			</select>
		</td>
	</tr>
	<tr>
	  <td style="width:10%;background-color:#b3d7ff87;">Invoice No:</td>
	  <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="invNo" id="invNo" type="text" placeholder="Invoice No" onblur="" /></td>
	</tr>
	<tr>
	  <td style="width:10%;background-color:#b3d7ff87;">Remark:</td>
	  <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="remark" id="remark" type="textarea" placeholder="" onblur="makeCapital(this.value,'remark')" /></td>
	</tr>
</table>

<script>
	function changeRequire(val)
	{
		if(val==1)
		{
			$('#cno').attr('required', 'required');
		}
		else if(val==10)
		{
			 $('#cno').removeAttr('required');
		}		
	}	
</script>