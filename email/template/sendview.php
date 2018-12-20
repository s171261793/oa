<!DOCTYPE html>
<!--[if IE 6 ]> <html class="ie6 lte_ie6 lte_ie7 lte_ie8 lte_ie9"> <![endif]--> 
<!--[if lte IE 6 ]> <html class="lte_ie6 lte_ie7 lte_ie8 lte_ie9"> <![endif]--> 
<!--[if lte IE 7 ]> <html class="lte_ie7 lte_ie8 lte_ie9"> <![endif]--> 
<!--[if lte IE 8 ]> <html class="lte_ie8 lte_ie9"> <![endif]--> 
<!--[if lte IE 9 ]> <html class="lte_ie9"> <![endif]--> 
<!--[if (gte IE 10)|!(IE)]><!--><html><!--<![endif]-->
 <head>
    <title>邮件系统</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=10,chrome=1" />
</head>
<link rel="stylesheet" type="text/css" href="template/default/email/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="template/default/email/css/style.css" />
<script type="text/javascript" src="template/default/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="template/default/js/bootstrap.min.js"></script>

<body >	
  <div class="read_email_head bodycolor">

  <table width="96%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tablenoborder email_head ">
    <tr>
      <td height="50" colspan="2" class="subject" style="font-size:22px; font-weight:900; line-height:40px;">
      <?php echo $row['subject'];?></td>
      </tr>
    <tr>
      <td width="8%">发 件 人：</td>
      <td width="92%" height="25"><?php echo get_realname($row['user']);?></td>
    </tr>
	<tr>
      <td>收 件 人：</td>
      <td height="25" ><?php echo trim($row['receuser']);?></td>
    </tr>
	<tr>
      <td>抄 送 人：</td>
      <td height="25" ><?php echo trim($row['ccuser']);?></td>
    </tr>
	<tr>
      <td>密 送 人：</td>
      <td height="25" ><?php echo trim($row['bssuser']);?></td>
    </tr>
    <tr>
      <td class="time">发送日期：</td>
      <td height="25" class="time">
         <?php echo $row['date'];?></td>
    </tr>
	<?php if($row['appendix']!=''){?>
	<tr>
      <td class="time">附件下载：</td>
      <td height="25" class="time">
         <?php
		 $appendix=explode('||',substr($row['appendix'], 0, -1));
		 for($i=0;$i<sizeof($appendix);$i++){
		 	$appendixs=explode('|',$appendix[$i]);
			echo '<a href="downurl.php?urls='.$appendixs[1].'&filename='.urlencode($appendixs[0]).'">'.$appendixs[0].'</a>&nbsp;&nbsp;&nbsp;&nbsp;';
		 }
		 ?></td>
    </tr>
	<?php }?>
  </table>
  </div>

 <div style="margin:10px 0px 10px 5px;min-height:75px;font-size:12pt;" id="contentText"><?php echo $row['content'];?></div><!--line-height:20px;-->


 
<br>
</body>

</html>