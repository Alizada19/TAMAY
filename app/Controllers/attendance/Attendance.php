<?php

namespace App\Controllers\attendance;
use App\Controllers\BaseController;
use App\Models\attendance\AttendanceModel;
use App\Models\salary\SalaryModel;
use CodeIgniter\I18n\Time;

require_once(APPPATH . '/ThirdParty/vendor2/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Attendance extends BaseController
{
    //my constructor
	public function __construct() 
	{

        $this->AttendanceModel = new AttendanceModel();
        $this->SalaryModel = new SalaryModel();
		$request = \Config\Services::request();
        helper('fornames');
	}
	
	public function index()
    {		
			
			$data['a']='a';
			$hdata['title']='Attendance Dashboard';
			echo view('attendance/header', $hdata);
			echo view('attendance/dashboard', $data);
			echo view('attendance/footer');
    }
	
	//Add Employee
	public function addemp()
	{	
			//Locations
			$locations = $this->AttendanceModel->getLocations();	
			$shops='';
			foreach($locations AS $shop)
			{
					$shops.='<option value="'.$shop->Id.'">'.$shop->name.'</option>';	
			}
			//Get Departments
			$getDeps = $this->AttendanceModel->getDeps();	
			$allDeps='';
			foreach($getDeps AS $deps)
			{
					$allDeps.='<option value="'.$deps->Id.'">'.$deps->name.'</option>';	
			}
			//Get Nationality
			$getNat = $this->AttendanceModel->getNats();	
			$allNats='';
			foreach($getNat AS $nat)
			{
					$allNats.='<option value="'.$nat->Id.'">'.$nat->country.'</option>';	
			}
			
			//Get Banks
			$getBanks = $this->AttendanceModel->getBanks();	
			$allBanks='';
			foreach($getBanks AS $bank)
			{
					$allBanks.='<option value="'.$bank->Id.'">'.$bank->bname.'</option>';	
			}
			
			$data['shops']=$shops;
			$data['deps']=$allDeps;
			$data['nats']=$allNats;
			$data['banks']=$allBanks;
			$hdata['title']='Add Employee';
			echo view('attendance/header', $hdata);
			echo view('attendance/addemp', $data);
			echo view('attendance/footer');	
	}
	
	//Save employee
	public function saveemp()
	{	
		$name = $this->request->getPost('name');
		$lname = trim($this->request->getPost('lname'));
		$location = $this->request->getPost('location');
		$dep = $this->request->getPost('dep');
		$nat = $this->request->getPost('nat');
		$phone1 = $this->request->getPost('phone1');
		$phone2 = $this->request->getPost('phone2');
		$category = $this->request->getPost('category');
		$email = $this->request->getPost('email');
		$jdate = $this->request->getPost('jdate');
		$addr = $this->request->getPost('addr');
		$bsalary = $this->request->getPost('bsalary');
		$wh = $this->request->getPost('wh');
		$offday = $this->request->getPost('offday');
		$tol = $this->request->getPost('tol');
		$gender = $this->request->getPost('gender');
		$mstatus = $this->request->getPost('mstatus');
		$dob = $this->request->getPost('dob');
		$bname = $this->request->getPost('bname');
		$accno = $this->request->getPost('accno');
		$acch = $this->request->getPost('acch');
		$epf = $this->request->getPost('epf');
		$socso = $this->request->getPost('socso');
		$wdays = $this->request->getPost('wdays');
		$ic = $this->request->getPost('ic');
			
		//Get username and id from the session
		$username = $this->session->get('name');
		$userid = $this->session->get('userid');
		
		$data = array(
				'name'=>$name,
				'lname'=>$lname,
				'location'=>$location,
				'department'=>$dep,
				'nat'=>$nat,
				'phone1'=>$phone1,
				'phone2'=>$phone2,
				'email'=>$email,
				'jdate'=>$jdate,
				'addr'=>$addr,
				'bsalary'=>$bsalary,
				'wh'=>$wh,
				'tolerance'=>$tol,
				'offday'=>$offday,
				'gender'=>$gender,
				'mstatus'=>$mstatus,
				'dob'=>$dob,
				'bname'=>$bname,
				'accno'=>$accno,
				'acch'=>$acch,
				'epf'=>$epf,
				'socso'=>$socso,
				'wdays'=>$wdays,
				'ic'=>$ic,
				
				'userid'=>$userid,
				'username'=>$username,
				"saveDate" => date('Y-m-d H:i:s')
			  );
			 	
			$rid = $this->AttendanceModel->saveemp($data); 
			if($rid)
			{
				//upload profile pic
				$this->upload($rid, $name);
				$this->upload2($rid, $name);
				
				return redirect()->to(base_url('codeigniter/public/attendance/viewemp/'.$rid.'/1'.'')); exit;
			}
			else
			{
				echo "Your record is not saved successfully";
			}		
				
	}
	
	//view employee
	public function viewemp($rid,$flag)
	{    
		$row = $this->AttendanceModel->displayEmp($rid);
		//Get profile image
		$pimage = $this->AttendanceModel->getProfileImage($rid);
		$idimage = $this->AttendanceModel->getIdImage($rid);
		$data['row'] = $row;
		$data['pimage'] = $pimage;
		$data['idimage'] = $idimage;
		$data['flag'] = $flag;
		$hdata['title']='View Employee';
		echo view('attendance/header', $hdata);
		echo view('attendance/viewemp', $data);
		echo view('attendance/footer');	
	}
	//Employees edit view
	public function editViewemp($rid)
	{ 
		$row = $this->AttendanceModel->displayEmp($rid);
		
		//locations
		 $db = \Config\Database::connect();
		 $dcquery = $db->query("SELECT * FROM locations");
		 $locations = $dcquery->getResult();
		 $lstr='';  
		 foreach($locations AS $lrow)
		 {
			if($lrow->Id == $row->location)
			{	
				$lstr.='<option value="'.$lrow->Id.'" selected>'.$lrow->name.'</option>';
			}
			else
			{
				$lstr.='<option value="'.$lrow->Id.'">'.$lrow->name.'</option>';
			}		
		 }
		 $data['lstr'] = $lstr;
		 
		 //all Banks
		 $db = \Config\Database::connect();
		 $dcquery = $db->query("SELECT * FROM allbanks");
		 $allbanks = $dcquery->getResult();
		 $bstr=''; 
				
		 foreach($allbanks AS $bank)
		 {
			if(isset($row->bname))
			{
				if($bank->Id == $row->bname)
				{	
					$bstr.='<option value="'.$bank->Id.'" selected>'.$bank->bname.'</option>';
				}
				else
				{
					$bstr.='<option value="'.$bank->Id.'">'.$bank->bname.'</option>';
				}
			}
			else
			{
				$bstr.='<option value="'.$bank->Id.'">'.$bank->bname.'</option>';
			}		
		 }
				
		 $data['bnames'] = $bstr;
		 //gender
		 $gstr='';
		 if(isset($row->gender))
		 {
			if($row->gender==1)
			{
				$gstr.='<option value="1" selected>Male</option>';
				$gstr.='<option value="2">Female</option>';
			}	
			else
			{
				$gstr.='<option value="1">Male</option>';
				$gstr.='<option value="2" selected>Female</option>';
			}		
		 }
		 else
		 {
			$gstr.='<option value="1" selected>Male</option>';
			$gstr.='<option value="2" selected>Female</option>';
		 }
		 $data['gender'] = $gstr;
		 //Marital Status
		 $mstr='';
		 if(isset($row->mstatus))
		 {
			if($row->mstatus==1)
			{
				$mstr.='<option value="1" selected>Single</option>';
				$mstr.='<option value="2">Marride</option>';
			}	
			else
			{
				$mstr.='<option value="1">Single</option>';
				$mstr.='<option value="2" selected>Marride</option>';
			}		
		 }
		 else
		 {
			$mstr.='<option value="">Select Marital Status</option>';
			$mstr.='<option value="1" selected>Single</option>';
			$mstr.='<option value="2" selected>Marride</option>';
		 }
		 $data['mstatus'] = $mstr;
		 //Department
		 $db = \Config\Database::connect();
		 $dcquery = $db->query("SELECT * FROM departments");
		 $departments = $dcquery->getResult();
		 $dstr='';  
		 foreach($departments AS $ldep)
		 {
			if($ldep->Id == $row->department)
			{	
				$dstr.='<option value="'.$ldep->Id.'" selected>'.$ldep->name.'</option>';
			}
			else
			{
				$dstr.='<option value="'.$ldep->Id.'">'.$ldep->name.'</option>';
			}		
		 }
		 $data['dstr'] = $dstr;
		 //Get Status
		 $status='';
		 $astatus = array(
				'1'=>'Active',
				'2'=>'Deactive',
				 ); 
		foreach($astatus AS $key=>$value)
		 {
			if($key == $row->active)
			{	
				$status.='<option value="'.$key.'" selected>'.$value.'</option>';
			}
			else
			{
				$status.='<option value="'.$key.'">'.$value.'</option>';
			}		
		 }
		 $data['status']=$status;
		//Nationality
		 $db = \Config\Database::connect();
		 $dcquery = $db->query("SELECT * FROM nationality");
		 $nationality = $dcquery->getResult();
		 $nstr='';  
		 foreach($nationality AS $nrow)
		 {
			if($nrow->Id == $row->nat)
			{	
				$nstr.='<option value="'.$nrow->Id.'" selected>'.$nrow->country.'</option>';
			}
			else
			{
				$nstr.='<option value="'.$nrow->Id.'">'.$nrow->country.'</option>';
			}		
		 }
		 $data['nstr'] = $nstr;
		//off day
		 $db = \Config\Database::connect();
		 $nationality = array(
			'1' =>'Monday',
			'2' =>'Tuesday',
			'3' =>'Wednesday',
			'4' =>'Thursday',
			'5' =>'Friday',
			'6' =>'Saturday',
			'7' =>'Sunday',
			'8' =>'None'
		 );
		 $offdaystr='';  
		 foreach($nationality AS $key=>$value)
		 {
			if($key == $row->offday)
			{	
				$offdaystr.='<option value="'.$key.'" selected>'.$value.'</option>';
			}
			else
			{
				$offdaystr.='<option value="'.$key.'">'.$value.'</option>';
			}		
		 }
		 $data['offdaystr'] = $offdaystr;
		
		$data['row'] = $row;
		$hdata['title'] = 'Edit Employee';
		echo view('attendance/header', $hdata);
		echo view('attendance/viewEdit', $data);
		echo view('attendance/footer');
	}
	
	//Save Edit employee
	public function saveEmpUpdate($rid)
	{
		
		$name = $this->request->getPost('name');
		$lname = trim($this->request->getPost('lname'));
		$location = $this->request->getPost('location');
		$dep = $this->request->getPost('dep');
		$nat = $this->request->getPost('nat');
		$phone1 = $this->request->getPost('phone1');
		$phone2 = $this->request->getPost('phone2');
		$category = $this->request->getPost('category');
		$email = $this->request->getPost('email');
		$jdate = $this->request->getPost('jdate');
		$addr = $this->request->getPost('addr');
		$bsalary = $this->request->getPost('bsalary');
		$status = $this->request->getPost('status');
		$wh = $this->request->getPost('wh');
		$offday = $this->request->getPost('offday');
		$tol = $this->request->getPost('tol');
		$gender = $this->request->getPost('gender');
		$mstatus = $this->request->getPost('mstatus');
		$dob = $this->request->getPost('dob');
		$bname = $this->request->getPost('bname');
		$accno = $this->request->getPost('accno');
		$acch = $this->request->getPost('acch');
		$epf = $this->request->getPost('epf');
		$socso = $this->request->getPost('socso');
		$wdays = $this->request->getPost('wdays');
		$ic = $this->request->getPost('ic');
			
		//Get username and id from the session
		$username = $this->session->get('name');
		$userid = $this->session->get('userid');
		
		$data = array(
				'name'=>$name,
				'lname'=>$lname,
				'location'=>$location,
				'department'=>$dep,
				'nat'=>$nat,
				'phone1'=>$phone1,
				'phone2'=>$phone2,
				'email'=>$email,
				'jdate'=>$jdate,
				'addr'=>$addr,
				'bsalary'=>$bsalary,
				'active'=>$status,
				'wh'=>$wh,
				'offday'=>$offday,
				'tolerance'=>$tol,
				'gender'=>$gender,
				'mstatus'=>$mstatus,
				'dob'=>$dob,
				'bname'=>$bname,
				'accno'=>$accno,
				'acch'=>$acch,
				'epf'=>$epf,
				'socso'=>$socso,
				'wdays'=>$wdays,
				'ic'=>$ic
			  );
			 
			$update = $this->AttendanceModel->updateEmp($data, $rid); 
			if($update==1)
			{
				//upload profile pic
				$this->uploadEdit($rid, $name);
				$this->uploadEditID($rid, $name);
				return redirect()->to(base_url('codeigniter/public/attendance/viewemp/'.$rid.'/1'.'')); exit;
			}
			else
			{
				echo "Record Not Update";
			}		
	}
	
	//list employees
	public function empList()
    {		
			//My location
			$mylocation = $this->session->get('shop'); 
			
			$employees = $this->AttendanceModel->getEmpBylocation($mylocation); 
			$allEmps='';
			foreach($employees AS $emp)
			{
					$allEmps.='<option value="'.$emp->Id.'">'.$emp->name.' '.$emp->lname.'</option>';	
			}
			$data['allEmps']=$allEmps;
			//Locations
			$locations = $this->AttendanceModel->getLocations();	
			$shops='';
			foreach($locations AS $shop)
			{
					$shops.='<option value="'.$shop->Id.'">'.$shop->name.'</option>';	
			}
			$data['shops']=$shops;
			//Get Departments
			$getDeps = $this->AttendanceModel->getDeps();	
			$allDeps='';
			foreach($getDeps AS $deps)
			{
					$allDeps.='<option value="'.$deps->Id.'">'.$deps->name.'</option>';	
			}
			$data['allDeps']=$allDeps;
			//Get Nationality
			$getNat = $this->AttendanceModel->getNats();	
			$allNats='';
			foreach($getNat AS $nat)
			{
					$allNats.='<option value="'.$nat->Id.'">'.$nat->country.'</option>';	
			}
			$data['allNats']=$allNats;
			$result = $this->AttendanceModel->listEmployees();
			$data['result']=$result;
			$hdata['title']='List of Employees';
			echo view('attendance/header', $hdata);
			echo view('attendance/listEmp', $data);
			echo view('attendance/footer');
    }
	
	//Add punches
	function addPunch()
	{	
		//My location
		$mylocation = $this->session->get('shop');
		$uname = $this->session->get('name'); 
		$myRole=$this->session->get('myRole'); 
		if($myRole==900)
		{
			$employees = $this->AttendanceModel->getEmpof3shops();
			$locations = $this->AttendanceModel->getLocation3shops();
		}
		else
		{	
			$employees = $this->AttendanceModel->getEmpBylocation($mylocation);
			$locations = $this->AttendanceModel->getSpeceficLocation($mylocation, $uname);
		}
		$allEmps='';
		foreach($employees AS $emp)
		{
				$allEmps.='<option value="'.$emp->Id.'">'.$emp->name.' '.$emp->lname.'</option>';	
		}
		
		
		//Locations	
		$shops='';
		foreach($locations AS $shop)
		{
				$shops.='<option value="'.$shop->Id.'">'.$shop->name.'</option>';	
		}
		$data['locations']=$shops;
		$data['employees']=$allEmps;
		$hdata['title']='Add Punches';
		echo view('attendance/header', $hdata);
		echo view('attendance/addPunch', $data);
		echo view('attendance/footer');
	}	
	
	//Save punches
	public function savePunch($action)
	{	
		$empId = $this->request->getGet('empId');
		$value = $this->request->getGet('value'); 
		$oth = $this->request->getGet('oth'); 
		$otm = $this->request->getGet('otm'); 
		$empDate = $this->request->getGet('cdate'); 
		$location = $this->request->getGet('location');
		$otremark = $this->request->getGet('resion');
		
		
		//Get username and id from the session
		$username = $this->session->get('name');
		$userid = $this->session->get('userid');
		
		if($action == 'IN')
		{
			$data = array(
				'in'=>$value,
				'empId'=>$empId,
				'pdate'=>$empDate,
				'location'=>$location,
				
				'userid'=>$userid,
				'username'=>$username,
				"saveDate" => date('Y-m-d H:i:s')
			  );
			 	
		}
		else if($action == 'OUT')
		{
			$data = array(
				'out'=>$value,
				'empId'=>$empId,
				'pdate'=>$empDate,
				'location'=>$location,
				
				'userid'=>$userid,
				'username'=>$username,
				"saveDate" => date('Y-m-d H:i:s')
			  );
		}	
		else if($action == 'BIN')
		{
			$data = array(
				'bin'=>$value,
				'empId'=>$empId,
				'pdate'=>$empDate,
				'location'=>$location,
				
				'userid'=>$userid,
				'username'=>$username,
				"saveDate" => date('Y-m-d H:i:s')
			  );
		}
		else if($action == 'BOUT')
		{
			$data = array(
				'bout'=>$value,
				'empId'=>$empId,
				'pdate'=>$empDate,
				'location'=>$location,
				
				'userid'=>$userid,
				'username'=>$username,
				"saveDate" => date('Y-m-d H:i:s')
			  );
		}
		else if($action == 'OT')
		{ 
			$data = array(
				'empId'=>$empId,
				'pdate'=>$empDate,
				'location'=>$location,
				'userid'=>$userid,
				'username'=>$username,
				"saveDate" => date('Y-m-d H:i:s'),
				'ot' =>$oth.':'.$otm,
				'otremark' =>$otremark
			  );
		}
			
				// Fetch the record with two conditions
				$record = $this->AttendanceModel->where('empId', $empId)
						 ->where('pdate', $empDate)
						 ->first(); //echo "<pre />"; 
						//echo "<pre />"; print_r($record); exit;
				if ($record) { //echo "<pre />"; print_r($data); exit;
							$this->AttendanceModel->where('empId', $empId)
                          ->where('pdate', $empDate)
                          ->set($data)
                          ->update();
							//echo "Record updated successfully!"; 
						} else { 
							//insert
							$res=$this->AttendanceModel->save($data);
							//echo "Record Inserted successfully!"; 
						}
			
			//echo $this->AttendanceModel->getLastQuery();
			
			//$rid = $this->AttendanceModel->savePunch($data); 
			if($record OR $res)
			{
				$this->bringAtt();
			}
			else
			{
				echo "Your record is not saved successfully";
			}
	}	
	
	//Bring attendance by given id
	public function bringAtt()
	{	
		$sdate = $this->request->getGet('sdate'); 
		$edate = $this->request->getGet('edate'); 
		if($sdate !='' AND $edate!='')
		{
				$fdm = $sdate; 
				$now = $edate; 
		}
		else
		{		
			$fdm = date('Y-m-01'); 
			$now = date('Y-m-d'); 
		}
		
		$location = $this->request->getGet('location'); 
		$emps = $this->request->getGet('empId'); 
		
		$data = array(
			'sdate'=>$fdm,
			'edate'=>$now,
			'location'=>$location,
			'emps'=>$emps
		  );
		//echo "<pre />"; print_r($data); exit; 
		$empAtt = $this->AttendanceModel->searchAttendanceTol($data); //echo "<pre />"; print_r($empAtt); exit;
		$empRecord = $this->AttendanceModel->displayemp($emps);
		$empOff = getDay($empRecord->offday); 
		$ewdays = $empRecord->wdays; 
		//Calculate allowed off days
		$aoffday=0;
		$offcount=1;
		if($ewdays == 26)
		{
			$aoffday=5;
		}
		else if($ewdays == 27)
		{
			$aoffday=3;
		}
		else if($ewdays == 28)
		{
			$aoffday=2;
		}
		else if($ewdays == 29)
		{
			$aoffday=1;
		}
			
		//manipulate records start
			// Initialize variables
			$start_date = new \DateTime($fdm); 
			$end_date = new \DateTime($now); // Today's date
			$all_dates = [];
			$current_index = 0;
			$notWorked=0;
			// Loop through all dates from start to end
			while ($start_date <= $end_date) 
			{
				$formatted_date = $start_date->format('Y-m-d');  

				// Check if the current date exists in records
				if (isset($empAtt[$current_index]) && $empAtt[$current_index]['pdate'] == $formatted_date) { 
					// Add the existing record
					$all_dates[] = [
						'date' => $formatted_date,
						'in' => $empAtt[$current_index]['in'],
						'out' => $empAtt[$current_index]['out'],
						'bin' => $empAtt[$current_index]['bin'],
						'bout' => $empAtt[$current_index]['bout'],
						'otremark' => $empAtt[$current_index]['otremark'],
						'ot' => $empAtt[$current_index]['ot']
					];
					$current_index++; // Move to the next record
				} 
				else if($start_date->format('l') === $empOff AND $offcount <= $aoffday)
				{
					// Add a placeholder for missing date
					$all_dates[] = [
						'date' => $formatted_date,
						'offtype' => 'off'
						
					];
					$offcount++;
					$notWorked++;
				}
				else
				{
					// Add a placeholder for missing date
					$all_dates[] = [
						'date' => $formatted_date,
						'offtype' => 'Upsent'
						
					];
					$notWorked++;
				}		
				
				// Move to the next date
				$start_date->modify('+1 day');
			}
		
		//manipulate records ends
		//echo "<pre />"; print_r($all_dates); exit;
		// Sort the array in descending order by date
		usort($all_dates, function ($a, $b) {
			return strcmp($b['date'], $a['date']); // Compare dates in descending order
		});
		
		//echo "<pre />"; print_r($all_dates); exit;
		if($empRecord)
		{
			$required_hours = $empRecord->wh; 
			$tolerance = $empRecord->tolerance; 
			
				
			$tolerance_in_hours = $tolerance / 60;			
			
			$total_overtime = 0;
			$total_undertime = 0;
			$allOverTime='';
			$allunderTime='';
			$mainStr='';
			$totalMinutes=0;
			foreach ($all_dates as $row) 
			{
				//Get Week name from the date
				$rdate = date_format(date_create($row['date']), 'd-m-Y');
				$tempDate = new \DateTime($rdate);
				$day = $tempDate->format('l'); 
				
				if(!isset($row['offtype']))
				{	
					$overtime = 0;
					$undertime = 0;
					$ot='';
					$ut='';
					$rot='';
					$rut='';
					$bgcolor='';
					// Time-in and Time-out (datetime fields)
					$time_in = new \DateTime($row['in']);
					$time_out = new \DateTime($row['out']);
					if ($time_out <= $time_in) { 
						$time_out->modify('+1 day');  // Add 1 day (24 hours) to time_out
					}
					// Calculate the total worked time (difference between time-in and time-out)
					$worked_time = $time_in->diff($time_out);  
					$worked_hours = $worked_time->h + ($worked_time->i / 60); // Convert minutes to fraction of hours
					
					// If the worked hours are less than the required hours, check if it's within the tolerance
					if ($worked_hours < $required_hours) {
						// If within tolerance, treat it as working the full required hours
						if ($worked_hours == $required_hours-1 AND $worked_time->i <= $tolerance) {
							$worked_hours = $required_hours;
						}
					}
					
					// Calculate overtime or undertime
					if ($worked_hours > $required_hours + $tolerance_in_hours) 
					{ 
						// If worked hours exceed required hours + tolerance, consider overtime
						$overtime = ($worked_hours - $required_hours)*60; 
						if($overtime>=60)
						{
							
							$osHours = floor($overtime / 60); 
							$osMinutes = trim($overtime) % 60;  
							//$rot = '+ '.$osHours.':'.$osMinutes;
						}
						else
						{
							//$rot = '+ 0:'.$overtime;
						}		
						$total_overtime += $overtime;
					} 
					elseif ($worked_hours < $required_hours - $tolerance_in_hours) 
					{  
						// If worked hours are less than required hours - tolerance, consider undertime
						$undertime = ($required_hours - $worked_hours)*60;
						if($undertime>=60)
						{
							$usHours = floor($undertime / 60);
							$usMinutes = trim($undertime) % 60;
							$rut = '- '.$usHours.':'.$usMinutes;
						}
						else
						{
							$rut = '- 0:'.$undertime;
						}		
						$total_undertime += $undertime;
					}
					$in = strtotime($row['in']);
					$in = date("g:i A", $in);
					$out = strtotime($row['out']);
					$out = date("g:i A", $out);
					
					$bin = strtotime($row['bin']);
					$bin = date("g:i A", $bin);
					$bout = strtotime($row['bout']);
					$bout = date("g:i A", $bout);
					
					
					$breakIn = new \DateTime($row['bin']);
					$breakOut = new \DateTime($row['bout']);
					$bdif = $breakIn->diff($breakOut); 
					if($bdif->h > 0 AND $bdif->i > 5)
					{
						$bgcolor="background-color:#FF7F7F;";
					}
					else if($bdif->h < 1 AND $bdif->i < 55)
					{
						$bgcolor="background-color:#90EE90;";
					}	
					
					$mainStr.="<tr>
									<td>$rdate</td> 
									<td>$day</td>   
									<td>$in</td>
									<td>$bin</td>
									<td style='$bgcolor'>$bout</td>
									<td>$out</td>
									<td>	
										$rot $rut
									</td>
									<td>	
									 {$row['ot']}
									</td>
									<td>	
										{$row['otremark']}
									</td>
								</tr>";
					//Sum the OT
					if(isset($row['ot']))
					{
						list($hours, $minutes) = explode(':', $row['ot']);
						$totalMinutes += ($hours * 60) + $minutes;
					}

						
				}
				else if(isset($row['offtype']) AND $row['offtype']=='off')
				{
					$mainStr.="<tr>
								<td>{$row['date']}</td>
								<td colspan='1'>$day</td>  
								<td colspan='8'>off day</td>  
							</tr>";
				}
				else if(isset($row['offtype']) AND $row['offtype']=='Upsent')
				{
					$mainStr.="<tr>
								<td>{$row['date']}</td>
								<td>$day</td>
								<td colspan='8'>Absent</td>  
							</tr>";
				}	
				
				
			}
			
			/*if($total_overtime>=$total_undertime)
			{
				
				$mot = $total_overtime - $total_undertime;
				$overtime_hours = floor($mot / 60);
				$overtime_minutes = trim($mot) % 60;
				$allOverTime = '+ '.$overtime_hours.':'.$overtime_minutes;
			}*/
			//if($total_overtime<$total_undertime)
			//{ 
				$mut = $total_undertime;//-$total_overtime; 
				$undertime_hours = floor($mut / 60);
				$undertime_minutes = trim($mut) % 60;
				$allunderTime = '- '.$undertime_hours.':'.$undertime_minutes;
				
			//}	
			//Overtime final
			$hours = floor($totalMinutes / 60);
			$minutes = $totalMinutes % 60;
			$totalTime = sprintf('%02d:%02d', $hours, $minutes);
			//now final undertime minus overtime 
			// Convert to minutes
			// Convert to minutes
			list($h1, $m1) =  explode(":", $allunderTime);//array_map('intval', explode(":", $allunderTime));
			list($h2, $m2) = explode(":", $totalTime);
			$h1 = str_replace(' ', '', $h1); // Remove spaces
			$total_minutes1 = (abs((int)$h1 * 60)) + $m1;
			//echo $total_minutes1; exit;
			$total_minutes2 = ($h2 * 60) + $m2;

			// Subtract the minutes
			$diff_minutes = $total_minutes2 - $total_minutes1; 
			// Determine the sign
			$sign = ($diff_minutes < 0) ? "-" : "+";
			//echo $diff_minutes; exit;
			// Convert back to HH:MM format
			$diff_hours = floor(abs($diff_minutes) / 60);
			$diff_remaining_minutes = abs($diff_minutes) % 60;
			
			$finalTime = sprintf('%s %02d:%02d',  $sign, $diff_hours, $diff_remaining_minutes);

			//echo $finalTime; exit;

			$mainStr.="<tr>
								<td colspan='6'>Total</td>  
								<td>	
									 $allunderTime 
								</td>
								<td>	
									 + 	$totalTime 
								</td>
								<td>	
									  	$finalTime 
								</td>
							</tr>";
			$data['mainStr']=$mainStr;
			$data['empId']=$emps;
			$data['tolerance']=$tolerance;
			$data['aoffday']=$aoffday;
			$data['finalTime']=$finalTime;
			
			//Summary calculations
			//echo "<pre />"; print_r($empRecord); exit;
			$empRecord->fullName=$empRecord->name.' '.$empRecord->lname;
			$empRecord->nat2 = $this->shortNat($empRecord->nat);
			$empRecord->bname = getbname($empRecord->bname);
			$empRecord->perday = $this->perday($empRecord->bsalary, $empRecord->wdays);
			$empRecord->perhour = $this->perhour($empRecord->perday, $empRecord->wh);
			$empRecord->otHours = $this->otHours($empRecord->Id,$sdate, $edate);
			$empRecord->otRate = 1.5;
			$empRecord->otRm = $empRecord->perhour * $empRecord->otHours * 1.5;
			$empRecord->woffdays = $this->workedOffdays($empRecord->Id,$sdate, $edate);
			$data['row'] = $empRecord;
			$data['offcount'] = $offcount-1;
			$data['ot'] = $allOverTime;
			$data['ut'] = $allunderTime;
			$data['notWorked'] = $notWorked; 
			//Only passing data for print
			$data['sdate'] = $fdm;
			$data['edate'] = $now;
			$data['location'] = $location;
			$data['emps'] = $emps;
			$myRole = $this->session->get('myRole'); 
			$data['myRole'] = $myRole;
			//echo "<pre />"; print_r($empRecord); exit;
		}
		
		echo view('attendance/seePunch', $data);
	}
	
	//Search Layout
	public function searchlayout()
	{	
		
		$myRole=$this->session->get('myRole');
		//Locations
		$locations = $this->AttendanceModel->getLocations2($myRole);	
		$shops='';
		foreach($locations AS $shop)
		{
				$shops.='<option value="'.$shop->Id.'">'.$shop->name.'</option>';	
		}
		$data['locations']=$shops;
		
		//employees
		$employees = $this->AttendanceModel->getEmployees2($myRole);
		$allEmps='';
		foreach($employees AS $emp)
		{
				$allEmps.='<option value="'.$emp->Id.'">'.$emp->name.' '.$emp->lname.'</option>';	
		}
		$data['employees']=$allEmps;
		$hdata['title']='Search Layout';
		echo view('attendance/header', $hdata);
		echo view('attendance/searchLayout', $data);
		echo view('attendance/footer');
	}
	
	//Search Attendance
	public function search()
	{	
		
		$sdate = $this->request->getGet('sdate'); 
		$edate = $this->request->getGet('edate'); 
		$location = $this->request->getGet('location'); 
		$emps = $this->request->getGet('emps'); 
		
		$data = array(
			'sdate'=>$sdate,
			'edate'=>$edate,
			'location'=>$location,
			'emps'=>$emps
		  );
		  
		$empAtt = $this->AttendanceModel->searchAttendance($data);
		$data['records']=$empAtt;
		echo view('attendance/empAtt', $data);
	}
	
	//View Punch
	function viewPunch($rid)
	{
		
		$getPunch = $this->AttendanceModel->getPunch($rid);
		$data['row']=$getPunch;
		$hdata['title']='View Punch';
		echo view('attendance/header', $hdata);
		echo view('attendance/viewPunch', $data);
		echo view('attendance/footer');
	}	
	
	//Edit View Punch
	function editViewPunch($rid)
	{

		$getPunch = $this->AttendanceModel->getPunch($rid);
		$data['row']=$getPunch;
		$hdata['title']='View Punch';
		echo view('attendance/header', $hdata);
		echo view('attendance/editViewPunch', $data);
		echo view('attendance/footer');
	}
	
	//Save edited punch
	function saveEditPunch($rid)
	{
		$data['in'] = $this->request->getPost('in'); 
		$data['out'] = $this->request->getPost('out'); 
		$data['bin'] = $this->request->getPost('bin'); 
		$data['bout'] = $this->request->getPost('bout'); 
		
		
		
		$update = $this->AttendanceModel->updatePunch($data, $rid);
		if($update==1)
		{
			return redirect()->to(base_url('codeigniter/public/attendance/viewPunch/'.$rid.'')); exit;
		}
		else
		{
			echo "Record Not Update";
		}
		
	}	
	
	//Delete Punch
	function deletePunch($rid)
	{
		$deleted = $this->AttendanceModel->deletePunch($rid);
		if($deleted==1)
		{
			echo "Record Deleted successfully!";
		}
		else
		{
			echo "Record Not Update";
		}
	}
	//Upload Image
	public function upload($empId, $name)
    {	
        if (!empty($_FILES['image']['name'])) 
		{
			$validation = \Config\Services::validation();

			// Validate the image upload
			$validation->setRules([
				'image' => [
					'uploaded[image]',
					'mime_in[image,image/jpg,image/jpeg,image/png]',
					'max_size[image,2048]',
				]
			]);
			
			if (!$validation->withRequest($this->request)->run()) {
				return redirect()->back()->with('error', $validation->getErrors());
			}
			
			// Store the file
			$file = $this->request->getFile('image');
			$extension = $file->getExtension();	
			if ($file->isValid() && !$file->hasMoved()) {
				$newName = $empId.'-'.$name.'-1'.'.'.$extension; 
				$file->move(FCPATH . 'uploads/profiles/', $newName);
				
				// Save the image path to the database (optional)
				$imageModel = new \App\Models\ImageModel();
				$imageModel->save([
					'empId' => $empId,
					'etype' => '1',
					'image_path' => 'uploads/profiles/' . $newName,
				]);

				return redirect()->back()->with('success', 'Image uploaded successfully!');
			} else {
				return redirect()->back()->with('error', 'Failed to upload image.');
			}
		}
    }

	//Upload Image2 for ID
	public function upload2($empId, $name)
    {	
        if (!empty($_FILES['imageid']['name'])) 
		{	
			$validation = \Config\Services::validation();

			// Validate the image upload
			$validation->setRules([
				'imageid' => [
					'uploaded[imageid]',
					'mime_in[imageid,image/jpg,image/jpeg,image/png,application/pdf]',
					'max_size[imageid,2048]',
				]
			]);
			
			if (!$validation->withRequest($this->request)->run()) {
				return redirect()->back()->with('error', $validation->getErrors());
			}
			
			// Store the file
			$file = $this->request->getFile('imageid');
			$extension = $file->getExtension();	
			if ($file->isValid() && !$file->hasMoved()) {
				$newName = $empId.'-'.$name.'-2'.'.'.$extension; 
				$file->move(FCPATH . 'uploads/ids/', $newName);
				
				// Save the image path to the database (optional)
				$imageModel = new \App\Models\ImageModel();
				$imageModel->save([
					'empId' => $empId,
					'etype' => '2',
					'image_path' => 'uploads/ids/' . $newName,
				]);

				return redirect()->back()->with('success', 'Image uploaded successfully!');
			} else {
				return redirect()->back()->with('error', 'Failed to upload image.');
			}
		}
    }	
	
	//Download ID 
	function downloadId($rid)
	{
		$idimage = $this->AttendanceModel->getIdImage($rid);
		// Define the path to the image directory
        $filePath = $idimage->image_path;
		// Check if the file exists
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File not found.');
        }
		
		// Serve the file as a download
        return $this->response->download($filePath, null);
	}	
	
	//Edit Upload Image
	public function uploadEdit($empId, $name)
    {	
        if (!empty($_FILES['image']['name'])) 
		{
			$validation = \Config\Services::validation();

			// Validate the image upload
			$validation->setRules([
				'image' => [
					'uploaded[image]',
					'mime_in[image,image/jpg,image/jpeg,image/png]',
					'max_size[image,2048]',
				]
			]);
			
			if (!$validation->withRequest($this->request)->run()) { 
				return redirect()->back()->with('error', $validation->getErrors());
			}
			
			// Store the file
			$file = $this->request->getFile('image');
			$extension = $file->getExtension();	
			if ($file->isValid() && !$file->hasMoved()) {
				//Get profile image
				$pimage = $this->AttendanceModel->getProfileImage($empId);
				if($pimage)
				{	
					$imagePath=FCPATH.$pimage->image_path;
					
					// Delete the old image if it exists
					if (file_exists($imagePath)) { 
						unlink($imagePath);
					}
				}
				// Generate a new file name and move the file
				$newName = $empId.'-'.$name.'-1'.'.'.$extension; 
				$file->move(FCPATH . 'uploads/profiles/', $newName);
				
			    
				$imageModel = new \App\Models\ImageModel();

				// Fetch the record with two conditions
				$record = $imageModel->where('empId', $empId)
						 ->where('etype', '1')
						 ->first(); //echo "<pre />"; print_r($record); exit;
				if ($record) {
							// Update the image path
							$record['image_path'] = 'uploads/profiles/' . $newName;
							$imageModel->save($record);
							echo "Record updated successfully!";
						} else {
							// insert
							$data=array(
								'empId' => $empId,
								'etype' => '1',
								'image_path' => 'uploads/profiles/' . $newName
							
							);
							$imageModel->save($data);
							echo "Record Inserted successfully!";
						}
			} else {
				return redirect()->back()->with('error', 'Failed to upload image.');
			}
		}
    }
	//Edit Upload of ID
	public function uploadEditID($empId, $name)
    {	
        if (!empty($_FILES['imageid']['name'])) 
		{
			$validation2 = \Config\Services::validation();
				
			// Validate the image upload
			$validation2->setRules([
				'imageid' => [
					'uploaded[imageid]',
					'mime_in[imageid,image/jpg,image/jpeg,image/png,application/pdf]',
					'max_size[imageid,2048]',
				]
			]);
			
			if (!$validation2->withRequest($this->request)->run()) {
				return redirect()->back()->with('error', $validation2->getErrors());
			}
			
			// Store the file
			$file = $this->request->getFile('imageid');
			$extension = $file->getExtension();	
			if ($file->isValid() && !$file->hasMoved()) {
				//Get profile image
				$idimage = $this->AttendanceModel->getIdImage($empId);
				if($idimage)
				{
					$imagePath=FCPATH.$idimage->image_path;
					
					// Delete the old image if it exists
					if (file_exists($imagePath)) { 
						unlink($imagePath);
					}
				}
				// Generate a new file name and move the file
				$newName = $empId.'-'.$name.'-2'.'.'.$extension; 
				$file->move(FCPATH . 'uploads/ids/', $newName);
				
			
				$imageModel = new \App\Models\ImageModel();

				// Fetch the record with two conditions
				$record = $imageModel->where('empId', $empId)
						 ->where('etype', '2')
						 ->first(); //echo "<pre />"; print_r($record); exit;
				if ($record) {
							// Update the image path
							$record['image_path'] = 'uploads/ids/' . $newName;
							$imageModel->save($record);
							//echo "Record updated successfully!";
						} else {
							// insert
							$data=array(
								'empId' => $empId,
								'etype' => '2',
								'image_path' => 'uploads/ids/' . $newName
							
							);
							$imageModel->save($data);
							//echo "Record Inserted successfully!";
						}
			} else {
				return redirect()->back()->with('error', 'Failed to upload image.');
			}
		}
    }
	//Download profile Picture 
	function downloadProfile($rid)
	{  
		$pimage = $this->AttendanceModel->getProfileImage($rid);
		// Define the path to the image directory
        $filePath = $pimage->image_path;
		// Check if the file exists
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File not found.');
        }
		
		// Serve the file as a download
        return $this->response->download($filePath, null);
	}
	
	//search Employee
	function searchEmp()
	{
			$data['sdate'] = $this->request->getGet('sdate');
			$data['edate'] = $this->request->getGet('edate');
			$data['emp'] = trim($this->request->getGet('emp'));
			$data['location'] = trim($this->request->getGet('location'));
			$data['dep'] = trim($this->request->getGet('dep'));
			$data['nat'] = trim($this->request->getGet('nat'));
			$data['status'] = trim($this->request->getGet('status'));
			$data['bsalary'] = trim($this->request->getGet('bsalary'));
			
			$result = $this->AttendanceModel->searchEmp($data); 
			$data['result']=$result;
			//echo "<pre />"; print_r($result); exit;
			echo view('attendance/searchEmp', $data);
	}

	//Attandence Report Layout
	public function reportLayout()
	{	
		$myRole = $this->session->get('myRole'); 
		$data['myRole']=$myRole;
		//Locations
		$locations = $this->AttendanceModel->getLocations2($myRole);	
		$shops='';
		foreach($locations AS $shop)
		{
				$shops.='<option value="'.$shop->Id.'">'.$shop->name.'</option>';	
		}
		$data['locations']=$shops;
		
		//employees
		$employees = $this->AttendanceModel->getEmployees2($myRole);
		$allEmps='';
		foreach($employees AS $emp)
		{
				$allEmps.='<option value="'.$emp->Id.'">'.$emp->name.' '.$emp->lname.'</option>';	
		}
		$data['employees']=$allEmps;
		$hdata['title']='Report Layout';
		echo view('attendance/header', $hdata);
		echo view('attendance/reportLayout', $data);
		echo view('attendance/footer');
	}
	
	//Attendance Report
	public function report()
	{	
		
		$sdate = $this->request->getGet('sdate'); 
		$edate = $this->request->getGet('edate'); 
		$location = $this->request->getGet('location'); 
		$emps = $this->request->getGet('emps'); 
		
		$data = array(
			'sdate'=>$sdate,
			'edate'=>$edate,
			'location'=>$location,
			'emps'=>$emps
		  );
		  
		$empAtt = $this->AttendanceModel->searchAttendance($data); 
		//echo "<pre />"; print_r($empAtt); exit;
		$getEmpOffDay = $this->AttendanceModel->getEmpOffDay($emps);
		$empOff='';
		if($getEmpOffDay)
		{
			$empOff = getDay($getEmpOffDay);
		}
				
		//manipulate records start
			// Initialize variables
			$start_date = new \DateTime($sdate); //print_r($start_date); exit;
			$end_date = new \DateTime($edate); // Today's date
			$all_dates = [];
			$current_index = 0;

			// Loop through all dates from start to end
			while ($start_date <= $end_date) 
			{
				$formatted_date = $start_date->format('Y-m-d');

				// Check if the current date exists in records
				if (isset($empAtt[$current_index]) && $empAtt[$current_index]['pdate'] == $formatted_date) { 
					// Add the existing record
					$all_dates[] = [
						'date' => $formatted_date,
						'in' => $empAtt[$current_index]['in'],
						'out' => $empAtt[$current_index]['out'],
						'bin' => $empAtt[$current_index]['bin'],
						'bout' => $empAtt[$current_index]['bout']
					];
					$current_index++; // Move to the next record
				} 
				else if($start_date->format('l') === $empOff)
				{
					// Add a placeholder for missing date
					$all_dates[] = [
						'date' => $formatted_date,
						'offtype' => 'off'
						
					];
				}
				else
				{
					// Add a placeholder for missing date
					$all_dates[] = [
						'date' => $formatted_date,
						'offtype' => 'Upsent'
						
					];
				}		

				// Move to the next date
				$start_date->modify('+1 day');
			}
		
		//manipulate records ends
		//echo "<pre />"; print_r($all_dates); exit;
		// Sort the array in descending order by date
		usort($all_dates, function ($a, $b) {
			return strcmp($b['date'], $a['date']); // Compare dates in descending order
		});
		//echo "<pre />"; print_r($all_dates); exit;
		$nwh = $this->AttendanceModel->nowh($emps); //No working hours		
		
		$data['nwh']=$nwh;
		$data['empId']=$emps;
		$data['records']=$all_dates;
		echo view('attendance/report', $data);
	}
	
	//Bring sub employees on dropdown
	public function bringEmp()
	{	
		
		$location = $this->request->getGet('value');
		//employees
		$employees = $this->AttendanceModel->getEmployeesBylocation($location);
		$allEmps='';
		if($employees)
		{	
			$allEmps.='<option value="">Select Employees</option>';
			foreach($employees AS $emp)
			{	
					$allEmps.='<option value="'.$emp->Id.'">'.$emp->name.' '.$emp->lname.'</option>';	
			}
		}
		else
		{
				$allEmps.='<option value="">No Employee</option>';	
		}	
		return $allEmps;
	}
	
	//Bring sub employees Based on status
	public function bringStatus()
	{	
		
		$location = $this->request->getGet('location');
		$status = $this->request->getGet('status');
		
		//employees
		$employees = $this->AttendanceModel->getEmployeesBylocationStatus($location, $status);
		$allEmps='';
		if($employees)
		{	
			$allEmps.='<option value="">Select Employees</option>';
			foreach($employees AS $emp)
			{	
					$allEmps.='<option value="'.$emp->Id.'">'.$emp->name.' '.$emp->lname.'</option>';	
			}
		}
		else
		{
				$allEmps.='<option value="">No Employee</option>';	
		}	
		return $allEmps;
	}
	
	
	//Attendance Report with tolerance
	public function reportTol()
	{	
		
		$sdate = $this->request->getGet('sdate'); 
		$edate = $this->request->getGet('edate'); 
		$location = $this->request->getGet('location'); 
		$emps = $this->request->getGet('emps'); 
		
		$data = array(
			'sdate'=>$sdate,
			'edate'=>$edate,
			'location'=>$location,
			'emps'=>$emps
		  );
		  
		$empAtt = $this->AttendanceModel->searchAttendanceTol($data);
		$empRecord = $this->AttendanceModel->displayemp($emps);
		$empOff = getDay($empRecord->offday); 
		$ewdays = $empRecord->wdays; 
		//Calculate allowed off days
		$aoffday=0;
		$offcount=1;
		if($ewdays == 26)
		{
			$aoffday=5;
		}
		else if($ewdays == 27)
		{
			$aoffday=3;
		}
		else if($ewdays == 28)
		{
			$aoffday=2;
		}
		else if($ewdays == 29)
		{
			$aoffday=1;
		}
			
		//manipulate records start
			// Initialize variables
			$start_date = new \DateTime($sdate); //print_r($start_date); exit;
			$end_date = new \DateTime($edate); // Today's date
			$all_dates = [];
			$current_index = 0;
			$notWorked=0;
			// Loop through all dates from start to end
			while ($start_date <= $end_date) 
			{
				$formatted_date = $start_date->format('Y-m-d');

				// Check if the current date exists in records
				if (isset($empAtt[$current_index]) && $empAtt[$current_index]['pdate'] == $formatted_date) { 
					// Add the existing record
					$all_dates[] = [
						'date' => $formatted_date,
						'in' => $empAtt[$current_index]['in'],
						'out' => $empAtt[$current_index]['out'],
						'bin' => $empAtt[$current_index]['bin'],
						'bout' => $empAtt[$current_index]['bout']
					];
					$current_index++; // Move to the next record
				} 
				else if($start_date->format('l') === $empOff AND $offcount <= $aoffday)
				{
					// Add a placeholder for missing date
					$all_dates[] = [
						'date' => $formatted_date,
						'offtype' => 'off'
						
					];
					$offcount++;
					$notWorked++;
				}
				else
				{
					// Add a placeholder for missing date
					$all_dates[] = [
						'date' => $formatted_date,
						'offtype' => 'Upsent'
						
					];
					$notWorked++;
				}		

				// Move to the next date
				$start_date->modify('+1 day');
			}
		
		//manipulate records ends
		//echo "<pre />"; print_r($all_dates); exit;
		// Sort the array in descending order by date
		usort($all_dates, function ($a, $b) {
			return strcmp($b['date'], $a['date']); // Compare dates in descending order
		});
		
		//echo "<pre />"; print_r($all_dates); exit;
		if($empRecord)
		{
			$required_hours = $empRecord->wh; 
			$tolerance = $empRecord->tolerance; 
			
				
			$tolerance_in_hours = $tolerance / 60;			
			
			$total_overtime = 0;
			$total_undertime = 0;
			$allOverTime='';
			$allunderTime='';
			$mainStr='';
			foreach ($all_dates as $row) 
			{
				
				
				if(!isset($row['offtype']))
				{	
					$overtime = 0;
					$undertime = 0;
					$ot='';
					$ut='';
					$rot='';
					$rut='';
					$bgcolor='';
					// Time-in and Time-out (datetime fields)
					$time_in = new \DateTime($row['in']);
					$time_out = new \DateTime($row['out']);
					if ($time_out <= $time_in) { 
						$time_out->modify('+1 day');  // Add 1 day (24 hours) to time_out
					}
					// Calculate the total worked time (difference between time-in and time-out)
					$worked_time = $time_in->diff($time_out);  
					$worked_hours = $worked_time->h + ($worked_time->i / 60); // Convert minutes to fraction of hours
					
					// If the worked hours are less than the required hours, check if it's within the tolerance
					if ($worked_hours < $required_hours) {
						// If within tolerance, treat it as working the full required hours
						if ($worked_hours == $required_hours-1 AND $worked_time->i <= $tolerance) {
							$worked_hours = $required_hours;
						}
					}
					
					// Calculate overtime or undertime
					if ($worked_hours > $required_hours + $tolerance_in_hours) 
					{ 
						// If worked hours exceed required hours + tolerance, consider overtime
						$overtime = ($worked_hours - $required_hours)*60; 
						if($overtime>=60)
						{
							
							$osHours = floor($overtime / 60); 
							$osMinutes = trim($overtime) % 60;  
							$rot = '+ '.$osHours.':'.$osMinutes;
						}
						else
						{
							$rot = '+ 0:'.$overtime;
						}		
						$total_overtime += $overtime;
					} 
					elseif ($worked_hours < $required_hours - $tolerance_in_hours) 
					{  
						// If worked hours are less than required hours - tolerance, consider undertime
						$undertime = ($required_hours - $worked_hours)*60;
						if($undertime>=60)
						{
							$usHours = floor($undertime / 60);
							$usMinutes = trim($undertime) % 60;
							$rut = '- '.$usHours.':'.$usMinutes;
						}
						else
						{
							$rut = '- 0:'.$undertime;
						}		
						$total_undertime += $undertime;
					}
					$in = strtotime($row['in']);
					$in = date("g:i A", $in);
					$out = strtotime($row['out']);
					$out = date("g:i A", $out);
					
					$bin = strtotime($row['bin']);
					$bin = date("g:i A", $bin);
					$bout = strtotime($row['bout']);
					$bout = date("g:i A", $bout);
					
					
					$breakIn = new \DateTime($row['bin']);
					$breakOut = new \DateTime($row['bout']);
					$bdif = $breakIn->diff($breakOut); 
					if($bdif->h > 0 AND $bdif->i > 5)
					{
						$bgcolor="background-color:#FF7F7F;";
					}
					else if($bdif->h < 1 AND $bdif->i < 55)
					{
						$bgcolor="background-color:#90EE90;";
					}		
					$mainStr.="<tr>
									<td>{$row['date']}</td>  
									<td>$in</td>
									<td>$bin</td>
									<td style='$bgcolor'>$bout</td>
									<td>$out</td>
									<td>	
										$rot $rut
									</td>
								</tr>";
				}
				else if(isset($row['offtype']) AND $row['offtype']=='off')
				{
					$mainStr.="<tr>
								<td>{$row['date']}</td>
								<td colspan='5'>off day</td>  
							</tr>";
				}
				else if(isset($row['offtype']) AND $row['offtype']=='Upsent')
				{
					$mainStr.="<tr>
								<td>{$row['date']}</td>
								<td colspan='5'>Absent</td>  
							</tr>";
				}	
					
			}
			
			if($total_overtime>=$total_undertime)
			{
				
				$mot = $total_overtime - $total_undertime;
				$overtime_hours = floor($mot / 60);
				$overtime_minutes = trim($mot) % 60;
				$allOverTime = '+ '.$overtime_hours.':'.$overtime_minutes;
			}
			if($total_overtime<$total_undertime)
			{ 
				$mut = $total_undertime-$total_overtime; 
				$undertime_hours = floor($mut / 60);
				$undertime_minutes = trim($mut) % 60;
				$allunderTime = '- '.$undertime_hours.':'.$undertime_minutes;
				
			}	
			$mainStr.="<tr>
								<td colspan='5'>Total</td>  
								<td>	
									 $allunderTime $allOverTime
								</td>
							</tr>";
			$data['mainStr']=$mainStr;
			$data['empId']=$emps;
			$data['tolerance']=$tolerance;
			$data['aoffday']=$aoffday;
			
			//Summary calculations
			//echo "<pre />"; print_r($empRecord); exit;
			$empRecord->fullName=$empRecord->name.' '.$empRecord->lname;
			$empRecord->nat2 = $this->shortNat($empRecord->nat);
			$empRecord->bname = getbname($empRecord->bname);
			$empRecord->perday = $this->perday($empRecord->bsalary, $empRecord->wdays);
			$empRecord->perhour = $this->perhour($empRecord->perday, $empRecord->wh-1);
			$empRecord->otHours = $this->otHours($empRecord->Id,$sdate, $edate);
			$empRecord->otRate = 1.5;
			$empRecord->otRm = $empRecord->perhour * $empRecord->otHours * 1.5;
			$empRecord->woffdays = $this->workedOffdays($empRecord->Id,$sdate, $edate);
			$data['row'] = $empRecord;
			$data['offcount'] = $offcount-1;
			$data['ot'] = $allOverTime;
			$data['ut'] = $allunderTime;
			$data['notWorked'] = $notWorked; 
			//Only passing data for print
			$data['sdate'] = $sdate;
			$data['edate'] = $edate;
			$data['location'] = $location;
			$data['emps'] = $emps;
			$myRole = $this->session->get('myRole'); 
			$data['myRole'] = $myRole;
			//echo "<pre />"; print_r($empRecord); exit;
		}
		echo view('attendance/reportTolerance', $data);
	}
	
	//Show short nationality
	public function shortNat($id)
	{
		if($id==1)
		{
			return 'L';
		}
		else
		{
			return 'F';
		}		
	}	
	
	//per day salary 
	public function perday($bsalary, $wdays)
	{
		if(isset($bsalary) AND isset($wdays))
		{
			return round($bsalary/$wdays, 2);
		}
		else
		{
			return 0;
		}		
	}
	//per hour salary 
	public function perhour($perday, $wh)
	{	
		if(isset($perday) AND isset($wh))
		{	
			return round($perday/$wh, 2);
		}
		else
		{
			return 0;
		}		
	}
	
	//Find OT hours
	public function otHours($empId, $sdate, $edate)
	{	
		$data['empId']=$empId; 
		$data['sdate']=$sdate; 
		$data['edate']=$edate; 
		
		$empAtt = $this->SalaryModel->bringAttendance($data); 
		$empRecord = $this->SalaryModel->getEmployee($empId);
		
		$required_hours = $empRecord->wh; 
		$tolerance = $empRecord->tolerance;
		$tolerance_in_hours = $tolerance / 60;
		
		//echo "<pre />"; print_r($empAtt); exit;
			$total_overtime = 0;
			$total_undertime = 0;
			if($empAtt)
			{
				foreach ($empAtt as $row) 
				{
					
					$overtime = 0;
					$undertime = 0;
					$worked_hours=0;
					// Time-in and Time-out (datetime fields)
					$time_in = new \DateTime($row['in']);
					$time_out = new \DateTime($row['out']);
					if ($time_out <= $time_in) { 
						$time_out->modify('+1 day');  // Add 1 day (24 hours) to time_out
					}
					// Calculate the total worked time (difference between time-in and time-out)
					$worked_time = $time_in->diff($time_out);
					$worked_hours = $worked_time->h + ($worked_time->i / 60); // Convert minutes to fraction of hours
							
					
					// Calculate overtime or undertime
					if ($worked_hours > $required_hours + $tolerance_in_hours) 
					{ 
						// If worked hours exceed required hours + tolerance, consider overtime
						$overtime = $worked_hours - $required_hours;
								
						$total_overtime += trim($overtime);
					}
					elseif ($worked_hours < $required_hours - $tolerance_in_hours) 
					{  
						// If worked hours are less than required hours - tolerance, consider undertime
						$undertime = trim($required_hours) - trim($worked_hours);
								
						$total_undertime += trim($undertime);
					}
				}
				
				//$h = floor($total_overtime);
				//$m = round(($total_overtime - $h) * 60);
			} 
			$total_overtime = trim($total_overtime) - trim($total_undertime); 
			return round($total_overtime, 2);
	}
	
	//Worked Off Days
	public function workedOffdays($empId, $sdate, $edate)
	{	
		$data['empId']=$empId; 
		$data['sdate']=$sdate; 
		$data['edate']=$edate; 
		
		$empAtt = $this->SalaryModel->bringAttendance($data);
		$empRecord = $this->SalaryModel->getEmployee($empId);
		
		$empOff = getDay($empRecord->offday);
		$ewdays = $empRecord->wdays; 
		//Calculate allowed off days
		$aoffday=0;
		if($ewdays == 26)
		{
			$aoffday=5;
		}
		else if($ewdays == 27)
		{
			$aoffday=3;
		}
		else if($ewdays == 28)
		{
			$aoffday=2;
		}
		else if($ewdays == 29)
		{
			$aoffday=1;
		}	
		$required_hours = $empRecord->wh; 
		$tolerance = $empRecord->tolerance;
		$tolerance_in_hours = $tolerance / 60;
		
		$start_date = new \DateTime($sdate); //print_r($start_date); exit;
		$end_date = new \DateTime($edate); // Today's date
			
		$current_index = 0;
		$workedDays=0;
		//echo "<pre />"; print_r($empAtt); exit;
		// Loop through all dates from start to end
			
		while ($start_date <= $end_date) 
		{
			$formatted_date = $start_date->format('Y-m-d');
			
			// Check if the current date exists in records
			if (isset($empAtt[$current_index]) && $empAtt[$current_index]['pdate'] == $formatted_date && $start_date->format('l') == $empOff AND $workedDays <$aoffday) { 
				// Add the existing record
				$workedDays++;
				
			} 
	
			$start_date->modify('+1 day');
			$current_index++; // Move to the next record

		}
		return $workedDays;
		
	}
	//List the leave
	public function leaveList()
    {		
			
			$data['a']='a';
			$hdata['title']='Leave List';
			echo view('attendance/header', $hdata);
			echo view('attendance/leave/list', $data);
			echo view('attendance/footer');
    }
	
	//leave type main layout
	public function leaveAdd()
    {		
			
			$leaveTypes = $this->AttendanceModel->getLeaveTypes();
			$leaves='';			
			foreach($leaveTypes AS $row)
			{
					$leaves.='<option value="'.$row->Id.'">'.$row->leaveName.'</option>';	
			}
			$data['leaveTypes']=$leaves;
			
			$hdata['title']='Add Leave';
			echo view('attendance/leave/header', $hdata);
			echo view('attendance/leave/leaveAdd', $data);
			echo view('attendance/leave/footer');
    }
	
		
}
