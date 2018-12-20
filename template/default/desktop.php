<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_CONFIG->config_data('name')?></title>
<script type="text/javascript" src="template/default/home/lib/js/jquery/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="template/default/home/lib/js/mydesktop/myDesktopBase.js"></script>
<script type="text/javascript"> 

$(window).load(function(){
	      //停止进度条
		  myDesktop.stopProgress();
		  
		  //禁止选择文本内容
		  myDesktop.disableSelect();					   
		    <?php
			if($bguser['homebg']!=''){
				$bg=''.$bguser['homebg'];
			}else{
				$bg='template/default/home/theme/default/images/wallpaper.jpg';
			}
			?>
		  //初始化桌面背景
		  myDesktop.wallpaper.init("<?php echo $bg;?>",1);
    
         //===========================初始化桌面=========================
 		 //桌面应用json数据 	  
		   var iconData={
		   
		   
			   <?php
				$html='';
				$page=0;
				$ns=0;
				$homemana=explode('|',$homemana);
				$homemana=array_unique($homemana);
				
				for($i=0;$i<sizeof($homemana);$i++){
					$j=$j+1;
					if($homemana[$i]!=$j.':,'){
						//if($i==4){
						// echo $homemana[$i];
						//}
						//$j=$j+1;
						$html.='desktop'.$j.': ['.chr(13).chr(10);
						$htmlview='';
						$page=$page+$nums;
						$homemana_data=explode(',',str_replace($j.':','',$homemana[$i]));
						$homemana_data= array_unique($homemana_data);
						for($m=0;$m<sizeof($homemana_data);$m++){
							if(str_replace('"','',trim($homemana_data[$m]))!=''){
								$sqls = "SELECT  * FROM ".DB_TABLEPRE."menu  WHERE menuid=".str_replace('"','',trim(preg_replace('/[^0-9]/i','',$homemana_data[$m])))." and menutype='2'";
								$row = $db->fetch_one_array($sqls);
								if($row['menuid']!=''){
									if ( file_exists('template/default/ico/'.$row['menuid'].'.png') ) {
										$row['icoid']=$row['menuid'];
									}else{
										$row['icoid']='0';
									}
									$htmlview.='{'.chr(13).chr(10);
									$htmlview.='iconSrc: "template/default/ico/'.$row['icoid'].'.png",';
									$htmlview.='windowsId: "menu'.$row['menuid'].'",';
									$htmlview.='windowTitle: "'.$row['menuname'].'",';
									$htmlview.='iframSrc: "'.$row['menuurl'].'",';
									$htmlview.='windowWidth: 1024,';
									$htmlview.='windowHeight: 600,';
									$htmlview.='txNum: '.get_home_nums($row['menuurl']).'';
									$htmlview.='},'.chr(13).chr(10);
								}
							}
						}
						$ns=$ns+$nums;
						$html.=substr($htmlview, 0, -3);
						$html.='],'.chr(13).chr(10);
					}
				}
				echo substr($html, 0, -3);
				?>
			   };

		   myDesktop.desktop.init(iconData,{
				arrangeType:1,  
				iconMarginLeft:45,
				iconMarginTop:25,
				defaultDesktop:0
				});
		   
		   //初始化任务栏
		   myDesktop.taskBar.init();
  		   
		   //===========================初始化侧边栏===================
           //侧边栏应用json数据
		   var defaultAppData=[
		   				<?php
						$homemanaleft=explode(',',$homemanaleft);
						$htmlview='';
						for($i=0;$i<sizeof($homemanaleft);$i++){
							if(str_replace('"','',trim($homemanaleft[$i]))!=''){
								$sqls = "SELECT * FROM ".DB_TABLEPRE."menu  WHERE menuid=".str_replace('"','',trim(preg_replace('/[^0-9]/i','',$homemanaleft[$i])))."";

								$row = $db->fetch_one_array($sqls);
								if($row['menuid']!=''){
									if ( file_exists('template/default/ico/'.$row['menuid'].'_left.png') ) {
										$row['icoid']=$row['menuid'].'_left';
									}else{
										$row['icoid']='0';
									}
									$htmlview.='{'.chr(13).chr(10);
									$htmlview.='iconSrc: "template/default/ico/'.$row['icoid'].'.png",';
									$htmlview.='windowsId: "menu'.$row['menuid'].'",';
									$htmlview.='windowTitle: "'.$row['menuname'].'",';
									$htmlview.='iframSrc: "'.$row['menuurl'].'",';
									$htmlview.='windowWidth: 1024,';
									$htmlview.='windowHeight: 600,';
									$htmlview.='txNum: '.get_home_nums($row['menuurl']).'';
									$htmlview.='},'.chr(13).chr(10);
								}
							}
						}
						// echo substr($htmlview, 0, -3);
						?>
						
					   ];

		   myDesktop.sildeBar.init(defaultAppData,"left");
           
            //全屏
             $("#showZm_btn").click(function(event){
                    //location.href="inc/online.php";
					  event.preventDefault(); 
					  event.stopPropagation();
	
					  myDesktop.myWindow.init({
								   'iconSrc':'template/default/home/theme/default/images/user.png',  	   
								   'windowsId':'user',   
								   'windowTitle':'微消息',
								   'iframSrc':'inc/online.php',
								   'windowWidth':300,
								   'windowHeight':530,
								   'parentPanel':".currDesktop"
									});
					  //添加到状态栏
					  if(!$("#taskTab_skins").size()){
						 myDesktop.taskBar.addTask("user","微消息","template/default/home/theme/default/images/user.png");
						 }
                 });
           
           //设置主题
             $("#them_btn").click(function(event){
                  event.preventDefault(); 
                  event.stopPropagation();

                  myDesktop.myWindow.init({
                               'iconSrc':'template/default/home/theme/default/images/skin1.png',  	   
                               'windowsId':'info',   
                               'windowTitle':'短消息',
                               'iframSrc':'admin.php?ac=receive&fileurl=sms',
                               'windowWidth':1200,
                               'windowHeight':580,
                               'parentPanel':".currDesktop"
                                });
                  //添加到状态栏
                  if(!$("#taskTab_skins").size()){
                     myDesktop.taskBar.addTask("info","短消息","template/default/home/theme/default/images/skin1.png");
                     }
                 });
 		   
		  //===========================初始化开始菜单=================
		  myDesktop.startBtn.init([
		  			[
					<?php
					$htmlviews='';
					$sqls = "SELECT * FROM ".DB_TABLEPRE."menu where fatherid='0' and menutype!=1 ORDER BY menunum asc";	
					$query = $db->query($sqls);
					while ($row = $db->fetch_array($query)) {
						$rsfno = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."menu where fatherid='".$row[menuid]."' and menutype!=1 ORDER BY menunum asc limit 0,1");
						if($row['keytable']!=''){
							if(is_superadmin() || check_purview($row['keytable'])){
								if ( file_exists('template/default/ico/'.$row['menuid'].'.png') ) {
									$row['icoid']=$row['menuid'];
								}else{
									$row['icoid']='0';
								}
								$htmlviews.='{'.chr(13).chr(10);
								$htmlviews.='windowsId: "menu'.$row['menuid'].'",';
								$htmlviews.='iconSrc: "template/default/ico/'.$row['icoid'].'.png",';
								$htmlviews.='windowTitle: "'.$row['menuname'].'",';
								if($rsfno[menuid]!=''){
									$htmlviews.='childItem:['.chr(13).chr(10);
									$htmlviews.='['.chr(13).chr(10);
										$htmlviews.=get_menu_home($row['menuid']);
									$htmlviews.=']'.chr(13).chr(10);
									$htmlviews.=']'.chr(13).chr(10);
								}else{
									
									$htmlviews.='iframSrc: "'.$row['menuurl'].'",';
									$htmlviews.='windowWidth: 1024,';
									$htmlviews.='windowHeight: 600';
								}
								$htmlviews.='},'.chr(13).chr(10);
							}
						}else{
							if ( file_exists('template/default/ico/'.$row['menuid'].'.png') ) {
								$row['icoid']=$row['menuid'];
							}else{
								$row['icoid']='0';
							}
							$htmlviews.='{'.chr(13).chr(10);
							$htmlviews.='windowsId: "menu'.$row['menuid'].'",';
							$htmlviews.='iconSrc: "template/default/ico/'.$row['icoid'].'.png",';
							$htmlviews.='windowTitle: "'.$row['menuname'].'",';
							if($rsfno[menuid]!=''){
								$htmlviews.='childItem:['.chr(13).chr(10);
								$htmlviews.='['.chr(13).chr(10);
									$htmlviews.=get_menu_home($row['menuid']);
								$htmlviews.=']'.chr(13).chr(10);
								$htmlviews.=']'.chr(13).chr(10);
							}else{
								
								$htmlviews.='iframSrc: "'.$row['menuurl'].'",';
								$htmlviews.='windowWidth: 1024,';
								$htmlviews.='windowHeight: 600';
							}
							$htmlviews.='},'.chr(13).chr(10);
						}
				    }
				    echo substr($htmlviews, 0, -3);
					?>
					]
  					]);
 		
		//====================初始化桌面右键菜单==============
		var data=[
					// [{
					// text:"显示桌面",
					// func:function(){
					// 	$("div.myWindow").not(".hideWin")
					// 	.each(function(){
					// 			$(this).find(".winMinBtn").trigger("click");									   
 				// 				});
					// 	}
					// 	}]
					// ,
					[
					{
					// text:"切换风格",
					// func:function(){
     //                   location.href="index.php?hometype=2&<?php echo get_date('YmdHis',PHP_TIME)?>";
     //                }
					  },
					  {
					// text:"桌面设置",
					// func:function(){
     //                   //调用弹出窗口    
     //                   myDesktop.myWindow.init({
     //                        windowsId:"555", 	  
     //                        windowTitle:"桌面设置",
     //                        iconSrc:"icon/item2.png",
     //                        windowWidth:1000,
     //                        windowHeight:580,
     //                        iframSrc:'admin.php?ac=user&fileurl=member&do=home',
     //                        parentPanel:'div.currDesktop'
					// 	  });
     //                }
					  },{
					text:"主题设置",
					func:function(){
						//调用弹出窗口    
                       myDesktop.myWindow.init({
                               'iconSrc':'template/default/home/theme/default/images/skin.png',  	   
                               'windowsId':'skins',   
                               'windowTitle':'主题设置',
                               'iframSrc':'admin.php?ac=user&fileurl=member&do=bg&mid=<?php echo $_GET['mid']?>',
                               'windowWidth':1000,
                               'windowHeight':580,
                               'parentPanel':"div.currDesktop"
						  });
					
					}
						  },
						  {
					// text:"重置桌面",
					// func:function(){
     //                   location.href="desktop.php?homeico=yes";
     //                }
					  }]
					,[{
					  text:"退出系统",
					  func:function(){
					  	location.href="login.php?do=logout";
					  } 
					  }]
					
					];
		 myDesktop.contextMenu($(document.body),data,"body",10);
		 
});
//消息提示,设定标题提示
//var newSmsSoundHtml = "<object id='sms_sound' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='template/default/swf/swflash.cab' width='0' height='0'><param name='movie' value='template/default/swf/9.swf'><param name=quality value=high><embed id='sms_sound' src='template/default/swf/9.swf' width='0' height='0' quality='autohigh' wmode='opaque' type='application/x-shockwave-flash' plugspace='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash'></embed></object>";

