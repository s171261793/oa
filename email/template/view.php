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
   <div class="clearfix" style="float:right; margin-right:40px;">
   <ul id="email-action-list-inbox-single" class="email-action-group inline pull-left">
                    <li> 
                        <div class="btn-group">
		
                          <button type="button" data-cmd="reply" class="btn blue" onClick='window.open("admin.php?ac=email&fileurl=email&do=add&sendid=<?php echo $row['sendid']?>&type=1","_self");'><i class="email-action-icon-reply"></i>回复</button>
                          <button type="button" data-cmd="reply_all" class="btn" onClick='window.open("admin.php?ac=email&fileurl=email&do=add&sendid=<?php echo $row['sendid']?>&type=2","_self");'><i class="email-action-icon-replyall"></i>回复全部</button>
                          <button type="button" data-cmd="forward" class="btn" onClick='window.open("admin.php?ac=email&fileurl=email&do=add&sendid=<?php echo $row['sendid']?>&type=3","_self");'><i class="email-action-icon-forward"></i>转发</button>
                        </div>
                    </li>
                    <li> 
                        <div class="btn-group">
                            <button type="button" data-cmd="delete" class="btn red"><i class="email-action-icon-del"></i>删除</button>
                            <button class="btn dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="admin.php?ac=email&do=update&fileurl=email&id=<?php echo $row['id']?>&type=2" data-cmd="delete"  title="回收站">回收站</a>
                                </li>
                                <li>
                                    <a href="admin.php?ac=email&do=update&fileurl=email&id=<?php echo $row['id']?>&type=1" data-cmd="destory"  title="切底删除">切底删除</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    
                    <li> 
                        <div class="btn-group">
                            <button class="btn dropdown-toggle" data-toggle="dropdown">
                                <i class="email-action-icon-more"></i>
                                移动到    <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                               <?php
								$sql = "SELECT * FROM ".DB_TABLEPRE."emailtype where uid='".$_USER->id."' ORDER BY number asc";
								$result = $db->query($sql);
								while ($rows = $db->fetch_array($result)) {
								?>
                                <li>
                                    <a href="admin.php?ac=email&do=type&fileurl=email&id=<?php echo $row['id']?>&typeid=<?php echo $rows['id']?>&title=<?php echo $rows['title']?>" data-cmd="export_excel"  title="将邮件移动到<?php echo $rows['title']?>"><?php echo $rows['title']?></a>
                                </li>
                             <?php }?>   
                            </ul>
                        </div>
         
                    </li>
     </ul>   

</div>
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
      <td height="25" ><?php echo get_realname($row['receuser']);?></td>
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