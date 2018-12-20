<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta content="IE=7" http-equiv="X-UA-Compatible" /> 
    <title>&nbsp; 文件首页列表</title>
    <link href="StyleSheet.css" rel="stylesheet" type="text/css" />
    <script language="javascript" type="text/javascript" src="ntko.js"></script>
    <script type="text/javascript">
        function showFileEditPage(URL,tWidth,tHeight)
        {
	        dlgFeatures = "dialogWidth:950px;dialogHeight:850px;resizable:yes;center:yes;location:no;status:no;";
	        window.showModalDialog(URL,"",dlgFeatures);
	        window.location.reload();
        }
     </script>
</head>
<body>
    <div id="default" class="divdefault">
        <div id="top" class="top">
        <img src="images/index_banner.jpg" alt="ntko文档控件示例"/>
        </div>
        <div id="maindiv_top" class="maindiv_top">
                <div id="index_button_div" class="index_button_div">
                <a href='javascript:showFileEditPage("FileEdit.php?fileType=word",1100,800);'><img border="0" alt="创建新的word文档" src="images/index_button_word.gif" /></a>
                <a href='javascript:showFileEditPage("FileEdit.php?fileType=excel",1100,800);'><img border="0" alt="创建新的excel文档" src="images/index_button_xls.gif" /></a>
                <a href='javascript:showFileEditPage("FileEdit.php?fileType=ppt",1100,800);'><img border="0" alt="创建新的PPT文档" src="images/index_button_ppt.gif"/></a>
                <a href="示例帮助.html" ><img border="0" class="help" alt="示例程序帮助文档" src="images/demohelp.jpg"/></a>
                </div>
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td><img src="images/index_main_top.gif"  alt="文件列表上框" /></td>
                </tr>
                <tr>
                    <td class="tablebackground"></td>
                </tr>
            </table>
       </div>
       <div id="maindiv_middle" class="maindiv_middle">
           <div id="wordlist" class="officelist">
           <span>OFFICE文件列表:</span>
               <table class="tabletitle">
                   <tr><td width="25%">文&nbsp;件&nbsp;标&nbsp;题</td><td width="30%">文&nbsp;件&nbsp;类&nbsp;型</td><td width="20%">文&nbsp;件&nbsp;大&nbsp;小</td><td width="25%">相&nbsp;关&nbsp;操&nbsp;作</td></tr>
                     <?php

                              require 'connectionInfo.php';//添加引用文件
                              mb_internal_encoding('utf-8');

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
                           echo '<tr><td>'.$row['filename'].'</td><td>'.$row['filetype'].'</td><td>'.$row['filesize'].'</td><td><a href="javascript:showFileEditPage(\'FileEdit.php?FileId='.$row['id'].'\',900,800);">编辑</a></td></tr>';
                       }
                       ?>
		    <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
               </table>
               <table>
               <!--office文件列表-->
               </table>
           </div>
           <div id="htmllist" class="officelist">
           <span>HTML文件列表:</span>
            <table class="tabletitle">
               <tr><td width="25%">文&nbsp;件&nbsp;序&nbsp;号</td><td width="30%">文&nbsp;件&nbsp;标&nbsp;题</td><td width="20%">文&nbsp;件&nbsp;大&nbsp;小</td><td width="25%">相&nbsp;关&nbsp;操&nbsp;作</td></tr>
           	<?php
 		  $query = 'select * from '.$htmlFileInfoTableName;
 	 	  $DB->query($query);
 		  $rs = $DB->sql_result();
  		  while ($row = mysql_fetch_array($rs,MYSQL_BOTH)) {
                   echo "<tr><td>{$row['id']}</td><td>{$row['filename']}</td><td>{$row['filesize']}</td><td><a href=\"{$row['filename']}\" target=htmlfile>查看</a></td></tr>";
 		  }
		?>
		 <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>

	    </table>
           <table>
                <!--HTML文件列表数据-->
           </table>
           </div>
           <div id="pdflist" class="officelist">
           <span>PDF文件列表:</span>
            <table class="tabletitle">
               <tr><td width="25%">文&nbsp;件&nbsp;序&nbsp;号</td><td width="30%">文&nbsp;件&nbsp;标&nbsp;题</td><td width="20%">文&nbsp;件&nbsp;大&nbsp;小</td><td width="25%">相&nbsp;关&nbsp;操&nbsp;作</td></tr>

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

           </table>
           </div>
       </div>
       <div id="maindiv_bottom" class="maindiv_bottom">
       <img alt="" src="images/index_main_nether.jpg" />
           <div id="conmpanyinfo" class="conmpanyinfo">
            <img alt="重庆软航科技有限公司" src="images/Companyinfo.jpg" />
            <p>技术支持详见公司网站www.ntko.com “联系我们”</p>
            </div>
       </div>
    </div>
</body>
</html>
