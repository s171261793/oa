<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>应用管理</title>
<script type="text/javascript" src="template/default/home/lib/js/jquery/jquery-1.8.2.js"></script>
<style type="text/css">
.wrap{ margin-top:10px;}.wrap li{ width:90px; height:120px;  margin-left:8px; margin-top:10px; margin-bottom:10px; float:left; text-align:center; display:inline;}.wrap li h1{ font-size:12px; color:#005eac; line-height:22px; text-align:center; margin-top:5px; font-weight:normal;}.wrap li p{ color:#666; line-height:22px; text-align:center;}.wrap li img{ border:0px;}
</style>
<script type="text/javascript">
//这里数据需动态读取
var appData=[
			<?php
			$sql = "SELECT * FROM ".DB_TABLEPRE."menu where fatherid!=0 and menutype='2' ORDER BY menunum asc";
			$query = $db->query($sql);
			$htmlview='';
			while ($row = $db->fetch_array($query)) {
				if($row['keytable']!=''){
					if(is_superadmin() || check_purview($row['keytable'])){
						if ( file_exists('template/default/ico/'.$row['menuid'].'.png') ) {
							$row['icoid']=$row['menuid'];
						}else{
							$row['icoid']='0';
						}
						if(sizeof(explode('"'.$row['menuid'].'"',$bghome['homemana']))>1){
							//$picvalue=1;
						}else{
							//$picvalue=0;
						
						$htmlview.="{";
						$htmlview.="'iconSrc':'template/default/ico/".$row['icoid'].".png', "; 	   
						$htmlview.="'windowsId':'menu".$row['menuid']."', ";  
						$htmlview.="'windowTitle':'".$row['menuname']."',";
						$htmlview.="'iframSrc':'".$row['menuurl']."',";
						//$htmlview.="'picvalue':".$picvalue.",";
						$htmlview.="'windowWidth':500,";
						$htmlview.="'windowHeight':500"; 
						$htmlview.="},";
					 }
					}
				}else{
					if ( file_exists('template/default/ico/'.$row['menuid'].'.png') ) {
						$row['icoid']=$row['menuid'];
					}else{
						$row['icoid']='0';
					}
					if(sizeof(explode('"'.$row['menuid'].'"',$bghome['homemana']))>1){
						//$picvalue=1;
					}else{
						//$picvalue=0;
					
					$htmlview.="{";
					$htmlview.="'iconSrc':'template/default/ico/".$row['icoid'].".png', "; 	   
					$htmlview.="'windowsId':'menu".$row['menuid']."', ";  
					$htmlview.="'windowTitle':'".$row['menuname']."',";
					$htmlview.="'iframSrc':'".$row['menuurl']."',";
					//$htmlview.="'picvalue':".$picvalue.",";
					$htmlview.="'windowWidth':500,";
					$htmlview.="'windowHeight':500"; 
 					$htmlview.="},";
					}
				}
				  
			}
				echo substr($htmlview, 0, -1);
				?>];

$(function(){
	var applist=$(".appList"),appLi="";
		for(var i=0;i<appData.length;i++){
			if(appData[i].picvalue==1){
				appLi+="<li><img src='"+appData[i].iconSrc+"' /><h1 style='color:#ccc;'>"+appData[i].windowTitle+"(己添加)</h1></li>";
			}else{
				appLi+="<li><a href='javascript:void(0);' id='"+appData[i].windowsId+"'><img src='"+appData[i].iconSrc+"' /></a><h1 style='color:#F7F7F7;'>"+appData[i].windowTitle+"</h1></li>";
			}
		}
		applist.html(appLi);
		
	var app=$(".appList > li a");
	    //将数据保存在每个应用上
		app.each(function(i){
			$(this).data("winAttrData",appData[i]);
			})
		.click(function(){
			//console.log(window.parent.document);
			//alert($(this).data("winAttrData").windowsId);
			parent.myDesktop.desktop.addApp($(this).data("winAttrData"));
			//var menuid=$(this).data("winAttrData").windowsId;
			/*jQuery.ajax({
				  type: 'GET',
				  url: 'admin.php?ac=user&fileurl=member&do=home&view=t&menuid='+menuid.replace('menu','')+'&date='+new Date(),
				  success: function(data){
				  }
		   		});*/
			});	
 	});
					
						
</script>
</head>

<body style="background:url(template/default/home/theme/default/images/wallpaper1.jpg) center top repeat;">
<div class="wrap">
<ul class="appList">
</ul>
</div>
</body>
</html>
