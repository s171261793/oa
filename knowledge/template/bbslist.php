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
					<li <?php if($ischeck==''){?>class="active"<?php }?>><a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>" data-toggle="tab">所有贴子</a></li>
					<li <?php if($ischeck==1){?>class="active"<?php }?>><a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&ischeck=1" data-toggle="tab">我发布的贴子</a></li>
					<li <?php if($ischeck==2){?>class="active"<?php }?>><a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&ischeck=2" data-toggle="tab">待我审批的贴子</a></li>
					
				</ul>
			</div>
<div class="search_area">
    <form method="get" action="admin.php" name="save">
	<input type="hidden" name="ac" value="<?php echo $ac?>" />
		<input type="hidden" name="do" value="list" />
		<input type="hidden" name="fileurl" value="<?php echo $fileurl?>" />
        <div class="form-search form-search-top" style="text-align:left;padding-left:10px;">
                        <?php echo get_keyuser($ui,$un);?>    
			 <div class="adv-select-label">版块：</div>
       		           
	         <select name="bbsclass">
	           <option value="" selected></option>
			   <?php foreach ($bbsclasslist as $row) {?>
			   <option value="<?php echo $row[id]?>" <?php if(trim($bbsclass)==trim($row[id])){?>selected<? }?>><?php echo $row[name]?></option>
			   <?php }?>
                </select>
	         <div class="adv-select-label">主题：</div>
       		<input type="text"  name="title" size="20" class="span3" value="<?php echo urldecode($title)?>">  

            <div class="adv-select-label">发贴日期：</div>
            <input type="text" class="span1" value="<?php echo $vstartdate?>"  style="width:80px;" readonly="readonly"  onClick="WdatePicker();" name='vstartdate'> 至 <input type="text" class="span1" value="<?php echo $venddate?>"  style="width:80px;" readonly="readonly"  onClick="WdatePicker();" name='venddate'>
			
           
            <button id="do_search" type="button" onClick="sendForm();" class="btn btn-primary">查 询</button>
           <!-- <button  onClick="formview()" type="button" class="btn">切换更多查询</button> -->
        </div>
       
    </form>
</div>


<div class="data-wrap">
	<div class="data-operation">
		<div class="button-operation">
		<button type="button" action="new_work" class="btn btn-success" onClick="javascript:window.location='admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=add'">发布新贴</button>				
<button type="button" onClick="updateform(1);" action="cancel_concern" class="btn btn-danger">清理数据</button>

				
				
		</div>

<div class="pager_operation">
	<?php echo newshowpage($num,$pagesize,$page,$url);?>
	
	
</div>
</div>		
</div>
<form name="update" method="post" action="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>">
		<input type="hidden" name="do" value="update" />
		<input type="hidden" name="uptype" id="uptype" value="2" />

<div class="data-list" >
<div  id="lockTable">
<table  class="table table-bordered table-hover" width="100%">
      <tr class="editThead" align="center">
      <td width="40"><input type="checkbox" value="1" name="chkall" onClick="check_all(this)" /></td>
      <td>主题</td>
	  <td width="100">作者</td>
	  <td width="100">来源</td>
	  <td width="100">阅读次数</td>
	  <td width="80">状态</td>
	  <td width="100">版主</td>
      <td width="100">发布人</td>
      <td width="120">发布时间</td>
      <td width="100">操作</td>
   </tr>
<?php
foreach ($result as $row) {
global $db;
$bbsclassadmin = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."bbsclass  WHERE id = '".$row["bbsclass"]."' and classadmin like '%".get_realname($_USER->id)."%' ");
if($_USER->id==$row['uid'] && $bbsclassadmin["classadmin"]==''){
	$disabled='';
}elseif($bbsclassadmin["classadmin"]!=''){
	$disabled='';
}else{
	$disabled='disabled';
}
?>
    <tr >
      <td width="40"><input type="checkbox" name="id[]" value="<?php echo $row['id']?>" class="checkbox" <?php echo $disabled?> /></td>
        <td>
<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=views&id=<?php echo $row['id']?>"><?php echo $row['title']?></a>
</td>
<td><?php echo $row['author']?></td>
<td><?php echo $row['origin']?></td>
<td><span style='color:red;'><?php echo $row['readnum']?></span>次</td>
<td><?php if($row['type']=='1'){echo "<font color=#006600>待审</font>";}elseif($row['type']=='2'){echo "正常";}else{echo "<font color=red>置顶</font>";}?></td>
<td><?php
global $db;
$bbsclass = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."bbsclass  WHERE id = '".$row["bbsclass"]."' ");
echo $bbsclass["classadmin"];
?></td>
<td><?php echo get_realname($row['uid'])?></td>
<td><?php echo $row['issuedate']?></td>
<td>
<?php
if($_USER->id==$row['uid'] && $bbsclassadmin["classadmin"]==''){
	echo '<a href="admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=add&id='.$row['id'].'">编辑</a>';
}elseif($bbsclassadmin["classadmin"]!=''){
	if($row["type"]=='1'){
	echo '<a href="admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=keys&id='.$row['id'].'">审批</a> | ';
	}
echo '<a href="admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=add&id='.$row['id'].'">编辑</a>';
}
?>
</td>
    </tr>
<?php } ?>	       
    </table>
</div>
</div>
</form>

</body>
</html>