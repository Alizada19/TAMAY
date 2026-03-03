<?php

namespace App\Controllers;
use App\Models\DailyModel;
class Payment extends BaseController
{
    //my constructor
	public function __construct() {

        $this->DailyModel = new DailyModel();
		//$this->session = \Config\Services::session();
        helper('fornames');
	}
	
	public function index(): string
    {
		
		$data['sname'] = $this->session->get('name'); 
		
        return view('payments/home', $data);
    }
	//Bring the main type of payment forms
	public function bringPtype($value): string
    {
		 $data['sname'] = $this->session->get('name');
		
		$db = \Config\Database::connect();
		
		 //Bring the banks
		 $banksr = $db->query("SELECT * FROM banks");
		 $banks = $banksr->getResult();
		 $bstr='';
		 foreach($banks AS $bank)
		 {
			$bstr.='<option value="'.$bank->Id.'">'.$bank->bname.'</option>';
		 }
		 $data['bstr'] = $bstr;
		 //Bring the debtors and creditors
		 $dc = $db->query("SELECT * FROM debtorcreditor");
		 $dcres = $dc->getResult();
		 //echo "<pre />"; print_r($dcres); exit;
		 $str='';
		 foreach($dcres AS $dc)
		 {
			$str.='<option value="'.$dc->Id.'">'.$dc->dcnames.'</option>';
		 }	 
		 $data['str'] = $str;
		if($value ==1)
		{	
			return view('payments/cheque', $data);
		}
		else if($value==2)
		{
			return view('payments/ocash', $data);
		}
		else if($value==4)
		{
			return view('payments/unsched', $data);
		}	
        
    }
	// Add cheque
	public function addc()
    { 
        
		$request = \Config\Services::request();
		
		$ptype = $request->getPost('ptype');
		if($ptype == 1)
		{
			$bname = $request->getPost('bname');
			$ddate = $request->getPost('ddate');
			$cno = $request->getPost('cno');
			$pto = $request->getPost('pto');
			$amount = $request->getPost('amount');
			$invNo = $request->getPost('invNo');
			$remark = $request->getPost('remark');
			$status = $request->getPost('status');
			
			
			//Get username and id from the session
			$username = $this->session->get('name');
			$userid = $this->session->get('userid');
			
			$data = array(
				'bname'=>$bname,
				'ptype'=>$ptype,
				'ddate'=>$ddate,
				'cno'=>$cno,
				'amount'=>$amount,
				'pto'=>$pto,
				'invNo'=>$invNo,
				'remark'=>$remark,
				'status'=>$status,
				'userid'=>$userid,
				'username'=>$username,
				"saveDate" => date('Y-m-d H:i:s')
			  );
			if($status!=10)
			{
				 //Check if cheque no exist already
				$db = \Config\Database::connect();
				$query = $db->query("SELECT cno FROM payments WHERE cno=$cno");
				$samecno = $query->getNumRows();
				if($samecno<1)
				{
					 $rid = $this->DailyModel->gadd($data, 'payments'); 

					if($rid != 0)
					{	
							 return redirect()->to(base_url('paymentViewc/'.$rid.'/1'.'')); exit;
					}
					else
					{
						echo "Record not updated successfully!";
					}
				}
				else
				{
					echo "cheque number already exist in the database!";
				}
			}
			else
			{
				 $rid = $this->DailyModel->gadd($data, 'payments'); 

				if($rid != 0)
				{	
						 return redirect()->to(base_url('paymentViewc/'.$rid.'/1'.'')); exit;
				}
				else
				{
					echo "Record not updated successfully!";
				}
			}		
		}
		else if($ptype == 2)
		{
				
				//$oc = $request->getPost('oc');
				$invno = $request->getPost('invno');
				$ddate = $request->getPost('ddate');
				$invDate = $request->getPost('invDate');
				$amount = $request->getPost('amount');
				$pto = $request->getPost('pto');
				$remark = $request->getPost('remark');
				
				
				//Get username and id from the session
				$username = $this->session->get('name');
				$userid = $this->session->get('userid');
				
				$data = array(
					'ptype'=>$ptype,
					'invNo'=>$invno,
					'invDate'=>$invDate,
					//'oc'=>$oc,
					'ddate'=>$ddate,
					'amount'=>$amount,
					'pto'=>$pto,
					'remark'=>$remark,
					'userid'=>$userid,
					'username'=>$username,
					"saveDate" => date('Y-m-d H:i:s')
				  );
				
				 //Check if cheque no exist already
				$db = \Config\Database::connect();
				$query = $db->query("SELECT invNo FROM payments WHERE invNo='$invno'");
				$sameInvo = $query->getNumRows();
				if($sameInvo<1)
				{
					$rid = $this->DailyModel->gadd($data, 'payments'); 
					
					if($rid != 0)
					{	
							 return redirect()->to(base_url('paymentViewoc/'.$rid.'/1'.'')); exit;
					}
					else
					{
						echo "You can not insert report of same date twoice!";
					}
				}
				else
				{
						echo "This invoice is already saved in to database!";
				}		
		}
		else if($ptype == 4)
		{   
				//For the unscheduled form
				$invno = $request->getPost('invno');
				$ddate = $request->getPost('ddate');
				$amount = $request->getPost('amount');
				$pto = $request->getPost('pto');
				$remark = $request->getPost('remark');
				$bname = $request->getPost('bname');
				$cno = $request->getPost('cno');
				
				//Get username and id from the session
				$username = $this->session->get('name');
				$userid = $this->session->get('userid');
				
				$data = array(
					'ptype'=>$ptype,
					'invNo'=>$invno,
					'cno'=>$cno,
					'bname'=>$bname,
					'ddate'=>$ddate,
					'amount'=>$amount,
					'pto'=>$pto,
					'remark'=>$remark,
					'userid'=>$userid,
					'status'=>4,
					'username'=>$username,
					"saveDate" => date('Y-m-d H:i:s')
				  );
				
				
				
				$rid = $this->DailyModel->gadd($data, 'payments'); 
				
				if($rid != 0)
				{	
						 return redirect()->to(base_url('paymentun/'.$rid.'/1'.'')); exit;
				}
				else
				{
					echo "Your data is not inserted!";
				}
					
		}		
    }
	
