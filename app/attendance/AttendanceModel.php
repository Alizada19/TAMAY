<?php
namespace App\Models\attendance;
use CodeIgniter\Model;
class AttendanceModel extends Model
{
	//Get Locations
	public function getLocations()
	{		
			$query = $this->db->query("SELECT * From locations");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Get departments 
	public function getDeps()
	{
			$query = $this->db->query("SELECT * From departments");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Get Nationality 
	public function getNats()
	{
			$query = $this->db->query("SELECT * From nationality");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Save record		
	public function saveemp($data)
	{
		    
			$query = $this->db->table("employees");
			$res = $query->insert($data);
			if($res == 1)
			{	
				return $lastId = $this->db->insertID();
			}
			else
			{	
				return 0;
			}
		
	}
	
	//Display employees
	public function displayemp($rid)
	{
			$query = $this->db->query("SELECT * FROM employees WHERE Id=$rid");
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Update employee
	public function updateEmp($data,$rid)
	{
		  
			$query = $this->db->table("employees");
			$query->set($data);
			$query->where('Id', $rid);
			$res = $query->update(); 
			if($res == 1)
			{	
				return 1;
			}
			else
			{	
				return 0;
			}
	}
	
	//List employees
	public function listEmployees()
	{
			$query = $this->db->query("SELECT * FROM employees");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//get employees
	public function getEmployees()
	{
			$query = $this->db->query("SELECT * FROM employees");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Save Punch
	public function savePunch($data)
	{
		$query = $this->db->table("tinout");
		$res = $query->insert($data);
		
		if($res == 1)
		{	
			return $lastId = $this->db->insertID();
		}
		else
		{	
			return 0;
		}
	}
	
	//Get My locations
	public function getSpeceficLocation($location, $uname)
	{		
			$str='1';
			if($location!=20)
			{	
				if($uname=='JB')
				{
					$str.=" AND Id IN ('11', '12')";
				}
				else
				{	
					$str.=" AND Id=$location";
				}
			}
						
			$query = $this->db->query("SELECT * From locations WHERE $str");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//get employees by locations
	public function getEmpBylocation($location)
	{
			$str='1';
			if($location!=20)
			{
				$str.=" AND location=$location";
			}
			$query = $this->db->query("SELECT * FROM employees WHERE $str AND active=1");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//get employee attendance
	public function getEmpAttendance($empId, $fdm, $now)
	{
			$query = $this->db->query("
			SELECT 
				*
			FROM tinout 
			WHERE 
			empId=$empId AND pdate BETWEEN '$fdm' AND '$now' ORDER BY pdate;
			");
			$res = $query->getResultArray(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Search Attendance
	public function searchAttendance($data)
	{
			$str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND pdate BETWEEN '$sdate' AND '$edate'";
			}
			if($data['location']!='')
			{
				$location=$data['location']; 
				$str.=" AND location=$location";
			}
			if($data['emps']!='')
			{
				$emps=$data['emps']; 
				$str.=" AND empId=$emps";
			}
			$query = $this->db->query("SELECT * FROM tinout WHERE $str ORDER BY pdate");
			$res = $query->getResultArray(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	//View Punch
	public function getPunch($rid)
	{
			$query = $this->db->query("SELECT * FROM tinout WHERE Id=$rid");
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	//Update punch record
	public function updatePunch($data, $rid)
	{
		  
			$query = $this->db->table('tinout');
			$query->set($data);
			$query->where('Id', $rid);
			$res = $query->update(); 
			if($res == 1)
			{	
				return 1;
			}
			else
			{	
				return 0;
			}
	}
	
	//Deleted Punch
	public function deletePunch($id)
	{ 
			$query = $this->db->table('tinout');
			$query->where('Id', $id);
			$res = $query->delete(); 
			if($res == 1)
			{	
				return 1;
			}
			else
			{	
				return 0;
			}
	}
	
	//Get Profile Image
	public function getProfileImage($rid)
	{
			$query = $this->db->query("SELECT * FROM images WHERE empId=$rid AND etype=1");
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	//Get ID Image
	public function getIdImage($rid)
	{
			$query = $this->db->query("SELECT * FROM images WHERE empId=$rid AND etype=2");
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	//Filter Search employee
	public function searchEmp($data)
	{	
			//echo "<pre />"; print_r($data); exit;
			$str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND jdate BETWEEN '$sdate' AND '$edate'";
			}
			if($data['emp']!='')
			{
				$emp=$data['emp']; 
				$str.=" AND Id=$emp";
			}
			if($data['location']!='')
			{
				$location=$data['location']; 
				$str.=" AND location=$location";
			}
			if($data['dep']!='')
			{
				$dep=$data['dep']; 
				$str.=" AND department=$dep";
			}	
			if($data['nat']!='')
			{
				$nat=$data['nat']; 
				$str.=" AND nat=$nat";
			}
			if($data['status']!='')
			{
				$status=$data['status']; 
				$str.=" AND active='$status'";
			}
			if($data['bsalary']!='')
			{
				$bsalary=$data['bsalary']; 
				$str.=" AND bsalary=$bsalary";
			}
			$query = $this->db->query("SELECT * FROM employees WHERE $str ORDER BY saveDate DESC");
			$res = $query->getResult(); 
			//echo $this->db->getLastQuery()->getQuery(); exit;
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Get employee details
	public function nowh($empId)
	{	
			$query = $this->db->query("SELECT * FROM employees WHERE Id=$empId");
			$res = $query->getRow(); 
			if($res)
			{
				return $res->wh;
			}
			else
			{	
				return 0;
			}
	}
	//
	protected $table = 'tinout';
	protected $primaryKey = 'Id';
	protected $allowedFields = ['in', 'out', 'bin', 'bout', 'pdate', 'location', 'username', 'saveDate', 'userid', 'empId'];
	
	//get employees of 3 shops
	public function getEmpof3shops()
	{ 
			$query = $this->db->query("SELECT * FROM employees WHERE location IN ('3') AND active=1");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	
	//Get locations of 3 shops
	public function getLocation3shops()
	{				
			$query = $this->db->query("SELECT * From locations WHERE Id in ('3', '4', '5', '10')");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//get employees by location 
	public function getEmployeesBylocation($location)
	{
			$query = $this->db->query("SELECT * FROM employees WHERE location=$location AND active=1");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//get employees off day
	public function getEmpOffDay($empId)
	{
			$query = $this->db->query("SELECT offday FROM employees WHERE Id=$empId");
			$res = $query->getRow()->offday; 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//get employees by location and status
	public function getEmployeesBylocationStatus($location, $status)
	{
			$query = $this->db->query("SELECT * FROM employees WHERE location=$location AND active=$status");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Search Attendance with tolerance
	public function searchAttendanceTol($data)
	{
			$str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND pdate BETWEEN '$sdate' AND '$edate'";
			}
			if($data['location']!='')
			{
				$location=$data['location']; 
				$str.=" AND location=$location";
			}
			if($data['emps']!='')
			{
				$emps=$data['emps']; 
				$str.=" AND empId=$emps";
			}
			$query = $this->db->query("
				SELECT * 
				FROM tinout 
				WHERE $str
				ORDER BY pdate;

			");
			$res = $query->getResultArray(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	//Get Banks 
	public function getBanks()
	{
			$query = $this->db->query("SELECT * From allBanks");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	
	//Get the leave  type 
	public function getLeaveTypes()
	{
			$query = $this->db->query("SELECT * FROM leavetypes");
			$res = $query->getResult(); 
			return $res;
	}
	
}	
?>




