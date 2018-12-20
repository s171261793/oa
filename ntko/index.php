<HTML>
<HEAD>
<meta http-equiv="content-type" content="text/html;charset=gb2312">
<TITLE>NTKO Office文档控件PHP示例-MYSQL数据库</TITLE>
<style>
*{font-family:Comic Sans MS;font-size:12px;padding-top:0px ; }
a{color:blue;under-line:none;}
td{border:1 solid #dcdcdc;vertical-align:top;}
</style>
<script type="text/javascript">
function showFileEditPage(URL,tWidth,tHeight)
{
//    alert("可以到这里");
	dlgFeatures = "dialogWidth:"+screen.width+"px;dialogHeight:"+screen.height+"px;resizable:yes;center:yes;location:no;status:no;";
	//window.showModalDialog(URL,"",dlgFeatures);
	window.open(URL,"",dlgFeatures);
	window.location.reload();
}
</script>
</HEAD>
<BODY>


<Center style="width:850px;border:"><h3 style="padding:20px 0px 0px 0px;margin:5px;font-size:18px;">NTKO Office文档控件PHP示例-MYSQL</h3>
重庆软航科技文档控件示例程序<br><br>

<a href='javascript:showFileEditPage("FileEdit.php?fileType=word",900,800);'>新建word文档</a>&nbsp;<a href='javascript:showFileEditPage("FileEdit.php?fileType=excel",900,800);'>新建excel文档</a><br><br>
<div style="text-align:left;">
<div style="width:100%;height:20px;BACKGROUND:#c0c0c0;"><b>OFFICE文档列表</b></div>
<table width=100% align=center border="0" cellpadding="0" cellspacing="0">
<tr><td width=50px;>ID号</td><td width=250px;>文件名称</td><td width=50px;>文件类型</td><td width=200px;>大小</td><td width=50px;>操作</td></tr>

   <?php

        require 'connectionInfo.php';//添加引用文件
//        $query = 'select * from '.$officeFileInfoTableName.'  order by filetype;'; //写入sql语句
          $query = 'select * from '.$officeFileInfoTableName; //写入sql语句
   /* Example */
//<!--读取数据库中的文件-->

   $DB = new mysql_db();//建立数据库辅助类
   $DB->sql_connect($ip, $sqlname, $sqlpw, $dbname);//建立一个新连接
   $DB->query($query);//执行sql
   $rs = $DB->sql_result();
   /* 处理结果集 */
   while ($row = mysql_fetch_array($rs,MYSQL_BOTH)) {
//       echo "<tr><td>{$row['id']}</td><td>{$row['filename']}</td><td>{$row['filetype']}</td><td>{$row['filesize']}</td><td><a href=\'javascript:showFileEditPage(\"FileEdit.php?FileId={{$row['id']}}\",900,800);\' > 编辑 </a></td></tr>";
       echo '<tr><td>'.$row['id'].'</td><td>'.$row['filename'].'</td><td>'.$row['filetype'].'</td><td>'.$row['filesize'].'</td><td><a href="javascript:showFileEditPage(\'FileEdit.php?FileId='.$row['id'].'\',900,800);">编辑</a></td></tr>';
   }
   ?>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
</table><br>
<div style="width:100%;height:20px;BACKGROUND:#c0c0c0;"><b>HTML文档列表</b></div>
<table width=100% align=center border="0" cellpadding="0" cellspacing="0">
<tr><td width=50px>ID号</td><td width=500px>文件名称</td><td width=100px>大小</td><td width=50px>操作</td></tr>
<?php
   $query = 'select * from '.$htmlFileInfoTableName;
   $DB->query($query);
   $rs = $DB->sql_result();
   while ($row = mysql_fetch_array($rs,MYSQL_BOTH)) {
       echo "<tr><td>{$row['id']}</td><td>{$row['filename']}</td><td>{$row['filesize']}</td><td><a href=\"{$row['filename']}\" target=htmlfile>查看</a></td></tr>";
   }

?>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
</table><br>
<div style="width:100%;height:20px;BACKGROUND:#c0c0c0;"><b>PDF文档列表</b></div>
<table width=100% align=center border="0" cellpadding="0" cellspacing="0">
<tr><td width=50px>ID号</td><td width=500px>文件名称</td><td width=100px>大小</td><td width=50px>操作</td></tr>
<?php
    $query = 'select * from '.$pdfFileInfoTableName;
    $DB->query($query);
    $rs = $DB->sql_result();
    while($row = mysql_fetch_array($rs,MYSQL_BOTH)){
       // echo "<tr><td>{$row['id']}</td><td>{$row['pdffilename']}</td><td>{$row['filesize']}</td><td><a href=\"{$row['id']$row['pdffilepath']}\" target=htmlfile>下载</a></td></tr>";
         echo '<tr><td>'.$row['id'].'</td><td>'.$row['pdffilename'].'</td><td>'.$row['filesize'].'</td><td><a href="'.$row['pdffilepath'].'" target=htmlfile>下载</a></td></tr>';
    }


    $DB->sql_close();
?>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
</table><br>

<table width=100% height=120 border=0 CELLPADDING=0 CELLSPACING=0 bgcolor="#dedfde"  style="border-left:1px black #9DC2DB;">
<TR><TD class="copyright" valign="middle" align="center">
官方网站: <a class="leftareadoc" href="HTTP://WWW.NTKO.COM">HTTP://WWW.NTKO.COM</A><BR>
NTKO<font style="font-size:7pt;">&trade;</font>和软航<font style="font-size:7pt;">&trade;</font>是软航科技的商标<BR>
重庆软航科技有限公司[NTKO SOFTWARE]<BR>重庆市南岸区千航网络开发所<BR>&copy版权所有(2003-2008),保留所有权利.
<br><p>技术支持详见公司网站www.ntko.com “联系我们”</p>
</TD></TR>
</table>
</div>
</Center>
</BODY>
</HTML>