<?php
    header("content-type:text/html;charset=utf-8");
    require 'connectionInfo.php';
?>

<?php
//实现方式不包括删除重复的文件，而是不让他们重名。
//    print 'hello!';
    $fileId = 0 ;
	$fileSize = 0;
	$fileName = "" ;
	$otherData ="";
	$attachFileDescribe ="" ;
	$attachFileName = "" ;
	$fileType ="";
	$mySqlStr = "";
	$result = "";
    $isChangeAttach = false;
	$isNewRecode = false ;
	if($_POST['Fileurl']!=''){
		$relativeOfficeFileUrl ='../'.$_POST['Fileurl'];
	}
    if(array_key_exists('upLoadFile', $_FILES)&&is_uploaded_file($_FILES['upLoadFile']['tmp_name'])){
        //是否有上传的文件
//        print 'statement1';
        if($_FILES['upLoadFile']['size']<1024*1024*4){
            $fileSize = $_FILES['upLoadFile']['size'];
            if(array_key_exists('fileId', $_POST)&&$_POST['fileId']!=''){
                $fileId = $_POST['fileId'];
            }
            //是否有上传的附件
            if(array_key_exists('attachFile',$_FILES)){
                 $attachfilenamedisk = $_FILES['attachFile']['name'];
                 //转换保存文件的格式
                 $attachfilenamedisk1 =  mb_convert_encoding($attachfilenamedisk, "GB2312", "UTF-8");
                 //mb_convert_encoding 需要安装扩展库才行
                 //把上传的附件保存到磁盘上
                 $uploadattachdir = $relativeAttachFileUrl.$attachfilenamedisk;
                 /*如果该位置已经有文件则删除*/
		   //用于拼的sql
                 $sqlattachfilenamedisk = ', attachfilenamedisk=\''.$attachfilenamedisk.'\'';
		   //删除这个位置上的文件
                  if (move_uploaded_file($_FILES['attachFile']['tmp_name'], $relativeAttachFileUrl.$attachfilenamedisk1)){
                      print '保存附件到'.$uploadattachdir;
                  }else{
                      print '上传附件失败！';
                  }
                 //是否有attachFileDescribe  附件备注
                if(array_key_exists('attachFileDescribe', $_POST)){
                    $attachFileDescribe = $_POST['attachFileDescribe'];
                    $attachFileDescribe=$attachFileDescribe==''?'请输入附件描述':$attachFileDescribe;
                    $sqlattachfiledescribe =',attachfiledescribe=\''.$attachFileDescribe.'\'';
                }
            }
            //是否有fileType            文件类型
            if(array_key_exists('fileType',$_POST)){
                $fileType = $_POST['fileType'];
            }
            //是否有fileName            文件名
            if(array_key_exists('fileName',$_POST)){
                $fileName=trim($_POST['fileName']);
                $sqlfilename = 'filename=\''.$fileName.'\' ,';
            }
            //是否有otherdata           其他数据
            if(array_key_exists('otherData',$_POST)){
               $otherData = $_POST['otherData'];
               //$otherData = otherData==''?'请输入附加数据':$otherData;
               $sqlotherData = 'otherdata=\''.$otherData.'\',';
            }
            //看是否是用于编辑的文件，从而重新选择不同的sql语句。
			$rowe = $db->fetch_one_array("SELECT * FROM toa_".$officeFileInfoTableName."  WHERE id = '$fileId'");
			if($rowe['id']==''){
				$rowes = $db->fetch_one_array("SELECT id FROM toa_".$officeFileInfoTableName."  WHERE filetype = '".$fileType."' and filenamedisk = '".$fileName."'");
				if($rowes['id']==''){
					$ntkoofficefile = array(
						'filename' => $fileName,
						'fileSize' => $fileSize,
						'otherData' => $otherData,
						'filetype' => $fileType,
						'filenamedisk' => $attachfilenamedisk,
						'attachfilenamedisk' => $attachfilenamedisk,
						'attachfiledescribe' => $attachFileDescribe
					);
					//写入主表信息
					insert_db('ntkoofficefile',$ntkoofficefile);
					$fileId=$db->insert_id();
					$fileoffice = array(
						'number' => $_POST['filenumber'],
						'fileid' => $fileId,
						'filetype' => 1,
						'officetype' => $_POST['officetype'],
						'filename' => $fileName,
						'uid' => $_POST['uid'],
						'date' => $_POST['date']
					);
					insert_db('fileoffice',$fileoffice);
				}else{
					$fileId=$rowes['id'];
				}
			}else{
				$ntkoofficefile = array(
					'filename' => $fileName,
					'fileSize' => $fileSize,
					'otherData' => $otherData,
					'filetype' => $fileType,
					'filenamedisk' => $attachfilenamedisk,
					'attachfilenamedisk' => $attachfilenamedisk,
					'attachfiledescribe' => $attachFileDescribe
				);
				update_db('ntkoofficefile',$ntkoofficefile, array('id' =>$fileId));
				
			}
			//$officefileNameDisk = $fileId.'officefile'.$fileName;
			$officefileNameDisk = $fileName;
			$updatefile = array(
					'filenamedisk' => $officefileNameDisk
				);
			update_db('ntkoofficefile',$updatefile, array('id' =>$fileId));
            $uploadofficefile = $relativeOfficeFileUrl.$officefileNameDisk;
            unlink($uploadofficefile);
              //mb_convert_encoding 需要安装扩展库才行
                if (move_uploaded_file($_FILES['upLoadFile']['tmp_name'],mb_convert_encoding($uploadofficefile, "GB2312", "UTF-8"))){
                        $htmlFileName = $FILES['upLoadFile']['name'];
						
                 }else{
                        print "文件".$_FILES['upLoadFile']['name'].'保存错误！';
                 }
        }else{
            print '文件过大';
        }
    }else{
        print '并未上传文件或文件并不是上传的文件';
    }
?>