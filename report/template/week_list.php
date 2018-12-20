
<html>
<head>
	<title>周报列表页面</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<!-- <link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
	<link rel="stylesheet" type="text/css" href="template/default/content/css/style2014.css"> -->
	<link rel="stylesheet" type="text/css" href="template/default/content/css/bootstrap.min.css" media="screen">
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
		.warning{
			color:#f97500 !important;
		}
		.warning a{
			color:#f97500 !important;
		}


		.success{
			color:green !important;
		}
		.success a{
			color:green !important;
		}
		.danger{
			color:#fb0000 !important;
			background:#f2dedf !important;
		}
		.danger a{
			color:#fb0000 !important;

		}

	</style>
</head>
<body class="bodycolor">
<div class="table-responsive" style="padding:0 20px;">
	<table width="90%" border="0" align="center">
	  <tr>
	    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 周报列表页面</span>
	    </td>

	  </tr>

	</table>

	<br/>
	<div class="data-wrap" >
			<div class="data-operation">
					<div class="button-operation" style="margin-left:80%;">
						<button type="button" action="new_work" class="btn btn-info" onClick="javascript:window.location='admin.php?ac=weekly&fileurl=report&do=add';">添加周报</button>
					</div>

			</div>		
		</div>

<br/>
<br/>

	<table  class="table table-hover" name="coure">
		<thead>
			<tr>
				<th>序号</th>
				<th>周报名称</th>
				<th>创建时间</th>
				<th width="200px">周报状态(提交/未提交)</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
	
	<?php 

			if(count($data) > 0)
			{
				//有数据循环
				foreach($data as $key=>$value)
				{
					// $datasHtml = '<tr class="TableControl color-text"><td align="center">'.($key+1).'</td>
					// 			<td>第'.$value['weekly_number'].'周总结汇报表与第'.($value['weekly_number_plan']).'周计划汇报表</td>
					// 			<td>'.$value['create_time_early'].'</td>';
					//判断是否完成
					if($value['verify_status'] =='4')
					{
						$datasHtml = '<tr class="success"><td align="center">'.($key+1).'</td>
								<td>第'.$value['weekly_number'].'周总结汇报表与第'.($value['weekly_number_plan']).'周计划汇报表</td>
								<td>'.$value['create_time_early'].'</td>';
					}
					else if($value['verify_status'] =='5')
					{
						$datasHtml = '<tr class="danger"><td align="center">'.($key+1).'</td>
								<td>第'.$value['weekly_number'].'周总结汇报表与第'.($value['weekly_number_plan']).'周计划汇报表</td>
								<td>'.$value['create_time_early'].'</td>';
					}
					else if($value['is_submit'] =='1')
					{
						$datasHtml = '<tr class="warning"><td align="center">'.($key+1).'</td>
								<td>第'.$value['weekly_number'].'周总结汇报表与第'.($value['weekly_number_plan']).'周计划汇报表</td>
								<td>'.$value['create_time_early'].'</td>';
					}
					else 
					{
						$datasHtml = '<tr class="active"><td align="center">'.($key+1).'</td>
								<td>第'.$value['weekly_number'].'周总结汇报表与第'.($value['weekly_number_plan']).'周计划汇报表</td>
								<td>'.$value['create_time_early'].'</td>';
					}

					if($value['verify_status'] =='4')
					{
						$datasHtml .= '<td width="100px">审核完成</td>';
					}
					else if($value['verify_status'] =='5')
					{
						$datasHtml .= '<td width="100px">审核未通过</td>';
					}
					else
					{
						if($value['is_submit'] =='1')
						{

							$datasHtml .= '<td width="100px">已提交(审核中)</td>';
						}
						else
						{

							$datasHtml .= '<td width="100px">未提交</td>';
						}

					}
					


					//判断是否有编辑状态按钮
					if( $value['is_submit'] !='1' && $value['verify_status'] <= 3 )
					{
						$datasHtml .='<td><a href="/admin.php?ac=weekly&fileurl=report&do=view&orderid='.$value['id'].'">编辑</a>  |  <a  class="dele"  href="/admin.php?ac=weekly&fileurl=report&do=del&orderid='.$value['id'].'-'.$value['weekly_number'].'">删除</a>';  

					}
					else  if($value['is_submit'] =='1' && $value['verify_status'] == 5)
					{
						$datasHtml .='<td><a href="/admin.php?ac=weekly&fileurl=report&do=view&orderid='.$value['id'].'">修改</a> |  <a   class="dele"  href="/admin.php?ac=weekly&fileurl=report&do=del&orderid='.$value['id'].'-'.$value['weekly_number'].'">删除</a>';
					}
					else
					{
						$datasHtml .='<td><a href="/admin.php?ac=weekly&fileurl=report&do=view&orderid='.$value['id'].'&cl=sw">查看</a> |  <a   href="/admin.php?ac=weekly&fileurl=report&do=del&orderid='.$value['id'].'-'.$value['weekly_number'].'"   class="dele" >删除</a></td></tr>';
					}
					
					echo $datasHtml;
				}

			}
			else
			{
				echo '<tr class="TableControl">
						<td colspan="6">暂时没有信息</td>
					</tr>';
			}





	?>
		
		</tbody>
	</table>
	

	<div class="data-wrap">
		<div class="data-operation">
				
			<div class="pager_operation">
				<?php echo newshowpage($num,$pagesize,$page,$url);?>
			</div>
		</div>		
	</div>

</div>





</body>
</html>
<script language="javascript" type="text/javascript" src="template/default/js/jquery-1.10.2.min.js"></script>
<script>
	
	//删除确定  
	$(".dele").click(function(){
		if(confirm('确定删除？'))
		{
			return true;
		}
		return false;
	});
</script>