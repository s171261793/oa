<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
<script language="javascript" type="text/javascript" src="DatePicker/WdatePicker.js"></script>
<script src="template/default/tree/js/admincp.js?SES" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="template/default/js/jquery.min.js"></script>
<script charset="utf-8" src="eweb/kindeditor.js"></script>
<script type="text/javascript"> 
function show_help()
{
   mytop=(screen.availHeight-430)/2;
   myleft=(screen.availWidth-800)/2;
   window.open("admin.php?ac=view&fileurl=help&helpid=<?php echo $fileurl?>","","height=470,width=800,status=0,toolbar=no,menubar=no,location=no,scrollbars=yes,top="+mytop+",left="+myleft+",resizable=yes");
}
filenumber_show()
function filenumber_show()
{
   jQuery.ajax({
      type: 'GET',
      url: 'admin.php?ac=file&fileurl=public&filenumber=<?php echo $filenumber?>&officetype=4&'+new Date(),
      success: function(data){
		  if(data!=''){
			  $("#filenumber").html(data);
		  }else{
		  	  <? if($blog['id']==''){?>
			  $("#filenumber").html('还没有附件!');
			  <? }?>
		  }
      }
   });
}
</script>
<title>Office 515158 2011 OA办公系统</title>
 
</head>
<body>
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 查询<?php echo $human_type_name?>信息</span>&nbsp;&nbsp;&nbsp;&nbsp;
	<span style="font-size:12px; float:right;margin-right:20px;">
	
	<a href="admin.php?ac=humanlist&fileurl=<?php echo $fileurl?>&type=<?php echo $type?>" style="font-size:12px;"><<返回列表页</a></span>
    </td>
  </tr>
</table>

<form name="save" method="post" action="#">
	<table class="TableBlock" width="90%" align="center">
  <tr>
    <td nowrap class="TableHeader" colspan="6"><b>&nbsp;基本信息</b></td>
  </tr>
   <tr>
    <td nowrap align="left" width="120" class="TableContent">OA用户名：</td>
    <td nowrap align="left" class="TableData" width="180"><?php echo get_realusername($blog['userid'],'username')?></td>
    <td nowrap align="left" width="120" class="TableContent">权限组：</td>
    <td class="TableData"  colspan="2"><?php echo get_groupname(get_realusername($blog['userid'],'groupid'))?></td>
    <td class="TableData" align="center" rowspan="6" colspan="1">
