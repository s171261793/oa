
<html>
<head>
	<title>部门列表</title>
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
		/*.color-text{
			color:red;
		}*/
	</style>
</head>
<body class="bodycolor">
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 部门页面</span>
    </td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
  	<td></td>
  	<td></td>
  	<td></td>
  	<td></td>
  	<td></td>
  	<td></td>
  
  	<!-- <td><a class="addData" href=""><font color="white">添加周报</font></a></td> -->
  </tr>
</table>

<br/>
<div class="data-wrap">
		<div class="data-operation">
				<div class="button-operation">
					<button type="button" action="new_work" class="btn btn-success" onClick="javascript:window.location='admin.php?ac=weeklyDpart&fileurl=report&do=add';">添加部门</button>
			<!-- <button type="button" onClick="updateform(2);" action="cancel_concern" class="btn btn-info">发送短信</button>
			<button type="button" onClick="updateform(1);" action="cancel_concern" class="btn btn-danger">清理数据</button>	 -->	
					</div>

		</div>		
	</div>

<br/>
<br/>
<br/>
	<table class="TableBlock" border="0" width="95%" align="center">
		<tr class="TableControl">
			<th>序号</th>
			<th>部门名称</th>
			<th>人员名称</th>
			<th>创建时间</th>
			<th>操作</th>
		</tr>
	
	<?php 

			if(count($data) > 0)
			{
				$datasHtml = ''; 
				//有数据循环
				foreach($data as $key=>$value)
				{
					$datasHtml .= '<tr class="TableControl color-text"><td align="center">'.($key+1).'</td>
								<td>'.get_realdepaname($value['department_id']).'</td>';
					
					$datasHtml .= '<td align="center">'.get_realname($value['uid']).'</td>
								<td>'.$value['create_time'].'</td>';
					
					$datasHtml .='<td><a href="/admin.php?ac=weeklyDpart&fileurl=report&do=del&id='.$value['id'].'">删除</a></td></tr>';  

				}
				echo $datasHtml;

			}
			else
			{
				echo '<tr class="TableControl">
						<td colspan="6">暂时没有部门和人员的关联信息！</td>
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

			<div class="pager_operation">
				<?php echo newshowpage($num,$pagesize,$page,$url);?>
				
				
			</div>
		</div>		
	</div>





</body>
</html>