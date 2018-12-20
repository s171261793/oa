<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<title>信息添加编辑</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
<script language="javascript" type="text/javascript" src="template/default/js/jquery-1.10.2.min.js"></script>
</head>
<body class="bodycolor" <?php if($user['keytype']=='1'){?>onLoad="toggle2('div1');"<?php }?>>
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3">添加部门</span>&nbsp;&nbsp;&nbsp;&nbsp;
	<span style="font-size:12px; float:right;margin-right:20px;">
	
	<a href="admin.php?ac=weekly_log&fileurl=report&do=list" style="font-size:12px;"><<返回列表页</a></span>
    </td>
  </tr>
</table>
<script Language="JavaScript">




function CheckForm()
{
   if(document.save.coefficient.value=="")
   { alert("计算系数不能为空！");
     document.save.coefficient.focus();
     return (false);
   }

   return true;
}

function sendForm()
{
   if(CheckForm())
      document.save.submit();
}


</script>
<style type="text/css"> 
#div1{display:none;}
#div2{display:block;}
</style>
<form name="save" method="post" action="<?php echo 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=countsub';?>">
<!-- <input type="hidden" name="view" value="edit" /> -->
	<!-- <input type="hidden" name="id" value="<?php echo $user['uid']?>" /> -->
  <!-- <input type="hidden" name="oldpassword" value="<?php echo $user['password']?>" /> -->
	<input type="hidden" name="orderid" value="<?php echo $orderid?>" />
 <table class="TableBlock" border="0" width="90%" align="center">
      <tr>
        <td nowrap class="TableContent">周报名称：</td>
        <td class="TableData">第<?php   echo $info['weekly_number'];?>周总结汇报表与第<?php echo $info['weekly_number_plan']?> 周计划汇报表</td>
        <td nowrap class="TableContent">周报绩效分数：</td>
        <td class="TableData"><input name="number-fen" type="text" disabled="disabled" value="<?php  echo $info['score'];?>"> 分</td>
      </tr>
      <tr>
        <td nowrap class="TableContent">系数：</td>
        <td class="TableData"><input type="text"  name="coefficient" placeholder="输入计算系数" ></td>
        <td nowrap class="TableContent">计算后绩效分数：</td>
        <td class="TableData"><input name="score" type="text" readonly="readonly" value="<?php  echo $info['score'];?>"> 分</td>  
      </tr>
  

    <tr align="center" class="TableControl">
    	<td colspan="4" nowrap>
    	<input type="button" value="修改绩效" class="BigButtonBHover" onClick="sendForm();">&nbsp;
 
	    </td>
  </tr>
 </table>
  
</form>

 
</body>
</html>
<script type="text/javascript">

$(function(){

    $("input[name=score]").val($("input[name=number-fen]").val());
    $('input[name=coefficient]').val('');


    $('input[name=coefficient]').bind('input propertychange',function(){

        var first = $("input[name=number-fen]").val();
        var second = $(this).val();
        if(second >1 || second < 0)
        { 
          alert('此处的值范围在0至1之间');
          $('input[name=coefficient]').val('');
          return false;
        }
        var count =(first * second).toFixed(2);

      $("input[name=score]").val( count);
    });



})

</script>
