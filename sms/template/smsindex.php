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
            subtHeig:70,                    //表格高度减去多少
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



<div class="data-wrap">
	<div class="data-operation">
		<div class="button-operation">
		<button type="button" action="new_work" class="btn btn-success" onClick="javascript:window.location='admin.php?ac=smsadd&fileurl=sms'">发送短信</button>
		<button type="button" action="new_work" class="btn btn-success" onClick="javascript:window.location='admin.php?ac=channel_edit&fileurl=sms'">接口配置</button>
<button type="button" onClick="javascript:document:update.submit();" action="cancel_concern" class="btn btn-danger">清理数据</button>

	
				
		</div>

<div class="pager_operation">
	<?php echo newshowpage($num,$pagesize,$page,$url);?>

	
	
</div>
</div>		
</div>
<form name="update" method="post" action="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>">
		<input type="hidden" name="do" value="update" />
		<input type="hidden" name="vuidtype" value="<?php echo urldecode($userkeytype)?>" />

<div class="data-list" >
<div  id="lockTable">
<table  class="table table-bordered table-hover" width="100%">
      <tr class="editThead" align="center">
      <td width="40"><input type="checkbox" value="1" name="chkall" onClick="check_all(this)" /></td>
      <td width="100">状态</td>
      <td width="100">接收手机</td>
      <td width="100">接收人</td>
      <td width="100">发送人</td>
      <td width="140">发送时间</td>
	  <td>内容</td>
   </tr>
<?php
foreach ($result as $row) {
?>
    <tr >
      <td width="40"><?php
get_boxlistkey("id[]",$row['id'],$row['uid'],$_USER->id);
?>
    	<td align="center"><?php if($row['type']=='1'){echo '<font color=red>成功</font>';}else{echo'失败';}?></td>
      <td>
       <?php echo $row['receivephone']?>
      </td>
    	<td nowrap align="center"><?php echo $row['receiveperson']?></td>
      <td nowrap align="right" >
	  <?php echo get_realname($row['sendperson'])?>
	  </td>
      <td nowrap align="center" ><?php echo $row['date']?></td>
      <td nowrap ><?php echo $row['content']?></td>
    </tr>
<?php } ?>	       
    </table>
</div>
</div>
</form>
<form name="excel" method="post" action="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>">
		<input type="hidden" name="do" value="excel" />
		<input type="hidden" name="vuidtype" value="<?php echo urldecode($userkeytype)?>" />
	</form>
</body>
</html>