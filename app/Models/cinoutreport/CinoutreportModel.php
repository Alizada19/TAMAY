<?php
namespace App\Models\cinoutreport;
use CodeIgniter\Model;
class CinoutreportModel extends Model
{
	//Display records
	public function getPurchase($data)
	{
			$str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND saveDate BETWEEN '$sdate' AND '$edate'";
			}
			if($data['shop']!='')
			{   
				$shop=$data['shop']; 
				$str.=" AND shop=$shop";
			}		
			$query = $this->db->query("SELECT saveDate AS date, SUM(cin) AS visitors, SUM(purchase) AS purchases FROM cinout WHERE $str GROUP BY date");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Display all purchases
	public function getPurchaseAll($data)
	{
			$str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND saveDate BETWEEN '$sdate' AND '$edate'";
			}
			if($data['shop']!='')
			{   
				$shop=$data['shop']; 
				$str.=" AND shop=$shop";
			}		
			$query = $this->db->query("SELECT SUM(cin) AS visitors, SUM(purchase) AS purchases FROM cinout WHERE $str");
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Locality
	public function locality($data)
	{
			$str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND saveDate BETWEEN '$sdate' AND '$edate'";
			}
			if($data['shop']!='')
			{   
				$shop=$data['shop']; 
				$str.=" AND shop=$shop";
			}		
			$query = $this->db->query("
				SELECT 
					saveDate AS date, 
					SUM(local) AS locals, 
					SUM(foreigner) AS foreigner
				FROM 
					cinout
				WHERE 
					purchase = 1  AND $str
				GROUP BY 
					date
				ORDER BY 
					Date
			");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Locality All
	public function localityAll($data)
	{
			$str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND saveDate BETWEEN '$sdate' AND '$edate'";
			}
			if($data['shop']!='')
			{   
				$shop=$data['shop']; 
				$str.=" AND shop=$shop";
			}		
			$query = $this->db->query("
				SELECT 
					SUM(local) AS locals, 
					SUM(foreigner) AS foreigner
				FROM 
					cinout
				WHERE 
					purchase = 1  AND $str
			");
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
}	
?>




