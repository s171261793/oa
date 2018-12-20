
<html>
<head>
	<title>生日列表页面</title>
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
		.color-text{
			color:red;
		}
		.greenText{
			color:green;
		}
		.showTag tr:hover{
					background-color:yellow;
		}

	</style>
</head>
<body class="bodycolor">
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 生日列表页面</span>
    </td>
  
  </tr>
</table>
<div class="data-wrap">
		<div class="data-operation" style="margin-left: 128px;">
			<div class="button-operation">
				<button type="button" action="new_work" class="btn btn-success" onClick="javascript:window.location='admin.php?ac=weekly_birthday&fileurl=report';">今天过生日的小伙伴</button>

				<button type="button" onClick="javascript:window.location='admin.php?ac=weekly_birthday&fileurl=report&c=advance';" action="cancel_concern" class="btn btn-info">本月过生日的小伙伴</button>

				<!-- <button type="button" onClick="updateform(1);" action="cancel_concern" class="btn btn-danger">清理数据</button>	 -->	
			</div>

		</div>		
	</div> 


<br/>

	<table class="TableBlock" border="0" width="80%" align="center">
		<tr class="TableControl">
			<th>序号</th>
			<th>姓名</th>
			<th>生日时间</th>
			<th>部门</th>
		</tr>
	
	<?php 

			if(count($data_second) > 0)
			{

				foreach($data_second as $key=>$value)
				{
					$datasHtml = '<tr class="TableControl">
								<td align="center">'.($key+1).'</td>
								<td align="center">'.$value['name'].'</td>
								<td align="center"><font color="red">'.$value['birthday'].'<font></td>
								<td align="center">'.get_realdepaname($value['departmentid']).'</td><tr>';

					echo $datasHtml;
				}

			}
			else
			{
				echo '<tr class="TableControl">
						<td colspan="4">暂时没有信息</td>
					</tr>';
			}





	?>
		
		
	</table>

	

	<!-- <div class="data-wrap">
		<div class="data-operation">
				<div class="button-operation">
					<button type="button" action="new_work" class="btn btn-success" onClick="javascript:window.location='admin.php?ac=add&fileurl=communication&type=<?php echo $_GET[type]?>'">新增通迅录</button>
			<button type="button" onClick="updateform(2);" action="cancel_concern" class="btn btn-info">发送短信</button>
			<button type="button" onClick="updateform(1);" action="cancel_concern" class="btn btn-danger">清理数据</button>		
					</div>

			<div class="pager_operation">
				<?php echo newshowpage($num,$pagesize,$page,$url);?>
				
				
			</div>
		</div>		
	</div>
 -->




</body>
</html>