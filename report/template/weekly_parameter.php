<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<title>信息添加编辑</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">

</head>
<body class="bodycolor" <?php if($user['keytype']=='1'){?>onLoad="toggle2('div1');"<?php }?>>
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3">添加部门</span>&nbsp;&nbsp;&nbsp;&nbsp;
	<span style="font-size:12px; float:right;margin-right:20px;">
	
	<!-- <a href="admin.php?ac=weeklyDpart&fileurl=report" style="font-size:12px;"><<返回列表页</a></span> -->
    </td>
  </tr>
</table>
<script Language="JavaScript"> 
// function CheckForm()
// {
//    if(document.save.department.value=="")
//    { alert("部门不能为空！");
//      document.save.department.focus();
//      return (false);
//    }

//    if(document.save.user_id.value=="0")
//    { alert("人员不能为空！");
//      document.save.name.focus();
//      return (false);
//    }
  
//    return true;
// }

function sendForm()
{
   // if(CheckForm())
      document.save.submit();
}


</script>
<style type="text/css"> 
#div1{display:none;}
#div2{display:block;}
</style>
<form name="save" method="post" action="">
<!-- <input type="hidden" name="view" value="edit" /> -->
	<!-- <input type="hidden" name="id" value="<?php echo $user['uid']?>" /> -->
	<!-- <input type="hidden" name="oldpassword" value="<?php echo $user['password']?>" /> -->
 <table class="TableBlock" border="0" width="90%" align="center">

      <tr>
          <td nowrap class="TableContent" colspan="6" align="center">周报总结参数</td>
          <!-- <td class="TableData">(填写准确)</td> -->
      </tr>

      <tr>
        <td nowrap class="TableContent" >A:</td>
        <td class="TableData"><input type="text" name="week_one_A" value="<?php echo $info['week_one_A'];?>"></td>

        <td nowrap class="TableContent" >B:</td>
        <td class="TableData"><input type="text" name="week_one_B" value="<?php echo $info['week_one_B'];?>"></td>

         <td nowrap class="TableContent" >C:</td>
        <td class="TableData"><input type="text" name="week_one_C" value="<?php echo $info['week_one_C'];?>"></td>
      </tr>

      <tr>
         <td nowrap class="TableContent" >D:</td>
        <td class="TableData"><input type="text" name="week_one_D" value="<?php echo $info['week_one_D'];?>"></td>

        <td nowrap class="TableContent" >E:</td>
        <td class="TableData"><input type="text" name="week_one_E" value="<?php echo $info['week_one_E'];?>"></td>

         <td nowrap class="TableContent" >F:</td>
        <td class="TableData"><input type="text" name="week_one_F" value="<?php echo $info['week_one_F'];?>"></td>
      </tr>

      <tr>
         <td nowrap class="TableContent" >G:</td>
        <td class="TableData"><input type="text" name="week_one_G" value="<?php echo $info['week_one_G'];?>"></td>

        <td nowrap class="TableContent" >H:</td>
        <td class="TableData"><input type="text" name="week_one_H" value="<?php echo $info['week_one_H'];?>"></td>

         <td nowrap class="TableContent" >I:</td>
        <td class="TableData"><input type="text" name="week_one_I" value="<?php echo $info['week_one_I'];?>"></td>
      </tr>

      <tr>
         <td nowrap class="TableContent" >J:</td>
        <td class="TableData"><input type="text" name="week_one_J"  value="<?php echo $info['week_one_J'];?>"></td>

        <td nowrap class="TableContent" >K:</td>
        <td class="TableData"><input type="text" name="week_one_K" value="<?php echo $info['week_one_K'];?>"></td>

         <td nowrap class="TableContent" >L:</td>
        <td class="TableData"><input type="text" name="week_one_L" value="<?php echo $info['week_one_L'];?>"></td>
      </tr>

       <tr>
         <td nowrap class="TableContent" >M:</td>
        <td class="TableData"><input type="text" name="week_one_M" value="<?php echo $info['week_one_M'];?>"></td>

        <td nowrap class="TableContent" >N:</td>
        <td class="TableData"><input type="text" name="week_one_N" value="<?php echo $info['week_one_N'];?>"></td>

         <td nowrap class="TableContent" >O:</td>
        <td class="TableData"><input type="text" name="week_one_O" value="<?php echo $info['week_one_O'];?>"></td>
      </tr>
      


       <tr>
          <td nowrap class="TableContent" colspan="6" align="center">周报计划参数</td>
          <!-- <td class="TableData">(填写准确)</td> -->
      </tr>


       <tr>
         <td nowrap class="TableContent" >A:</td>
        <td class="TableData"><input type="text" name="week_two_A" value="<?php echo $info['week_two_A'];?>"></td>

        <td nowrap class="TableContent" >B:</td>
        <td class="TableData"><input type="text" name="week_two_B" value="<?php echo $info['week_two_B'];?>"></td>

         <td nowrap class="TableContent" >C:</td>
        <td class="TableData"><input type="text" name="week_two_C" value="<?php echo $info['week_two_C'];?>"></td>
      </tr>

       <tr>
         <td nowrap class="TableContent" >D:</td>
        <td class="TableData"><input type="text" name="week_two_D" value="<?php echo $info['week_two_D'];?>"></td>

        <td nowrap class="TableContent" >E:</td>
        <td class="TableData"><input type="text" name="week_two_E" value="<?php echo $info['week_two_E'];?>"></td>

         <td nowrap class="TableContent" >F:</td>
        <td class="TableData"><input type="text" name="week_two_F" value="<?php echo $info['week_two_F'];?>"></td>
      </tr>

       <tr>
         <td nowrap class="TableContent" >G:</td>
        <td class="TableData"><input type="text" name="week_two_G" value="<?php echo $info['week_two_G'];?>"></td>

        <td nowrap class="TableContent" >H:</td>
        <td class="TableData"><input type="text" name="week_two_H" value="<?php echo $info['week_two_H'];?>"></td>
      </tr>
  

    <tr align="center" class="TableControl">
    	<td colspan="4" nowrap>
    	<input type="button" value="保存" class="BigButtonBHover" onClick="sendForm();">&nbsp;
 
	    </td>
  </tr>
 </table>
  
</form>

 
</body>
</html>
