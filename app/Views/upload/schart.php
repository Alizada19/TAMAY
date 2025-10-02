<div style="margin-top: 10%;">
	<form id="form1" method="post" enctype="multipart/form-data" action="#">
	
		<div>
			<input type="date" name="sdate" id="sdate"  value="<?=$sdate?>" style="width:20%; height:30px;	text-align:center;">
		</div>
		<div>
			<input type="date" name="edate" id="edate"  value="<?=$edate?>" style="width:20%; height:30px;	text-align:center;margin-top:5px;margin-bottom:5px;">
		</div>
		
	</form>	
			<input type="submit" value="Search by date" name="btn_result" onclick="submitForm('<?=base_url('codeigniter/public/searchExcel')?>')" style="width:110px;" class="btn btn-primary line"></button>
			
			<input type="submit" value="Ungroup" name="btn_result" onclick="submitForm('<?=base_url('codeigniter/public/ungroup')?>')" style="width:100px;" class="btn btn-primary line"></button>
			
			<!--<input type="submit" value="Chart" name="btn_result" onclick="submitForm('<?//=base_url('codeigniter/public/schart')?>')" style="width:100px;" class="btn btn-primary line"></button>-->
			<input type="submit" value="Group by Category" name="btn_result" onclick="submitForm('<?=base_url('codeigniter/public/gcategory')?>')" style="width:160px;" class="btn btn-primary line"></button>
			
			<input type="submit" value="Chart" name="btn_result" onclick="submitForm('<?=base_url('codeigniter/public/schart')?>')" style="width:100px;" class="btn btn-primary line"></button>
			
			<a title="Upload excel file" target="_blank" href="<?=base_url('codeigniter/public/excel')?>"><input type="button" name="btn_result" style="width:150px;" class="btn btn-primary line" value="Upload Excel File"  /></a>
	<div id="mainDive">
		<div style="width:98%; margin-right:1%; margin-left:1%;">	
			<div style="text-align:center; font-weight:bold;font-size: 18px;">
				
			</div>
			<div class="" style="width:100%;">
				<div id="showStocks">
					
				</div>	
			</div>	
		</div>
	</div>
</div>
<script>
function submitForm(actionUrl) {
    let form = document.getElementById("form1");
	form.action = actionUrl;

	let openInNewTab = actionUrl.includes('Printpdf') || actionUrl.includes('schart');

	if (openInNewTab) {
		form.target = "_blank";
	} else {
		form.removeAttribute("target"); // or form.target = "";
	}

	form.submit();
}
	
//Show expenses chart
 var stockChart = Highcharts.chart('showStocks', {
    chart: {
        type: 'pie'
    },
    title: {
        text: 'Stock Transfered'
    },
    tooltip: {
        valueSuffix: ' RM'
    },
   
    plotOptions: {
        series: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: [{
                enabled: true,
                distance: 20
            }, {
                enabled: true,
                distance: -40,
                format: '{point.percentage:.1f}%',
                style: {
                    fontSize: '1.5em',
                    textOutline: 'none',
                    opacity: 0.7
                },
                filter: {
                    operator: '>',
                    property: 'percentage',
                    value: 5
                }
            }]
        }
    },
    series: [
        {
            name: 'Amount',
            colorByPoint: true,
            data: <?=json_encode($record);?>//[{name:"PPPP",y:32000},{name:"G1",y:6000}]	
        }
    ]
});
</script>