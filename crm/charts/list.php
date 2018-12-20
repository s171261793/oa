<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
<script language="javascript" type="text/javascript" src="template/default/js/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="DatePicker/WdatePicker.js"></script>
<script type="text/javascript"> 
function searchtpl(typeid){
   var obj = document.getElementById("typeid");
   jQuery.ajax({
      type: 'GET',
      url: 'admin.php?ac=list&fileurl=<?php echo $fileurl?>&do=ajax&typeid='+obj.value+'&date='+new Date(),
      success: function(data){
		  if(data!=''){
			  $("#tplid").html(data);
			  //alert(data);
		  }else{
			  $("#tplid").html('');
		  }
      }
   });
}
</script>
<title>Office 515158 2011 OA办公系统</title>
</head>
<body class="bodycolor">
<div id="navPanel">
<div id="navMenu" style="padding-left:30px;">
<?php for($i=0;$i<sizeof($r);$i++){?>
<a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&modid=<?php echo $r[$i];?>" <?php if($r[$i]==$_GET['modid']){?>class="active"<?php }?>><span><img src="template/default/content/images/p4.gif" width="16" height="16" align="absmiddle"><?php echo form_mod($r[$i]);?></span></a>
<?php }?>
</div>
<div id="search" style="float: right; padding-right:90px;">

</div>
</div>

<div style="position:absolute; height:90%; width:100%;overflow:auto"> 
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="0" class="small" style="margin-top:6px;">
<form method="get" action="admin.php?modid=<?php echo $_GET['modid']?>" name="topSearchForm" class="ui-grid-21 ui-grid-right ui-form" style=" margin-top:0px;">
  <tr>
    <td class="Big" style="font-size:12px;"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"><?php echo form_mod($_GET['modid']);?>综合统计</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	
	<input type="hidden" name="ac" value="<?php echo $ac?>" />
	<input type="hidden" name="do" value="list" />
	<input type="hidden" name="fileurl" value="<?php echo $fileurl?>" />
	<input type="hidden" name="flashtype" value="<?php echo $flashtype?>" />
	<input type="hidden" name="type" value="<?php echo $type?>" />
	日期：<input type="text" value="<?php echo $datesart?>"  style="width:80px;" readonly="readonly"  onClick="WdatePicker();" name='datesart' > - <input type="text" value="<?php echo $dateend?>"  style="width:80px;" readonly="readonly"  onClick="WdatePicker();" name='dateend' />
	&nbsp;&nbsp;<input
	type="submit" value="查 询" class="SmallButton" />
&nbsp;&nbsp;

 
	<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&flashtype=<?php echo $flashtype?>&modid=<?php echo $_GET['modid']?>&type=year" style="font-size:12px;<?php if($type=='year'){?>color:#006600;<?php }?>">按年统计</a>&nbsp;|&nbsp;
	<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&flashtype=<?php echo $flashtype?>&modid=<?php echo $_GET['modid']?>&type=month" style="font-size:12px;<?php if($type=='month'){?>color:#006600;<?php }?>">按月统计</a>&nbsp;|&nbsp;
	<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&flashtype=<?php echo $flashtype?>&modid=<?php echo $_GET['modid']?>&type=day" style="font-size:12px;<?php if($type=='day'){?>color:#006600;<?php }?>">今日统计</a>&nbsp;|&nbsp;
	<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&flashtype=<?php echo $flashtype?>&modid=<?php echo $_GET['modid']?>&type=user&dateend=<?php echo $dateend?>&datesart=<?php echo $datesart?>" style="font-size:12px;<?php if($type=='user'){?>color:#006600;<?php }?>">成员统计</a>
<span style="font-size:12px; padding-top:5px;float:right; margin-right:50px;">
<?php if(($_GET['modid']=='crm_offer' || $_GET['modid']=='crm_contract' || $_GET['modid']=='crm_order' || $_GET['modid']=='crm_price' || $_GET['modid']=='crm_payment') && $type!='user'){?>
<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&flashtype=MSColumn3D&modid=<?php echo $_GET['modid']?>&type=<?php echo $type?>&dateend=<?php echo $dateend?>&datesart=<?php echo $datesart?>" style="font-size:12px;<?php if($flashtype=='MSColumn3D'){?>color:#FF3300;<?php }?>">柱形图展示</a>&nbsp;|&nbsp;
	<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&flashtype=MSLine&modid=<?php echo $_GET['modid']?>&type=<?php echo $type?>&dateend=<?php echo $dateend?>&datesart=<?php echo $datesart?>" style="font-size:12px;<?php if($flashtype=='MSLine'){?>color:#FF3300;<?php }?>">折线图展示</a>
<?php }else{?>
	<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&flashtype=Column3D&modid=<?php echo $_GET['modid']?>&type=<?php echo $type?>&dateend=<?php echo $dateend?>&datesart=<?php echo $datesart?>" style="font-size:12px;<?php if($flashtype=='Column3D'){?>color:#FF3300;<?php }?>">柱形图</a>&nbsp;|&nbsp;
	<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&flashtype=Line&modid=<?php echo $_GET['modid']?>&type=<?php echo $type?>&dateend=<?php echo $dateend?>&datesart=<?php echo $datesart?>" style="font-size:12px;<?php if($flashtype=='Line'){?>color:#FF3300;<?php }?>">折线图</a>&nbsp;|&nbsp;
	<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&flashtype=Pie3D&modid=<?php echo $_GET['modid']?>&type=<?php echo $type?>&dateend=<?php echo $dateend?>&datesart=<?php echo $datesart?>" style="font-size:12px;<?php if($flashtype=='Pie3D'){?>color:#FF3300;<?php }?>">饼图</a>&nbsp;|&nbsp;
	<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&flashtype=Area2D&modid=<?php echo $_GET['modid']?>&type=<?php echo $type?>&dateend=<?php echo $dateend?>&datesart=<?php echo $datesart?>" style="font-size:12px;<?php if($flashtype=='Area2D'){?>color:#FF3300;<?php }?>">面积图</a>&nbsp;|&nbsp;
	<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&flashtype=Bar2D&modid=<?php echo $_GET['modid']?>&type=<?php echo $type?>&dateend=<?php echo $dateend?>&datesart=<?php echo $datesart?>" style="font-size:12px;<?php if($flashtype=='Bar2D'){?>color:#FF3300;<?php }?>">条形图</a>&nbsp;|&nbsp;
	<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&flashtype=Doughnut2D&modid=<?php echo $_GET['modid']?>&type=<?php echo $type?>&dateend=<?php echo $dateend?>&datesart=<?php echo $datesart?>" style="font-size:12px;<?php if($flashtype=='Doughnut2D'){?>color:#FF3300;<?php }?>">环形图</a>
	<?php }?>
	</span>
    </td>
  </tr>
  </form>
</table>

<table width="98%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td align="center" class="Big" style="font-size:12px;">
	<?php echo renderChartHTML("template/fusioncharts/".$flashtype.".swf", "", $strtype, "",$fw, $fh, false)?>    </td>
  </tr>
</table>
</div>
</body>
</html>
