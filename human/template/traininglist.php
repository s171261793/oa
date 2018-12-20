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
	function updateform(type){
		if(type==1){
			document.getElementById("uptype").value='1';
		}
		document.update.submit();
	}
</script>
</head>
<body class="body-wrap">
<div class="tabbable work-nav"> <!-- Only required for left/right tabs -->
				<ul id="myTab" class="nav nav-tabs">
					<li <?php if($_GET['type']==''){?>class="active"<?php }?>><a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>" data-toggle="tab">培训信息列表</a></li>
					<li <?php if($_GET['type']==1){?>class="active"<?php }?>><a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&type=1" data-toggle="tab">我负责的培训</a></li>
					<li <?php if($_GET['type']==2){?>class="active"<?php }?>><a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&type=2" data-toggle="tab">我参与的培训</a></li>
					<li <?php if($_GET['type']==3){?>class="active"<?php }?>><a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&type=3" data-toggle="tab">待审培训</a></li>
					
				</ul>
			</div>
<div class="search_area">
    <form method="get" action="admin.php" name="save">
	<input type="hidden" name="ac" value="<?php echo $ac?>" />
		<input type="hidden" name="do" value="list" />
		<input type="hidden" name="fileurl" value="<?php echo $fileurl?>" />
		<input type="hidden" name="type" value="<?php echo $type?>" />
        <div class="form-search form-search-top" style="text-align:left;padding-left:10px;">
                        <?php echo get_keyuser($ui,$un);?>    
			            
	        <div class="adv-select-label">培训编号：</div>
       		<input type="text"  name="number" size="20" class="span1" value="<?php echo urldecode($number)?>"> 
			<div class="adv-select-label">培训名称：</div>
       		<input type="text"  name="name" size="20" class="span1" value="<?php echo urldecode($name)?>"> 
			<div class="adv-select-label">培训类型：</div>
       		<select name="channel" style="width:80px;">
			<option value="0" selected="selected">请选择类型</option>
			<?php echo get_typelist($channel,17)?>
			</select> 
			<div class="adv-select-label">培训形式：</div>
       		<select name="trform" style="width:80px;">
			<option value="0" selected="selected">请选择形式</option>
			<?php echo get_typelist($trform,18)?>
			</select>
			
            <div class="adv-select-label">培训周期：</div>
            <input type="text" class="span1" value="<?php echo $vstartdate?>"  style="width:80px;" readonly="readonly"  onClick="WdatePicker();" name='vstartdate'> 至 <input type="text" class="span1" value="<?php echo $venddate?>"  style="width:80px;" readonly="readonly"  onClick="WdatePicker();" name='venddate'>
			
           
            <button id="do_search" type="button" onClick="sendForm();" class="btn btn-primary">查 询</button>
           <!-- <button  onClick="formview()" type="button" class="btn">切换更多查询</button> -->
        </div>
       
    </form>
</div>


<div class="data-wrap">
	<div class="data-operation">
		<div class="button-operation">
		<button type="button" action="new_work" class="btn btn-success" onClick="javascript:window.location='admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=add'">发布信息</button>				
<button type="button" onClick="updateform(1);" action="cancel_concern" class="btn btn-danger">清理数据</button>

				<?php echo get_exceldown('excel_31',1);?>
				
		</div>

<div class="pager_operation">
	<?php echo newshowpage($num,$pagesize,$page,$url);?>
	
	
</div>
</div>		
</div>
<form name="update" method="post" action="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>">
		<input type="hidden" name="do" value="update" />
		<input type="hidden" name="uptype" id="uptype" value="2" />
		<input type="hidden" name="type" value="<?php echo $_GET['type']?>" />

<div class="data-list" >
<div  id="lockTable">
<table  class="table table-bordered table-hover" width="100%">
      <tr class="editThead" align="center">
      <td width="40"><input type="checkbox" value="1" name="chkall" onClick="check_all(this)" /></td>
      <td width="120">培训编号</td>
									<td>培训名称</td>
									<td width="100">培训类型</td>
									<td width="80">培训形式</td>
									<td width="100">负责人</td>
									<td width="80">培训预算</td>
									<td width="60">状态</td>
									<td width="60">审批人</td>
									<td width="60">发布人</td>
									<td width="80">发布日期</td>
									<td width="130">操作</td>
   </tr>
<?php
foreach ($result as $row) {
?>
    <tr >
      <td width="40"><?php echo get_boxlistkey("id[]",$row['id'],$row['uid'],$_USER->id)?></td>
      <td><?php echo $row['number']?></td>
<td>
<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=views&id=<?php echo $row['id']?>"><?php echo $row['name']?></a>
</td>
<td><?php echo get_typename($row["channel"])?> </td>
<td><?php echo get_typename($row["trform"])?></td>
<td><?php echo $row['responsible']?></td>
<td><?php echo $row['price']?></td>
<td><?php if($row['type']=='1'){echo "<font color=#006600>待审</font>";}elseif($row['type']=='2'){echo "<font color=red>己批</font>";}else{echo "拒绝";}?></td>
<td><?php echo $row['examination']?></td>
<td ><?php echo get_realname($row['uid'])?></td>
<td><?php echo str_replace(' ','<br>',$row['date'])?></td>
<td>
<?php if($row['type']=='1'){ ?>
<?php get_urlkey("编辑","admin.php?ac=".$ac."&fileurl=".$fileurl."&do=add&id=".$row['id']."","".$row['uid']!=$_USER->id)?>|
<a class="detail" href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=views&id=<?php echo $row['id']?>">查看</a>|
<a class="detail" href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=views&id=<?php echo $row['id']?>&keys=1">审批</a>

<?php }else{?>
<a class="detail" href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=views&id=<?php echo $row['id']?>">查看</a>|
<a class="detail" href="admin.php?ac=training_record&fileurl=<?php echo $fileurl?>&id=<?php echo $row['id']?>">培训记录管理</a>
<?php }?>
</td>
    </tr>
<?php } ?>	       
    </table>
</div>
</div>
</form>
<form name="excel" method="post" action="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>">
		<input type="hidden" name="do" value="excel" />
		<input type="hidden" name="un" value="<?php echo urldecode($un)?>" />
		<input type="hidden" name="ui" value="<?php echo urldecode($ui)?>" />
		<input type="hidden" name="name" value="<?php echo $name?>" />
		<input type="hidden" name="number" value="<?php echo $number?>" />
		<input type="hidden" name="trform" value="<?php echo $trform?>" />
		<input type="hidden" name="channel" value="<?php echo $channel?>" />
		<input type="hidden" name="vstartdate" value="<?php echo $vstartdate?>" />
		<input type="hidden" name="venddate" value="<?php echo $venddate?>" />
		<input type="hidden" name="type" value="<?php echo $_GET['type']?>" />
	</form>
</body>
</html>