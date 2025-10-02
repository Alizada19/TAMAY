<?php
namespace App\Models\upload;
use CodeIgniter\Model;
class ExcelModel extends Model
{
	//Get Locations
	public function getLocations()
	{		
			$query = $this->db->query("SELECT * From locations");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Get Locations by user name and shop name
	public function getLocations2($myRole, $shop)
	{		
			$str='1';
			if($myRole!=1)
			{
				$str.=" AND Id=$shop";
			}
			$query = $this->db->query("SELECT * From locations WHERE $str");
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
	
	//get employees by locations
	public function getEmpBylocation($location)
	{
			$str='1';
			if($location!=20)
			{
				$str.=" AND location=$location";
			}
			$query = $this->db->query("SELECT * FROM employees WHERE $str AND active=1");
			$res = $query->getResultArray(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Bring Attendance
	public function bringAttendance($data)
	{
			
			$str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND pdate BETWEEN '$sdate' AND '$edate'";
			}
			if($data['empId']!='')
			{
				$empId=$data['empId']; 
				$str.=" AND empId=$empId";
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
	
	//get employees by id
	public function getEmployee($empId)
	{
			$query = $this->db->query("SELECT * FROM employees WHERE Id=$empId");
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Save record		
	public function saveRecord($data, $table)
	{
		    $query = $this->db->table($table);
			$res = $query->insert($data);
			if($res == 1)
			{	
				//return $lastId = $this->db->insertID();
				return 1;
			}
			else
			{	
				return 0;
			}
	}
	
	//Get record details
	public function rdetails($Id)
	{
			$query = $this->db->query("SELECT * FROM salary WHERE Id=$Id");
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Get all salary
	public function getAllSalary()
	{
			$query = $this->db->query("SELECT * FROM salary");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Get total salary
	public function getTotalSalary()
	{
			$query = $this->db->query("SELECT SUM(bsalary) AS tbsalary, SUM(gSalary) AS tgSalary, SUM(netSalary) AS tnetSalary FROM salary");
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Get user details
	public function edetails($Id)
	{
			$query = $this->db->query("SELECT * FROM employees WHERE Id=$Id");
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Update one record
	public function updateRecord($data, $rid, $table)
	{
		  
			$query = $this->db->table($table);
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
	
	// Search
	public function search($data)
	{	
			//echo "<pre />"; print_r($data); exit;
			$str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND cdate BETWEEN '$sdate' AND '$edate'";
			}
			
			
			$query = $this->db->query("SELECT Id, category, SUM(cost) AS cost, cdate FROM excel WHERE $str GROUP BY cdate, category");
			$res = $query->getResult(); 
			//echo $this->db->getLastQuery()->getQuery(); exit;
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Search Category
	public function searchCategory($data)
	{	
			//echo "<pre />"; print_r($data); exit;
			$str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND cdate BETWEEN '$sdate' AND '$edate'";
			}
			
			
			$query = $this->db->query("SELECT category, SUM(cost) AS cost FROM excel WHERE $str GROUP BY category");
			$res = $query->getResult(); 
			//echo $this->db->getLastQuery()->getQuery(); exit;
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	// Search single record
	public function searchSingle($data)
	{	
			//echo "<pre />"; print_r($data); exit;
			$str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND cdate BETWEEN '$sdate' AND '$edate'";
			}
			
			
			$query = $this->db->query("SELECT * FROM excel WHERE $str");
			$res = $query->getResult(); 
			//echo $this->db->getLastQuery()->getQuery(); exit;
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Total Search 
	public function totalSearch($data)
	{	
			//echo "<pre />"; print_r($data); exit;
			$str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND cdate BETWEEN '$sdate' AND '$edate'";
			}
			
			
			$query = $this->db->query("SELECT SUM(cost) AS cost FROM excel WHERE $str");
			$res = $query->getRow(); 
			//echo $this->db->getLastQuery()->getQuery(); exit;
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	
	//Save record for customer in johoni		
	public function customerSave($data, $table)
	{
		    
			$query = $this->db->table($table);
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
	
	//Customer Details
	public function customerDetails($Id)
	{
			$query = $this->db->query("SELECT * FROM customer WHERE Id=$Id ");
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Update customer
	public function customerUpdate($data,$rid)
	{
		  
			$query = $this->db->table("customer");
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
	
	//get All customer records
	public function customerRecords($shop, $myRole)
	{	
			$cdate = date('Y-m-d');
			$str='1';
			if($myRole!=1)
			{
				$str.=" AND Id=$shop";
			}
			$str.=" AND saveDate='$cdate'";
			$query = $this->db->query("SELECT * FROM customer WHERE $str ORDER BY saveDate DESC");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Deleted record
	public function deleteRecord($id)
	{ 
			$query = $this->db->table('excel');
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
}		
?>




