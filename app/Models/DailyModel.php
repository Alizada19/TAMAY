<?php
namespace App\Models;
use CodeIgniter\Model;
class DailyModel extends Model
{

		
	public function add($data)
	{
		    
			$query = $this->db->table('daily');
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
	
	public function updateRecord($data, $rid)
	{
		  
			$query = $this->db->table('daily');
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

	public function display()
	{
		    
			//$query = $this->db->query("SELECT * FROM daily WHERE DATE(sdate) = CURDATE()");
			$query = $this->db->query("SELECT * FROM daily WHERE shop='2'");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	public function displaybergaya()
	{
		    
			//$query = $this->db->query("SELECT * FROM daily WHERE DATE(sdate) = CURDATE()");
			$query = $this->db->query("SELECT * FROM daily WHERE shop='1'");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	public function displayeden()
	{
		    
			//$query = $this->db->query("SELECT * FROM daily WHERE DATE(sdate) = CURDATE()");
			$query = $this->db->query("SELECT * FROM daily WHERE shop IN('3', '4', '5', '6', '7')");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	public function finaldisplay()
	{
		    
			$query = $this->db->query("SELECT SUM(scash) AS totalCash, SUM(scard) AS totalCard, SUM(tsales) AS totalSales, SUM(texpens) AS totaleamount FROM daily");
			$res2 = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res2;
	}

	//expenses subtable
	public function addsub($data)
	{
		    
			$query = $this->db->table('exsub');
			$res = $query->insert($data);
			return $res;
	}	
	
	//Search specifec records
	public function displaysearch($data)
	{		
		    $sdate =  $data['sdate']; 
		    $edate =  $data['edate']; 
		    $shop =  $data['shop']; 
			$query = $this->db->query("SELECT SUM(scash) AS totalCash, SUM(scard) AS totalCard, SUM(tsales) AS totalSales, SUM(texpens) AS totaleamount FROM daily WHERE sdate BETWEEN '$sdate' AND '$edate' AND shop='$shop'");	
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Search all Tamay
	public function tamay($data)
	{		
		    $sdate =  $data['sdate']; 
		    $edate =  $data['edate']; 
		    $shop =  $data['shop']; 
			
			$query = $this->db->query("SELECT SUM(scash) AS totalCash, SUM(ncash) AS totalNcash, SUM(scard) AS totalCard, SUM(tsales) AS totalSales, SUM(texpens) AS totaleamount FROM daily WHERE sdate BETWEEN '$sdate' AND '$edate' AND shop='2'");	
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Search all Tamay chocolate
	public function tamayChocolate($data)
	{		
		    $sdate =  $data['sdate']; 
		    $edate =  $data['edate']; 
		    $shop =  $data['shop']; 
			
			$query = $this->db->query("SELECT SUM(scash) AS totalCash, SUM(ncash) AS totalNcash, SUM(scard) AS totalCard, SUM(tsales) AS totalSales, SUM(texpens) AS totaleamount FROM daily WHERE sdate BETWEEN '$sdate' AND '$edate' AND shop='12'");	
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Search all Bergaya
	public function bergaya($data)
	{		
		    $sdate =  $data['sdate']; 
		    $edate =  $data['edate']; 
		    $shop =  $data['shop']; 
			
			$query = $this->db->query("SELECT SUM(scash) AS totalCash, SUM(ncash) AS totalNcash, SUM(scard) AS totalCard, SUM(tsales) AS totalSales, SUM(texpens) AS totaleamount FROM daily WHERE sdate BETWEEN '$sdate' AND '$edate' AND shop='1'");	
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Search all Eden
	public function eden($data)
	{		
		    $sdate =  $data['sdate']; 
		    $edate =  $data['edate']; 
		    $shop =  $data['shop']; 
			
			$query = $this->db->query("SELECT SUM(scash) AS totalCash, SUM(ncash) AS totalNcash, SUM(scard) AS totalCard, SUM(tsales) AS totalSales, SUM(texpens) AS totaleamount FROM daily WHERE sdate BETWEEN '$sdate' AND '$edate' AND shop IN('3', '4', '6', '7', '11', '12')");	
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Tamay Total
	public function tamayTotal($data)
	{		
		    $sdate =  $data['sdate']; 
		    $edate =  $data['edate']; 
		    $shop =  $data['shop']; 
			
			$query = $this->db->query("SELECT SUM(scash) AS totalCash, SUM(ncash) AS totalNcash, SUM(scard) AS totalCard, SUM(tsales) AS totalSales, SUM(texpens) AS totaleamount FROM daily WHERE sdate BETWEEN '$sdate' AND '$edate' AND shop IN('2', '12')");	
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Bergaya total
	public function bergayaTotal($data)
	{		
		    $sdate =  $data['sdate']; 
		    $edate =  $data['edate']; 
		    $shop =  $data['shop']; 
			
			$query = $this->db->query("SELECT SUM(scash) AS totalCash, SUM(ncash) AS totalNcash, SUM(scard) AS totalCard, SUM(tsales) AS totalSales, SUM(texpens) AS totaleamount FROM daily WHERE sdate BETWEEN '$sdate' AND '$edate' AND shop IN('5')");	
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Search all si
	public function edensi($data)
	{		
		    $sdate =  $data['sdate']; 
		    $edate =  $data['edate']; 
		    $shop =  $data['shop']; 
			
			$query = $this->db->query("SELECT SUM(scash) AS totalCash, SUM(ncash) AS totalNcash, SUM(scard) AS totalCard, SUM(tsales) AS totalSales, SUM(texpens) AS totaleamount FROM daily WHERE sdate BETWEEN '$sdate' AND '$edate' AND shop='3'");	
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Search all johoni scent
	public function js($data)
	{		
		    $sdate =  $data['sdate']; 
		    $edate =  $data['edate']; 
		    $shop =  $data['shop']; 
			
			$query = $this->db->query("SELECT SUM(scash) AS totalCash, SUM(ncash) AS totalNcash, SUM(scard) AS totalCard, SUM(tsales) AS totalSales, SUM(texpens) AS totaleamount FROM daily WHERE sdate BETWEEN '$sdate' AND '$edate' AND shop='11'");	
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Search all sw
	public function edensw($data)
	{		
		    $sdate =  $data['sdate']; 
		    $edate =  $data['edate']; 
		    $shop =  $data['shop']; 
			
			$query = $this->db->query("SELECT SUM(scash) AS totalCash, SUM(ncash) AS totalNcash, SUM(scard) AS totalCard, SUM(tsales) AS totalSales, SUM(texpens) AS totaleamount FROM daily WHERE sdate BETWEEN '$sdate' AND '$edate' AND shop='4'");	
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Search JOHONI 
	public function edenjo($data)
	{		
		    $sdate =  $data['sdate']; 
		    $edate =  $data['edate']; 
		    $shop =  $data['shop']; 
			
			$query = $this->db->query("SELECT SUM(scash) AS totalCash, SUM(ncash) AS totalNcash, SUM(scard) AS totalCard, SUM(tsales) AS totalSales, SUM(texpens) AS totaleamount FROM daily WHERE sdate BETWEEN '$sdate' AND '$edate' AND shop='5'");	
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Search JOHONI-2 search 
	public function edenjo2($data)
	{		
		    $sdate =  $data['sdate']; 
		    $edate =  $data['edate']; 
		    $shop =  $data['shop']; 
			
			$query = $this->db->query("SELECT SUM(scash) AS totalCash, SUM(ncash) AS totalNcash, SUM(scard) AS totalCard, SUM(tsales) AS totalSales, SUM(texpens) AS totaleamount FROM daily WHERE sdate BETWEEN '$sdate' AND '$edate' AND shop='7'");	
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Search Eden 66A
	public function edena($data)
	{		
		    $sdate =  $data['sdate']; 
		    $edate =  $data['edate']; 
		    $shop =  $data['shop']; 
			
			$query = $this->db->query("SELECT SUM(scash) AS totalCash, SUM(ncash) AS totalNcash, SUM(scard) AS totalCard, SUM(tsales) AS totalSales, SUM(texpens) AS totaleamount FROM daily WHERE sdate BETWEEN '$sdate' AND '$edate' AND shop='6'");	
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Search all Shops
	public function allshops($data)
	{		
		    $sdate =  $data['sdate']; 
		    $edate =  $data['edate']; 
		    $shop =  $data['shop']; 
			
			$query = $this->db->query("SELECT SUM(scash) AS totalCash, SUM(ncash) AS totalNcash, SUM(scard) AS totalCard, SUM(tsales) AS totalSales, SUM(texpens) AS totaleamount FROM daily WHERE sdate BETWEEN '$sdate' AND '$edate'");	
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Update sub records
	//expenses subtable
	public function updateSub($data,$rid)
	{
		    
			$query = $this->db->table('exsub');
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
	
	//update only existing usb records
	public function updateSub2($data,$rid, $sf)
	{
		    
			$query = $this->db->table('exsub');
			$query->set($data);
			$query->where('Id', $rid);
			$query->where('allsubs', $sf);
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
	//Nightly reports
	//Search all Tamay
	public function tamayn()
	{		
		    
			$query = $this->db->query("SELECT SUM(scash) AS totalCash, SUM(ncash) AS totalNcash, SUM(scard) AS totalCard, SUM(tsales) AS totalSales, SUM(texpens) AS totaleamount FROM daily WHERE sdate BETWEEN CURDATE() AND CURDATE() AND shop='2'");	
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Search all Bergaya
	public function bergayan()
	{		 
			
			$query = $this->db->query("SELECT SUM(scash) AS totalCash, SUM(ncash) AS totalNcash, SUM(scard) AS totalCard, SUM(tsales) AS totalSales, SUM(texpens) AS totaleamount FROM daily WHERE sdate BETWEEN CURDATE() AND CURDATE() AND shop='1'");	
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Search all Eden
	public function edenn()
	{		
			
			$query = $this->db->query("SELECT SUM(scash) AS totalCash, SUM(ncash) AS totalNcash, SUM(scard) AS totalCard, SUM(tsales) AS totalSales, SUM(texpens) AS totaleamount FROM daily WHERE sdate BETWEEN CURDATE() AND CURDATE() AND shop IN('3', '4', '5', '6', '7')");	
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Search all si
	public function edensin()
	{				
			$query = $this->db->query("SELECT SUM(scash) AS totalCash, SUM(ncash) AS totalNcash, SUM(scard) AS totalCard, SUM(tsales) AS totalSales, SUM(texpens) AS totaleamount FROM daily WHERE sdate BETWEEN CURDATE() AND CURDATE() AND shop='3'");	
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Search all sw
	public function edenswn()
	{					
			$query = $this->db->query("SELECT SUM(scash) AS totalCash, SUM(ncash) AS totalNcash, SUM(scard) AS totalCard, SUM(tsales) AS totalSales, SUM(texpens) AS totaleamount FROM daily WHERE sdate BETWEEN CURDATE() AND CURDATE() AND shop='4'");	
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Search JOHONI 
	public function edenjon()
	{					
			$query = $this->db->query("SELECT SUM(scash) AS totalCash, SUM(ncash) AS totalNcash, SUM(scard) AS totalCard, SUM(tsales) AS totalSales, SUM(texpens) AS totaleamount FROM daily WHERE sdate BETWEEN CURDATE() AND CURDATE() AND shop='5'");	
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	
	//Search JOHONI-2 
	public function edenjon2()
	{					
			$query = $this->db->query("SELECT SUM(scash) AS totalCash, SUM(ncash) AS totalNcash, SUM(scard) AS totalCard, SUM(tsales) AS totalSales, SUM(texpens) AS totaleamount FROM daily WHERE sdate BETWEEN CURDATE() AND CURDATE() AND shop='7'");	
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Search Eden 66A
	public function edenan()
	{					
			$query = $this->db->query("SELECT SUM(scash) AS totalCash, SUM(ncash) AS totalNcash, SUM(scard) AS totalCard, SUM(tsales) AS totalSales, SUM(texpens) AS totaleamount FROM daily WHERE sdate BETWEEN CURDATE() AND CURDATE() AND shop='6'");	
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Search all Shops
	public function allshopsn()
	{		
			$query = $this->db->query("SELECT SUM(scash) AS totalCash, SUM(ncash) AS totalNcash, SUM(scard) AS totalCard, SUM(tsales) AS totalSales, SUM(texpens) AS totaleamount FROM daily WHERE sdate BETWEEN CURDATE() AND CURDATE()");	
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Remove sub records based on give id
	public function removesub($id)
	{
		    
			$query = $this->db->table('exsub');
			$query->where('Id', $id);
			$res = $query->delete(); 
			echo $res;
	}
	
	//Insert record
	public function savedc($data, $table)
	{
		    
			$query = $this->db->table($table);
			$res = $query->insert($data);
			return $res;
			
	}
	
	//General Add records
	public function gadd($data, $table)
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
	//General update record based on given id
	public function gupdate($data, $rid, $table)
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
	
	//Get all the cheques
	public function chequereports()
	{
		    
			$query = $this->db->query("SELECT * FROM payments WHERE ptype='1' ORDER BY ddate ASC");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	//Get specefic cheque reports
	public function chequeSpeceficReport($data)
	{
			$str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND ddate BETWEEN '$sdate' AND '$edate'";
			}
			if($data['status']!='')
			{
				$status=$data['status']; 
				$str.=" AND status=$status";
			}		
			if($data['cno']!='')
			{
				$cno=$data['cno']; 
				$str.=" AND cno=$cno";
			}	
			$query = $this->db->query("SELECT * FROM payments WHERE $str AND ptype='1' ORDER BY ddate");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	//Bring total amount
	public function chequeTotal()
	{
		    
			$query = $this->db->query("SELECT SUM(amount) AS totalAmount FROM payments WHERE ptype='1'");
			$res = $query->getRow(); 
			//echo $res->totalAmount ; exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	//Bring cheque specefic results
	public function chequeSpeceficTotal($data)
	{
		    $str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND ddate BETWEEN '$sdate' AND '$edate'";
			}
			if($data['status']!='')
			{
				$status=$data['status']; 
				$str.=" AND status=$status";
			}		
			if($data['cno']!='')
			{
				$cno=$data['cno']; 
				$str.=" AND cno=$cno";
			}	
			$query = $this->db->query("SELECT SUM(amount) AS totalAmount FROM payments WHERE $str AND ptype='1'");
			$res = $query->getRow(); 
			//echo $res->totalAmount ; exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	//Get all the online trnasfer and cash reports
	public function ocashreports()
	{
		    
			$query = $this->db->query("SELECT * FROM payments WHERE ptype='2' ORDER BY ddate");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	//Cheque Search
	public function chequesearch($data)
	{		
		    $sdate =  $data['sdate']; 
		    $edate =  $data['edate']; 
		    $status =  $data['status']; 
		    $cno =  $data['cno'];
			$str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND ddate BETWEEN '$sdate' AND '$edate'";
			}
			if($data['status']!='')
			{
				$status=$data['status']; 
				$str.=" AND status=$status";
			}		
			if($data['cno']!='')
			{
				$cno=$data['cno']; 
				$str.=" AND cno=$cno";
			}
			$query = $this->db->query("SELECT * FROM payments WHERE $str AND ptype='1' ORDER BY ddate ASC");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	//Cheque Search total
	public function chequesearcht($data)
	{		
		    $sdate =  $data['sdate']; 
		    $edate =  $data['edate']; 
		    $status =  $data['status']; 
			$cno =  $data['cno'];
			$str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND ddate BETWEEN '$sdate' AND '$edate'";
			}
			if($data['status']!='')
			{
				$status=$data['status']; 
				$str.=" AND status=$status";
			}		
			if($data['cno']!='')
			{
				$cno=$data['cno']; 
				$str.=" AND cno=$cno";
			}
			
			$query = $this->db->query("SELECT SUM(amount) AS totalAmount FROM payments WHERE $str AND ptype='1'");
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
		//Get all the OT(Online transfer) plus cash
	public function otreports()
	{
		    
			$query = $this->db->query("SELECT * FROM payments WHERE ptype='2' ORDER BY ddate");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	//Bring total OT
	public function otTotal()
	{
		    
			$query = $this->db->query("SELECT SUM(amount) AS totalAmount FROM payments WHERE ptype='2'");
			$res = $query->getRow(); 
			//echo $res->totalAmount ; exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	//OT specefic search
	//OT specefic search
	public function otsearch($data)
	{		
		    $str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND ddate BETWEEN '$sdate' AND '$edate'";
			}
			if($data['nsdate']!='' AND  $data['nedate']!='')
			{
				$nsdate=$data['nsdate']; 
				$nedate=$data['nedate']; 
				$str.=" AND invDate BETWEEN '$nsdate' AND '$nedate'";
			}
			if($data['invNo']!='')
			{
				$invNo=$data['invNo']; 
				$str.=" AND invNo=$invNo";
			} 
			if($data['status']!='')
			{   
				$status=$data['status']; 
				$str.=" AND status=$status";
			} 
			if($data['creditor']!='')
			{   
				$creditor=$data['creditor']; 
				$str.=" AND pto=$creditor";
			} 
			
			$query = $this->db->query("SELECT * FROM payments WHERE $str AND ptype='2' ORDER BY ddate");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	//Cheque Search total
	public function otsearchtTotal($data)
	{		
		     $str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND ddate BETWEEN '$sdate' AND '$edate'";
			}
			if($data['nsdate']!='' AND  $data['nedate']!='')
			{
				$nsdate=$data['nsdate']; 
				$nedate=$data['nedate']; 
				$str.=" AND invDate BETWEEN '$nsdate' AND '$nedate'";
			}
			if($data['invNo']!='')
			{
				$invNo=$data['invNo']; 
				$str.=" AND invNo=$invNo";
			}
			if($data['status']!='')
			{
				$status=$data['status']; 
				$str.=" AND status=$status";
			}  
			if($data['creditor']!='')
			{   
				$creditor=$data['creditor']; 
				$str.=" AND pto=$creditor";
			} 
			$query = $this->db->query("SELECT SUM(amount) AS totalAmount FROM payments WHERE $str AND ptype='2'");
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	//Search OT specefic records 
	public function otSpeceficReportSearch($data)
	{
			$str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND ddate BETWEEN '$sdate' AND '$edate'";
			}
			if($data['nsdate']!='' AND  $data['nedate']!='')
			{
				$nsdate=$data['nsdate']; 
				$nedate=$data['nedate']; 
				$str.=" AND invDate BETWEEN '$nsdate' AND '$nedate'";
			}
			if($data['invNo']!='')
			{
				$invNo=$data['invNo']; 
				$str.=" AND invNo=$invNo";
			}
			if($data['status']!='')
			{
				$status=$data['status']; 
				$str.=" AND status=$status";
			}  
			if($data['creditor']!='')
			{   
				$creditor=$data['creditor']; 
				$str.=" AND pto=$creditor";
			}
			$query = $this->db->query("SELECT * FROM payments WHERE $str AND ptype='2' ORDER BY ddate");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	//Bring total Sepecefic Records of OT
	public function otSearchTotal($data)
	{
		    $str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND ddate BETWEEN '$sdate' AND '$edate'";
			}
			if($data['nsdate']!='' AND  $data['nedate']!='')
			{
				$nsdate=$data['nsdate']; 
				$nedate=$data['nedate']; 
				$str.=" AND invDate BETWEEN '$nsdate' AND '$nedate'";
			}
			if($data['invNo']!='')
			{
				$invNo=$data['invNo']; 
				$str.=" AND invNo=$invNo";
			}
			if($data['status']!='')
			{
				$status=$data['status']; 
				$str.=" AND status=$status";
			}  
			if($data['creditor']!='')
			{   
				$creditor=$data['creditor']; 
				$str.=" AND pto=$creditor";
			}
			
			$sdate = $data['sdate'];
			$edate = $data['edate'];; 
			$query = $this->db->query("SELECT SUM(amount) AS totalAmount FROM payments WHERE $str AND ptype='2'");
			$res = $query->getRow(); 
			//echo $res->totalAmount ; exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	//Get all the payments
	public function apayments()
	{
			$query = $this->db->query("SELECT * FROM payments ORDER BY ddate");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	//Get all the payments total
	public function ptotal()
	{
		    
			$query = $this->db->query("SELECT SUM(amount) AS totalAmount FROM payments");
			$res = $query->getRow(); 
			//echo $res->totalAmount ; exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	//All Reports specefic Search
	public function allReportSearch($data)
	{		
		    $str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND ddate BETWEEN '$sdate' AND '$edate'";
			}
			if($data['nsdate']!='' AND  $data['nedate']!='')
			{
				$nsdate=$data['nsdate']; 
				$nedate=$data['nedate']; 
				$str.=" AND invDate BETWEEN '$nsdate' AND '$nedate'";
			}
			if($data['invNo']!='')
			{
				$invNo=$data['invNo']; 
				$str.=" AND invNo=$invNo";
			}
			if($data['status']!='')
			{
				$status=$data['status'];
				if($status==1)
				{
					$str.=" AND status IN ('1', '10')";
				}
				else
				{		
					$str.=" AND status=$status";
				}
			}  
			if($data['creditor']!='')
			{   
				$creditor=$data['creditor']; 
				$str.=" AND pto=$creditor";
			}
			if($data['cno']!='')
			{   
				$cno=$data['cno']; 
				$str.=" AND cno=$cno";
			}
			if($data['type']!='')
			{   
				$type=$data['type']; 
				$str.=" AND ptype=$type";
			}
			//echo $status; exit;
			$query = $this->db->query("SELECT * FROM payments WHERE $str ORDER BY ddate");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	//Cheque Search total
	public function allReportSearchTotal($data)
	{		
		    $str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND ddate BETWEEN '$sdate' AND '$edate'";
			}
			if($data['nsdate']!='' AND  $data['nedate']!='')
			{
				$nsdate=$data['nsdate']; 
				$nedate=$data['nedate']; 
				$str.=" AND invDate BETWEEN '$nsdate' AND '$nedate'";
			}
			if($data['invNo']!='')
			{
				$invNo=$data['invNo']; 
				$str.=" AND invNo=$invNo";
			}
			if($data['status']!='')
			{
				$status=$data['status']; 
				$str.=" AND status=$status";
			}  
			if($data['creditor']!='')
			{   
				$creditor=$data['creditor']; 
				$str.=" AND pto=$creditor";
			} 	
			if($data['cno']!='')
			{   
				$cno=$data['cno']; 
				$str.=" AND cno=$cno";
			} 
			if($data['type']!='')
			{   
				$type=$data['type']; 
				$str.=" AND ptype=$type";
			}
			$query = $this->db->query("SELECT SUM(amount) AS totalAmount FROM payments WHERE $str");
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	
	//Get specefic cheque reports
	public function chequeSpeceficReport2($data)
	{
			$str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND ddate BETWEEN '$sdate' AND '$edate'";
			}
			if($data['nsdate']!='' AND  $data['nedate']!='')
			{
				$nsdate=$data['nsdate']; 
				$nedate=$data['nedate']; 
				$str.=" AND invDate BETWEEN '$nsdate' AND '$nedate'";
			}
			if($data['invNo']!='')
			{
				$invNo=$data['invNo']; 
				$str.=" AND invNo=$invNo";
			}
			if($data['status']!='')
			{
				$status=$data['status']; 
				if($status==1)
				{
					$str.=" AND status IN ('1','10')";
				}
				else
				{	
					$str.=" AND status=$status";
				}
			}  
			if($data['creditor']!='')
			{   
				$creditor=$data['creditor']; 
				$str.=" AND pto=$creditor";
			} 	
			if($data['cno']!='')
			{   
				$cno=$data['cno']; 
				$str.=" AND cno=$cno";
			} 
			$query = $this->db->query("SELECT * FROM payments WHERE $str AND ptype='1' ORDER BY ddate");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	

	//Bring cheque specefic results total
	public function chequeSpeceficTotal2($data)
	{
		    $str='1';
			if($data['sdate']!='' AND  $data['edate']!='')
			{
				$sdate=$data['sdate']; 
				$edate=$data['edate']; 
				$str.=" AND ddate BETWEEN '$sdate' AND '$edate'";
			}
			if($data['nsdate']!='' AND  $data['nedate']!='')
			{
				$nsdate=$data['nsdate']; 
				$nedate=$data['nedate']; 
				$str.=" AND invDate BETWEEN '$nsdate' AND '$nedate'";
			}
			if($data['invNo']!='')
			{
				$invNo=$data['invNo']; 
				$str.=" AND invNo=$invNo";
			}
			if($data['status']!='')
			{
				$status=$data['status']; 
				if($status==1)
				{
					$str.=" AND status IN ('1','10')";
				}
				else
				{	
					$str.=" AND status=$status";
				}
			}  
			if($data['creditor']!='')
			{   
				$creditor=$data['creditor']; 
				$str.=" AND pto=$creditor";
			} 	
			if($data['cno']!='')
			{   
				$cno=$data['cno']; 
				$str.=" AND cno=$cno";
			} 
			$query = $this->db->query("SELECT SUM(amount) AS totalAmount FROM payments WHERE $str AND ptype='1'");
			$res = $query->getRow(); 
			//echo $res->totalAmount ; exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	//Bring reports of suppliers
	public function supReports()
	{
		    
			$query = $this->db->query("SELECT SUM(t1.amount) AS gamount, t1.pto as supplier FROM payments AS t1 GROUP BY t1.pto");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	//Calculat the 10 coming days pending cheques 
	public function pChequesChart()
	{
			$query = $this->db->query("SELECT SUM(t1.amount) AS tamount, t1.ddate AS dates FROM payments AS t1 WHERE t1.status ='1' GROUP BY t1.ddate");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	//Get user id
	public function getUsername($uname)
	{
		    
			//$query = $this->db->query("SELECT * FROM daily WHERE DATE(sdate) = CURDATE()");
			$query = $this->db->query("SELECT * FROM users WHERE uname='$uname'");
			$res = $query->getRow(); 
			return $res;
	}
	
	//Get user id
	public function myrole($uid)
	{
		    
			//$query = $this->db->query("SELECT * FROM daily WHERE DATE(sdate) = CURDATE()");
			$query = $this->db->query("SELECT * FROM roles WHERE userId='$uid'");
			$res = $query->getRow(); 
			return $res;
	}
	
	//Get all the creditors/debtors
	public function dcList()
	{
			$query = $this->db->query("SELECT * FROM debtorcreditor");
			$res = $query->getResult(); 
			return $res;
	}
	//Get total of the creditors/debtors
	public function dcListt()
	{
			$query = $this->db->query("SELECT COUNT(t1.dcnames) AS total FROM debtorcreditor AS t1");
			$res = $query->getRow(); 
			return $res->total;
	}
	
	//General Select records
	public function gselect($table, $id)
	{
			$query = $this->db->query("SELECT * FROM $table WHERE Id = '$id'");
			$res = $query->getRow(); 
			return $res;
	}
	
	//Update record
	public function updatedbc($data, $id)
	{
		     
			$query = $this->db->table('debtorcreditor');
			$query->set($data);
			$query->where('Id', $id);
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
	
	//Display todays curstomer inout records
	public function todayrecords($shop, $cdate)
	{
			$query = $this->db->query("SELECT * FROM cinout WHERE saveDate = '$cdate' AND shop=$shop");
			$res = $query->getResult(); 
			return $res;
	}
	
	//Get all the unschedule reports
	public function uncashreports()
	{
		    
			$query = $this->db->query("SELECT * FROM payments WHERE ptype='4'");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	//Bring total Unschedule
	public function unTotal()
	{
		    
			$query = $this->db->query("SELECT SUM(amount) AS totalAmount FROM payments WHERE ptype='4'");
			$res = $query->getRow(); 
			//echo $res->totalAmount ; exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	//Get all the list for the daily sales report
	public function dailyList()
	{
			$query = $this->db->query("SELECT * FROM daily");
			$res = $query->getResult(); 
			return $res;
	}
	
	//Get the total for the list of daily sales report
	public function dailyListt()
	{
			$query = $this->db->query("SELECT COUNT(t1.Id) AS total FROM daily AS t1");
			$res = $query->getRow(); 
			return $res->total;
	}
	//Get total records for each section of the customer in and out
	public function totalrecordsoftoday($shop, $cdate)
	{
			/*$query = $this->db->query("SELECT SUM(t1.cin) AS cin, COUNT(CASE WHEN t1.parchase = 2 THEN 1 END) AS yes, COUNT(CASE WHEN t1.parchase = 1 THEN 1 END) AS no, COUNT(CASE WHEN t1.lf = 1 THEN 1 END) AS locals, COUNT(CASE WHEN t1.lf = 2 THEN 1 END) AS foreigners FROM cinout AS t1 WHERE saveDate = CURDATE()");*/
			$query = $this->db->query("SELECT SUM(t1.cin) AS customers, SUM(t1.purchase) AS purchased, SUM(t1.purchasenot) AS notpurchased, SUM(t1.local) AS locals, SUM(t1.foreigner) AS foreigners FROM cinout AS t1 WHERE saveDate = '$cdate' AND shop=$shop");
			$res = $query->getRow();
			//echo "<pre />"; print_r($res); exit;	
			return $res;
	}
	
	//Select all the sales percentage for one week 
	public function parchase()
	{
			$query = $this->db->query("SELECT SUM(t1.purchase) AS purchase, t1.saveDate AS date FROM cinout AS t1 GROUP BY t1.saveDate");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	//Get given date payments
	public function givendatepayments($date)
	{	
			$query = $this->db->query("SELECT * FROM payments WHERE ddate = '$date' AND status='1' ORDER BY ptype");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	//Get given date total payments
	public function givenDateTotalPayments($date)
	{
		    
			$query = $this->db->query("SELECT SUM(amount) AS totalAmount FROM payments WHERE ddate = '$date' AND status='1'");
			$res = $query->getRow(); 
			return $res;
	}
	
	//Cheque Total
	public function chequeTotalBydate($date)
	{
		    
			$query = $this->db->query("SELECT SUM(amount) AS totalAmount FROM payments WHERE ddate = '$date' AND status='1' AND ptype='1'");
			$res = $query->getRow(); 
			return $res;
	}
	//creditors Total
	public function creditorsTotal($date)
	{
		    
			$query = $this->db->query("SELECT SUM(amount) AS totalAmount FROM payments WHERE ddate = '$date' AND status='1' AND ptype='2'");
			$res = $query->getRow(); 
			return $res;
	}
	
	//Search and count by date
	public function searchAmountBydate($data)
	{		
		    $sdate =  $data['sdate']; 
		    $edate =  $data['edate']; 
			$query = $this->db->query("SELECT SUM(t1.amount) AS totalAmount, t1.ddate AS ddate FROM payments AS t1 WHERE ddate BETWEEN '$sdate' AND '$edate' AND status='1' GROUP BY t1.ddate");
			$res = $query->getResult(); 
			return $res;
	}
	
	//Payment total
	public function totalsearchBydate($data)
	{		
		    $sdate =  $data['sdate']; 
		    $edate =  $data['edate'];   	
			
			$query = $this->db->query("SELECT SUM(amount) AS totalAmount FROM payments WHERE ddate BETWEEN '$sdate' AND '$edate' AND status ='1'");
			$res = $query->getRow(); 
			return $res;
	}
	
	
	//Get sales reports day by day
	public function dailySales($sdate, $edate, $slocation)
	{		
		    //echo $sdate.'|'.$edate.'|'.$slocation; exit;
			$query = $this->db->query("SELECT SUM(scash) AS totalCash, SUM(ncash) AS totalNcash, SUM(scard) AS totalCard, SUM(tsales) AS totalSales, SUM(texpens) AS totaleamount, sdate FROM daily WHERE sdate BETWEEN '$sdate' AND '$edate' AND shop='$slocation' GROUP BY sdate");	
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Search sum of given shops
	public function sumofgivenshops($sdate, $edate, $shop)
	{		
		    
			$query = $this->db->query("SELECT SUM(scash) AS totalCash, SUM(ncash) AS totalNcash, SUM(scard) AS totalCard, SUM(tsales) AS totalSales, SUM(texpens) AS totaleamount FROM daily WHERE sdate BETWEEN '$sdate' AND '$edate' AND shop='$shop'");	
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Get expenses type by given dates
	public function expensesType($sdate, $edate, $shop)
	{		
		    //echo $sdate.'|'.$edate.'|'.$slocation; exit;
			$query = $this->db->query("SELECT SUM(t1.sub1) As tsub1, 
			SUM(t1.sub2) As tsub2, 
			SUM(t1.sub3) As tsub3, 
			SUM(t1.sub4) As tsub4, 
			SUM(t1.sub5) As tsub5, 
			SUM(t1.sub6) As tsub6, 
			SUM(t1.sub7) As tsub7, 
			SUM(t1.sub8) As tsub8 
			from exsub AS t1, daily AS t2
			WHERE t2.Id=t1.rdid AND sdate BETWEEN '$sdate' AND '$edate' AND shop='$shop'
			");	
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Calculat the 10 coming days pending cheques 
	public function displayPending($sdate, $edate)
	{	
			$query = $this->db->query("SELECT SUM(t1.amount) AS tamount, t1.ddate AS dates FROM payments AS t1 WHERE ddate BETWEEN '$edate' AND '$sdate' AND t1.status ='1' GROUP BY t1.ddate ORDER BY ddate DESC");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	//Get one month pending for the payments
	public function pendingPaymentsCharts()
	{
			$query = $this->db->query("SELECT SUM(t1.amount) AS tamount, t1.ddate AS dates FROM payments AS t1 WHERE t1.status ='1' AND MONTH(t1.ddate)=MONTH(now()) GROUP BY t1.ddate");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	//Get all the list for the balancesheet
	public function balanceList($dbc)
	{
			$query = $this->db->query("SELECT * FROM balancesheet AS t1 WHERE t1.dbc=$dbc ORDER BY t1.ddate");
			$res = $query->getResult(); 
			return $res;
	}
	
	//Get all the list for the Main list
	public function balanceMainList()
	{
			$query = $this->db->query("SELECT SUM(t1.damount) AS damount, SUM(t1.camount) AS camount, t1.dbc AS dbc, t2.type AS type FROM balancesheet AS t1, debtorcreditor As t2 WHERE t2.Id=t1.dbc GROUP BY t1.dbc ");
			$res = $query->getResult(); //echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//sum of single creditor and debtor
	public function dbcSum($dbc)
	{
			$query = $this->db->query("SELECT SUM(t1.damount) AS damount, SUM(t1.camount) AS camount FROM balancesheet AS t1 WHERE dbc=$dbc");
			$res = $query->getRow(); 
			return $res;
	}
	
	//sum of all debtors and creditors
	public function dbcTotal()
	{
			$query = $this->db->query("SELECT SUM(t1.damount) AS damount, SUM(t1.camount) AS camount FROM balancesheet AS t1");
			$res = $query->getRow(); 
			return $res;
	}
	
	//Get total of creditors and debtors
	public function geTotaldbc()
	{
			$query = $this->db->query("SELECT COUNT(t1.dcnames)AS total FROM debtorcreditor AS t1");
			$res = $query->getRow(); 
			return $res->total;
	}
	//Get one record
	public function dbconerecord($id)
	{
			$query = $this->db->query("SELECT * FROM debtorcreditor WHERE Id = '$id'");
			$res = $query->getRow(); 
			return $res;
	}
	
	//Search by type
	public function searchbytype($type)
	{
			$query = $this->db->query("SELECT SUM(t1.damount) AS damount, SUM(t1.camount) AS camount, t1.dbc AS dbc, t2.type AS type FROM balancesheet AS t1, debtorcreditor As t2 WHERE t2.Id=t1.dbc AND t2.type=$type GROUP BY t1.dbc");  
			$res = $query->getResult();  //echo "<pre />"; print_r($res); exit;
			return $res;
	}
	//Total Search By type
	public function dbctypeTotal($type)
	{
			$query = $this->db->query("SELECT SUM(t1.damount) AS damount, SUM(t1.camount) AS camount FROM balancesheet AS t1, debtorcreditor AS t2 WHERE t2.Id=t1.dbc and t2.type=$type");
			$res = $query->getRow(); 
			return $res;
	}
	
	//Get user details
	public function udetails($uname)
	{
			$query = $this->db->query("SELECT * FROM users WHERE uname='$uname'");
			$res = $query->getRow(); 
			return $res;
	}
	//temp can be removed
	public function temp($perpage, $offset)
	{
			$query = $this->db->query("SELECT * FROM debtorcreditor limit $offset, $perpage");
			$res = $query->getResult(); 
			return $res;
	}
	//Pending of one month
	public function amonthpending()
	{	
			$query = $this->db->query("SELECT SUM(t1.amount) AS tamount, t1.ddate AS dates FROM payments AS t1 WHERE MONTH(ddate)=MONTH(CURRENT_DATE()) AND t1.status ='1' GROUP BY t1.ddate ORDER BY ddate DESC");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	//MTD Sales results for the charts
	public function mtdSales()
	{
		    
			$query = $this->db->query("SELECT t1.shop AS shop, SUM(t1.tsales)  AS tsales FROM daily AS t1 WHERE MONTH(t1.sdate)=MONTH(CURRENT_DATE) GROUP BY t1.shop");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	//Daily Sales results for the charts
	public function shopsDailySales()
	{
		    
			$query = $this->db->query("SELECT t1.sdate AS sdate, SUM(t1.tsales)  AS tsales FROM daily AS t1 WHERE MONTH(t1.sdate)=MONTH(CURRENT_DATE) GROUP BY t1.sdate");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	//Get all the list for the Main list
	public function balanceMainList2()
	{
			$query = $this->db->query("
			
			SELECT 
				ur.dbc,
				SUM(ur.tamount) AS tamount,
				SUM(ur.damount) AS damount,
				t.type
			FROM (
				SELECT 
					p.pto AS dbc, 
					p.tamount, 
					NULL AS damount
				FROM 
					(SELECT pto, SUM(amount) AS tamount FROM payments WHERE ptype=2 GROUP BY pto) AS p
				
				UNION ALL
				
				SELECT
					e.crno AS dbc, 
					NULL AS tamount, 
					e.damount AS damount
				FROM
					(SELECT crno, SUM(amount) AS damount FROM expenses WHERE crno!=0 GROUP BY crno) AS e
			) ur
			LEFT JOIN debtorcreditor AS t
			ON t.Id=ur.dbc
			GROUP BY ur.dbc;
			
			"); 
			$res = $query->getResult(); //echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Get Total records
	public function balanceMainListTotal()
	{   
			$query = $this->db->query("
			SELECT 
				ur.dbc,
				SUM(ur.tamount) AS td,
				SUM(ur.damount) AS tc,
				t.type
			FROM (
				SELECT 
					p.pto AS dbc, 
					p.tamount, 
					NULL AS damount
				FROM 
					(SELECT pto, SUM(amount) AS tamount FROM payments WHERE ptype=2 GROUP BY pto) AS p
				
				UNION ALL
				
				SELECT
					e.crno AS dbc, 
					NULL AS tamount, 
					e.damount AS damount
				FROM
					(SELECT crno, SUM(amount) AS damount FROM expenses WHERE crno!=0 GROUP BY crno) AS e
			) ur
			LEFT JOIN debtorcreditor AS t
			ON t.Id=ur.dbc
			 "); 
			$res = $query->getRow(); //echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Get all the list for the balancesheet of single D/C
	public function balanceList2($dbc)
	{		
			$query = $this->db->query("
			SELECT  
			pto AS pto, 
			invDate AS invDate, 
			amount AS amount,
			cno AS cno,
			NULL AS crno, 
			NULL AS pdate, 
			NULL AS damount
			FROM payments
			WHERE pto = $dbc AND ptype=2

			UNION ALL

			SELECT  
				NULL AS pto, 
				NULL AS invDate, 
				NULL AS amount,
				cno AS cno,
				crno AS crno, 
				pdate AS pdate, 
				amount AS damount
			FROM expenses
			WHERE crno = $dbc;	
			
			
					");
			$res = $query->getResult(); //echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Get total
	public function dbcSum2($dbc)
	{		
			$query = $this->db->query("
			SELECT   
			SUM(amount) AS tamount, 
			NULL AS damount
			FROM payments
			WHERE pto = $dbc AND ptype=2

			UNION ALL

			SELECT  
				NULL AS amount, 
				SUM(amount) AS damount
			FROM expenses
			WHERE crno = $dbc;	
			
			
					");
			$res = $query->getResultArray(); //echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Search by type
	public function searchbytypeNew($type)
	{		
			$query = $this->db->query("
			SELECT 
				ur.dbc,
				SUM(ur.tamount) AS tamount,
				SUM(ur.damount) AS damount,
				t.type
			FROM (
				SELECT 
					p.pto AS dbc, 
					p.tamount, 
					NULL AS damount
				FROM 
					(SELECT pto, SUM(amount) AS tamount FROM payments WHERE ptype=2 GROUP BY pto) AS p
				
				UNION ALL
				
				SELECT
					e.crno AS dbc, 
					NULL AS tamount, 
					e.damount AS damount
				FROM
					(SELECT crno, SUM(amount) AS damount FROM expenses WHERE crno!=0 GROUP BY crno) AS e
			) ur
			LEFT JOIN debtorcreditor AS t
			ON t.Id=ur.dbc WHERE t.type=$type
			GROUP BY ur.dbc;
			
			"); 
			$res = $query->getResult(); //echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Get Total records
	public function dbctypeTotalNew($type)
	{   
			$query = $this->db->query("
			SELECT 
				ur.dbc,
				SUM(ur.tamount) AS td,
				SUM(ur.damount) AS tc,
				t.type
			FROM
			(SELECT 
			p.pto AS dbc, 
			p.tamount, 
			NULL AS damount	
			FROM 
			(SELECT pto, SUM(amount) AS tamount FROM payments WHERE ptype=2 GROUP BY pto) AS p
			
			UNION ALL
			
			SELECT
			e.crno AS dbc, 
			NULL AS tamount, 
			e.damount AS damount
			FROM
			(SELECT crno, SUM(amount) AS damount FROM expenses WHERE crno!=0 GROUP BY crno) AS e) ur 
			
			LEFT JOIN debtorcreditor AS t
			ON t.Id=ur.dbc WHERE t.type=$type;
			 "); 
			$res = $query->getRow(); //echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Get post dated cheques for given supplier
	public function postDateCheque($dbc)
	{
			$query = $this->db->query("SELECT * FROM payments WHERE ptype=1 AND status IN ('1', '10') AND pto=$dbc ORDER BY ddate");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}	
	
	//sum of all post dated cheques
	public function postDateChequeTotal($dbc)
	{
			$query = $this->db->query("SELECT SUM(t1.amount) AS tamount FROM payments AS t1 WHERE ptype=1 AND status IN ('1', '10') AND pto=$dbc ORDER BY t1.ddate");
			$res = $query->getRow(); 
			return $res;
	}
	
	//Get pendding On Accounts
	public function onaPending($dbc)
	{
			$query = $this->db->query("SELECT * FROM payments WHERE ptype=2 AND status=1 AND pto=$dbc ORDER BY ddate");
			$res = $query->getResult(); 
			return $res;
	}	
	
	//sum of all On Accounts pendding
	public function onapendingTotal($dbc)
	{
			$query = $this->db->query("SELECT SUM(t1.amount) AS tamount FROM payments AS t1 WHERE ptype=2 AND status=1 AND pto=$dbc");
			$res = $query->getRow(); 
			return $res;
	}
	
	//Get paid Cheques
	public function paidCheques($dbc)
	{
			$query = $this->db->query("SELECT * FROM payments WHERE ptype=1 AND status=2 AND pto=$dbc ORDER BY ddate");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}	
	
	//sum of paid Cheques
	public function paidChequesTotal($dbc)
	{
			$query = $this->db->query("SELECT SUM(t1.amount) AS tamount FROM payments AS t1 WHERE ptype=1 AND status=2 AND pto=$dbc");
			$res = $query->getRow(); 
			return $res;
	}
	
	//Get paid On Accounts
	public function paidOt($dbc)
	{
			$query = $this->db->query("SELECT * FROM payments WHERE ptype=2 AND status=2 AND pto=$dbc ORDER BY ddate");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}	
	
	//sum of paid On Accounts
	public function paidOtTotal($dbc)
	{
			$query = $this->db->query("SELECT SUM(t1.amount) AS tamount FROM payments AS t1 WHERE ptype=2 AND status=2 AND pto=$dbc");
			$res = $query->getRow(); 
			return $res;
	}
	
	//get all MTD SALES
	public function getAllmtdsales()
	{
		    
			$query = $this->db->query("SELECT SUM(t1.tsales)  AS tsales FROM daily AS t1 WHERE MONTH(t1.sdate)=MONTH(CURRENT_DATE)");
			$res = $query->getRow(); 
			//echo "<pre />"; print_r($res); exit;
			//$data['cat_data'] = $res;
			return $res;
	}
	
	//Get investment records
	public function getInvestment($data)
	{		
		    $sdate =  $data['sdate']; 
		    $edate =  $data['edate']; 
			$query = $this->db->query("SELECT * FROM investment WHERE sdate BETWEEN '$sdate' AND '$edate'");
			$res = $query->getResult(); 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
	
	//Get Investment Total
	public function getInvestmentTotal($data)
	{		
		    $sdate =  $data['sdate']; 
		    $edate =  $data['edate']; 
			$query = $this->db->query("SELECT SUM(amount) AS total FROM investment WHERE sdate BETWEEN '$sdate' AND '$edate'");
			$res = $query->getRow()->total; 
			//echo "<pre />"; print_r($res); exit;
			return $res;
	}
}	
?>