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
            subtHeig:130,                    //表格高度减去多少
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

<div class="search_area">
    <form method="get" action="admin.php" name="save">
	<input type="hidden" name="ac" value="<?php echo $ac?>" />
		<input type="hidden" name="do" value="list" />
		<input type="hidden" name="fileurl" value="<?php echo $fileurl?>" />
        <div class="form-search form-search-top" style="text-align:left;padding-left:10px;">
                        <?php echo get_keyuser($ui,$un);?>    
			            
	        <div class="adv-select-label">单位员工：</div>
       		<?php
						  get_pubuser(1,"user",$user,"+选择人员",70,20)
						  ?>
			<div class="adv-select-label">合同编号：</div>
       		<input type="text"  name="number" size="20" class="span1" value="<?php echo urldecode($number)?>">
			<div class="adv-select-label">合同类型：</div>
       		<select name="type" style="width:90px;">
						<option value="0" selected="selected">请选择类型</option>
						<?php echo get_typelist($type,14)?>
						</select>
			<div class="adv-select-label">合同状态：</div>
       		<select name="ckey" style="width:90px;">
			<option value="0" selected="selected" >请选择状态</option>
			<?php echo get_typelist($ckey,15)?>
			</select>
			
           
            <button id="do_search" type="button" onClick="sendForm();" class="btn btn-primary">查 询</button>
           <button  onClick="formview()" type="button" class="btn">切换更多查询</button>
        </div>
       <div class="form-search form-search-bottom query-fom-search" id="dynamicDiv" style="display:none;margin-top:10px;text-align:left;padding-left:10px;"> 
	   <div class="adv-select-label">签订日期：</div>
       		<input type="text"  name="signdate" size="20" class="span1" value="<?php echo urldecode($signdate)?>" onClick="WdatePicker();">
			<div class="adv-select-label">试用生效日期：</div>
       		<input type="text"  name="testdate" size="20" class="span1" value="<?php echo urldecode($testdate)?>" onClick="WdatePicker();">
			<div class="adv-select-label">试用到期日期：</div>
       		<input type="text"  name="testenddate" size="20" class="span1" value="<?php echo urldecode($testenddate)?>" onClick="WdatePicker();">
			<div class="adv-select-label">合同到期日期：</div>
       		<input type="text"  name="signenddate" size="20" class="span1" value="<?php echo urldecode($signenddate)?>" onClick="WdatePicker();">
       </div>   
    </form>
</div>


<div class="data-wrap">
	<div class="data-operation">
		<div class="button-operation">
		<button type="button" action="new_work" class="btn btn-success" onClick="javascript:window.location='admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=add'">发布信息</button>				
<button type="button" onClick="updateform(1);" action="cancel_concern" class="btn btn-danger">清理数据</button>

				<?php echo get_exceldown('excel_30',1);?>
				
		</div>

<div class="pager_operation">
	<?php echo newshowpage($num,$pagesize,$page,$url);?>
	
	
</div>
</div>		
</div>
<form name="update" method="post" action="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>">
		<input type="hidden" name="do" value="update" />
		<input type="hidden" name="uptype" id="uptype" value="2" />
		<input type="hidden" name="type" value="<?php echo $type?>" />

<div class="data-list" >
<div  id="lockTable">
<table  class="table table-bordered table-hover" width="100%">
      <tr class="editThead" align="center">
      <td width="40"><input type="checkbox" value="1" name="chkall" onClick="check_all(this)" /></td>
      <td width="100">合同编号</td>
									<td>单位员工</td>
									<td width="120">合同类型</td>
									<td width="100">合同状态</td>
									<td width="120">合同签订日期</td>
									<td width="120">合同到期日期</td>
									<td width="100">签约次数</td>
									<td width="100">发布人</td>
									<td width="120">操作</td>
   </tr>
<?php
foreach ($result as $row) {
?>
    <tr >
<td>
<?php echo get_boxlistkey("id[]",$row['id'],$row['uid'],$_USER->id)?></td>
<td>
<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=views&id=<?php echo $row['id']?>"><?php echo $row['number']?></a>
</td>
<td><?php echo get_realname($row['userid'])?></td>
<td><?php echo get_typename($row["type"])?></td>
<td><?php echo get_typename($row["ckey"])?></td>
<td><?php echo $row['signdate']?></td>
<td><?php echo $row['signenddate']?></td>
<td><?php echo $row['signnum']?></td>
<td><?php echo get_realname($row['uid'])?></td>
<td>
<?php get_urlkey("编辑","admin.php?ac=".$ac."&fileurl=".$fileurl."&do=add&id=".$row['id']."","".$row['uid']!=$_USER->id)?>
</td>
    </tr>
<?php } ?>	       
    </table>
</div>
</div>
</form>
<form name="excel" method="post" action="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>">
		<input type="hidden" name="do" value="excel" />
		<input type="hidden" name="userid" value="<?php echo $userid?>" />
		<input type="hidden" name="number" value="<?php echo $number?>" />
		<input type="hidden" name="type" value="<?php echo $type?>" />
		<input type="hidden" name="ckey" value="<?php echo $ckey?>" />
		<input type="hidden" name="signdate" value="<?php echo $signdate?>" />
		<input type="hidden" name="testdate" value="<?php echo $testdate?>" />
		<input type="hidden" name="testenddate" value="<?php echo $testenddate?>" />
		<input type="hidden" name="signenddate" value="<?php echo $signenddate?>" />
		<input type="hidden" name="un" value="<?php echo urldecode($un)?>" />
		<input type="hidden" name="ui" value="<?php echo urldecode($ui)?>" />
		
	</form>
</body>
</html>