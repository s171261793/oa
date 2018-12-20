<?php
    require 'connectionInfo.php';
?>
<?php
        //实现方式不包括删除重复的文件，而是不让他们重名。
                    $uploaddir = $relativeHtmlFileUrl;
                    if (array_key_exists('uploadHtml', $_FILES)){
                         if($_FILES['uploadHtml']['size']<1024*1024*4){
                            $mResult = 0;
                            $mSql = 'select max(id)+1 as MaxID from '.$htmlFileInfoTableName.';';
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
                            $uploadfile = $uploaddir.$mResult.'.'.$_FILES['uploadHtml']['name'];

                            if (is_uploaded_file($_FILES['uploadHtml']['tmp_name'])){
                                if (move_uploaded_file($_FILES['uploadHtml']['tmp_name'], mb_convert_encoding($uploadfile, "GB2312", "UTF-8"))){
                    //                print '大小为：（'.$_FILES['uploadHtml']['size'].')';
                                    $$htmlFileName = $FILES['uploadHtml']['name'];
                    //                print "成功保存文件:".$_FILES['uploadHtml']['name'].".大小:".$_FILES['uploadHtml']['size']."字节<br>";
    //                                $DB = new mysql_db();
    //                                $DB->sql_connect('127.0.0.1:3306', $sqlname, $sqlpw, $dbname); //建立一个新连接
                                    $SqlStr='insert into '.$htmlFileInfoTableName.'(id,FileName,filepath,fileSize)values('.$mResult.',"'.$uploadfile.'","'.$uploaddir.'",'.$_FILES['uploadHtml']['size'].')';

                                    $rs = $DB->query($SqlStr);
                                    $DB->sql_close();
                            }else{
                                print "文件".$_FILES['htmlFileName']['name'].'保存错误！';
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