<div class="avatar"><img src="<?php echo get_human_db($blog['id'],"toa_1_56")?>" width=130></div>
    </td>           
  </tr>
  <tr>
  	<td nowrap align="left" width="120" class="TableContent">编号：</td>
    <td nowrap align="left" class="TableData" width="180"><?php echo $blog['number']?></td>  
    <td nowrap align="left" width="120" class="TableContent">岗位：</td>
    <td class="TableData" width="180" colspan="2"><?php echo get_postname(get_realusername($blog['userid'],'positionid'))?></td>          
  </tr>
  <tr>
  	<td nowrap align="left" width="120" class="TableContent">姓名：</td>
    <td class="TableData" width="180"><?php echo get_human_db($blog['id'],"toa_1_1")?></td>  	
    <td nowrap align="left" width="120" class="TableContent">部门：</td>
    <td class="TableData" width="180" colspan="2"><?php echo get_realdepaname(get_realusername($blog['userid'],'departmentid'))?></td>         
  </tr>
  <tr>
  <td nowrap align="left" width="120" class="TableContent">英文名：</td>
    <td class="TableData" width="180"><?php echo get_human_db($blog['id'],"toa_1_2")?></td>  
    <td nowrap align="left" width="120" class="TableContent">性别：</td>
    <td class="TableData" width="180" colspan="2"><?php echo get_human_db($blog['id'],"toa_1_3")?></td>  
   </tr>
   <tr>       
  	<td nowrap align="left" width="120" class="TableContent">身份证号：</td>
    <td class="TableData" width="180" ><?php echo get_human_db($blog['id'],"toa_1_4")?></td>  
    <td nowrap align="left" width="120" class="TableContent">出生日期：</td>
    <td class="TableData" width="180" colspan="2"><?php echo get_human_db($blog['id'],"toa_1_5")?></td>             
  </tr>
  
  <tr>
    <td nowrap align="left" width="120" class="TableContent">年龄：</td>
    <td class="TableData" width="180"><?php echo get_human_db($blog['id'],"toa_1_6")?></td>
    <td nowrap align="left" width="120" class="TableContent">婚姻状况：</td>
    <td class="TableData" width="180"  colspan="2"><?php echo get_human_db($blog['id'],"toa_1_7")?></td>      
  </tr>
  <tr>
    <td nowrap align="left" width="120" class="TableContent">籍贯：</td>
    <td class="TableData" width="180" ><?php echo get_human_db($blog['id'],"toa_1_8")?></td>    
    <td nowrap align="left" width="120" class="TableContent">民族：</td>
    <td class="TableData" width="180" colspan="3"><?php echo get_human_db($blog['id'],"toa_1_9")?></td>            
  </tr>   
  <tr>
    <td nowrap align="left" width="120" class="TableContent">健康状况：</td>
    <td class="TableData"  width="180" ><?php echo get_human_db($blog['id'],"toa_1_10")?></td>
    <td nowrap align="left" width="180" class="TableContent">年休假:</td>
    <td class="TableData"  width="180" colspan="3"><?php echo get_human_db($blog['id'],"toa_1_11")?>天</td> 
  </tr>  
  <tr>
    <td nowrap align="left" width="120" class="TableContent">政治面貌：</td>
    <td class="TableData" width="180"><?php echo get_human_db($blog['id'],"toa_1_57")?></td>
    <td nowrap align="left" width="180" class="TableContent">入党时间：</td>
    <td class="TableData"  width="180" colspan="3"><?php echo get_human_db($blog['id'],"toa_1_13")?></td>
  </tr>
  <tr>
  	<td nowrap align="left" width="120" class="TableContent">户口类别：</td>
    <td class="TableData"  width="180"><?php echo get_human_db($blog['id'],"toa_1_14")?></td>
    <td nowrap align="left" width="180" class="TableContent">户口所在地:</td>
    <td class="TableData"  width="180" colspan="3"><?php echo get_human_db($blog['id'],"toa_1_15")?></td> 
  </tr>
  <tr>
    <td nowrap class="TableHeader" colspan="6"><b>&nbsp;职位情况及联系方式：</b></td>
  </tr>
  <tr>
  	<td nowrap align="left" width="120" class="TableContent">工种：</td>
    <td class="TableData"  width="180"><?php echo get_human_db($blog['id'],"toa_1_16")?></td>
    <td nowrap align="left" width="180" class="TableContent">行政级别：</td>
    <td class="TableData"  width="180"><?php echo get_human_db($blog['id'],"toa_1_17")?></td>
    <td nowrap align="left" width="180" class="TableContent">员工类型:</td>
    <td nowrap align="left" width="180" class="TableData"><?php echo get_human_db($blog['id'],"toa_1_18")?></td>
    </tr>
  <tr>
    <td nowrap align="left" width="120" class="TableContent">职务：</td>
    <td class="TableData"  width="180"><?php echo get_human_db($blog['id'],"toa_1_19")?></td>
    <td nowrap align="left" width="180" class="TableContent">职称：</td>
    <td class="TableData"  width="180"><?php echo get_human_db($blog['id'],"toa_1_20")?></td>
    <td nowrap align="left" width="180" class="TableContent">入职时间：</td>
    <td nowrap align="left" width="180" class="TableData"><?php echo get_human_db($blog['id'],"toa_1_21")?></td>
    </tr>
  <tr>
    <td nowrap align="left" class="TableContent">职称级别：</td>
    <td class="TableData"><?php echo get_human_db($blog['id'],"toa_1_22")?></td>   	
    <td nowrap align="left" class="TableContent">岗位：</td>
    <td class="TableData" colspan="3"><?php echo get_human_db($blog['id'],"toa_1_23")?></td>  	
  </tr>  
  <tr>
    <td nowrap align="left" width="120" class="TableContent">本单位工龄:</td>
    <td class="TableData"  width="180"><?php echo get_human_db($blog['id'],"toa_1_24")?></td>
    <td nowrap align="left" width="180" class="TableContent">起薪时间:</td>
    <td class="TableData"  width="180"><?php echo get_human_db($blog['id'],"toa_1_25")?></td>
    <td nowrap align="left" width="180" class="TableContent">在职状态:</td>
    <td nowrap align="left" width="180" class="TableData"><?php echo get_human_db($blog['id'],"toa_1_26")?></td>
    </tr>
  <tr>
    <td nowrap align="left" width="120" class="TableContent">总工龄：</td>
    <td class="TableData"  width="180"><?php echo get_human_db($blog['id'],"toa_1_27")?></td>
    <td nowrap align="left" width="180" class="TableContent">参加工作时间：</td>
    <td class="TableData"  width="180"><?php echo get_human_db($blog['id'],"toa_1_28")?></td>
    <td nowrap align="left" width="180" class="TableContent">联系电话：</td>
    <td nowrap align="left" width="180" class="TableData"><?php echo get_human_db($blog['id'],"toa_1_29")?></td>
    </tr>     
  <tr>        
    <td nowrap align="left" width="120" class="TableContent">手机号码：</td>
    <td class="TableData"  width="180" ><?php echo get_human_db($blog['id'],"toa_1_30")?></td>
    <td nowrap align="left" width="180" class="TableContent">小灵通：</td>
    <td class="TableData"  width="180"><?php echo get_human_db($blog['id'],"toa_1_31")?></td>
    <td nowrap align="left" width="180" class="TableContent">MSN：</td>
    <td nowrap align="left" width="180" class="TableData"><?php echo get_human_db($blog['id'],"toa_1_32")?></td>
    </tr>
