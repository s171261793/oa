<?php
    require 'connectionInfo.php';

?>
<?php

        //实现方式不包括删除重复的文件，而是不让他们重名。
                    $uploaddir = $relativePdfFileUrl;
                    if (array_key_exists('uploadPdf', $_FILES)){
                         if($_FILES['uploadHtml']['size']<1024*1024*4){
                            $mResult = 0;
                            $mSql = 'select max(id)+1 as MaxID from '.$pdfFileInfoTableName.';';
                            $DB = new mysql_db();
                            $DB->sql_connect($ip, $sqlname, $sqlpw, $dbname); //建立一个新连接
                            $DB->query($mSql);
                            $rs = $DB->sql_result();
                            while($row = mysql_fetch_array($rs,MYSQL_BOTH)){
                                 $mResult = $row['MaxID'];
                                if($mResult==0){
                                    $mResult = 1;
                                }
                            }
                            $uploadfile = $uploaddir.$mResult.'.'.$_FILES['uploadPdf']['name'];
                            if (is_uploaded_file($_FILES['uploadPdf']['tmp_name'])){
                                    $uploadfile1 = mb_convert_encoding($uploadfile, "GB2312", "UTF-8");
                                if (move_uploaded_file($_FILES['uploadPdf']['tmp_name'], $uploadfile1)){
//                                    print '大小为：（'.$_FILES['uploadPdf']['size'].')';
                                    $pdfFileName = $_FILES['uploadPdf']['name'];
					  $pdffileSize = $_FILES['uploadPdf']['size'];
                                    print "成功保存文件:".$_FILES['uploadPdf']['name'].".大小:".$_FILES['uploadPdf']['size']."字节<br>";
                                    $SqlStr='insert into '.$pdfFileInfoTableName.' (id,pdffilename,pdffilepath,filesize)values('.$mResult.',"'.$pdfFileName.'","'.$uploadfile.'",'.$pdffileSize.')';

//                                    print $SqlStr;
                                    $rs = $DB->query($SqlStr);
//                                    print $rs;
                                    $DB->sql_close();
                            }else{
                                print "文件".$_FILES['uploadPdf']['name'].'保存错误！';
                            }
                    }else{
                        echo '不为上传文件';
                    }
         }else{
             print "没有上传的文件。";
         }
    }else{
        echo 'invalid file size';
    }
?>