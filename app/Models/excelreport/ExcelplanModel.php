<?php
namespace App\Models\excelreport;
use CodeIgniter\Model;
class ExcelplanModel extends Model
{
	//Get records of gilasco
	public function getResult($table, $shop, $sdate, $edate)
	{
			$query = $this->db->query("SELECT sdate, tsales FROM $table WHERE shop='$shop' AND sdate BETWEEN '$sdate' AND '$edate' ORDER BY sdate");
			$res = $query->getResultArray(); 
			return $res;
	}
	//Get records of edens
	public function getGlcCash($table, $sdate, $edate)
	{
			$query = $this->db->query("SELECT pdate, SUM(amount) AS amount FROM $table WHERE ptype IN('1','3') AND pdate BETWEEN '$sdate' AND '$edate' GROUP BY pdate ORDER BY pdate");
			$res = $query->getResultArray(); 
			return $res;
	}
	
	//Get records credits
	public function glcCredit($table, $sdate, $edate)
	{
			$query = $this->db->query("
			SELECT pdate, SUM(amount) AS tamount, crno 
			FROM $table 
			WHERE (crno IS NOT NULL AND crno != 0) 
			  AND (cno IS NULL OR cno = '') 
			  AND pdate BETWEEN '$sdate' AND '$edate' 
			GROUP BY pdate 
			ORDER BY pdate;
			");
			$res = $query->getResultArray(); 
			return $res;
	}
}	
?>