<tr>
    <td nowrap align="left" width="120" class="TableContent">电子邮件：</td>
    <td class="TableData"  width="180"><?php echo get_human_db($blog['id'],"toa_1_33")?></td>
    <td nowrap align="left" width="180" class="TableContent">家庭地址：</td>
    <td class="TableData"  width="180" colspan="3"><?php echo get_human_db($blog['id'],"toa_1_34")?></td>                
  </tr>  
  <tr>     
    <td nowrap align="left" width="120" class="TableContent">QQ：</td>
    <td class="TableData"  width="180"><?php echo get_human_db($blog['id'],"toa_1_35")?></td> 
    <td nowrap align="left" width="180" class="TableContent">其他联系方式：</td>
    <td class="TableData"  width="180" colspan="3"><?php echo get_human_db($blog['id'],"toa_1_36")?></td>                
  </tr>
  <tr>
    <td nowrap class="TableHeader" colspan="6"><b>&nbsp;教育背景：</b></td>
  </tr>              
  <tr>
    <td nowrap align="left" width="120" class="TableContent">学历：</td>
    <td class="TableData"  width="180"><?php echo get_human_db($blog['id'],"toa_1_37")?></td>
    <td nowrap align="left" width="180" class="TableContent">学位：</td>
    <td class="TableData"  width="180"><?php echo get_human_db($blog['id'],"toa_1_38")?></td>
    <td nowrap align="left" width="180" class="TableContent">毕业时间：</td>
    <td nowrap align="left" width="180" class="TableData"><?php echo get_human_db($blog['id'],"toa_1_39")?></td>
    </tr>       
  <tr>
    <td nowrap align="left" width="120" class="TableContent">毕业学校：</td>
    <td class="TableData"  width="180"><?php echo get_human_db($blog['id'],"toa_1_40")?></td>
    <td nowrap align="left" width="180" class="TableContent">专业：</td>
    <td nowrap class="TableData"  width="180"><?php echo get_human_db($blog['id'],"toa_1_41")?></td>
    <td nowrap align="left" width="180" class="TableContent">计算机水平：</td>
    <td nowrap align="left" width="180" class="TableData"><?php echo get_human_db($blog['id'],"toa_1_42")?></td>
    </tr>       
  <tr>
    <td nowrap align="left" width="120" class="TableContent">外语语种1：</td>
    <td class="TableData"  width="180"><?php echo get_human_db($blog['id'],"toa_1_43")?></td>
    <td nowrap align="left" width="180" class="TableContent">外语语种2：</td>
    <td class="TableData"  width="180"><?php echo get_human_db($blog['id'],"toa_1_44")?></td>
    <td nowrap align="left" width="180" class="TableContent">外语语种3：</td>
    <td nowrap align="left" width="180" class="TableData"><?php echo get_human_db($blog['id'],"toa_1_45")?></td>
    </tr>       
  <tr>
    <td nowrap align="left" width="120" class="TableContent">外语水平1：</td>
    <td class="TableData"  width="180"><?php echo get_human_db($blog['id'],"toa_1_46")?></td>
    <td nowrap align="left" width="180" class="TableContent">外语水平2：</td>
    <td class="TableData"  width="180"><?php echo get_human_db($blog['id'],"toa_1_47")?></td>
    <td nowrap align="left" width="180" class="TableContent">外语水平3：</td>
    <td nowrap align="left" width="180" class="TableData"><?php echo get_human_db($blog['id'],"toa_1_48")?></td>
    </tr>  
  <tr>
    <td nowrap align="left" width="120" class="TableContent">特长：</td>
    <td class="TableData"  width="180" colspan="5"><?php echo get_human_db($blog['id'],"toa_1_49")?></td>             
  </tr>
  <tr>
    <td nowrap colspan="3" class="TableHeader">职务情况：</td>
    <td nowrap colspan="3" class="TableHeader">担保记录：</td> 
  </tr>
  <tr>
    <td class="TableData" colspan="3" style="vertical-align:top;"><?php echo get_human_db($blog['id'],"toa_1_50")?></td>
    <td class="TableData" colspan="3" style="vertical-align:top;"><?php echo get_human_db($blog['id'],"toa_1_51")?></td>
  </tr>
  <tr>
  	<td nowrap class="TableHeader" colspan="3"><b>&nbsp;社保缴纳情况：</b></td>
  	<td nowrap class="TableHeader" colspan="3"><b>&nbsp;体检记录：</b></td>
  </tr>
  <tr>
    <td class="TableData" colspan="3" style="vertical-align:top;"><?php echo get_human_db($blog['id'],"toa_1_52")?></td>
    <td class="TableData" colspan="3" style="vertical-align:top;"><?php echo get_human_db($blog['id'],"toa_1_53")?></td>
  </tr>           
  <tr>
    <td nowrap align="left" colspan="6" class="TableHeader">备注：</td>
  </tr>   
  <tr>
    <td nowrap class="TableData" colspan="6" style="vertical-align:top;"><?php echo get_human_db($blog['id'],"toa_1_54")?></td>               
  </tr> 
  <tr>
    <td nowrap align="left" class="TableHeader" colspan="6">简历:</td>                
  </tr>
  </table>	
	<table  width="90%" style="border-left:#4686c6 solid 1px;border-right:#4686c6 solid 1px;" align="center">	       
  <tr>
    <td nowrap class="TableData" colspan="6" style="vertical-align:top;"><?php echo get_human_db($blog['id'],"toa_1_55")?></td>                 
  </tr>           
  
  
  
                                     
  <tr>
  	<td nowrap  class="TableHeader" colspan="6" id=m2>附件文档：</td>
  </tr>
  <tr>    
    <td nowrap align="left" class="TableData" colspan="6">
	<?php
	global $db;
	$sql = "SELECT * FROM ".DB_TABLEPRE."fileoffice WHERE officeid='".$blog['id']."' and officetype='4' and filetype='2' ORDER BY id desc";
	$result = $db->query($sql);
	while ($row = $db->fetch_array($result)) {	
		echo '<a href="down.php?urls='.$row['fileaddr'].'">'.$row['filename'].'</a>&nbsp;&nbsp;&nbsp;&nbsp;上传人：'.get_realname($row['uid']).'&nbsp;&nbsp;&nbsp;&nbsp;上传时间：'.$row['date'].'<br>';
	}
	
	?>
	
	</td>
  </tr> 
        
   
</table>

	
	
	
	
	
	
	
	
	
<table class="TableBlock" border="0" width="90%" align="center">
 
    <tr align="center" class="TableControl">
      <td colspan="2" nowrap height="35">
<!-- onclick="sendForm();" -->
		<input type="button" name="Submit" value="保存信息" class="BigButtonBHover" onclick="sendForm();">      </td>
    </tr>
  </table>
</form>

 
</body>
</html>
