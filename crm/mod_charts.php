<?php
(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
get_key("crm_charts");
require(TOA_ROOT.'include/function_charts.php');
$modlist='crm_company,crm_service,crm_care,crm_complaints,crm_product,crm_stock,crm_business,crm_supplier,crm_purchase,crm_offer,crm_program,crm_contract,crm_order,crm_price,crm_payment';
$r=explode(',',$modlist);
if($_GET["modid"]=='') $_GET["modid"]='crm_company';
empty($do) && $do = 'list';
if($_GET['type']!=''){
	$type=$_GET['type'];
}else{
	$type='day';
}
$datesart=$_REQUEST['datesart'];
$dateend=$_REQUEST['dateend'];
if($_GET['flashtype']!=''){
	$flashtype=$_GET['flashtype'];
}else{
	$flashtype='Column3D';
}
//Column3D,Line,Pie3D,Area2D,Bar2D,Doughnut2D
$fw='100%';
$fh='350';
if ($do == 'list') {
	$wheresql = '';
	if ($datesart!='' && $dateend!='') {
		$wheresql .= " AND (date>='".$datesart."' and date<='".$dateend."')";
	}
	if($type=='year'){
		//处理特定模型
		if($_GET['modid']=='crm_offer' || $_GET['modid']=='crm_contract' || $_GET['modid']=='crm_order' || $_GET['modid']=='crm_price' || $_GET['modid']=='crm_payment'){
			if($flashtype=='Column3D'){
				$flashtype='MSColumn3D';
			}else{
				$flashtype=$_GET['flashtype'];
			}
			//XML开始
			$strtype = "<chart caption='按年度[".get_date('Y',PHP_TIME)."]' numberPrefix='' formatNumberScale='1' rotateValues='1' placeValuesInside='1' decimals='2'>";
			//统计头
			$strtype .= "<categories>";
			$m=0;
			for($i=0;$i<12;$i++){
			$m++;
				$strtype .= "<category name='".$m."月' />";
			}
			$strtype .= "</categories>";
			//数据
			$charts['name']=explode(',','记录总数,金额合计');
			for($i=0;$i<2;$i++){
				if($charts['name'][$i]!=''){
					$strtype .= "<dataset seriesName='".$charts['name'][$i]."'>";
					$m=0;
					for($s=0;$s<12;$s++){
						$m++;
						if($charts['name'][$i]=='记录总数'){
							$numtype = $db->result("SELECT COUNT(*) AS numtype FROM ".DB_TABLEPRE.$_GET['modid']." WHERE year(date)= ".get_date('Y',PHP_TIME)." and month(date)=".$m."");
						}else{
							$numtype = $db->result("SELECT sum(price) AS numtype FROM ".DB_TABLEPRE.$_GET['modid']." WHERE year(date)= ".get_date('Y',PHP_TIME)." and month(date)=".$m."");
						}
						if($numtype==''){
						$numtype=0;
						}
						$strtype .= "<set value='".sprintf("%01.2f",$numtype)."' />";
					}
					$strtype .= "</dataset>";
				}
			}
			$strtype .= "</chart>";
		}else{
			//年度统计
			$strtype  = "<chart caption='' xAxisName='按年度[".get_date('Y',PHP_TIME)."]' yAxisName='".form_mod($_GET['modid'])."综合统计' showValues='0' formatNumberScale='0' showBorder='1'>";
			$m=0;
			for($i=0;$i<12;$i++){
			$m++;
				$numtype = $db->result("SELECT COUNT(*) AS numtype FROM ".DB_TABLEPRE.$_GET['modid']." WHERE year(date)= ".get_date('Y',PHP_TIME)." and month(date)=".$m."");
				$strtype .= "<set label='".$m."月' value='".$numtype."' />";
			}
			$strtype .= "</chart>";
		}
	}elseif($type=='month'){
		//处理特定模型
		if($_GET['modid']=='crm_offer' || $_GET['modid']=='crm_contract' || $_GET['modid']=='crm_order' || $_GET['modid']=='crm_price' || $_GET['modid']=='crm_payment'){
			if($flashtype=='Column3D'){
				$flashtype='MSColumn3D';
			}else{
				$flashtype=$_GET['flashtype'];
			}
			//XML开始
			$strtype = "<chart caption='本月统计[".get_date('m',PHP_TIME)."月]' numberPrefix='' formatNumberScale='1' rotateValues='1' placeValuesInside='1' decimals='2'>";
			//统计头
			$strtype .= "<categories>";
			$m=0;
			$t=date(t,strtotime(get_date('Y/m',PHP_TIME).'/1'));
			for($i=0;$i<$t;$i++){
			$m++;
				$strtype .= "<category name='".$m."' />";
			}
			$strtype .= "</categories>";
			//数据
			$charts['name']=explode(',','记录总数,金额合计');
			for($i=0;$i<2;$i++){
				if($charts['name'][$i]!=''){
					$strtype .= "<dataset seriesName='".$charts['name'][$i]."'>";
					$m=0;
					for($s=0;$s<$t;$s++){
						$m++;
						if($charts['name'][$i]=='记录总数'){
							$numtype = $db->result("SELECT COUNT(*) AS numtype FROM ".DB_TABLEPRE.$_GET['modid']." WHERE year(date)= ".get_date('Y',PHP_TIME)." and month(date)=".get_date('m',PHP_TIME)." and day(date)= ".$m."");
						}else{
							$numtype = $db->result("SELECT sum(price) AS numtype FROM ".DB_TABLEPRE.$_GET['modid']." WHERE year(date)= ".get_date('Y',PHP_TIME)." and month(date)=".get_date('m',PHP_TIME)." and day(date)= ".$m."");
						}
						if($numtype==''){
						$numtype=0;
						}
						$strtype .= "<set value='".sprintf("%01.2f",$numtype)."' />";
					}
					$strtype .= "</dataset>";
				}
			}
			$strtype .= "</chart>";
		}else{
			//本月统计
			$strtype  = "<chart caption='' xAxisName='本月统计[".get_date('m',PHP_TIME)."月]' yAxisName='".form_mod($_GET['modid'])."综合统计' showValues='0' formatNumberScale='0' showBorder='1'>";
			$m=0;
			$t=date(t,strtotime(get_date('Y/m',PHP_TIME).'/1'));
			for($i=0;$i<$t;$i++){
			$m++;
				$numtype = $db->result("SELECT COUNT(*) AS numtype FROM ".DB_TABLEPRE.$_GET['modid']." WHERE year(date)= ".get_date('Y',PHP_TIME)." and month(date)=".get_date('m',PHP_TIME)." and day(date)= ".$m."");
				$strtype .= "<set label='".$m."' value='".$numtype."' />";
			}
			$strtype .= "</chart>";
		}
	}elseif($type=='day'){
		//处理特定模型
		if($_GET['modid']=='crm_offer' || $_GET['modid']=='crm_contract' || $_GET['modid']=='crm_order' || $_GET['modid']=='crm_price' || $_GET['modid']=='crm_payment'){
			if($flashtype=='Column3D'){
				$flashtype='MSColumn3D';
			}else{
				$flashtype=$_GET['flashtype'];
			}
			//XML开始
			$strtype = "<chart caption='今天[".get_date('d',PHP_TIME)."号]统计' numberPrefix='' formatNumberScale='1' rotateValues='1' placeValuesInside='1' decimals='2'>";
			//统计头
			$strtype .= "<categories>";
			for($i=0;$i<24;$i++){
				$strtype .= "<category name='".$i."' />";
			}
			$strtype .= "</categories>";
			//数据
			$charts['name']=explode(',','记录总数,金额合计');
			for($i=0;$i<2;$i++){
				if($charts['name'][$i]!=''){
					$strtype .= "<dataset seriesName='".$charts['name'][$i]."'>";
					$m=0;
					for($s=0;$s<24;$s++){
						$m++;
						if($charts['name'][$i]=='记录总数'){
							$numtype = $db->result("SELECT COUNT(*) AS numtype FROM ".DB_TABLEPRE.$_GET['modid']." WHERE year(date)= ".get_date('Y',PHP_TIME)." and month(date)=".get_date('m',PHP_TIME)." and day(date)= ".get_date('d',PHP_TIME)." and Hour(date)= ".$s."");
						}else{
							$numtype = $db->result("SELECT sum(price) AS numtype FROM ".DB_TABLEPRE.$_GET['modid']." WHERE year(date)= ".get_date('Y',PHP_TIME)." and month(date)=".get_date('m',PHP_TIME)." and day(date)= ".get_date('d',PHP_TIME)." and Hour(date)= ".$s."");
						}
						if($numtype==''){
						$numtype=0;
						}
						$strtype .= "<set value='".sprintf("%01.2f",$numtype)."' />";
					}
					$strtype .= "</dataset>";
				}
			}
			$strtype .= "</chart>";
		}else{
			//今日数据
			$strtype  = "<chart caption='' xAxisName='今天[".get_date('d',PHP_TIME)."号]统计' yAxisName='".form_mod($_GET['modid'])."综合统计' showValues='0' formatNumberScale='0' showBorder='1'>";
			$m=0;
			for($i=0;$i<24;$i++){
			$m++;
				$numtype = $db->result("SELECT COUNT(*) AS numtype FROM ".DB_TABLEPRE.$_GET['modid']." WHERE year(date)= ".get_date('Y',PHP_TIME)." and month(date)=".get_date('m',PHP_TIME)." and day(date)= ".get_date('d',PHP_TIME)." and Hour(date)= ".$i."");
				$strtype .= "<set label='".$i."' value='".$numtype."' />";
			}
			$strtype .= "</chart>";
		}
	}elseif($type=='user'){
	    //成员统计
		if($flashtype=='MSColumn3D'){
			$flashtype='Column3D';
		}
		if($flashtype=='MSLine'){
			$flashtype='Line';
		}
		if($flashtype=='Bar2D'){
			$fw='100%';
			$fh='1250';
		}
		$strtype  = "<chart caption='' xAxisName='成员统计' yAxisName='".form_mod($_GET['modid'])."综合统计' showValues='0' formatNumberScale='0' showBorder='1'>";
		global $db;
		$sql = $db->query("SELECT a.id,b.name FROM ".DB_TABLEPRE."user a,".DB_TABLEPRE."user_view b where a.id=b.uid ORDER BY a.numbers Asc");
		while ($row = $db->fetch_array($sql)) {
			$numuser = $db->result("SELECT COUNT(*) AS numuser FROM ".DB_TABLEPRE.$_GET['modid']." WHERE uid='".$row['id']."' ".$wheresql."");
			$strtype .= "<set label='".$row['name']."' value='".$numuser."' />";
		}
		$strtype .= "</chart>";
	}else{
	}
	include_once('charts/list.php');

}

function form_mod($mod=''){
	switch ($mod)
	{
		case 'crm_company':
		  return "客户";
		  break;
		case 'crm_contact':
		  return "联系人";
		  break;
		case 'crm_service':
		  return "客户回访";
		  break;
		case 'crm_care':
		  return "客户关怀";
		  break;
		case 'crm_complaints':
		  return "客户投诉";
		  break;
		case 'crm_product':
		  return "产品";
		  break;
		case 'crm_stock':
		  return "库存";
		  break;
		case 'crm_business':
		  return "代理商";
		  break;
		case 'crm_supplier':
		  return "供应商";
		  break;
		case 'crm_purchase':
		  return "采购单";
		  break;
		case 'crm_offer':
		  return "报价单";
		  break;
		case 'crm_program':
		  return "解决方案";
		  break;
		case 'crm_contract':
		  return "合同";
		  break;
		case 'crm_order':
		  return "订单";
		  break;
		case 'crm_price':
		  return "收款单";
		  break;
		case 'crm_payment':
		  return "付款单";
		  break;
		default:
		  return "错误类型";
	}
	return ;
}
?>