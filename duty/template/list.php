<!DOCTYPE html>
<!--[if IE 6 ]> <html class="ie6 lte_ie6 lte_ie7 lte_ie8 lte_ie9"> <![endif]--> 
<!--[if lte IE 6 ]> <html class="lte_ie6 lte_ie7 lte_ie8 lte_ie9"> <![endif]--> 
<!--[if lte IE 7 ]> <html class="lte_ie7 lte_ie8 lte_ie9"> <![endif]--> 
<!--[if lte IE 8 ]> <html class="lte_ie8 lte_ie9"> <![endif]--> 
<!--[if lte IE 9 ]> <html class="lte_ie9"> <![endif]--> 
<!--[if (gte IE 10)|!(IE)]><!--><html><!--<![endif]-->
 <head>
    <title><?php echo $_CONFIG->config_data('name')?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=10,chrome=1" />
<link rel="stylesheet" type="text/css" href="template/default/content/css/style2014.css">
<script type="text/javascript" src="template/default/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="template/default/content/js/lockTableTitle.js"></script>
<script language="javascript" type="text/javascript" src="template/default/content/js/common.js"></script>
<script language="javascript" type="text/javascript" src="DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
    
    var locktb;
    $(function(){
        locktb=new Kkctf.table.lockTableSingle({
            tMain:$('#lockTable'),            //table的层
            padWidth:15,                        //单元格左右的padding的值总和数值
            borWidth:2,                        //表格左右边框宽度总和值
            subtHeig:150,                    //表格高度减去多少
            dinamicDiv:$('#dynamicDiv'),      //动态层的高度.表格会根据动态层的显示或隐藏进行表格大小的动态调整(可选)
            autoHeight:true                 //表格窗口是否随着窗口的高度改变自动调整高度(可选)
        });
    });

    function formview(){
    
        if($('#dynamicDiv').is(':visible')){
            $('#dynamicDiv').hide();
        }else{
            $('#dynamicDiv').show();
        }
        
        locktb.autoHeightFn();
    }
    function sendForm(){
	   document.save.submit();
	}
</script>
</head>
<body class="body-wrap">
<div class="tabbable work-nav"> <!-- Only required for left/right tabs -->
				<ul id="myTab" class="nav nav-tabs">
					<li <?php if($dkey==''){?>class="active"<?php }?> ><a href="admin.php?ac=duty&fileurl=duty" data-toggle="tab">所有任务</a></li>
					<li <?php if($dkey==1){?>class="active"<?php }?>><a href="admin.php?ac=duty&fileurl=duty&dkey=1" data-toggle="tab">进行中任务</a></li>
					<li <?php if($dkey==2){?>class="active"<?php }?>><a href="admin.php?ac=duty&fileurl=duty&dkey=2" data-toggle="tab">未完成任务</a></li>
					<li <?php if($dkey==3){?>class="active"<?php }?>><a href="admin.php?ac=duty&fileurl=duty&dkey=3" data-toggle="tab">己完成任务</a></li>
				</ul>
			</div>
<div class="search_area">
    <form method="get" action="admin.php" name="save">
	<input type="hidden" name="ac" value="<?php echo $ac?>" />
		<input type="hidden" name="do" value="list" />
		<input type="hidden" name="fileurl" value="<?php echo $fileurl?>" />
		<input type="hidden" name="dkey" value="<?php echo $dkey?>" />

        <div class="form-search form-search-top" style="text-align:left;padding-left:10px;">
                        <?php echo get_keyuser($ui,$un);?>    
			            <div class="adv-select-label">任务编号：</div>
	        <input type="text" name="number" value="<?php echo urldecode($number)?>" size="6" class="span1" >
	        <div class="adv-select-label">任务名称：</div>
       		<input type="text"  name="title" size="20" class="span3" value="<?php echo urldecode($title)?>">  

            <div class="adv-select-label">任务周期：</div>
            <input type="text" class="span1" value="<?php echo $vstartdate?>"  style="width:80px;" readonly="readonly"  onClick="WdatePicker();" name='vstartdate'> 至 <input type="text" class="span1" value="<?php echo $venddate?>"  style="width:80px;" readonly="readonly"  onClick="WdatePicker();" name='venddate'>
			
           
            <button id="do_search" type="button" onClick="sendForm();" class="btn btn-primary">查 询</button>
           <!-- <button  onClick="formview()" type="button" class="btn">切换更多查询</button> -->
        </div>
       
    </form>
</div>


<div class="data-wrap">
	<div class="data-operation">
		<div class="button-operation">
		<button type="button" action="new_work" class="btn btn-success" onClick="javascript:window.location='admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&do=add'">新建任务</button>
<button type="button" onClick="javascript:document:update.submit();" action="cancel_concern" class="btn btn-danger">清理数据</button>

				<?php echo get_exceldown('excel_1',1);?>
				
		</div>

<div class="pager_operation">
	<?php echo newshowpage($num,$pagesize,$page,$url);?>
		
	<!--<div class="pagination" id="work-pager-block">
	<ul>
	<li><span>首页</span></li>
	<li><span>上一页</span></li>
	<li class="active"><span>1</span></li>
	<li><span>2</span></li>
	<li><span>3</span></li>
	<li><span>4</span></li>
	<li><span>5</span></li>
	<li><span>6</span></li>
	<li><span>下一页</span></li>
	<li><span>尾页</span></li>
	</ul>
	</div> -->
	
	
