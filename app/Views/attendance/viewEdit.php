	
<div id="container" style="padding:5px 5px 5px 5px;width:100%;">
	<form id="form1" method="post" enctype="multipart/form-data" action="<?=base_url('codeigniter/public/attendance/saveEmpUpdate/')?><?=$row->Id?>">
		<div style="width:100%" style="margin-right:1%;">
			
			<table  style="width:100%;font-size:20px;float:left;margin-top:10px;margin-bottom:10px;">
			  <tr>
				 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Name:</td>
				 <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" placeholder="Text" name="name" id="name" type="text" value="<?=$row->name?>" required /></td>
			  </tr>
			  <tr>
				 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Last Name:</td>
				 <td colspan="3" style="width:26%;"><input class="form-control line" placeholder="Text" style="font-weight:bold;font-size:30px;" name="lname" id="lname" value="<?=$row->lname?>" type="text"/></td>
			  </tr>
			  <tr>
				<td colspan="4" style="width:100%;background-color:#b3d7ff87;">
					<select  style="background-color:#b3d7ff87;width:100%;font-size:20px;height:50px;text-align:center;"  id="location" name="location" ontempchange="showHideCheque(this.value)" required>
						<option value="">Select Location</option>
								<?=$lstr?>					
					</select>
				</td>
			  </tr>
			  <tr>
				<td colspan="4" style="width:100%;background-color:#b3d7ff87;">
					<select  style="background-color:#b3d7ff87;width:100%;font-size:20px;height:50px;text-align:center;"  id="dep" name="dep" ontempchange="showHideCheque(this.value)" required>
						<option value="">Select Department</option>
							<?=$dstr?>							
					</select>
				</td>
			  </tr>
			  <tr>
				<td colspan="4" style="width:100%;background-color:#b3d7ff87;">
					<select  style="background-color:#b3d7ff87;width:100%;font-size:20px;height:50px;text-align:center;"  id="nat" name="nat" ontempchange="showHideCheque(this.value)">
						<option value="">Select Nationality</option>								
							<?=$nstr?>						
					</select>
				</td>
			  </tr>
			  <tr>
				 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Contact No:</td>
				 <td colspan="3" style="width:26%;"><input class="form-control line" placeholder="No1" style="font-weight:bold;font-size:30px;" name="phone1" id="phone1" value="<?=$row->phone1?>" type="text"/></td>
			  </tr>
			  <tr>
				 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Emergency Contact::</td>
				 <td colspan="3" style="width:26%;"><input class="form-control line" placeholder="No2" style="font-weight:bold;font-size:30px;" name="phone2" id="phone2" value="<?=$row->phone2?>" type="text"/></td>
			  </tr>
			  <tr>
				 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">EMail:</td>
				 <td colspan="3" style="width:26%;"><input class="form-control line" placeholder="abc@yahoo.com" style="font-weight:bold;font-size:30px;" name="email" id="email" value="<?=$row->email?>" type="email"/></td>
			  </tr>
			   <tr>
				 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Commencement Date:</td>
				 <td colspan="3" style="width:26%;"><input class="form-control line" style="font-weight:bold;font-size:30px;" name="jdate" id="jdate" value="<?=$row->jdate?>" type="date"/></td>
			  </tr>
			  <tr>
				 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Current Address:</td>
				 <td style="">
					<textarea id="addr" name="addr" style="width:100%;padding-bottom:0px;"><?=$row->addr?></textarea>
				 </td>
			  </tr>
			  <tr>
				 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Basic Salary:</td>
				 <td colspan="3" style="width:26%;"><input class="form-control line" placeholder="Amount" style="font-weight:bold;font-size:30px;" name="bsalary" id="bsalary" value="<?=$row->bsalary?>" type="text"/></td>
			  </tr>
			  <tr>
				<td colspan="4" style="width:100%;background-color:#b3d7ff87;">
					<select  style="background-color:#b3d7ff87;width:100%;font-size:20px;height:50px;text-align:center;"  id="status" name="status" >
						<option value="">Select Status</option>	
						<?=$status?>	
					</select>
				</td>
			  </tr>
			  <tr>
				 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Working Hours:</td>
				 <td colspan="3" style="width:26%;"><input class="form-control line" placeholder="Example: 8" style="font-weight:bold;font-size:30px;" name="wh" id="wh" value="<?=$row->wh?>" type="text"/></td>
			  </tr>
			  <tr>
				<td colspan="4" style="width:100%;background-color:#b3d7ff87;">
					<select  style="background-color:#b3d7ff87;width:100%;font-size:20px;height:50px;text-align:center;"  id="offday" name="offday" >
						<option value="">Select off day</option>	
						 <?=$offdaystr?>
					</select>
				</td>
			  </tr>
			  <tr>
				 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Working Days In Month:</td>
				 <td colspan="3" style="width:26%;"><input class="form-control line" placeholder="Working Days Per Month" value="<?=$row->wdays?>" style="font-weight:bold;font-size:30px;" name="wdays" id="wdays" type="text"/></td>
			  </tr>
			  <tr>
				 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Tolerance:</td>
				 <td  style="width:26%;"><input class="form-control line" placeholder="In minutes " style="font-weight:bold;font-size:30px;" name="tol" id="tol" value="<?=$row->tolerance?>" type="text"/></td>
			  </tr>
			  <tr>
				<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">
					<select  style="background-color:#b3d7ff87;width:100%;font-size:20px;height:50px;text-align:center;"  id="gender" name="gender">
						<?=$gender?>																
					</select>
				</td>
				
				<td  style="width:10%;background-color:#b3d7ff87;padding-left:5px;">
					<select  style="background-color:#b3d7ff87;width:100%;font-size:20px;height:50px;text-align:center;"  id="mstatus" name="mstatus">
						<?=$mstatus?>															
					</select>
				</td>
			  </tr>
			  <tr>
				<td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">
					<label style="float:left; margin-left:1%;margin-right:1%;">DOB:</label>
				</td>
				<td style="width:35%;background-color:#b3d7ff87;padding-left:5px;">
					<input class="form-control line" style="font-weight:bold;font-size:30px; width:99%;" name="dob" id="dob" type="date"value="<?=$row->dob?>" />
				</td>
			  </tr>
			  <tr>
					<td colspan="2" style="width:10%;background-color:#b3d7ff87;">
						<select  style="background-color:#b3d7ff87;width:100%;font-size:20px;height:50px;text-align:center;"  id="bname" name="bname" >
							<option value="">Select Bank</option>	
							 <?=$bnames?>
						</select>
					</td>
			 </tr>
			 <tr>	
					<td style="width:5%;background-color:#b3d7ff87;padding-left:5px;">Account No:</td>
					<td colspan="1" style="width:26%;"><input class="form-control line" placeholder="Account No " style="font-weight:bold;font-size:30px;" name="accno" id="accno" type="text" value="<?=$row->accno?>"/></td>
					
			  </tr>
			  <tr>
				<td style="width:5%;background-color:#b3d7ff87;padding-left:5px;">Account Holder:</td>
				<td colspan="1" style="width:26%;"><input class="form-control line" placeholder="Account Holder " style="font-weight:bold;font-size:30px;" name="acch" id="acch" type="text" value="<?=$row->acch?>"/></td>
			  </tr>
			  <tr>
				<td style="width:5%;background-color:#b3d7ff87;padding-left:5px;">EPF:</td>
				<td colspan="1" style="width:26%;"><input class="form-control line" placeholder="EPF" style="font-weight:bold;font-size:30px;" name="epf" id="epf" type="text" value="<?=$row->epf?>" /></td>
			  </tr>
			  <tr>
				<td style="width:5%;background-color:#b3d7ff87;padding-left:5px;">SOCSO:</td>
				<td colspan="1" style="width:26%;"><input class="form-control line" placeholder="SOCSO" style="font-weight:bold;font-size:30px;" name="socso" id="socso" type="text" value="<?=$row->socso?>" /></td>
			  </tr>
			  <tr>
				<td style="width:5%;background-color:#b3d7ff87;padding-left:5px;">IC/PASSPORT:</td>
				<td colspan="1" style="width:26%;"><input class="form-control line" placeholder="IC/PASSPORT" style="font-weight:bold;font-size:30px;" name="ic" id="ic" type="text" value="<?=$row->ic?>" /></td>
			  </tr>
			  <tr>
				 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Update Profile Image:</td>
				 <td colspan="3" style="width:26%;">
						 <input type="file" name="image">
				 </td>
			  </tr>
			  <tr>
				 <td style="width:10%;background-color:#b3d7ff87;padding-left:5px;">Update ID Image:</td>
				 <td colspan="3" style="width:26%;">
						  <input type="file" name="imageid">
				 </td>
			  </tr>
			</table>
		</div>	
	
		<div class="row" style="margin:5px 5px 5px 0px;width:100%; ;">
		   <input type="submit" name="btn_result"   style="width:200px;" class="btn btn-primary line" id="save" value="Save" />
		</div>
		
	</form>		
</div>	
