
<html>
<head>
	<title>周报审核页面</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
	<link rel="stylesheet" type="text/css" href="template/default/content/css/style2014.css">
	<script language="javascript" type="text/javascript" src="DatePicker/WdatePicker.js"></script>
	<style type="text/css">
		.addData{
			display: inline-block;
			width:80px;
			height:34px;
			background:#98BBD6;
			border-radius: 12px;
			text-align: center;
			line-height: 34px;
		}
		.a-TableControl-success{
			display:inline-block;
			width:60px;
			height:30px;
			background: #39C50E;
			text-align: center;
			line-height:30px;
			border-radius: 15px;
		}

		.a-TableControl-new{
			display:inline-block;
			width:60px;
			height:30px;
			background: #5BC0DE;
			text-align: center;
			line-height:30px;
			border-radius: 15px;
		}
	</style>
</head>
<body class="bodycolor">
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 周报审核页面</span>
    </td>
  </tr>
</table>
	
<br/>
<br/>
<br/>
	<table class="TableBlock" border="0" width="90%" align="center">
		<tr class="TableControl">
			<th>序 号</th>
			<th>姓 名</th>
			<th>部 门</th>
			<th>周报名称</th>
			<th>提交时间</th>
			<th>状 态</th>
			<th>操 作</th>
		</tr>
	
	<?php 

			if(count($data) > 0)
			{
				//有数据循环
				foreach($data as $key=>$value)
				{
					$datasHtml = '<tr class="TableControl">
								<td align="center">'.($key+1).'</td>
								<td align="center">'.get_realname($value['user_id']).'</td>
								<td align="center">'.get_realdepaname($value['department_id']).'</td>
								<td align="center">第'.$value['weekly_number'].'周总结汇报表与第'.($value['weekly_number']+1).'周计划汇报表</td>
								<td align="center">'.$value['create_time_sub'].'</td>';


						if($value['is_access'] == 'show')
						{
								$datasHtml .='<td align="center"> 已审核</td><td align="center"><a href="/admin.php?ac=weeklyVerify&fileurl=report&do=view&access=yes&weeknum='.$value['weekly_number'].'&cl=sw&id='.$value['id'].'" class="a-TableControl-success"><font color="white">查看</font></a> </td>';	
						}
						else
						{
								$datasHtml .='<td align="center"> 未审核</td><td align="center"><a href="/admin.php?ac=weeklyVerify&fileurl=report&do=view&weeknum='.$value['weekly_number'].'&cl=sw&id='.$value['id'].'"  class="a-TableControl-new"><font color="white">审核</font></a> </td></tr>';		
						}
					
					echo $datasHtml;
				}

			}
			else
			{
				echo '<tr class="TableControl">
						<td colspan="7">暂时没有信息</td>
					</tr>';
			}





	?>
		
		
	</table>

	

	<div class="data-wrap">
		<div class="data-operation">
				<!-- <div class="button-operation">
					<button type="button" action="new_work" class="btn btn-success" onClick="javascript:window.location='admin.php?ac=add&fileurl=communication&type=<?php echo $_GET[type]?>'">新增通迅录</button>
			<button type="button" onClick="updateform(2);" action="cancel_concern" class="btn btn-info">发送短信</button>
			<button type="button" onClick="updateform(1);" action="cancel_concern" class="btn btn-danger">清理数据</button>		
					</div> -->

			<div class="pager_operation" style="padding-right:600px;margin-top:50px;">
				<?php echo newshowpage($num,$pagesize,$page,$url);?>
			</div>
		</div>		
	</div>





</body>
</html>