	//View cheque
	public function viewc($rid,$suc)
    { 
		 //connect Database
		 $db = \Config\Database::connect();
		 
		 //Get username and id from the session
		 $username = $this->session->get('name');
		 $userid = $this->session->get('userid');
		
		 $builder = $db->table('payments');
		 $query = $builder->getWhere(['Id' => $rid]);
		 $query = $query->getRow();
		 
		 $data['sname'] = $username;
		 $data['userid'] = $userid;
		 $data['query'] = $query;
		 $data['suc'] = $suc;
		 return view('payments/vcheque', $data);
	}
	
	//View online transfer or cheque
	public function viewoc($rid,$suc)
    { 
		 //connect Database
		 $db = \Config\Database::connect();
		 
		 //Get username and id from the session
		 $username = $this->session->get('name');
		 $userid = $this->session->get('userid');
		
		 $builder = $db->table('payments');
		 $query = $builder->getWhere(['Id' => $rid]);
		 $query = $query->getRow();
		 
		 $data['sname'] = $username;
		 $data['userid'] = $userid;
		 $data['query'] = $query;
		 $data['suc'] = $suc;
		 return view('payments/viewoc', $data);
	}
	
	//Update payments view cheque
	public function updatec($rid)
    {   
		 //connect Database
		 $db = \Config\Database::connect();
		 
		 //Get username and id from the session
		 $username = $this->session->get('name');
		 $userid = $this->session->get('userid');
		
		 $builder = $db->table('payments');
		 $query = $builder->getWhere(['Id' => $rid]);
		 $query = $query->getRow();
		 
		 //select the payment type
		 $str='';
		 if($query->ptype == 1)
		 {
			$str.="<option value='1' selected>Cheque</option>";
			$str.="<option value='2' >Online/Cash</option>";
		 }
		 else if($query->ptype == 2)
		 {
			$str.="<option value='1'>Cheque</option>";
			$str.="<option value='2' selected>Online/Cash</option>";
		 }
		 
		 //select the payment status
		 $pstr='';
		 if($query->status == 1)
		 {
			$pstr.="<option value='1' selected>Pending</option>";
			$pstr.="<option value='2' >Paid</option>";
			$pstr.="<option value='3' >Conceld</option>";
		 }
		 else if($query->status == 2)
		 {
			$pstr.="<option value='1'>Pending</option>";
			$pstr.="<option value='2' selected>Paid</option>";
			$pstr.="<option value='3'>Conceld</option>";
		 }
		 else if($query->status == 3)
		 {
			$pstr.="<option value='1'>Pending</option>";
			$pstr.="<option value='2'>Paid</option>";
			$pstr.="<option value='3' selected>Conceld</option>";
		 }
		 else if($query->status == 10)
		 {
			$pstr.="<option value='1'>Pending</option>";
			$pstr.="<option value='2'>Paid</option>";
			$pstr.="<option value='3'>Conceld</option>";
			$pstr.="<option value='10' selected>Not Issued</option>";
		 }
		 //Bring and select banks
		 $banksr = $db->query("SELECT * FROM banks");
		 $banks = $banksr->getResult();
		 $bstr='';  
		 foreach($banks AS $bank)
		 {
			if($bank->Id == $query->bname)
			{	
				$bstr.='<option value="'.$bank->Id.'" selected>'.$bank->bname.'</option>';
			}
			else
			{
				$bstr.='<option value="'.$bank->Id.'">'.$bank->bname.'</option>';
			}		
		 }
		 
		 //display Pay to creditors and debtors 
		 $dcquery = $db->query("SELECT * FROM debtorcreditor");
		 $dcquery = $dcquery->getResult();
		 $dcstr='';  
		 foreach($dcquery AS $dc)
		 {
			if($dc->Id == $query->pto)
			{	
				$dcstr.='<option value="'.$dc->Id.'" selected>'.$dc->dcnames.'</option>';
			}
			else
			{
				$dcstr.='<option value="'.$dc->Id.'">'.$dc->dcnames.'</option>';
			}		
		 }
		 
		 $data['sname'] = $username;
		 $data['userid'] = $userid;
		 $data['query'] = $query;
		 $data['str'] = $str;
		 $data['bstr'] = $bstr;
		 $data['dcstr'] = $dcstr;
		 $data['rid'] = $rid;
		 $data['pstr'] = $pstr;
		 return view('payments/updatec', $data);
	}	 
	
