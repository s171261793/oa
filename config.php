<?php
 define('DB_HOST','localhost');	//数据库主机地址，一般为localhost
// define('DB_HOST','59.110.161.235');	//数据库主机地址，一般为localhost

define('DB_USER','root'); 			//数据库用户名

// define('DB_PWD','admin123');		//数据库密码

define('DB_PWD','');		//数据库密码


define('DB_NAME','toa');	//数据库名称

define('DB_TABLEPRE','toa_');	//数据表前缀

define('DB_PCONNECT',False);	//是否启用持久连接

define('COOKIE_PRE','toa_');	//COOKIE前缀

define('COOKIE_DOMAIN','');		//COOKIE作用域

define('COOKIE_PATH','/');		//COOKIE作用路径

define('TOA_CHARSET','utf-8');//编码类型

$superadmin = '3';	//超级管理员ID，拥有所有权限，多个用英文逗号“,”分隔。

define('publicunion','phpoa.cn');

define('COOKSHOW','0');

$uniondbtype='1'; //1,集成;2,同步

define('uniondbid','');
?>