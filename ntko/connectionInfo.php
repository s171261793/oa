<?php
	define('IN_TOA',true);
	define('TOA_ROOT',str_replace('\\','/',substr(dirname(__FILE__),0,-7)));
	require_once('../include/class_mysql.php');
	require_once('../config.php');
	$db = new Mysql();
	$db->connect(DB_HOST, DB_USER, DB_PWD, DB_NAME, DB_PCONNECT);
	//插入记录
	function insert_db($table, $data, $replace = false) {
		global $db;
		$keysql = $valsql = '';
		foreach ($data as $key => $val) {
			$keysql .= empty($keysql) ? "`$key`" : ", `$key`";
			$valsql .= empty($valsql) ? "'$val'" : ", '$val'";
		}
		$method = $replace ? 'REPLACE' : 'INSERT';
		$sql = "$method INTO `".DB_TABLEPRE."$table` ($keysql) VALUES ($valsql)";
		$db->query($sql);
		return $db->insert_id();
	}
	//更新记录
	function update_db($table, $value, $where) {
		global $db;
		$updatesql = $wheresql = '';
		foreach ($value as $key => $val) {
			$updatesql .= empty($updatesql) ? " `$key` = '$val'" : ", `$key` = '$val'";
		}
		foreach ($where as $key => $val) {
			$wheresql .= empty($wheresql) ? " `$key` = '$val' " : " AND `$key` = '$val'";
		}
		$sql = "UPDATE `".DB_TABLEPRE."$table` SET $updatesql WHERE $wheresql";
		$db->query($sql);
		return $db->affected_rows();
	}

    //一些配置文件
        $officeFileInfoTableName = 'ntkoofficefile';//officeFileInfoTalbeName
        $htmlFileInfoTableName = 'ntkohtmlfile';//htmlFileInfoTableName
        $pdfFileInfoTableName = 'ntkopdffile';//pdfFileInfoTableName
       /* 
        $ip = 'localhost:3306';
        $sqlname = 'root';//用户名名称
        $sqlpw = '123456';//密码
        $dbname = 'ntko';//数据库名

        //配置路径
        $tempFileDir = "E:\\Apache2.2\\htdocs\\NTKODemoPHP-MySql-UTF-8-OK\\tempFile\\" ;    //临时文件目录
       // $absoluteOfficeFileDir = "G:\\ServerJsp\\officeControlDemo-Oracle\\uploadOfficeFile\\";   //office文档保存绝对路径
        $absoluteOfficeFileDir = "E:\\Apache2.2\\htdocs\\NTKODemoPHP-MySql-UTF-8-OK\\uploadOfficeFile\\";
        $absoluteHtmlFileDir = "E:\\Apache2.2\\htdocs\\NTKODemoPHP-MySql-UTF-8-OK\\uploadHtmlFile\\" ;      //Html文档保存绝对路径
        $absoluteAttachFileDir = "E:\\Apache2.2\\htdocs\\NTKODemoPHP-MySql-UTF-8-OK\\uploadAttachFile\\" ;  //附件保存绝对路径
        $absolutePdfFileDir = "E:\\Apache2.2\\htdocs\\NTKODemoPHP-MySql-UTF-8-OK\\uploadPdfFile\\"   ;       //pdf文档保存绝对路径
		*/
        $relativeOfficeFileUrl = "uploadOfficeFile/" ;  //office文档相对目录
        $relativeHtmlFileUrl = "uploadHtmlFile/" ;      //html文档相对目录
        $relativeAttachFileUrl ="uploadAttachFile/" ;   //附件文件相对目录
        $relativePdfFileUrl = "uploadPdfFile/" ;        //pdf文档相对目录

/*
        //数据库的操作类
        class mysql_db{
      //+================得到结果集======================================================+
        function sql_result(){
                return $this->query_result;
        }
       //+========取得连接，写入对象属性==============================================+
       function sql_connect($sqlserver, $sqluser, $sqlpassword, $database){
           $this->connect_id = mysql_connect($sqlserver, $sqluser, $sqlpassword);
           if($this->connect_id){
               if (mysql_select_db($database)){
                   return $this->connect_id;
               }else{
                   return $this->error();
               }
           }else{
               return $this->error();
           }
       }
       //+===============的到错误信息=======================================+
       function error(){
           if(mysql_error() != ''){
               echo '<b>MySQL Error</b>: '.mysql_error().'<br/>';
           }
       }
       //+=====================写入sql语句=================================+
       function query($query){
           if ($query != NULL){
               $this->query_result = mysql_query($query, $this->connect_id);
               if(!$this->query_result){
                   return $this->error();
               }else{
                   return $this->query_result;
               }
           }else{
               return '<b>MySQL Error</b>: Empty Query!';
           }
       }
       //+=====================得到结果集中的行数=================================+
       function get_num_rows($query_id = ""){
           if($query_id == NULL){
               $return = mysql_num_rows($this->query_result);
           }else{
               $return = mysql_num_rows($query_id);
           }
           if(!$return){
               $this->error();
           }else{
               return $return;
           }
       }
       //+=================返回结果级的一条记录从0开始=====================================+
       function fetch_row($query_id = ""){
           if($query_id == NULL){
               $return = mysql_fetch_array($this->query_result);
           }else{
               $return = mysql_fetch_array($query_id);
           }
           if(!$return){
               $this->error();
           }else{
               return $return;
           }
       }
       //+==================得到执行的记录条数====================================+
       function get_affected_rows($query_id = ""){
           if($query_id == NULL){
               $return = mysql_affected_rows($this->query_result);
           }else{
               $return = mysql_affected_rows($query_id);
           }
           if(!$return){
               $this->error();
           }else{
               return $return;
           }
       }
       //+===========关闭连接===========================================+
       function sql_close(){
           if($this->connect_id){
               return mysql_close($this->connect_id);
           }
       }
	   
       //+======================================================+
  }*/
?>