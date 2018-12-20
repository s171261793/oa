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
					<li><a href="admin.php?ac=index&fileurl=communication&type=1" data-toggle="tab">个人通迅录</a></li>
					<li><a href="admin.php?ac=index&fileurl=communication&type=2" data-toggle="tab">公共通迅录</a></li>
					<li class="active"><a href="admin.php?ac=user&fileurl=communication" data-toggle="tab">公司通迅录</a></li>
					
				</ul>
			</div>
<div class="search_area">
    <form method="get" action="admin.php" name="save" >
		<input type="hidden" name="ac" value="<?php echo $ac?>" />
		<input type="hidden" name="do" value="list" />
		<input type="hidden" name="fileurl" value="<?php echo $fileurl?>" />
        <div class="form-search form-search-top" style="text-align:left;padding-left:10px;">
                           
			            
	        <div class="adv-select-label">关键词：</div>
       		<input type="text"  name="keyword" size="20" class="span3" value="<?php echo urldecode($keyword)?>">  

            <div class="adv-select-label">部门：</div>
            <select name="department" class="BigStatic">
						  <option value="" selected="selected"></option>
						 <?php echo get_realdepalist(0,$department,0)?>
			              </select>
           <div class="adv-select-label">用户组：</div>
            <select name="usergroup" class="BigStatic">
						  <option value="" selected="selected"></option>
						 <?php echo get_grouplist($usergroup)?>
			              </select>

            <button id="do_search" type="button" onClick="sendForm();" class="btn btn-primary">查 询</button>
           <!-- <button  onClick="formview()" type="button" class="btn">切换更多查询</button> -->
        </div>
       
    </form>
</div>


<div class="data-wrap">
	<div class="data-operation">
		<div class="button-operation">
		
<!--<button type="button" onClick="updateform(2);" action="cancel_concern" class="btn btn-info">发送短信</button>
<button type="button" onClick="updateform(1);" action="cancel_concern" class="btn btn-danger">发送短消息</button> -->		
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
      <td>姓名</td>
      <td width="100">性别</td>
	  <td width="100">联系电话</td>
	  <td width="100">传真</td>
	  <td width="100">手机</td>
	  <td width="100">电子邮件</td>
	  <td width="100">职位</td>
	  <td width="100">所属部门</td>
	 
   </tr>
<?php
foreach ($result as $row) {
?>
    <tr >
      <td width="40"><?php
get_boxlistkey("id[]",$row['id'],$row['uid'],$_USER->id)
?>
</td>
    	
      <td><?php echo $row['name']?></td>
    	<td><?php echo $row['sex']?></td>
<td><?php echo $row['tel']?></td>
<td><?php echo $row['fax']?></td>
<td><?php echo $row['phone']?></td>
<td ><?php echo $row['email']?></td>
<td><?php echo get_postname($row['positionid'])?></td>
<td><?php echo get_realdepaname($row['departmentid'])?>
</td>
    </tr>
<?php } ?>	       
    </table>
</div>
</div>
</form>

</body>
</html>