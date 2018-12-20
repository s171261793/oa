<!DOCTYPE HTML>
<html class="web">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<link href="template/default/new/css/calendar.css" rel="stylesheet"/>
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
			<!--<li method="removeClass" class="on">月历</li> -->
			<li method="addClass" onClick="javascript:document:excel.submit();">导出报表</li>
		</ul>
	</div>
	<form name="excel" method="post" action="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>">
		<input type="hidden" name="do" value="excel" />
		</form>
	<div class="user_avatar">
		<dl class="e_clear">
			<dd>
				<span></span>工作日志
			</dd>
		</dl>
	</div>
	<div class="today_calendar e_clear">
		<div class="today_calendar_data">
		<?php echo $yms[0];?>年<?php echo $yms[1];?>月</div>
		<div class="today_calendar_pn"><a id="lnk_prev" href="admin.php?ac=blog&fileurl=workbench&ym=<?php echo GetMonth($yms[0].$yms[1],1);?>&type=<?php echo $_GET['type'];?>" class="prev" hidefocus="true" title="前一个月"></a><a id="lnk_next" href="admin.php?ac=blog&fileurl=workbench&ym=<?php echo GetMonth($yms[0].$yms[1],0);?>&type=<?php echo $_GET['type'];?>" hidefocus="true" class="next" title="后一个月"></a></div>
		<?php if($_GET['day']==''){?>
		<a href="admin.php?ac=blog&fileurl=workbench&ym=<?php echo get_date('Y',PHP_TIME).'/'.get_date('m',PHP_TIME);?>&day=<?php echo get_date('d',PHP_TIME);?>&type=<?php echo $_GET['type'];?>" class="today_btn" hidefocus="true" title="切换回今天">今天</a>
		<?php }?>
	</div>
	<div class="month_view_title">
		<?php
		if($_GET['type']==1){
			echo '<a href="admin.php?ac=blog&fileurl=workbench&ym='.$ym.'&day='.$_GET[day].'&type=2"><p class="on">只显示我的日志</p></a>';
		}else{
			echo '<a href="admin.php?ac=blog&fileurl=workbench&ym='.$ym.'&day='.$_GET[day].'&type=1"><p>只显示我的日志</p></a>';
		}
		
		?>
		
	</div>
</div>
<div id="div_calendar_list" class="my_calendar_rightnone my_calendar e_clear">
	<div id="div_calendar_left" class="my_calendar_left">
		<!--<div id="lnk_left_switcher" class="left_visibility" title="隐藏日历列表"></div> --> 
		<dl class="palug_nav">
			<ul id="ul_plugin_list">
					<li class="e_clear"><a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>" hidefocus="true" class="almanac iepng">日志管理</a></li>
					<li class="e_clear"><a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=add" hidefocus="true" class="birthday iepng" >新增日志</a></li>
				</ul>
		</dl>
	</div>
	
<div class="my_calendar_center">
	<div class="month_view_right">
	<ul>
<?php
//处理当天数据
if($_GET['day']!=''){
$forday=$yms[0].'-'.$yms[1].'-'.$_GET['day'];
?>
	<li class="odd">
		<div class="month_view_date">
			<h3><span class="month_view_week"><?php echo "星期".$weekarray[date("w",strtotime($forday))];
	?></span><span class="month_view_ymd"><?php echo $forday;?></span></h3>
			<p><span class="month_view_solar"></span></p>
		</div>
		<?php
		$query = $db->query("SELECT id,title,uid,content FROM ".DB_TABLEPRE."blog  where date='".$forday."' ".$wheresql." order by id desc");
		while ($row = $db->fetch_array($query)) {
		?>
		<div class="month_view_schedule">
		<dl>
		<div class="list">
	  <dt><div class="spheric ui-corner-all-16"><img src="template/default/new/images/01.png"></div>
	  <span class="month_view_schedule_time"><a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=views&id=<?php echo $row['id']?>"><?php echo $row['title']?></a></span>
	  <?php if($row['uid']==$_USER->id || is_superadmin()){?>
	  <em class="none"><a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&do=add&id=<?php echo $row['id'];?>" title="修改日志" class="month_view_edit_schedule "></a><a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&do=update&id=<?php echo $row['id'];?>" title="删除日志" class="month_view_del_schedule "></a></em>
	  <?php }?>
	  </dt>
	  <dd>
	  <?php
	  $content=strip_tags($row['content']);
	  $content=str_replace('&nbsp;','',$content);
	  echo cut_str($content,'200');
	  ?></dd>
	</div>
	</dl>
		</div>
		
	<?php }?>	
	</li>
<?php
}else{
	for($i=1;$i<=$t;$i++){
	if($i%2==0){
		$evenodd='even';
	}else{
		$evenodd='odd';
	}
	if($i<10){
		$m='0'.$i;
	}else{
		$m=$i;
	}
	$forday=$yms[0].'-'.$yms[1].'-'.$m;
	?>
				
		<li class="<?php echo $evenodd;?>">
		<div class="month_view_date">
			<h3><span class="month_view_week"><?php echo "星期".$weekarray[date("w",strtotime($forday))];
	?></span><span class="month_view_ymd"><?php echo $forday;?></span></h3>
			<p><span class="month_view_solar"></span></p>
		</div>
		
		<?php
		$query = $db->query("SELECT id,title,uid,content FROM ".DB_TABLEPRE."blog  where date='".$forday."' ".$wheresql." order by id desc");
		while ($row = $db->fetch_array($query)) {
		?>
		<div class="month_view_schedule">
		<dl>
		<div class="list">
	  <dt><div class="spheric ui-corner-all-16"><img src="template/default/new/images/01.png"></div>
	  <span class="month_view_schedule_time"><a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=views&id=<?php echo $row['id']?>"><?php echo $row['title']?></a></span>
	  <?php if($row['uid']==$_USER->id || is_superadmin()){?>
	  <em class="none"><a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&do=add&id=<?php echo $row['id'];?>" title="修改日志" class="month_view_edit_schedule "></a><a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&do=update&id=<?php echo $row['id'];?>" title="删除日志" class="month_view_del_schedule "></a></em>
	  <?php }?>
	  </dt>
	  <dd>
	  <?php
	  $content=strip_tags($row['content']);
	  $content=str_replace('&nbsp;','',$content);
	  echo cut_str($content,'200');
	  ?>
	  
	  </dd>
	</div>
	</dl>
		</div>
		
	<?php }?>	
		
		
	</li>
	<?php
	}
}
?>	
			
			</ul>
		</div>
		</div>

</div>



</body>
</html>