sms_count();
function sms_count(type)
{
   jQuery.ajax({
      type: 'GET',
      url: 'inc/sms_count.php?date='+new Date(),
      success: function(data){
	  	if(data=='1'){
	  		//jQuery('#shortcut').click();
	  		$('#sms_count').html("<img src='template/default/images/xin.gif'><object id='sms_sound' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='template/default/swf/swflash.cab' width='0' height='0'><param name='movie' value='template/default/swf/9.swf'><param name=quality value=high><embed id='sms_sound' src='template/default/swf/9.swf' width='0' height='0' quality='autohigh' wmode='opaque' type='application/x-shockwave-flash' plugspace='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash'></embed></object>");
	  		//$('#sms_sound').html(newSmsSoundHtml);
			//$("#sms_num").html(data);
			//alert(data);
	  	}else{
	 		 $('#sms_count').html('  ');
	  	}
      }
   });

   window.setTimeout(sms_count,10*5*1000);
}
</script>
<!--[if IE 6]> <script type="text/javascript">   
DD_belatedPNG.fix('.dock_middle,.dock_pos_right #start_item .item li b,#shizhong_btn,#weather_btn,#showZm_btn,#them_btn,#start_btn,#start_item,#start_item .item li:hover,#start_item .item li span,#start_item .item li b,#start_item .childItem,#default_app .btnOver,.dock_drap_effect,.myWidget,.innerWidgetTitle,.widgetClose,.widgetClose:hover,.ui_boxyClose,.login_logo,#navBar s,#navBar span,#navBar span a,#navBar a.currTab,.indicator_header,.indicator_manage,.desktop,#bottomBarBgTask,.taskItem,.taskItem:hover,.taskCurrent .taskItem:hover,.taskCurrent .taskItem ,.taskPreBox,.taskPre,.taskNextBox,.taskNext,.aMg_dock_container,.aMg_line_y,.aMg_folder_container,.aMg_close,.aMg_close:hover,#aMg_prev,#aMg_next,.folderInner .desktopIcon .icon .txInfo,.folderInner .hover');
</script><![endif]-->
</head>
<body>

