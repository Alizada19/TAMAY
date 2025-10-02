<?php
namespace App\Models\perfumes;
use CodeIgniter\Model;
class HomeModel extends Model
{

	//Save record		
	public function saveRecord($data, $table)
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
	//Display records
	public function displayRecord($rid, $table)
	{
			$query = $this->db->query("SELECT * FROM $table WHERE Id=$rid");
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
	
	//Get all results
	public function getAllResult($table)
	{
			$query = $this->db->query("SELECT * FROM $table");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Get all results by given id
	public function getAllResultByid($table, $gid)
	{
			$query = $this->db->query("SELECT * FROM $table WHERE gid=$gid");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Get one Total
	public function getOneTotal($value1,$table)
	{
		    
			$query = $this->db->query("SELECT COUNT($value1) total FROM $table");
			$res = $query->getRow()->total; 
			return $res;
	}
	
	//Check Record
	public function checkRecord($value1, $value2, $table)
	{
		    
			$query = $this->db->query("SELECT COUNT($value1) AS total FROM $table WHERE $value1='$value2'");
			$res = $query->getRow()->total; 
			return $res;
	}
	
	//Get all result expenses payments
	public function perfumesAllResult($perpage, $offset)
	{
			$query = $this->db->query("SELECT * FROM perfumes ORDER BY saveDate DESC limit $offset, $perpage");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//main one Total
	public function mainOneTotal($value1,$table)
	{
		    
			$query = $this->db->query("SELECT SUM($value1) AS total FROM $table");
			$res = $query->getRow()->total; 
			return $res;
	}
	
	//temp can be removed
	public function temp($perpage, $offset)
	{
			$query = $this->db->query("SELECT * FROM expenses limit $offset, $perpage");
			$res = $query->getResult(); 
			return $res;
	}
	
	//Filter Search
	public function filterSearch($data)
	{	
			//echo "<pre />"; print_r($data); exit;
			$str='1';
			if($data['pid']!='')
			{
				$pid=$data['pid']; 
				$str.=" AND Id=$pid";
			}
			if($data['pname']!='')
			{
				$pname=$data['pname']; 
				$str.=" AND name=$pname";
			}
			if($data['pgroup']!='')
			{
				$pgroup=$data['pgroup']; 
				$str.=" AND `group`=$pgroup";
			}
			if($data['pcategory']!='')
			{
				$pcategory=$data['pcategory']; 
				$str.=" AND `category`=$pcategory";
			}	
			if($data['remark']!='')
			{
				$remark=$data['remark']; 
				$str.=" AND remark=$remark";
			}
			
			$query = $this->db->query("SELECT * FROM perfumes WHERE $str"); 
			$res = $query->getResult(); 
			//echo $this->db->getLastQuery()->getQuery(); exit;
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	
	//Filter search for pagination
	public function filterSearchPagination($perpage, $offset, $data)
	{	
			//echo "<pre />"; print_r($data); exit;
			$str='1';
			if($data['pid']!='')
			{
				$pid=$data['pid']; 
				$str.=" AND Id=$pid";
			}
			if($data['pname']!='')
			{
				$pname=$data['pname']; 
				$str.=" AND name=$pname";
			}
			if($data['pgroup']!='')
			{
				$pgroup=$data['pgroup']; 
				$str.=" AND `group`=$pgroup";
			}
			if($data['pcategory']!='')
			{
				$pcategory=$data['pcategory']; 
				$str.=" AND `category`=$pcategory";
			}	
			if($data['remark']!='')
			{
				$remark=$data['remark']; 
				$str.=" AND remark=$remark";
			}
			
			$query = $this->db->query("SELECT * FROM perfumes WHERE $str ORDER BY Id DESC limit $offset, $perpage"); 
			$res = $query->getResult(); 
			//echo $this->db->getLastQuery()->getQuery(); exit;
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Get one Total for filter
	public function filterOneTotal($data)
	{
		    $str='1';
			if($data['pid']!='')
			{
				$pid=$data['pid']; 
				$str.=" AND Id=$pid";
			}
			if($data['pname']!='')
			{
				$pname=$data['pname']; 
				$str.=" AND name=$pname";
			}
			if($data['pgroup']!='')
			{
				$pgroup=$data['pgroup']; 
				$str.=" AND `group`=$pgroup";
			}
			if($data['pcategory']!='')
			{
				$pcategory=$data['pcategory']; 
				$str.=" AND `category`=$pcategory";
			}	
			if($data['remark']!='')
			{
				$remark=$data['remark']; 
				$str.=" AND remark=$remark";
			}
			
			$query = $this->db->query("SELECT COUNT(Id) AS total FROM perfumes WHERE $str");
			$res = $query->getRow()->total; 
			return $res;
	}
	
	//Filter Search Sum
	public function filterSearchSum($data)
	{	
			//echo "<pre />"; print_r($data); exit;
			$str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND pdate BETWEEN '$sdate' AND '$edate'";
			}
			if($data['amount']!='')
			{
				$amount=$data['amount']; 
				$str.=" AND amount=$amount";
			}
			if($data['groupe']!='')
			{
				$groupe=$data['groupe']; 
				$str.=" AND groupe=$groupe";
			}
			if($data['category']!='')
			{
				$category=$data['category']; 
				$str.=" AND category=$category";
			}	
			if($data['subcategory']!='')
			{
				$subcategory=$data['subcategory']; 
				$str.=" AND subcategory=$subcategory";
			}
			if($data['des']!='')
			{
				$des=$data['des']; 
				$str.=" AND des='$des'";
			}
			if($data['ptype']!='')
			{
				$ptype=$data['ptype']; 
				$str.=" AND ptype=$ptype";
			}
			$query = $this->db->query("SELECT SUM(amount) AS total FROM expenses WHERE $str");
			$res = $query->getRow()->total; 
			//echo $this->db->getLastQuery()->getQuery(); exit;
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Groupe based report
	public function greport()
	{
			$query = $this->db->query("SELECT * FROM expenses WHERE groupe!=0 ORDER BY groupe");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Get all the expenses
	public function expenses()
	{
			$query = $this->db->query("SELECT t1.groupe AS groupe, SUM(t1.amount) AS amount FROM expenses AS t1 WHERE groupe!=0 AND MONTH(pdate)=MONTH(CURRENT_DATE()) GROUP BY t1.groupe");
			$res = $query->getResult(); //echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Sum amounts for the expenses
	public function sumAmount()
	{
			$query = $this->db->query("SELECT SUM(t1.amount) AS tamount FROM expenses AS t1 WHERE groupe!=0 AND MONTH(pdate)=MONTH(CURRENT_DATE())");
			$res = $query->getRow()->tamount; 
			return $res;
	}
	
	//Groupe based expenses
	public function groupebased($gid)
	{
			$query = $this->db->query("SELECT * FROM expenses WHERE groupe!=0 AND groupe=$gid AND MONTH(pdate)=MONTH(CURRENT_DATE())");
			$res = $query->getResult(); 
			return $res;
	}
	//Groupe based total expenses
	public function groupebasedTotal($gid)
	{
			$query = $this->db->query("SELECT SUM(t1.amount) AS total FROM expenses AS t1 WHERE groupe!=0 AND groupe=$gid AND MONTH(pdate)=MONTH(CURRENT_DATE())");
			$res = $query->getRow()->total; 
			return $res;
	}
	
	//Get Category
	public function getCategory()
	{
			$query = $this->db->query("SELECT t1.category AS category, SUM(t1.amount) AS amount FROM expenses AS t1 WHERE MONTH(pdate)=MONTH(CURRENT_DATE()) GROUP BY t1.category");
			$res = $query->getResult(); //echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Get Category total sub parts
	public function getCategoryTotal()
	{
			$query = $this->db->query("SELECT SUM(t1.amount) AS total FROM expenses AS t1 WHERE MONTH(pdate)=MONTH(CURRENT_DATE())");
			$res = $query->getRow()->total; //echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//category based expenses
	public function categorybased($cid)
	{
			$query = $this->db->query("SELECT * FROM expenses WHERE category=$cid AND MONTH(pdate)=MONTH(CURRENT_DATE())");
			$res = $query->getResult(); 
			return $res;
	}
	//category based total expenses
	public function categorybasedTotal($cid)
	{
			$query = $this->db->query("SELECT SUM(t1.amount) AS total FROM expenses AS t1 WHERE category=$cid AND MONTH(pdate)=MONTH(CURRENT_DATE())");
			$res = $query->getRow()->total; 
			return $res;
	}
	
	//Get all the expenses
	public function cexpenses()
	{
			$query = $this->db->query("SELECT t1.groupe AS groupe, SUM(t1.amount) AS amount FROM expenses AS t1 WHERE groupe!=0 AND MONTH(pdate)=MONTH(CURRENT_DATE()) GROUP BY t1.groupe");
			$res = $query->getResultArray(); //echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Expenses by category
	public function expenseBycategory()
	{
			$query = $this->db->query("SELECT t1.category AS category, SUM(t1.amount) AS amount FROM expenses AS t1 WHERE MONTH(pdate)=MONTH(CURRENT_DATE()) GROUP BY t1.category");
			$res = $query->getResultArray(); //echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Get cheque record
	public function getCheque($cid)
	{
			$query = $this->db->query("SELECT pto, amount FROM payments WHERE cno=$cid AND ptype='1'");
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Update cheque by cheque no
	public function updateCheque($cno)
	{
		  
			$query = $this->db->table("payments");
			$query->set('status', 2);
			$query->where('cno', $cno);
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
	
	//Get All pending Cheques
	public function getPendingCheques()
	{
			$query = $this->db->query("SELECT * FROM payments WHERE ptype='1' AND status=1");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Get All pending on accounts
	public function getPendingdb()
	{
			$query = $this->db->query("SELECT * FROM payments WHERE ptype='2' AND status=1");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//groupe by date
	public function getTotalPendings()
	{
			$query = $this->db->query("SELECT SUM(amount) AS total, ddate as date FROM payments WHERE status=1 GROUP BY ddate");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Get perfume Image
	public function getPerfumeImage($rid)
	{
			$query = $this->db->query("SELECT * FROM pimages WHERE rid=$rid AND etype=1");
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	//Get All Perfumes
	public function getAllPerfumes()
	{
			$query = $this->db->query("SELECT * FROM perfumes");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
}	
?>




