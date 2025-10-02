<?php

namespace App\Controllers;
use App\Models\DailyModel;
use App\Models\expenses\ExpensesModel;
class Login extends BaseController
{
    //my constructor
	public function __construct() {

        $this->DailyModel = new DailyModel();
		$this->ExpensesModel = new ExpensesModel();
		$this->session = \Config\Services::session();
		helper('fornames');
        
	}
	
	public function index(): string
    {   
		
        return view('login/home');
    }
	
	
	public function add()
    {		
		$request = \Config\Services::request();
		
		$uname = $request->getPost('uname');
		$password = $request->getPost('password');
		//Get user id
		$getUserid = $this->DailyModel->getUsername($uname); 
		if($getUserid)
		{
			$userid = $getUserid->Id; 
			//$pChequeCharts = $this->DailyModel->pChequesChart();
			//Daily sales for all shops
			$sresult = $this->DailyModel->mtdSales(); //echo "<pre />"; print_r($sresult); exit;
			$dsresult = $this->DailyModel->shopsDailySales(); //echo "<pre />"; print_r($dsresult); exit;
			//Get total sales
			$atsales = $this->DailyModel->getAllmtdsales();
			$data2['atsales']=$atsales;
			
			$sdata2=array();
			$sxdata2=array();
			if($dsresult)
			{	
				
				foreach($dsresult AS $s)
				{
					$sdata2[]=round(floatval($s->tsales),2);		
					$sxdata2[] = $s->sdate;		
				}
			}
			//echo "<pre >"; print_r($sxdata); exit;
			$data2['sdata2']=$sdata2;
			$data2['sxdata2']=$sxdata2;
			
			//monthly Sales for all shops
			$sdata=array();
			$sxdata=array();
			if($sresult)
			{	
				
				foreach($sresult AS $s)
				{
					$sdata[]=round(floatval($s->tsales),2);		
					$sxdata[] = bname($s->shop);		
				}
			}
			//echo "<pre >"; print_r($sdata); exit;
			$data2['sdata']=$sdata;
			$data2['sxdata']=$sxdata;
			//Ge pending payments for the charts
			$pendingPay = $this->DailyModel->pendingPaymentsCharts(); //echo "<pre />"; print_r($pendingPay); exit;
			$jdata = array();
			$jxdata = array();
			foreach($pendingPay AS $p)
			{
				$a['y']=floatval($p->tamount);		
				$b['ownURL'] = "byonedaylist/".$p->dates;		
				$jdata[] = array_merge($a, $b); 
				$jxdata[] = $p->dates;		
			}	
			$data2['jsonPending'] = $jdata;
			$data2['jxsonPending'] = $jxdata;
			//echo "<pre />"; print_r($jdata); exit;
			//echo json_encode($jdata); exit;
			//Get user role
			$myrole = $this->DailyModel->myrole($userid);	
			$udetails = $this->DailyModel->udetails($uname); 
			//echo "<pre />"; print_r($pChequeCharts); exit;
			
			$fdate = date("Y-m-01");	
			$ldate = date("Y-m-t", strtotime($fdate));
			for($i=$fdate;$i<=$ldate;$i++)
			{
					$cmonth[] = $i;
			}	
			$data2['cmonth'] = $cmonth;
			//echo "<pre />"; print_r($cmonth); exit;
			//$data2['pChequeCharts'] = $pChequeCharts;
			//$data2['aweek'] = $aweek;
			//Get Date of current month
			$mymonth = $this->DailyModel->amonthpending();	
			$data2['mymonth'] = $mymonth;
			//ِDisplay data for past 7 days
			$sdate =  date("Y-m-d", strtotime("-1 days")); 
			$edate =  date("Y-m-d", strtotime("-8 days")); 
			$data2['pp7days'] = $this->DailyModel->displayPending($sdate, $edate);
			//Start of showing sales percentage
			$cdate=date('Y-m-d');
			//$esi = $this->DailyModel->totalrecordsoftoday(3, $cdate); 
			$esi = $this->DailyModel->totalrecordsoftoday(11, $cdate); 
			$esw = $this->DailyModel->totalrecordsoftoday(4, $cdate); 
			$jq = $this->DailyModel->totalrecordsoftoday(5, $cdate); 
			$e66a = $this->DailyModel->totalrecordsoftoday(6, $cdate); 
			$me = $this->DailyModel->totalrecordsoftoday(10, $cdate); 
			if($esi)
			{
				$gesi='';
				$esic='';
				$esip='';
				if($esi->customers>0)
				{	
					$gesi = round($esi->purchased / $esi->customers * 100);
				}
				$esic=$esi->customers;
				$esip=$esi->purchased;
				$data2['gesi'] = $gesi; 
				$data2['esic'] = $esic; 
				$data2['esip'] = $esip;
			}		
			if($esw)
			{
				$gesw='';
				$eswc='';
				$eswp='';
				if($esw->customers>0)
				{	
					$gesw = round($esw->purchased / $esw->customers * 100);
				}
				$eswc=$esw->customers;
				$eswp=$esw->purchased;
				$data2['gesw'] = $gesw; 
				$data2['eswc'] = $eswc; 
				$data2['eswp'] = $eswp; 
			} 
			if($jq)
			{
				$gjq='';
				$jqc='';
				$jqp='';
				if($jq->customers>0)
				{	
					$gjq = round($jq->purchased / $jq->customers * 100);
				}
				$jqc=$jq->customers;
				$jqp=$jq->purchased;
				$data2['gjq'] = $gjq; 
				$data2['jqc'] = $jqc; 
				$data2['jqp'] = $jqp; 
			}
			if($e66a)
			{
				$ge66a='';
				$e66ac='';
				$e66ap='';
				if($e66a->customers>0)
				{	
					$ge66a = round($e66a->purchased / $e66a->customers * 100);
				}
				$e66ac=$e66a->customers;
				$e66ap=$e66a->purchased;
				$data2['ge66a'] = $ge66a; 
				$data2['e66ac'] = $e66ac; 
				$data2['e66ap'] = $e66ap; 
			}
			//me
			if($me)
			{
				$ge66am='';
				$e66acm='';
				$e66apm='';
				if($me->customers>0)
				{	
					$ge66am = round($me->purchased / $me->customers * 100);
				}
				$e66acm=$me->customers;
				$e66apm=$me->purchased;
				$data2['ge66am'] = $ge66am; 
				$data2['e66acm'] = $e66acm; 
				$data2['e66apm'] = $e66apm; 
			}
			
			//Expenses part Start
			$expenses = $this->ExpensesModel->expenses(); 
			$data2['expenses'] = $expenses;  
			$expenseTotal = $this->ExpensesModel->sumAmount();
			$data2['sum'] = $expenseTotal;
			$earray=array();
			//For pie chart
			$cexpenses = $this->ExpensesModel->cexpenses();
			if($cexpenses)
			{
					foreach($cexpenses AS &$row)
					{
						$row['name'] =  gname($row['groupe']);
						unset($row['groupe']);
						$row['y'] = (float) $row['amount'];
						unset($row['amount']);
					}	
			}	
			//echo "<pre />"; print_r($cexpenses); exit;
			$data2['cexpenses'] = $cexpenses;
			//Expenese by category
			$expenseBycategory = $this->ExpensesModel->expenseBycategory();
			if($expenseBycategory)
			{
					foreach($expenseBycategory AS &$row)
					{
						$row['name'] =  cname($row['category']);
						unset($row['category']);
						$row['y'] = (float) $row['amount'];
						unset($row['amount']);
					}	
			}	
			
			$data2['expenseBycategory'] = $expenseBycategory;
			//End of showing sales percentage	
			if($uname == $udetails->uname AND $password == $udetails->upassword AND  $myrole->role == 1)
			{
				$this->session->remove('name');
				$this->session->start();
				$data=array(
					'name' => $uname,
					'userid' => $userid,
					'myRole' => $myrole->role,
					'shop' => $udetails->shop
				);
				$this->session->set($data);
				return view('login/dashboard', $data2);
			}		
			else if($uname == $udetails->uname AND $password == $udetails->upassword AND  $myrole->role !=1)
			{  
				$this->session->remove('name');
				$this->session->start();
				$data=array(
					'name' => $uname,
					'userid' => $userid,
					'myRole' => $myrole->role,
					'shop' => $udetails->shop
				);
				$this->session->set($data);
				
				return view('login/userdashboard', $data);
				//return redirect()->to(base_url('codeigniter/public/dailyform'));
			}
			else
			{
				$this->session->remove('name');
				return redirect()->to(base_url('codeigniter/public/login'));		
			}
		}
		else
		{
			echo "Wrong username or Password!";	
		}
		
    }
}