<div id="wallpaper"></div>
<div id="desktopWrapper">

  <div id="topBar"></div>
  <div id="leftBar">
    <div id="dockContainer" class="dock_container dock_pos_left">
      <div class="dock_middle">
        <div id="default_app"></div>
        <div class="default_tools"> 
           <!--  <a href="javascript:void(0);" id="showZm_btn" title="微消息"></a>
            <a href="javascript:void(0);" id="them_btn" title="短消息"><span id="sms_count"></span></a> -->
             </div>
        <div class="default_tools"> 
            <!-- <a href="javascript:void(0);" id="weather_btn" title="天气"></a>  -->
            <a href="javascript:void(0);" id="shizhong_btn" title="时钟"></a>
          </div>
        <div id="start_block"> <a title="开始" id="start_btn"></a>
          <div id="start_item">
            <ul class="item admin">
              <li><span class="adminImg" style="background-image:url(<?php echo $bguser['pic'];?>);"></span> <?php echo get_realname($_USER->id)?></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="rightBar"></div>
  
 <div class="dock_drap_effect dock_drap_effect_top" ></div>
 <div class="dock_drap_effect dock_drap_effect_left" ></div>
 <div class="dock_drap_effect dock_drap_effect_right" ></div>
   
  <div class="dock_drap_mask">
    <div name="top" class="dock_drop_region_top"></div>
    <div name="left" class="dock_drop_region_left"></div>
    <div name="right" class="dock_drop_region_right"></div>
  </div>
  
  <div id="desktopsContainer">
    <div id="desktopContainer"></div>
  </div>
  
  <div id="bottomBarBgTask"></div>
  
  <div id="taskBlock">
    <div class="taskNextBox" id="taskNextBox"> <a href="javascript:void(0);" class="taskNext" id="taskNext"></a> </div>
    <div id="taskOuterBlock">
      <div id="taskInnnerBlock"> </div>
    </div>
    <div id="taskPreBox" class="taskPreBox"> <a href="javascript:void(0);" id="taskPre" class="taskPre"></a> </div>
  </div>

 <!-- <div id="navBar"><s class="l"><div class="indicator indicator_header" cmd="user" title="请在个人信息管理里编辑"><img src="<?php
 if($bguser['pic']!=''){
 	$bgs=$bguser['pic'];
 }else{
 	$bgs='template/default/images/sex01.gif';
 }
 echo $bgs;
 ?>" alt="请在个人信息管理里编辑" class="indicator_header_img"></div></s><span></span><s class="r"><a class="indicator indicator_manage" href="javascript:void(0);" hidefocus="true" cmd="manage" title="全局视图"></a></s></div> 
    
</div> -->


<div id="appManagerPanel" class="appManagerPanel">
<a class="aMg_close" href="javascript:void(0);"></a>

<div class="aMg_dock_container"></div>
<div class="aMg_line_x"></div>

<div class="aMg_folder_container">
<div class="aMg_folder_innercontainer"></div>
</div>
<a href="javascript:void(0);" id="aMg_prev"></a>
<a href="javascript:void(0);" id="aMg_next"></a> 
</div>  
</body>
</html>
