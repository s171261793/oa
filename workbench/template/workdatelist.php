<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<link href="template/default/new/css/calendar.css" rel="stylesheet"/>
	<link href="template/default/new/css/birthday.css" rel="stylesheet"/>
	<script type="text/javascript" src="template/default/new/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript">
	$(function(){
		$(".list dt").hover(function(){
			$(this).find("em").show();
		},function(){
			$(this).find("em").hide();
		});
	});
	</script>
</head>
<body>
	
<div id="div_today" class="today">
	<div class="calendar_month">
		<ul id="ul_view_switcher">
			<!--<li method="removeClass" class="on">月历</li>
			<li method="addClass">日历</li> -->
			<li method="addClass" onClick="javascript:document:excel.submit();">导出报表</li>
		</ul>
	</div>
	<form name="excel" method="post" action="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>">
		<input type="hidden" name="do" value="excel" />
		</form>
	<div class="user_avatar">
		<dl class="e_clear">
			<dd>
				<span></span>工作日程
			</dd>
		</dl>
	</div>
	<div class="today_calendar e_clear">
		<div class="today_calendar_data">
		<?php echo $yms[0];?>年<?php echo $yms[1];?>月</div>
		<div class="today_calendar_pn"><a id="lnk_prev" href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&ym=<?php echo GetMonth($yms[0].$yms[1],1);?>" class="prev" hidefocus="true" title="前一个月"></a><a id="lnk_next" href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&ym=<?php echo GetMonth($yms[0].$yms[1],0);?>" hidefocus="true" class="next" title="后一个月"></a></div>
		<?php if($yms[0].$yms[1]!=get_date('Ym',PHP_TIME)){?>
		<a href="admin.php?ac=workdate&fileurl=workbench" class="today_btn" hidefocus="true" title="切换回今天">本月</a>
		<?php }?>
	</div>
	<div class="month_view_title">
		<?php
		if(is_superadmin()){
			if($_GET['type']==1){
				echo '<a href="admin.php?ac='.$ac.'&fileurl=workbench&ym='.$ym.'&type=2"><p class="on">只显示我的日程</p></a>';
			}else{
				echo '<a href="admin.php?ac='.$ac.'&fileurl=workbench&ym='.$ym.'&type=1"><p>只显示我的日程</p></a>';
			}
		}
		?>
		
	</div>
</div>
<div id="div_calendar_list" class="my_calendar_rightnone my_calendar e_clear">
	<div id="div_calendar_left" class="my_calendar_left">
		<!--<div id="lnk_left_switcher" class="left_visibility" title="隐藏日历列表"></div> --> 
		<dl class="palug_nav">
			<ul id="ul_plugin_list">
					<li class="e_clear"><a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>" hidefocus="true" class="almanac iepng">日程管理</a></li>
					<li class="e_clear"><a href="javascript:;" onClick="window.open ('admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=add', 'newwindow_', 'height=550, width=600, top=6, left=200,right=0, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no')" hidefocus="true" class="birthday iepng" >新增日程</a></li>
				</ul>
		</dl>
	</div>
	
<div class="my_calendar_center">
	<div class="month_view_right calendar">
	
	<?php 
	 
 
$calc->showCalendar($wheresql); 
	
	?>
		</div>
		</div>

</div>



</body>
</html>