	//Update payments view online transfer and cash
	public function updateoc($rid)
    {   
		 //connect Database
		 $db = \Config\Database::connect();
		 
		 //Get username and id from the session
		 $username = $this->session->get('name');
		 $userid = $this->session->get('userid');
		
		 $builder = $db->table('payments');
		 $query = $builder->getWhere(['Id' => $rid]);
		 $query = $query->getRow();
		 
		 //select the payment type
		 $str='';
		 if($query->ptype == 1)
		 {
			$str.="<option value='1' selected>Cheque</option>";
			$str.="<option value='2' >Online/Cash</option>";
		 }
		 else if($query->ptype == 2)
		 {
			$str.="<option value='1'>Cheque</option>";
			$str.="<option value='2' selected>Online/Cash</option>";
		 }
			
		//select the payment status
		 $pstr='';
		 if($query->status == 1)
		 {
			$pstr.="<option value='1' selected>Pending</option>";
			$pstr.="<option value='2' >Paid</option>";
			$pstr.="<option value='3'>Conceld</option>";
		 }
		 else if($query->status == 2)
		 {
			$pstr.="<option value='1'>Pending</option>";
			$pstr.="<option value='2' selected>Paid</option>";
			$pstr.="<option value='3'>Conceld</option>";
		 }	
		 else if($query->status == 3)
		 {
			$pstr.="<option value='1'>Pending</option>";
			$pstr.="<option value='2'>Paid</option>";
			$pstr.="<option value='3' selected>Conceld</option>";
		 }	
		 //select type of transfer OT/Cash
		 /*$ocstr='';
		 if($query->oc == 1)
		 {
			$ocstr.="<option value='1' selected>OT (Online Transfer)</option>";
			$ocstr.="<option value='2' >Cash</option>";
		 }
		 else
		 {
			$ocstr.="<option value='1' >OT (Online Transfer)</option>";
			$ocstr.="<option value='2' selected>Cash</option>";
		 }	*/	
		 
		 //display Pay to creditors and debtors 
		 $dcquery = $db->query("SELECT * FROM debtorcreditor");
		 $dcquery = $dcquery->getResult();
		 $dcstr='';  
		 foreach($dcquery AS $dc)
		 {
			if($dc->Id == $query->pto)
			{	
				$dcstr.='<option value="'.$dc->Id.'" selected>'.$dc->dcnames.'</option>';
			}
			else
			{
				$dcstr.='<option value="'.$dc->Id.'">'.$dc->dcnames.'</option>';
			}		
		 }
		 
		 $data['sname'] = $username;
		 $data['userid'] = $userid;
		 $data['query'] = $query;
		 $data['str'] = $str;
		 //$data['ocstr'] = $ocstr;
		 $data['dcstr'] = $dcstr;
		 $data['rid'] = $rid;
		 $data['pstr'] = $pstr;
		 return view('payments/updateoc', $data);
	}	
	// Update the records in to database
	public function updatecs($rid)
    { 
        
		$request = \Config\Services::request();
		
		$ptype = $request->getPost('ptype'); 
		//Cheque parts
		if($ptype == 1)
		{	
			$bname = $request->getPost('bname');
			$ddate = $request->getPost('ddate');
			$cno = $request->getPost('cno');
			$pto = $request->getPost('pto');
			$amount = $request->getPost('amount');
			$invNo = $request->getPost('invNo');
			$remark = $request->getPost('remark');
			$pstatus = $request->getPost('pstatus');
			
			
			//Get username and id from the session
			$username = $this->session->get('name');
			$userid = $this->session->get('userid');
			
			$data = array(
				'bname'=>$bname,
				'ptype'=>$ptype,
				'ddate'=>$ddate,
				'cno'=>$cno,
				'amount'=>$amount,
				'pto'=>$pto,
				'remark'=>$remark,
				'invNo'=>$invNo,
				'status'=>$pstatus,
				'userid'=>$userid,
				'username'=>$username,
				"saveDate" => date('Y-m-d H:i:s')
			  );
			 
			if($pstatus!=10)
			{	
				//Check if cheque no exist already
				$db = \Config\Database::connect();
				$query = $db->query("SELECT cno FROM payments WHERE cno=$cno");
				$samecno = $query->getNumRows();
				if($samecno<2)
				{		
					 
					$up = $this->DailyModel->gupdate($data,$rid, 'payments'); 
					if($up != 0)
					{	
							 return redirect()->to(base_url('paymentViewc/'.$rid.'/1'.''));
					}
					else
					{
						echo "Record not updated successfully!";
					}
				}
				else
				{
					echo "cheque number already exist in the database!";
				}
			}
			else 
			{
					$up = $this->DailyModel->gupdate($data,$rid, 'payments'); 
					if($up != 0)
					{	
							 return redirect()->to(base_url('paymentViewc/'.$rid.'/1'.''));
					}
					else
					{
						echo "Record not updated successfully!";
					}
			}		
		}
		else if($ptype == 2)
		{
				
				//Online transfer/cash part
				//$oc = $request->getPost('oc');
				$invno = $request->getPost('invno');
				$ddate = $request->getPost('ddate');
				$invDate = $request->getPost('invDate');
				$amount = $request->getPost('amount');
				$pto = $request->getPost('pto');
				$remark = $request->getPost('remark');
				$pstatus = $request->getPost('pstatus');
				
				
				//Get username and id from the session
				$username = $this->session->get('name');
				$userid = $this->session->get('userid');
				
				$data = array(
					'ptype'=>$ptype,
					'invNo'=>$invno,
					//'oc'=>$oc,
					'ddate'=>$ddate,
					'invDate'=>$invDate,
					'amount'=>$amount,
					'pto'=>$pto,
					'remark'=>$remark,
					'status'=>$pstatus,
					'userid'=>$userid,
					'username'=>$username,
					"saveDate" => date('Y-m-d H:i:s')
				  );
				
				//Check if invoice no exist already
				$db = \Config\Database::connect();
				$query = $db->query("SELECT invNo FROM payments WHERE invNo='$invno'");
				$sameInvo = $query->getNumRows();
				if($sameInvo<2)
				{
					$up = $this->DailyModel->gupdate($data,$rid, 'payments'); 
					if($up != 0)
					{	
							 return redirect()->to(base_url('paymentViewoc/'.$rid.'/1'.''));
					}
					else
					{
						echo "Record not updated successfully!";
					}
				}
				else
				{
						echo "This invoice is already saved in to database!";
				}		
		}
		else if($ptype == 4)
		{
				//Unscheduled
				$invno = $request->getPost('invno');
				$bname = $request->getPost('bname');
				$cno = $request->getPost('cno');
				$ddate = $request->getPost('ddate');
				$amount = $request->getPost('amount');
				$pto = $request->getPost('pto');
				$remark = $request->getPost('remark');
				$pstatus = $request->getPost('pstatus');
				
				//Get username and id from the session
				$username = $this->session->get('name');
				$userid = $this->session->get('userid');
				
				if($pstatus == 1)
				{
					if($cno)
					{
					 $ptype = 1;
					}
					else 
					{
						$ptype=2;
					}		
					$unsched = 2;
					
				}
				else if($pstatus == 4)
				{
					$unsched = 1;
				}		
						
				$data = array(
					'ptype'=>$ptype,
					'invNo'=>$invno,
					'bname'=>$bname,
					'cno'=>$cno,
					'ddate'=>$ddate,
					'amount'=>$amount,
					'pto'=>$pto,
					'remark'=>$remark,
					'status'=>$pstatus,
					'Unsched'=>$unsched,
					'userid'=>$userid,
					'username'=>$username,
					"saveDate" => date('Y-m-d H:i:s')
				  );
				
				$up = $this->DailyModel->gupdate($data,$rid, 'payments'); 
				if($up != 0)
				{	
						 return redirect()->to(base_url('paymentun/'.$rid.'/1'.''));
				}
				else
				{
					echo "Record not updated successfully!";
				}
					
		}		
    }
	
