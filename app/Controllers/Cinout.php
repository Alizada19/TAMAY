<?php

namespace App\Controllers;
use App\Models\DailyModel;
use App\Models\salary\SalaryModel;
use App\Models\attendance\AttendanceModel;

require_once(APPPATH . '/ThirdParty/vendor2/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Cinout extends BaseController
{
    //my constructor
	public function __construct() {

        $this->DailyModel = new DailyModel();
        $this->SalaryModel = new SalaryModel();
		$this->AttendanceModel = new AttendanceModel();
		//$this->session = \Config\Services::session();
        helper('fornames');
	}
	
	public function index(): string
    {
		
		$data['sname'] = $this->session->get('name'); 
		$shop = $this->session->get('shop'); 
		$data['dvalue'] = 2; 
		//Bring today's inout 
		$str = '';
		if($shop !='')
		{	
			//Check my role
			$myrole = $this->session->get('myRole');
			$shops = array(
				'1'=>'B&S',
				'2'=>'GILASCO',
				'3'=>'ESI',
				'4'=>'ESW',
				'5'=>'JOHONI-Q',
				'6'=>'E66A',
				'10'=>'ME Perfume',
				'11'=>'JOHONI JB'
				 );
			if($myrole == 1)
			{
				  
				 foreach($shops AS $key=>$value)
				 {
					if($key == $shop)
					{	
						$str.='<option value="'.$key.'" selected>'.$value.'</option>';
					}
					else
					{
						$str.='<option value="'.$key.'">'.$value.'</option>';
					}		
				 }
			}
			else
			{		
				foreach($shops AS $key=>$value)
				 {
					if($key == $shop)
					{	
						$str.='<option value="'.$key.'" selected>'.$value.'</option>';
					}		
				 }			
			}
			$cdate = date('Y-m-d');	
			$res2 = $this->DailyModel->todayrecords($shop, $cdate);
			$total = $this->DailyModel->totalrecordsoftoday($shop, $cdate); 
			$percentage = '';
			if($total->customers)
			{	
				$percentage = round($total->purchased / $total->customers * 100); 
			}
			
		}
		else
		{
			$res2 = '';
			$total = 0;
			$percentage='';
		}		
		
		//echo "<pre />"; print_r($total); exit;
		$data['res2'] = $res2;
		$data['total'] = $total;
		$data['percentage'] = $percentage;
		$data['str'] = $str;
		return view('cinout/home', $data);
		
    }
	
	public function save()
    { 
        
		$request = \Config\Services::request();
		$shop = $request->getPost('shop');
		
		
		$cin = $request->getPost('cin');
				
		$pur = $request->getPost('parchase');
		$lf = $request->getPost('lf');
		$remark = $request->getPost('remark');
		$purchase =0;
		$purchasenot =0;
		if($pur == 1)
		{		
			$purchase = 1;
		}
		else
		{
			$purchasenot = 1; 
		}
		$local=0;
		$foreigner=0;
		if($lf == 1)
		{		
			$local = 1;
		}
		else
		{
			$foreigner = 1; 
		}		
		//Get username and id from the session
		$username = $this->session->get('name');
		$userid = $this->session->get('userid');
		
		$data = array(
			'shop'=>$shop,
			'cin'=>$cin,
			'purchase'=>$purchase,
			'purchasenot'=>$purchasenot,
			'local'=>$local,
			'foreigner'=>$foreigner,
			'remark'=>$remark,
			'userid'=>$userid,
			'username'=>$username,
			"saveDate" => date('Y-m-d H:i:s')
          );
		//echo "<pre />"; print_r($data); exit;
		//Add data
		$res = $this->DailyModel->savedc($data, 'cinout');
		if($res)
		{
			
			//Check my role
			$str = '';
			$myrole = $this->session->get('myRole');
			$shops = array(
				'1'=>'B&S',
				'2'=>'GILASCO',
				'3'=>'ESI',
				'4'=>'ESW',
				'5'=>'JOHONI-Q',
				'6'=>'E66A',
				'10'=>'ME Perfume',
				'11'=>'JOHONI JB'
				 );
			if($myrole == 1)
			{
				  
				 foreach($shops AS $key=>$value)
				 {
					if($key == $shop)
					{	
						$str.='<option value="'.$key.'" selected>'.$value.'</option>';
					}
					else
					{
						$str.='<option value="'.$key.'">'.$value.'</option>';
					}		
				 }
			}
			else
			{		
				foreach($shops AS $key=>$value)
				 {
					if($key == $shop)
					{	
						$str.='<option value="'.$key.'" selected>'.$value.'</option>';
					}		
				 }			
			}
			$cdate=date('Y-m-d'); 
			$res2 = $this->DailyModel->todayrecords($shop, $cdate);
			$total = $this->DailyModel->totalrecordsoftoday($shop, $cdate);
			$percentage = '';
			if($total->customers)
			{	
				$percentage = round($total->purchased / $total->customers * 100); 
			}
			$data['res2'] = $res2;
			$data['total'] = $total;
			$data['percentage'] = $percentage;
			$data['str'] = $str;
			return view('cinout/dailysub', $data);
		}		
		else
		{
			echo "Not inserted";
		}		
		
    }
	
	//Add customer
	public function customerAdd()
	{
		
		
		
		$shop = $this->session->get('shop');
		$myRole = $this->session->get('myRole'); 
		$records = $this->SalaryModel->customerRecords($shop, $myRole);
		$data['records'] = $records;		
		//Locations
		$locations = $this->SalaryModel->getLocations2($myRole, $shop);	
		$shops='';
		foreach($locations AS $shop)
		{
				$shops.='<option value="'.$shop->Id.'">'.$shop->name.'</option>';	
		}
		$data['locations'] = $shops;
		$hdata['title']='CUSTOMER INFORMATION';
		echo view('cinout/header', $hdata);
		echo view('cinout/customerAdd', $data);
		echo view('cinout/footer');
	}

	//Customer Save
	public function customerSave()
	{
			$location = $this->request->getPost('location'); 
			$cname = $this->request->getPost('cname'); 
			$phone = $this->request->getPost('phone'); 
			$tr = $this->request->getPost('tr'); 
			$gender = $this->request->getPost('gender'); 
			$dob = $this->request->getPost('dob'); 
			$product = $this->request->getPost('product');
			$invamount = $this->request->getPost('invamount');
			
			//Get username and id from the session
			$username = $this->session->get('name');
			$userid = $this->session->get('userid');
			$data = array(
				'location'	=>$location,
				'cname'		=>$cname,
				'phone'		=>$phone,
				'tr'		=>$tr,
				'gender'	=>$gender,
				'dob'		=>$dob,
				'product'	=>$product,
				'invamount'	=>$invamount,
				
				'userid'	=>$userid,
				'username'  =>$username,
				"saveDate"  => date('Y-m-d H:i:s')
			  );
			//echo "<pre />"; print_r($data); exit; 
			$rid = $this->SalaryModel->customerSave($data, 'customer');  
			if($rid)
			{ 
				return redirect()->to(base_url('codeigniter/public/customerAdd')); exit;
			}
			else
			{
				echo "Your record is not saved successfully";
			}
		
	}	
	
	
	//Customer View
	public function customerView($rId, $flag)
	{
		$row = $this->SalaryModel->customerDetails($rId);	
		$data['row'] = $row;
		$hdata['title']='CUSTOMER INFORMATION';
		echo view('cinout/header', $hdata);
		echo view('cinout/customerView', $data);
		echo view('cinout/footer');
	}
	
	//Update customer details
	public function customerUpdate($rid)
	{
		$shop = $this->session->get('shop');
		$myRole = $this->session->get('myRole'); 
		$row = $this->SalaryModel->customerDetails($rid);	
		$data['row'] = $row;	
		//Locations
		$locations = $this->SalaryModel->getLocations2($myRole, $shop);	
		$shops='';
		foreach($locations AS $shop)
		{
				if($shop->Id==$row->location)
				{
					$shops.='<option value="'.$shop->Id.'" selected>'.$shop->name.'</option>';
				}
				else
				{		
					$shops.='<option value="'.$shop->Id.'">'.$shop->name.'</option>';
				}				
		} 
		$data['locations'] = $shops;
		$hdata['title']='UPDATE CUSTOMER INFORMATION';
		echo view('cinout/header', $hdata);
		echo view('cinout/customerUpdate', $data);
		echo view('cinout/footer');
	}

	//Customer save Update
	public function customerSaveUpdate($rid)
	{		
			$location = $this->request->getPost('location'); 
			$cname = $this->request->getPost('cname'); 
			$phone = $this->request->getPost('phone'); 
			$tr = $this->request->getPost('tr'); 
			$gender = $this->request->getPost('gender'); 
			$dob = $this->request->getPost('dob'); 
			$product = $this->request->getPost('product');
			$invamount = $this->request->getPost('invamount');
			
			//Get username and id from the session
			$username = $this->session->get('name');
			$userid = $this->session->get('userid');
			$data = array(
				'location'	=>$location,
				'cname'		=>$cname,
				'phone'		=>$phone,
				'tr'		=>$tr,
				'gender'	=>$gender,
				'dob'		=>$dob,
				'product'	=>$product,
				'invamount'	=>$invamount,
				
			  );
			//echo "<pre />"; print_r($data); exit; 
			$update = $this->SalaryModel->customerUpdate($data, $rid); 
			if($update==1)
			{
				return redirect()->to(base_url('codeigniter/public/customerView/'.$rid.'/1'.'')); exit;
			}
			else
			{
				echo "Record Not Update";
			}
	}

	//Customer List
	public function customerList()
	{	
		//Locations
		$locations = $this->AttendanceModel->getLocations3();
		$records = $this->AttendanceModel->getAllCustomers();
		$data['records'] = $records;
		//echo "<pre />"; print_r($records); exit;	
		$shops='';
		foreach($locations AS $shop)
		{
				$shops.='<option value="'.$shop->Id.'">'.$shop->name.'</option>';	
		}
		$data['locations']=$shops;
	
		$hdata['title']='Customer List';
		echo view('cinout/header', $hdata);
		echo view('cinout/customerList', $data);
		echo view('cinout/footer');
	}
	//Customer search
	public function bringCustomers()
	{	
	
		//Locations
		$sdate = $this->request->getPost('sdate');
		$data['sdate'] = $sdate;	
		$edate = $this->request->getPost('edate');
		$data['edate'] = $edate;
		$myLocation = $this->request->getPost('location'); 
		$data['location'] = $myLocation;
		
		$locations = $this->AttendanceModel->getLocations3();
		$records = $this->AttendanceModel->bringCustomers($data);
		$data['records'] = $records;
		//echo "<pre />"; print_r($locations); exit;
		//echo "<pre />"; print_r($records); exit;	
		$shops='';  
		foreach($locations AS $shop)
		{
				if($shop->Id == $myLocation)
				{ 
					$shops.='<option value="'.$shop->Id.'" selected>'.$shop->name.'</option>';
				}
				else
				{		
					$shops.='<option value="'.$shop->Id.'">'.$shop->name.'</option>';	
				}
		}
		$data['locations']=$shops;
	
		$hdata['title']='Customer List';
		echo view('cinout/header', $hdata);
		echo view('cinout/bringCustomer', $data);
		echo view('cinout/footer');
	}

	//Generate customer excel
	public function customerExcel()
	{	
		
		$sdate = $this->request->getPost('sdate');
		$edate = $this->request->getPost('edate');
		$location = $this->request->getPost('location');
		$data['sdate']=$sdate;
		$data['edate']=$edate;
		$data['location']=$location;
		$records = $this->AttendanceModel->bringCustomers2($data);
		//echo "<pre />"; print_r($records); exit;
		$spreadsheet = new Spreadsheet();
		$activeWorksheet = $spreadsheet->getActiveSheet();
		
		$activeWorksheet->setCellValue('A2', 'No');
		$activeWorksheet->setCellValue('B2', 'Date');
		$activeWorksheet->setCellValue('C2', 'Outlet');
		$activeWorksheet->setCellValue('D2', 'Name');
		$activeWorksheet->setCellValue('E2', 'H/P');
		$activeWorksheet->setCellValue('F2', 'T/R');
		$activeWorksheet->setCellValue('G2', 'Gender');
		$activeWorksheet->setCellValue('H2', 'Age');
		$activeWorksheet->setCellValue('I2', 'Dob');
		$activeWorksheet->setCellValue('J2', 'Product');
		$activeWorksheet->setCellValue('K2', 'Inv Amount');
		
		$i=3;
		$j=1;
		foreach($records AS $row)
		{
			$activeWorksheet->setCellValue('A'.$i, $j);
			$activeWorksheet->setCellValue('B'.$i, date_format(date_create($row->saveDate), 'd/m/Y'));
			$activeWorksheet->setCellValue('C'.$i, bname($row->location));
			$activeWorksheet->setCellValue('D'.$i, $row->cname);
			$activeWorksheet->setCellValue('E'.$i, $row->phone);
			if($row->tr == 1)
			{	
				$activeWorksheet->setCellValue('F'.$i, 'T');
			}
			else
			{
				$activeWorksheet->setCellValue('F'.$i, 'R');
			}		
			if($row->gender == 1)
			{	
				$activeWorksheet->setCellValue('G'.$i, 'Male');
			}
			else
			{
				$activeWorksheet->setCellValue('G'.$i, 'Female');
			}
			$activeWorksheet->setCellValue('H'.$i, calculateAge($row->dob));
			$activeWorksheet->setCellValue('I'.$i, date_format(date_create($row->dob), 'd/m/Y'));
			$activeWorksheet->setCellValue('J'.$i,$row->product);
			$activeWorksheet->setCellValue('K'.$i,$row->invamount);
			$i++;
			$j++;
		}
		$activeWorksheet->getColumnDimension('B')->setAutoSize(true);
		$activeWorksheet->getColumnDimension('C')->setAutoSize(true);
		$activeWorksheet->getColumnDimension('D')->setAutoSize(true);
		$activeWorksheet->getColumnDimension('E')->setAutoSize(true);
		$activeWorksheet->getColumnDimension('F')->setAutoSize(true);
		$activeWorksheet->getColumnDimension('G')->setAutoSize(true);
		$activeWorksheet->getColumnDimension('H')->setAutoSize(true);
		$activeWorksheet->getColumnDimension('I')->setAutoSize(true);
		$activeWorksheet->getColumnDimension('J')->setAutoSize(true);
		$activeWorksheet->getColumnDimension('K')->setAutoSize(true);
		
		$writer = new Xlsx($spreadsheet);
		//$writer->save('hello world.xlsx'); 
		ob_clean();
		//ob_start();
		header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header("Content-Disposition: attachment;filename=\"RegisteredCustomers.xlsx\"");
		header("Cache-Control: max-age=0");
		header("Expires: Fri, 11 Nov 2011 11:11:11 GMT");
		header("Last-Modified: ". gmdate("D, d M Y H:i:s") ." GMT");
		header("Cache-Control: cache, must-revalidate");
		header("Pragma: public");
		$writer->save("php://output");
		//ob_end_flush();
		exit;
		
		
	}	
}
