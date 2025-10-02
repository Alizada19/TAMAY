<table style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
	<tr>
	 <th colspan="2" style="width:100%;background-color:#b3d7ff87;text-align:center;">Unscheduled</th>
	</tr>
	<tr>
	  <td style="width:10%;background-color:#b3d7ff87;">Invoice No:</td>
	  <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="invno" id="invno" type="text" placeholder="No" onblur="makeCapital(this.value,'invno')" /></td>
	</tr>
	<tr>
	  <td style="width:10%;background-color:#b3d7ff87;">Cheque No:</td>
	  <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="cno" id="cno" type="text" placeholder="No" onblur="makeCapital(this.value,'cno')" /></td>
	</tr>
	<tr>
		<td colspan="4" style="width:100%;background-color:#b3d7ff87;">
			<select  style="background-color:#b3d7ff87;width:100%;font-size:20px;"  id="bname" name="bname"  tabindex="1005">
				<option value="">Select Bank</option>
				<?=$bstr?>				
			</select>
		</td>
	</tr>
	<tr>
	 <td style="width:10%;background-color:#b3d7ff87;">Due Date:</td>
	 <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="ddate" id="ddate" type="date" onblur="makeCapital(this.value,'ddate')" /></td>
	</tr>
	</tr>
	<tr>
	  <td style="width:10%;background-color:#b3d7ff87;">Amount:</td>
	  <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="amount" id="amount" type="text" placeholder="RM 0" onblur="makeCapital(this.value,'amount')" required /></td>
	</tr>
	<tr>
		<td colspan="4" style="width:100%;background-color:#b3d7ff87;">
			<select  style="background-color:#b3d7ff87;width:100%;font-size:20px;"  id="pto" name="pto"  tabindex="1005">
				<option value="">Pay To</option>
				<?=$str?>											
			</select>
		</td>
	</tr>
	<tr>
	  <td style="width:10%;background-color:#b3d7ff87;">Remark:</td>
	  <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="remark" id="remark" type="textarea" placeholder="Text" onblur="makeCapital(this.value,'remark')" /></td>
	</tr>
</table>