	//View unscheduled payments
	public function viewun($rid,$suc)
	{ 
		 //connect Database
		 $db = \Config\Database::connect();
		 
		 //Get username and id from the session
		 $username = $this->session->get('name');
		 $userid = $this->session->get('userid');
		
		 $builder = $db->table('payments');
		 $query = $builder->getWhere(['Id' => $rid]);
		 $query = $query->getRow();
		 
		 $data['sname'] = $username;
		 $data['userid'] = $userid;
		 $data['query'] = $query;
		 $data['suc'] = $suc;
		 return view('payments/unview', $data);
	}
	
	//Update view for the unscheduled
	public function schedupv($rid)
    {   
		 //connect Database
		 $db = \Config\Database::connect();
		 
		 //Get username and id from the session
		 $username = $this->session->get('name');
		 $userid = $this->session->get('userid');
		
		 $builder = $db->table('payments');
		 $query = $builder->getWhere(['Id' => $rid]);
		 $query = $query->getRow();	
		//select the payment status
		 $pstr='';
		 if($query->status == 1)
		 {
			$pstr.="<option value='1' selected>Pending</option>";
			$pstr.="<option value='4' >Unscheduled</option>";
		 }
		 else if($query->status == 4)
		 {
			$pstr.="<option value='1'>Pending</option>";
			$pstr.="<option value='4' selected>Unscheduled</option>";
		 }		 
		 //display Pay to creditors and debtors 
		 $dcquery = $db->query("SELECT * FROM debtorcreditor");
		 $dcquery = $dcquery->getResult();
		 $dcstr='';  
		 foreach($dcquery AS $dc)
		 {
			if($dc->Id == $query->pto)
			{	
				$dcstr.='<option value="'.$dc->Id.'" selected>'.$dc->dcnames.'</option>';
			}
			else
			{
				$dcstr.='<option value="'.$dc->Id.'">'.$dc->dcnames.'</option>';
			}		
		 }
		 //Bring and select banks
		 $banksr = $db->query("SELECT * FROM banks");
		 $banks = $banksr->getResult();
		 $bstr='';  
		 foreach($banks AS $bank)
		 {
			if($bank->Id == $query->bname)
			{	
				$bstr.='<option value="'.$bank->Id.'" selected>'.$bank->bname.'</option>';
			}
			else
			{
				$bstr.='<option value="'.$bank->Id.'">'.$bank->bname.'</option>';
			}		
		 }
		 $data['sname'] = $username;
		 $data['userid'] = $userid;
		 $data['query'] = $query;
		 $data['dcstr'] = $dcstr;
		 $data['rid'] = $rid;
		 $data['pstr'] = $pstr;
		 $data['bstr'] = $bstr;
		 return view('payments/unschedupdate', $data);
	}
}