</div>
</div>		
</div>
<form name="update" method="post" action="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&type=<?php echo $_GET['type']?>">
<input type="hidden" name="do" value="update"/>

<div class="data-list" >
<div  id="lockTable">
<table  class="table table-bordered table-hover" width="100%">
      <tr class="editThead" align="center">
      <td width="40"><input type="checkbox" value="1" name="chkall" onClick="check_all(this)" /></td>
      <td width="120">任务编号</td>
      <td>任务名称</td>
      <td width="160">任务周期</td>
      <td width="190">任务进度</td>
      <td width="90">发起人</td>
      <td width="100">发起时间</td>
      <td width="90">状态</td>
      <td width="150">操作</td>
   </tr>
<?php
foreach ($result as $row) {
		$upnums = $db->result("SELECT COUNT(*) AS upnums FROM ".DB_TABLEPRE."duty_user  WHERE dutyid='".$row['id']."'");
	  $logupdate = $db->fetch_one_array("SELECT sum(progress) as progress FROM ".DB_TABLEPRE."duty_log WHERE dutyid='".$row['id']."'");
	if($logupdate["progress"]/$upnums>='100'){
		$db->query("UPDATE ".DB_TABLEPRE."duty SET dkey=3 WHERE id = '".$row['id']."'");
	}
	if($row['enddate']<get_date('Y-m-d',PHP_TIME) && $logupdate["progress"]/$upnums<'100'){
    	$db->query("UPDATE ".DB_TABLEPRE."duty SET dkey=2 WHERE id = '".$row['id']."'");
	}
?>
    <tr >
      <td width="40"><?php
get_boxlistkey("id[]",$row['id'],$row['uid'],$_USER->id);
?>
    	<td align="center"><?php echo $row['number']?></td>
      <td>
        <a href="admin.php?ac=<?php echo $ac?>&do=view&fileurl=<?php echo $fileurl?>&id=<?php echo $row['id']?>"><?php echo $row['title']?></a>
      </td>
    	<td nowrap align="center"><?php echo $row['startdate']?>至<?php echo $row['enddate']?></td>
      <td nowrap align="right" >
	  <?php
	  $nums = $db->result("SELECT COUNT(*) AS nums FROM ".DB_TABLEPRE."duty_user  WHERE dutyid='".$row['id']."'");
	  $key1 = $db->fetch_one_array("SELECT sum(progress) as progress FROM ".DB_TABLEPRE."duty_log WHERE dutyid='".$row['id']."'");
	 // echo $key1["progress"];
	 if($key1["progress"]/$nums<='100'){
		 echo '<div style="width:100%; background-color:#CCCCCC;">';
			 echo '<div style="width:';
			 if($key1["progress"]!=''){
				 echo $key1["progress"]/$nums;
			 }else{
				 echo '1';
			 }
			 echo '%; background-color:#006600;">
			  &nbsp;
			  </div>
		  </div>';
	 }else{
		 echo "任务己完成，但超出来进度！";
	 }
	 $progress=$key1["progress"]/$nums;
	 $progress=explode('.',$progress);
	 if($progress[1]!=''){
		 echo $progress[0].'.'.substr($progress[1], 0, 2)."%";
	 }else{
		 echo $progress[0]."%";
	 }
	  ?>
	  </td>
      <td nowrap align="center" ><?php echo get_realname($row['uid'])?></td>
      <td nowrap ><?php echo str_replace(' ','<br>',$row['date']);?></td>
      <td align="center" ><?php if($row['dkey']=='1'){echo "进行中";}elseif($row['dkey']=='2'){echo "<font color=red>未完成</font>";}else{echo "<font color=#006600>己完成</font>";}?></td>
     
      <td nowrap align="center" >
      <?php if($row['uid']==$_USER->id){?>
	   <a href="admin.php?ac=<?php echo $ac;?>&do=add&fileurl=<?php echo $fileurl;?>&id=<?php echo $row['id'];?>">编辑</a>|<a href="admin.php?ac=user&fileurl=<?php echo $fileurl;?>&did=<?php echo $row['id'];?>">执行人管理</a>|<?php }?><a href="admin.php?ac=<?php echo $ac;?>&do=view&fileurl=<?php echo $fileurl;?>&id=<?php echo $row['id'];?>">查看</a>
	   <?php
	   $uid = $db->fetch_one_array("SELECT id FROM ".DB_TABLEPRE."duty_user  WHERE dutyid = '".$row['id']."' and user = '".$_USER->id."' ");
	   if($uid['id']!=''){
	   ?>
	   <br>
	   <a href="admin.php?ac=log&fileurl=duty&did=<?php echo $row['id'];?>" style="color:red;">进度录入</a>
	   <?php }?>
                </td>
    </tr>
<?php } ?>	       
    </table>
</div>
</div>
</form>
<form name="excel" method="post" action="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>">
		<input type="hidden" name="title" value="<?php echo $title?>" />
		<input type="hidden" name="number" value="<?php echo $number?>" />
		<input type="hidden" name="typeid" value="<?php echo $typeid?>" />
		<input type="hidden" name="tplid" value="<?php echo $tplid?>" />
		<input type="hidden" name="vstartdate" value="<?php echo $vstartdate?>" />
		<input type="hidden" name="venddate" value="<?php echo $venddate?>" />
		<input type="hidden" name="ui" value="<?php echo $ui?>" />
		<input type="hidden" name="un" value="<?php echo $un?>" />
		<input type="hidden" name="do" value="excel" />
	</form>
</body>
</html>