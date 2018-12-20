
<html>
<head>
	<title>审核流程菜单页面</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<!-- <link rel="stylesheet" type="text/css" href="template/default/content/css/style.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="template/default/content/css/style2014.css"> -->
	<link rel="stylesheet" type="text/css" href="template/default/content/css/bootstrap.min.css" media="screen">
	<script language="javascript" type="text/javascript" src="DatePicker/WdatePicker.js"></script>
	<script language="javascript" type="text/javascript" src="template/default/js/jquery-1.10.2.min.js"></script>
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
		a{
			color:#f97500 !important;
		}
	</style>
</head>
<body class="bodycolor">
<div class="table-responsive" style="padding:0 20px;">
<table class="table table-hover">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 审核流程菜单页面</span>
    </td>
    
  </tr>
</table>

	<div class="data-wrap">
			<div class="data-operation">
					<div class="button-operation" style="margin-left:80%;">
						<button type="button" action="new_work" class="btn btn-info" onClick="javascript:window.location='admin.php?ac=weeklyAccess&fileurl=report&do=view';">添加审核流程</button>
					</div>
			</div>		
	</div>



<script Language="JavaScript"> 
	function CheckForm()
	{
	   if(document.save.name.value=="")
	   { alert("姓名不能为空！");
	     document.save.name.focus();
	     return (false);
	   }
	   if(document.save.phone.value=="")
	   { alert("手机不能为空！");
	     document.save.phone.focus();
	     return (false);
	   }
	   if(document.save.birthdate.value=="")
	   { alert("出生日期不能为空！");
	     document.save.birthdate.focus();
	     return (false);
	   }
	   return true;
	}
	function sendForm()
	{
	   if(CheckForm())
	      document.save.submit();
	}

	$(".alert").click(function(){

		if(confirm('确定要删除？'))
		{

			return true;
		}
		else
		{
			return false;
		}
	})

	function alerts(id)
	{
		if(confirm('确定删除？'))
		{
			window.location = '/admin.php?ac=weeklyAccess&fileurl=report&do=del&orderid='+id;
		}
		else
		{
			return false;
		}
	}
 
</script>
	<br/>
	<table class="table table-hover">
		<thead>
			<tr class="TableControl">
				<th width="60px">序号</th>
				<th>部门</th>
				<th>员工</th>
				<th width="200px">一级审核人</th>
				<th width="200px">二级审核人</th>
				<th width="200px">创建时间</th>
				<th>操作</th>
			</tr>
		</thead>
		</tbody>
	
	<?php 

			if(count($data) > 0)
			{
				//有数据循环
				foreach($data as $key=>$value)
				{
					$datasHtml = '<tr class="TableControl">
									<td>'.($key+1).'</td>
									<td>'.get_realdepaname($value['deparment_id']).'</td>
									<td>'.get_realusername($value['user_id'],'name').'</td>
									<td>'.get_realusername($value['one_person'],'name').'</td>
									<td>'.get_realusername($value['two_person'],'name').'</td>
									<td>'.$value['create_time'].'</td>';

						// $datasHtml .='<td><a href="/admin.php?ac=weeklyAccess&fileurl=report&do=save&orderid='.$value['id'].'">编辑</a>  |  <a onClick="alerts('.$value['id'].')" href="#">删除</a></td></tr>'; 
						$datasHtml .='<td><a onClick="alerts('.$value['id'].')" href="#">删除</a></td></tr>';   
				
					
					echo $datasHtml;
				}

			}
			else
			{
				echo '<tr class="TableControl">
						<td colspan="8">暂时没有信息</td>
					</tr>';
			}





	?>
		
	</tbody>
	</table>

	
	<!-- 分页 -->
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

