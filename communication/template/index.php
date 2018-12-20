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
					<li <?php if($_GET[type]=='1'){?>class="active"<?php }?>><a href="admin.php?ac=index&fileurl=communication&type=1" data-toggle="tab">个人通迅录</a></li>
					<li <?php if($_GET[type]=='2'){?>class="active"<?php }?>><a href="admin.php?ac=index&fileurl=communication&type=2" data-toggle="tab">公共通迅录</a></li>
					<li <?php echo $_check['ischeck2']?>><a href="admin.php?ac=user&fileurl=communication" data-toggle="tab">公司通迅录</a></li>
					
				</ul>
			</div>
<div class="search_area">
    <form method="get" action="admin.php" name="save">
		<input type="hidden" name="ac" value="<?php echo $ac?>" />
		<input type="hidden" name="do" value="list" />
		<input type="hidden" name="fileurl" value="<?php echo $fileurl?>" />
		<input type="hidden" name="type" value="<?php echo $_GET[type]?>" />
        <div class="form-search form-search-top" style="text-align:left;padding-left:10px;">
                           
			            
	        <div class="adv-select-label">关键词：</div>
       		<input type="text"  name="keyword" size="20" class="span3" value="<?php echo urldecode($keyword)?>">  

            <div class="adv-select-label">选项：</div>
            <select name="ttype" class="BigStatic">
						 <option value="" selected="selected"></option>
						  <option value="company" <?php if ($ttype=='company'){?>selected="selected"<?php }?>>公司名称</option>
						  <option value="person" <?php if ($ttype=='person'){?>selected="selected"<?php }?>>联系人</option>
						  <option value="position" <?php if ($ttype=='position'){?>selected="selected"<?php }?>>职位</option>
						  <option value="tel" <?php if ($ttype=='tel'){?>selected="selected"<?php }?>>联系电话</option>
						  <option value="phone" <?php if ($ttype=='phone'){?>selected="selected"<?php }?>>手机</option>
						  <option value="fax" <?php if ($ttype=='fax'){?>selected="selected"<?php }?>>传真</option>
						  <option value="address" <?php if ($ttype=='address'){?>selected="selected"<?php }?>>地址</option>
		              </select>
           

            <button id="do_search" type="button" onClick="sendForm();" class="btn btn-primary">查 询</button>
           <!-- <button  onClick="formview()" type="button" class="btn">切换更多查询</button> -->
        </div>
       
    </form>
</div>


<div class="data-wrap">
	<div class="data-operation">
		<div class="button-operation">
		<button type="button" action="new_work" class="btn btn-success" onClick="javascript:window.location='admin.php?ac=add&fileurl=communication&type=<?php echo $_GET[type]?>'">新增通迅录</button>
<button type="button" onClick="updateform(2);" action="cancel_concern" class="btn btn-info">发送短信</button>
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
		<input type="hidden" name="type"  value="<?php echo $_GET[type]?>" />
<div class="data-list" >
<div  id="lockTable">
<table  class="table table-bordered table-hover" width="100%">
      <tr class="editThead" align="center">
      <td width="40"><input type="checkbox" value="1" name="chkall" onClick="check_all(this)" /></td>
      <td>公司名称</td>
      <td width="100">联系人</td>
	  <td width="100">性别</td>
	  <td width="100">职位</td>
	  <td width="100">联系电话</td>
	  <td width="100">手机</td>
	  <td width="100">传真</td>
	  <td width="100">电子邮件</td>
	  <td width="90">发布人</td>
	  <td width="100">操作</td>
   </tr>
<?php
foreach ($result as $row) {
?>
    <tr >
      <td width="40"><?php
get_boxlistkey("id[]",$row['id'],$row['uid'],$_USER->id)
?>
<input type="hidden" name="phone[<?php echo $row[id]?>]" value="<?php echo $row[phone]?>" />
<input type="hidden" name="person[<?php echo $row[id]?>]" value="<?php echo $row[person]?>" />
</td>
    	
      <td><a href="<?php if($row['uid']==$_USER->id){?>admin.php?ac=edit&fileurl=communication&do=edit&id=<?php echo $row['id']?>&type=<?php echo $_GET[type]?><?php }else{?>#<?php }?>"><?php echo $row['company']?></a></td>
    	<td nowrap align="center"><?php echo $row['person']?></td>
      <td nowrap align="right" ><?php echo $row['sex']?>
	  </td>
      <td nowrap align="center" ><?php echo $row['position']?></td>
	<td nowrap align="center"><?php echo $row['tel']?></td>
	<td nowrap align="center"><?php echo $row['phone']?></td>
	<td nowrap align="center"><?php echo $row['fax']?></td>
	<td nowrap align="center"><?php echo $row['mail']?></td>
	<td nowrap align="center"><?php echo get_realname($row['uid'])?></td>
	<td nowrap align="center"><?php get_urlkey("编辑","admin.php?ac=edit&fileurl=communication&do=edit&type=".$_GET[type]."&id=".$row['id']."","".$row['uid']!=$_USER->id)?></td>
    </tr>
<?php } ?>	       
    </table>
</div>
</div>
</form>

</body>
</html>