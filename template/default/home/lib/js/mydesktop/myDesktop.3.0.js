/*-----------------------------------------------------------
 *桌面组件脚本，包括窗口、状态栏、侧边栏、桌面、桌面导航切换、全局视图、登录框
 ----------------------------------------------------------*/
//创建myWindow命名空间
myDesktop.myWindow={
	init:function(options){
 		 
		var wh={"w":$(window).width(),"h":$(window).height()},//浏览器窗口宽度、高度
 			curWinNum=$("div.myWindow").size(),//当前已打开窗口数量
 		    //默认参数配置
            defaults = {
                   windowTitle: null,                        /* true, false窗口标题*/
                   windowsId: null,                          /* true, false窗口id*/
				   iconSrc:null,
                   windowPositionTop: 'center',              /* Posible are pixels or 'center' 窗口初始位置top*/
                   windowPositionLeft: 'center',             /* Posible are pixels or 'center' 窗口初始位置left*/
                   windowWidth: Math.round(wh['w']*0.6),     /* Only pixels 窗口宽度*/
                   windowHeight: Math.round(wh['h']*0.8),    /* Only pixels 窗口高度*/
                   windowMinWidth: 250,                      /* Only pixels 窗口最小宽度*/
                   windowMinHeight: 250,                     /* Only pixels窗口最小高度 */
                   iframSrc: null,                           /* iframe的src路径*/
                   windowResizable: true,                    /* true, false是否可以resize窗口*/
                   windowMaximize: true,                     /* true, false是否可以最大化窗口*/
                   windowMinimize: true,                     /* true, false是否可以最小化窗口*/
                   windowClosable: true,                     /* true, false是否可以关闭窗口*/
                   windowDraggable: true,                    /* true, false是否拖曳窗口*/
                   windowStatus: 'regular',                  /* 'regular', 'maximized', 'minimized' 打开窗口时显示状态*/
                   windowAnimationSpeed: 500,                /* 动画执行时间*/
                   windowAnimation: false,                   /* true, false 是否启用动画*/ 
				   parentPanel:'body',                       /* 窗口被插入的容器元素*/
				   closeEvent:function(){}                   /* 关闭窗口时回调函数*/
				   },
 		    options = $.extend(defaults, options),
		    $newWin=$("#win_"+options['windowsId']), //当前打开的窗口
			//窗口html结构
 		    winHtml=function(options){
				var winHtml="<div class='myWindow' id='win_"+options.windowsId+"' >";
				winHtml+="<div class='winTitle'>";
				winHtml+="<span class='winTitleName'>"+options.windowTitle+"</span>"; 
				winHtml+="<span class='winControlBtn'><a href='#' class='winMinBtn' title='最小化'></a><a href='#' class='winMaxBtn' title='最大化'></a><a href='#' class='winRestore' title='还原'></a><a href='#' class='winCloseBtn' title='关闭'></a></span></div>";
				winHtml+="<div class='winContent'>";
				winHtml+="<div class='loading'>正在加载中</div>";
				winHtml+="<iframe scrolling='auto' frameborder='no' class='iframeApp' name='iframeApp_"+options.windowsId+"' id='iframeApp_"+options.windowsId+"' src=''></iframe>";
				winHtml+="<div class='iframeFix' id='iframeFix_"+options.windowsId+"'></div>";
				winHtml+="</div>";
				winHtml+="</div>";
				return winHtml;
				},
				_self=this;
		 
		//新建窗口,并判断此窗口是否已经存在
		if(!$newWin.size()){ 
		
			$(winHtml(options)).appendTo(options.parentPanel);
			
			var   $newWin=$("#win_"+options['windowsId']),
			      $allWins=$("div.myWindow"),
			      $iframe=$newWin.find("iframe"),
			      $loading=$newWin.find("div.loading"),
				  $wincontent=$newWin.find("div.winContent"),
				  $winTitle=$newWin.find("div.winTitle"),
				  winMaximize_btn=$newWin.find('a.winMaxBtn'),//最大化按钮
				  winMinimize_btn=$newWin.find('a.winMinBtn'),//最小化按钮
		          winClose_btn=$newWin.find('a.winCloseBtn'),//关闭按钮
		          winHyimize_btn=$newWin.find('a.winRestore');//还原按钮
 				  
			//设置窗口位置、大小
			var $topWin=$("div.topWin"),
			    dxy=Math.floor((Math.random()*200))+(wh['h']-options['windowHeight'])/2, //偏移量
			    zindex=curWinNum?parseInt($topWin.css("z-index"))+1:curWinNum+100,
 				deskWidth=$topWin.width(),
                wLeft=myDesktop.isTypeOf(options['windowPositionLeft'],"Number")?options['windowPositionLeft']+dxy:(wh['w']-options['windowWidth'])/2-73,
                wTop=myDesktop.isTypeOf(options['windowPositionTop'],"Number")?options['windowPositionTop']+dxy/2:(wh['h']-options['windowHeight'])/2-40;
			
			//初始化窗口
			$allWins.removeClass("topWin").find("div.iframeFix").show();
 			 
			$newWin
			.addClass("topWin")
			.css({"width":options['windowWidth'],"height":options['windowHeight'],"left":wLeft,"top":wTop,"z-index":zindex})
			.find("div.winContent")
			.css({"width":options['windowWidth'],"height":options['windowHeight']-$winTitle.height()})
			.find("iframe")
			.attr("src",options['iframSrc'])
					.load(function(){//当iframe加载完毕
 						$loading.hide();
						$(this).css("left",0);
  						})
			.end()
			.find("div.iframeFix")
			.hide();
			
			//更新窗口当前位置大小信息
			$newWin.data('winLocation',{
			  'w':options['windowWidth'],
			  'h':options['windowHeight'],
			  'left':wLeft,
			  'top':wTop
			  });
  
			
			//是否显示最大化按钮
			if(!options.windowMaximize){
				 winMaximize_btn.hide();
				}
				
			//是否显示最小化按钮	
			if(!options.windowMinimize){
				 winMinimize_btn.hide();
				}
				
			//是否显示关闭按钮	
			if(!options.windowClosable){
				 winClose_btn.hide();
				}	
    			
			//多个窗口上下切换
			$allWins.mousedown(function(event){
				                    event.stopPropagation();
									var $topWin=$("div.topWin"),id=this.id;
									 
									if(!$topWin.is($(this))){
									    var maxZindx=$topWin.removeClass("topWin").find("div.iframeFix").show().end().css("z-index");
									    $(this).css("z-index",parseInt(maxZindx)+1).find("div.iframeFix").hide().end().addClass("topWin");                                      
										 
										//更新任务栏图标状态
										myDesktop.taskBar.upTaskTab(id);
									}
									});
			
			//启用窗口拖动
			if(options.windowDraggable){ _self.winDrag($newWin);}
 			
				
			//启用拖曳改变窗口大小	
			if(options.windowResizable){
				_self.winResize($newWin,[options.windowMinWidth,options.windowMinHeight,wh['w']-wLeft,wh['h']-wTop]);
				}
			
			//关闭窗口
			winClose_btn.click(function(event){ 
			event.preventDefault();
			event.stopPropagation();
			_self.winClose($newWin);	
			var fun=$.isFunction(options.closeEvent)?options.closeEvent:{};
			fun.call(fun,options.windowsId);
			});
			
			//最大化窗口
			winMaximize_btn.click(function(event){ 
			event.preventDefault();
			event.stopPropagation();
			_self.winMaximize($newWin,options);
			});
			
			//最小化窗口
			winMinimize_btn.click(function(event){ 
			event.preventDefault();
			event.stopPropagation();
			_self.winMinize($newWin); 
			});
			
			//还原窗口
			winHyimize_btn.click(function(event){
			event.preventDefault();
			event.stopPropagation();
			 _self.winHyimize($newWin,options);
			 });
			
			//双击标题栏最大化、还原窗口
		    $winTitle.dblclick(function(){
				var hasMaximizeBtn=$(this).find(winMaximize_btn);
				if(!hasMaximizeBtn.is(":hidden")){
					winMaximize_btn.trigger("click");
				}else{
					winHyimize_btn.trigger("click");
					}
			});
			
			if(options.windowStatus=="maximized"){
			winMaximize_btn.trigger("click");
     		} 
			
			if(options.windowStatus=="minimized"){
			winMinimize_btn.trigger("click");
     		} 
 			
			//当改变浏览器窗口时且窗口处于最大化状态
			$(window).wresize(function(){
				if($newWin.data('windowStatus')=="maximized"){
					 _self.winMaximize($newWin);
				}
			 //更新窗口大小
			 _self.winResize($newWin,[options.windowMinWidth,options.windowMinHeight,$(window).width(),$(window).height()]);
 			  });
 	     
		    return $newWin;
		 
		//已经存在窗口
		}else{
  		  $("#taskTab_"+options.windowsId).trigger("click");
 			   }
		}, 
	//拖动窗口
	winDrag:function($newWin){
		var wh={'w':$(window).width(),'h':$(window).height()},
		   _self=this;
		
		$newWin
		.draggable({
				   handle:'div.winTitle',
				   scroll: false
				   })
		.bind("drag",function(event,ui){
					$(this).find("div.iframeFix").show();		  
						  })
		.bind("dragstop", function(event, ui) {
            $(this).find("div.iframeFix").hide();	
											
			//限制窗口拖曳范围
 			if(event.pageY>wh.h-80){
				$(this).css("top",wh.h-80);
 		    }else if(event.pageY<0){
				$(this).css("top",0);  
			}
								  
 			//更新窗口当前位置大小信息
			$newWin.data('winLocation',{
			  'w':$(this).width(),
			  'h':$(this).height(),
			  'left':$(this).css("left"),
			  'top':$(this).css("top")
			  });
 								  
		   });
		},
	//拖曳改变窗口大小
	 winResize:function($newWin,arr){
		var _self=this,wintitHeight=$newWin.find(".winTitle").height();
		
		$newWin
		.resizable({
				minWidth:arr[0],
				minHeight:arr[1],
				containment:'document',
				maxWidth:arr[2],
				maxHeight:arr[3],
				autoHide:true,
				handles:"n, e, s, w, ne, se, sw, nw, all",
				helper: "ui-resizable-helper"
			})
			.css("position","absolute")
			.on("resize", function(event, ui) {
				$(this).find("div.iframeFix").show();
			})
			.on("resizestop",function(event,ui){
			
			var h=$(this).innerHeight(),w=$(this).innerWidth();
			
			$(this)
			.find("div.winContent")
			.css({"width":w,"height":h-wintitHeight})
			.end()
			.find("div.iframeFix")
			.hide();
			
			var wh=ui.size,lt=ui.position;
			
			//更新窗口当前位置大小信息
			$newWin.data('winLocation',{
			'w':wh.width,
			'h':wh.height,
			'left':lt.left,
			'top':lt.top
			});
		}); 
		},
  	//获取当前最顶层窗口对象		
	findTopWin:function(maxZ){
		var topWin=null,$win=$("div.myWindow"),tab=$("div.taskTab");
		
 		  $win.each(function(index){
 						   if($(this).css("z-index")==maxZ){
							   topWin=$(this);
							   return false;
							   } 
 						   });
   
	    return topWin;	 			   
 	 },
 	//关闭窗口
	winClose:function($newWin){
		var $topWin=$("div.topWin"),
			nextWin=this.findTopWin(parseInt($topWin.css("z-index"))-1);
											
			nextWin==undefined?"":nextWin.addClass("topWin");
			$newWin.remove();
			
			//删除对应任务栏图标
			myDesktop.taskBar.removeTaskTab($newWin.attr("id"));
			if(nextWin!==null){
			myDesktop.taskBar.upTaskTab(nextWin.attr("id"));
			}
			
			$("#desktopsContainer").css("z-index",50);
		},
	//最大化窗口
	winMaximize:function($newWin,o){
		
 		var wh={'w':$(window).width(),'h':$(window).height()},
		    winHyimize_btn=$newWin.find("a.winRestore"),
		    winMaximize_btn=$newWin.find("a.winMaxBtn"),
			navBar=$("#navBar"),
			leftBar=$("#leftBar"),
			rightBar=$("#rightBar"),
			topBar=$("#topBar"),
			l=0,t=0;
		
		var slideWidth=topBar.is(":hidden")?leftBar.width():0,
		    topHeight=topBar.is(":hidden")?navBar.height():topBar.height();	
			
		if(!leftBar.is(":hidden")){
			l=slideWidth*-1;
			t=topHeight*-1;
		}else{
			l=0;
			t=topHeight*-1;
			}
 			   
		$newWin
		.data("windowStatus","maximized")
 		.addClass("maxWin")
 		.css({"width":wh['w']-2,"height":wh['h'],"left":l,"top":t})
		.find("div.winContent")
		.css({"width":wh['w']-2,"height":wh['h']-30});
       
		if(o.windowResizable){
 			$newWin
			.draggable("disable")
			.resizable("disable");
		}
		
		if(!$newWin.find("div.iframeFix").is(":hidden")){
			$newWin.find("div.iframeFix").hide();
			}
  
		winMaximize_btn.hide();
		winHyimize_btn.css("display","inline-block");
		
		$("#desktopsContainer").css("z-index",800);
		},
	//还原窗口
	winHyimize:function($newWin,o){
		var winInfo=$newWin.data("winLocation"),
		    winHyimize_btn=$newWin.find("a.winRestore"),
		    winMaximize_btn=$newWin.find("a.winMaxBtn");
			
			$newWin
			.data("windowStatus","regular")
			.removeClass("maxWin")
			.css({"width":winInfo.w,"height":winInfo.h,"left":winInfo.left,"top":winInfo.top})
			.find("div.winContent")
			.css({"width":winInfo.w,"height":winInfo.h-30});
			
			if(o.windowResizable){
			$newWin.draggable("enable").resizable("enable");
			}
			
			if(!$newWin.find("div.iframeFix").is(":hidden")){
			$newWin.find("div.iframeFix").hide();
			}			
									
			winHyimize_btn.hide();
			winMaximize_btn.show();
			
			$("#desktopsContainer").css("z-index",50);
		},
	//最小化窗口	
	winMinize:function($newWin){
		var p=$("div.desktop").index($newWin.parent());
 		
		$newWin.data({"oldLeft":$newWin.css("left"),"index":p}).css("left",-99999).addClass("hideWin");
         
 		var nextWin=this.findTopWin(parseInt($newWin.css("z-index"))-1);
         
		if(nextWin!==null){
		$newWin.removeClass("topWin");	
		nextWin.addClass("topWin").find("div.iframeFix").hide();	
		myDesktop.taskBar.upTaskTab(nextWin.attr("id"));
			}else{
			myDesktop.taskBar.upTaskTab($newWin.attr("id"));	
				}
			
		$("#desktopsContainer").css("z-index",50);		
		} 	
	};

   	
//创建wallpaper命名空间
/*背景平铺三种类型,1背景拉伸,2背景居中,3背景自适应屏幕*/
myDesktop.wallpaper={
	init:function(imgUrl,type){
		var _self=this;
		$("body").data("wallpaperType",type);
		
		if(type!=3){
		 myDesktop.getImgWh(imgUrl,function(imgWidth,imgHeight){
			 $("#wallpaper").html("<img src='"+imgUrl+"' />");
			 _self.setWallpaper(imgWidth,imgHeight,type);
			 
			 $(window).wresize(function(){
				 _self.setWallpaper(imgWidth,imgHeight,type);
				 });	
					});
					
		 }else{ //背景平铺
 		   $("#wallpaper").css({"background":"url("+imgUrl+") repeat 0 0","height":$(window).height()});
		 }
    
   },
  setWallpaper:function(imgWidth,imgHeight,type){
	  var winW=$(window).width(),
		  winH=$(window).height();
		  
	  	if(type==1){//如果是拉伸
			$("#wallpaper").find("img").css({'width':winW,'height':winH});
			}
											
		if(type==2){//如果是居中
			if(imgWidth>winW){
			$("#wallpaper").find("img").css({'width':imgWidth,'height':imgHeight,'margin-left':(imgWidth-winW)/2+"px",'margin-top':(imgHeight-winH)/2+"px"});
			}else{
			$("#wallpaper").find("img").css({'width':imgWidth,'height':imgHeight,'margin-left':-(imgWidth-winW)/2+"px",'margin-top':-(imgHeight-winH)/2+"px"});
			}
 		}
	  },
  updateWallpaper:function(imgSrc){
	  //alert(imgSrc);
	  var type=$("body").data("wallpaperType");
	  this.init(imgSrc,type);
	  
	  //保存Wallpaper信息
	  $.ajax({
		  //这里添加自己的代码,可以更新背景图片,暂不用
		  });
	  }	  		
		};


//创建桌面控制栏desktopBar
myDesktop.desktopBar={
	init:function(desktopNum,index){
 		
		var navBar=$("#navBar"),
 		    nav="",
			desktops=$("div.desktop"),
		    bottomBarBgTask=$("#bottomBarBgTask"),
			_self=this;
		
		for(var i=0;i<desktopNum;i++){
			i==index?nav+="<a href='#' class='currTab' title='桌面"+(i+1)+"'>"+(i+1)+"</a>":nav+="<a href='#' title='桌面"+(i+1)+"'>"+(i+1)+"</a>";
			}
 		
 		navBar
		.find("span")
		.html(nav) 
		.end()
 		.css("margin-left",(navBar.width()+20)*-1/2)
		.draggable({
 					scroll:false,
					containment:"body"
						});
  		
		//单击tab切换桌面
 		var tabs=navBar.find("span > a");
		    
		tabs
		.on("click",function(){
			_self.moveDesktop(tabs.index($(this)));
 			})
		.droppable({
			scope:'a',
            over:function(event,ui){
  					_self.moveDesktop(tabs.index($(this)));
 					}
			});	
		
		//单击头像，弹出登陆框
		$("#navbarHeaderImg").click(function(){
						myDesktop.login.init("login.html");					 
							  });
		//单击全局视图
		$("a.indicator_manage").click(function(){
					    //初始化全局视图
		                myDesktop.appManagerPanel.init();
						
						$("#appManagerPanel").css("top",0);
 						$("#desktopWrapper").hide();
						
 								 });
		
 		},
	moveDesktop:function(i){
		var navBar=$("#navBar"),
		    tabs=navBar.find("span > a"),
		    desktops=$("div.desktop"),
			innerDesktop=$("div.innerDesktop");
		
		innerDesktop.hide();
 		
		desktops.eq(i).animate({left:0}, 500,"easeInOutQuint");
	    innerDesktop.eq(i).show();
 		
		tabs.removeClass("currTab").eq(i).addClass("currTab");
		desktops.removeClass("currDesktop").eq(i).addClass("currDesktop");	
		
		for(var j=0;j<desktops.size();j++){
			desktops.eq(j).css('left',j>i?'2000px':'-2000px'); 
			 }
  		}	
	};
		
//创建desktop命名空间
myDesktop.desktop={
	init:function(iconData,options){
		//默认配置
		var defaults={
				arrangeType:1,       //图标排列类型,1竖排,2横排
				iconMarginLeft:30,   //图标左边距
				iconMarginTop:20,     //图标上边距
				defaultDesktop:0
 				};
				
		var options = $.extend(defaults, options);
 		
		//存储desktop配置
		$("body").data("desktopCofig",options);
 		
		var _self=this;
 			
		//创建初始化桌面图标
 		_self.desktopIconInit(iconData);
			
		var desktops=$("div.desktop"), 
   			desktopNum=desktops.size(),
			innerDesktop=$("div.innerDesktop");
				
		//默认显示第一个桌面 
		desktops.eq(options.defaultDesktop).addClass("currDesktop")
		.css("left",0)
		.find("div.innerDesktop").fadeIn(3000);
  			
 		if(desktopNum){ //是否显示桌面控制栏
			myDesktop.desktopBar.init(desktopNum,options.defaultDesktop);
 				
			//拖动桌面滑动切换桌面
 			var dxStart,dxEnd,tabs=$("#navBar").find("span > a");
				
			desktops
			.draggable({
					axis:'x',
					scroll: false,
					start:function(event,ui){
						$(this).css("cursor","move");
						dxStart=event.pageX;
						},
					stop:function(event,ui){
						$(this).css("cursor","inherit");
						dxEnd=event.pageX;
						
						var dxCha=dxEnd-dxStart
						    ,deskIndex=desktops.index($(this));
						 
						//左移
						if(dxCha < -150 && deskIndex<desktopNum-1){
  							tabs.eq(deskIndex+1).trigger('click');
						//右移
						}else if(dxCha > 150 && deskIndex>0){
							tabs.eq(deskIndex-1).trigger('click');
 						}else{
							 $(this).animate({'left':0},500,"easeInOutQuint");
							} 
						    }
								}); 
 				}
			
 			//设置桌面区域大小和排列桌面图标
			_self.arrangeIcons(desktops,options);
			 
 			//如果窗口大小改变，则重新排列图标
		    $(window).wresize(function(){
							 _self.arrangeIcons(desktops,options);
    								   });
			
   			//拖曳图标，在桌面空白处释放，插入最后
   			innerDesktop.droppable({
				scope:'a',
                drop: function(event,ui){
					
 				    if(ui.draggable.parent().is($(this))){
						ui.draggable.insertBefore($(this).find(".addIcon"));
 					}else{
  							var data=ui.draggable.data("winAttrData");
							var html=myDesktop.desktop.creatIcon(data);
							
							$(html).insertBefore($(this).find(".addIcon"));
							ui.draggable.remove();
							_self.hoverIcon($("#"+data.windowsId));	
							$("#"+data.windowsId).data("winAttrData",data);
							
							_self.clickInit();
  					}
 				    _self.arrangeIcons(desktops,options);
 					
 					//更新数据
				   _self.moveIconTo($(".currDesktop").attr("id"),ui.draggable.attr("id"));
					
   					}
                  });		
			
	     //桌面图标效果初始化
		 _self.clickInit();		
			
		//单击添加应用按钮
		desktops
		.find("div.addIcon")
		.click(function(){
		$("#win_appShop").remove();
		$("#taskTab_appShop").parent().remove();
		
		var	p=$(this).parents("div.desktop");
 			myDesktop.myWindow.init({
						'iconSrc':'template/default/home/icon/icon11.png', 	
					   'windowsId':'appShop', 	
					   'windowTitle':'添加应用',
					   'iframSrc':'admin.php?ac=user&fileurl=member&do=home',
					   'windowWidth':1000,
					   'windowHeight':600,
					   'parentPanel':p
			       });
			
		//添加到状态栏
		if(!$("#taskTab_appShop").size()){
 		myDesktop.taskBar.addTask("appShop","添加应用","template/default/home/icon/icon11.png");
		 } 
		});
		
		//解决谷歌浏览器下桌面打窗口出现滚动条问题
		$(window).scroll(function(){
		$(document).scrollTop(0);
		$(document).scrollLeft(0);
		});
 		 
 		},
	hoverIcon:function(o){
			 o.on({
			mouseenter: function(event){
				event.stopPropagation();
				$(this).addClass("desktopIconOver");
				},
			mouseleave: function(event){
				event.stopPropagation();
				$(this).removeClass("desktopIconOver");
				}});
		},	
	//桌面图标效果初始化	
	clickInit:function(){
		 var desktops=$("div.desktop"),
		     icons=desktops.find("div.desktopIcon"),
			 o=$("body").data("desktopCofig"),
			 p=$("div.currDesktop"),
			 _self=this;
 			
			_self.hoverIcon(icons);
			   
			icons
 			//单击图标打开窗口
			.not(".addIcon")
			.on("click",function(event){
							event.stopPropagation();	 
						var data=$(this).data("winAttrData");
 							
							//打开的事窗口
							if(!data.isWidget){
							var	p=$("div.currDesktop");
							data.parentPanel=p;	
							myDesktop.myWindow.init(data);
							//添加到状态栏
							if(!$("#taskTab_"+data.windowsId).size()){
							myDesktop.taskBar.addTask(data.windowsId,data.windowTitle,data.iconSrc);
							}
							}
							//小工具
							else{
								myDesktop.widget.init({
													  id:data.windowsId,
													  width:data.windowWidth,
													  height:data.windowHeight,
													  title:data.windowTitle,
													  isDrag:true,
													  iframeSrc:data.iframSrc,
													  top:data.top,
													  left:data.left,
													  right:data.right,
													  parentTo:"div.currDesktop"
													  });
								}
							
							})				
			.draggable({
					helper: "clone",
					scroll:false,
 					scope:'a',
					appendTo: 'body',
					zIndex:100,
					start: function(event, ui) {
 						ui.helper.removeClass("desktopIconOver").removeClass("btnOver").css({"float":"none"}).find(".text").hide();
						$("body").data("curDrag",$(this).next());
						$("body").data("curDragPar",$(this).parent());
						},
					stop:function(event,ui){
                                    _self.arrangeIcons(desktops,o);
 									ui.helper.find(".text").show();
 								  }
					})
					
		    .droppable({
				scope:'a',
                drop: function(event,ui) {
				var curDrag=$("body").data("curDrag"),curDragPar=$("body").data("curDragPar");	
  				
				if(curDragPar.is($(this).parent())){
					
					if($(this).is(curDrag)){
 					 ui.draggable
					.addClass("desktopIcon")
					.insertAfter($(this)); 
						}else{		
					ui.draggable
					.addClass("desktopIcon")
					.insertBefore($(this)); 
						}
				 	
				} 
 				   _self.arrangeIcons(desktops,o);	
     				}
           });	
		
		//添加图标右键菜单
		var dN=desktops.size();
		var dnData=[[]];
		
		for(var i=1;i<dN+1;i++){
 					
			dnData[0][i-1]=({
				text:"桌面"+i,
				func:function(j){
					j=j+1;
 				    var c=$("#desktop"+j).find(".addIcon"),b=$(".currDesktop ,"+"#desktop"+j);	 
 					$(this).insertBefore(c);
					//更新桌面布局	
		            _self.arrangeIcons(b,o);
 					
					//这里写更新后台数据代码
					_self.moveIconTo("desktop"+j,this.id);
					//_self.moveIconTo($(".currDesktop")[0].id,"desktop"+j,this.id);
					
   					}
				});
			}
		 
 		var data=[
					[{
					text:"打开应用",
					func:function(){
						$(this).trigger("click");
						}
						}]
					,[{
					text:"移动应用到",
                    data:dnData
					  },{
					text:"移除应用",
					func:function(){
						$(this).remove();
						//更新桌面布局	
		                 _self.arrangeIcons(p,o);
						 
						//这里通过ajax写更新后台数据
						 _self.removeIcon(this.id);
						//alert(this.id);
						}
						  }]
 					];
		 myDesktop.contextMenu(icons.not(".addIcon"),data,"icons",10);
 		},	    	
 	//桌面图标初始化
	arrangeIcons:function(desktops,options){
		var desktopsContainer=$("#desktopsContainer"),
		    desktopContainer=$("#desktopContainer"),
		    bottomBarBgTask=$("#bottomBarBgTask"),
			navBar=$("#navBar"),
			topBar=$("#topBar"),
			leftBar=$("#leftBar"),
			rightBar=$("#rightBar"),
			innerDesktop=$("div.innerDesktop"),
			outerDesktop=$("div.outerDesktop"),
 			desktopNum=desktops.size(),
			winW=$(window).width(),
			winH=$(window).height(),
 			topBarH=topBar.is(":hidden")?0:topBar.height();
			
		//设置桌面外围区域大小
		var slideWidth=leftBar.is(":hidden") && rightBar.is(":hidden")?0:leftBar.width(),
		    topHeight=topBar.is(":hidden")?navBar.height():topBar.height();
			
		var sw=winW-slideWidth,
		    sh=winH-topBarH-bottomBarBgTask.height()-62;
 		 
		desktopsContainer.css({'width':sw,'height':0,'left':slideWidth,'top':topHeight});
 		
		if(!rightBar.is(":hidden")){
		desktopsContainer.css({'width':sw,'height':0,'left':0,'top':topHeight});
		}
		
		desktopContainer.css({'width':sw,'height':sh});
		desktops.css({'width':sw,'height':sh});
		//innerDesktop.css({'width':sw,'height':sh});
  		outerDesktop.css({'width':sw,'height':sh}).eq(0).width(sw);
   		
		//排列图标 
		desktops.each(function(index){
			var did="#desktop"+(index+1);
			
			$(did).find(".outerDesktop").niceScroll(did+" .innerDesktop",{touchbehavior:false,cursorcolor:"#666",horizrailenabled:true,cursoropacitymax:0.8,cursorborder:"1px solid #ccc",horizrailenabled:false,zindex:0});
  			$(window).wresize(function(){$(did).find(".outerDesktop").getNiceScroll().resize();});
			
		    var desktop=$(this),
			desktopIcon=desktop.find("div.desktopIcon"),
			iconW=desktopIcon.width(),
			iconH=desktopIcon.height(),
			iconNum=desktopIcon.size();
			gH=iconH+options.iconMarginTop,//一个图标总高度，包括上下margin
			gW=iconW+options.iconMarginLeft,//图标总宽度,包括左右margin
			maxCols=Math.floor(outerDesktop.width()/gW),
			maxRows=Math.floor(outerDesktop.height()/gH),
			rows=Math.floor(outerDesktop.height()/gH),
			cols=Math.ceil(iconNum/rows),
			curcol=0,currow=0;
  		 
		 if(cols>maxCols){
			 rows=Math.ceil(iconNum/maxCols);
			 desktop.find(".innerDesktop").css({'height':rows*gH});
			 }
		 	
		 //存储当前总共有多少桌面图标
		 desktop.data('deskIconNum',iconNum);
         
		 //如果是竖排
		 if(options.arrangeType==1){
		 desktopIcon
		 .css({
				   "position":"absolute",
				   "margin":0,
				   "left":function(index,value){
					       var v=curcol*gW+30;
					           if((index+1)%rows==0){
							       curcol=curcol+1;
					              }
						   return v;	 
 						},
					"top":function(index,value){
 							var v=(index-rows*currow)*gH+20;
								if((index+1)%rows==0){
									 currow=currow+1;
									}
						    return v;
							}});
			}
			
		//如果是横排	
		if(options.arrangeType==2){
			desktopIcon.css({"float":"left","margin-left":options.iconMarginLeft,"margin-top":options.iconMarginTop});
			}	
			
		 });
 		
		},
 	creatIcon:function(o){
			var str="";	
			str+="<div class='desktopIcon' id='"+o.windowsId+"'><span class='icon'>";
			if(o.txNum){
				str+="<div class='txInfo'>"+o.txNum+"</div>";
				}
			str+="<img src='"+o.iconSrc+"' title='"+o.windowTitle+"'/></span><div class='text'><span>"+o.windowTitle+"</span><s></s></div></div>";
			return str;
			},
	//初始化创建桌面图标	
	desktopIconInit:function(data){
		var html="",_self=this;
		 for(var a in data){
			 html+="<div class='desktop' id='"+a+"'><div class='outerDesktop'><div class='innerDesktop'>";
			 var arr=data[a];
			 for(var i=0;i<arr.length;i++){
				 html+=_self.creatIcon(arr[i]);
				 }
 			 html+="<div class='desktopIcon addIcon'><span class='icon'><img src='template/default/home/theme/default/images/add_icon.png'/></span><div class='text'><span>添加</span><s></s></div></div></div></div></div>";
			 }
			 
		$("#desktopContainer").html(html);
		
		//给每个图标附加窗口属性数据
		for(var a in data){
			var arr=data[a];
			for(var i=0;i<arr.length;i++){
				$("#"+arr[i].windowsId).data("winAttrData",arr[i]);
				}
			}	 
		},
	addApp:function(appData){
		if(!$("#"+appData.windowsId).size()){
			
		var p=$("div.currDesktop"),_self=this;
 		var html=_self.creatIcon(appData);
				 
		//插入图标
		p.find("div.addIcon").before(html);
				 
		//附加数据给应用图标
		var thisApp=$("#"+appData.windowsId),config=$("body").data("desktopCofig");
		var data=thisApp.data("winAttrData",appData); 
		
		//更新桌面布局	
		_self.arrangeIcons(p,config);
		_self.clickInit();
		
		//图标添加到的桌面id并保存
		 _self.addIconSuccess(p.attr("id"),appData.windowsId);
		
		   }
		},
	 //添加图标成功后调用
	 addIconSuccess:function(pid,data){
		 //pid 值添加到的桌面id
		 //data 值新添加的图标数据
		 //这里写与后台的交互
		 db_ajax('admin.php?ac=user&fileurl=member&do=home&view=add&menuid='+pid.replace('desktop','')+'_'+data.replace('menu',''));
		 },
	//删除图标函数
	removeIcon:function(iconid){
		//这里写与后台的交互
		db_ajax('admin.php?ac=user&fileurl=member&do=home&view=removeIcon&menuid='+iconid.replace('menu',''));
		
		
		},
	//移动图标到其它桌面
	moveIconTo:function(desktopId,iconid){
			//这里写与后台的交互
			if(desktopId!='default_app'){
				db_ajax('admin.php?ac=user&fileurl=member&do=home&view=moveIconTo&menuid='+desktopId.replace('desktop','')+'_'+iconid.replace('menu',''));
			}
		}		 		
	};
	

//创建状态栏命名空间
myDesktop.taskBar={
	init:function(){
		
		//存储任务栏jq元素对象
        this.taskData();
		    
 		var taskBarData=$("body").data("taskBar"),
		    taskNextBox=taskBarData.taskNextBox,
			taskPreBox=taskBarData.taskPreBox,
			ww=taskBarData.ww,
			taskInnnerBlock=taskBarData.taskInnnerBlock,
			taskOuterBlock=taskBarData.taskOuterBlock,
			ow=ww-taskNextBox.outerWidth(true)*2,
		    _self=this;
				   
		
		$(window).wresize(function(){
 							  var mw=$(window).width()-taskNextBox.outerWidth(true)*2,tw=0;
								  tw=taskOuterBlock.width()<=mw?taskOuterBlock.width():mw;
 								  taskOuterBlock.width(tw);
								   });
		
		function taskMove(a){
			taskInnnerBlock.animate({"margin-right":'+='+a},1000);
			}
		
		taskNextBox.on("click",function(){
			var mr=taskInnnerBlock.css("margin-right"),
			    mr=parseInt(mr),
				taskTabWidth=$("body").data("tabWidth");
				
			if(Math.abs(mr)>taskTabWidth){	
			taskMove(taskTabWidth);
			}else{
				taskMove(Math.abs(mr));
				}
			
			});
			
		taskPreBox.on("click",function(){
			var ml=taskInnnerBlock.position(),
			    ml=Math.abs(ml.left),
				taskTabWidth=$("body").data("tabWidth");
				
			if(ml>taskTabWidth){
			taskMove(taskTabWidth*-1);
			}else{
				taskMove(ml*-1);
				}
				
			});	
				   
		},
	taskData:function(){
				$("body").data("taskBar",{
					   taskBlock:$("#taskBlock"),
		               taskInnnerBlock:$("#taskInnnerBlock"),
		               taskOuterBlock:$("#taskOuterBlock"),
			           taskNextBox:$("#taskNextBox"),
			           taskPreBox:$("#taskPreBox"),
			           ww:$(window).width(),
			           wh:$(window).height()
					   });
		},
	upTaskTab:function(id){
		var str=id.split("_").slice(1);
		
		//删除所有tab的taskCurrent样式
		$("div.taskTab").removeClass("taskCurrent");
		$("#taskTab_"+str).parent().addClass("taskCurrent"); 
		    
 		},
	removeTaskTab:function(id){
		var str=id.split("_").slice(1),
		    taskBarData=$("body").data("taskBar"),
 			taskTabWidth=$("body").data("tabWidth");
			 
		    $("#taskTab_"+str).parent().remove();
			var taskTabNum=$("div.taskTab").size(),
			    maxTabNum=$("body").data("maxTabNum");
			
			taskBarData.taskInnnerBlock.width(taskTabNum*taskTabWidth);
			if(taskTabNum<=maxTabNum){
				taskBarData.taskNextBox.hide();
			    taskBarData.taskPreBox.hide();
				taskBarData.taskOuterBlock.width(taskTabNum*taskTabWidth);
				}
		},			
	addTask:function(id,text,icon){
		var taskBarData=$("body").data("taskBar"),
		    taskNextBox=taskBarData.taskNextBox,
			taskPreBox=taskBarData.taskPreBox,
			ww=taskBarData.ww,
			taskInnnerBlock=taskBarData.taskInnnerBlock,
			taskOuterBlock=taskBarData.taskOuterBlock,
			ow=ww-taskNextBox.outerWidth(true)*2,
		    _self=this;
		
		//删除所有tab的taskCurrent样式
		$("div.taskTab").removeClass("taskCurrent");
		
		var taskTabHtml="<div class='taskTab taskCurrent'><a href='#'  title='"+text+"' class='taskItem' id='taskTab_"+id+"'><div class='tabIcon'><img src='"+icon+"'/></div><div class='tabTxt'><span>"+text+"</span></div></a></div>";
		
		$(taskTabHtml).prependTo(taskInnnerBlock);
		
		var taskTab=$("div.taskTab"),
		    tabNum=taskTab.size(),
 			tabWidth=taskTab.width();
			maxTabNum=Math.floor((ww-taskNextBox.outerWidth()*2)/tabWidth),
			win=$("#win_"+id);
 			
			$("body").data({"tabWidth":tabWidth,"maxTabNum":maxTabNum}); 
		    
			if(tabNum*tabWidth<=ow){
			taskOuterBlock.width(tabNum*tabWidth);
			}else{
				taskOuterBlock.width(ow);
				}
			taskInnnerBlock.width(tabNum*tabWidth);
		   
		   //单击tab
		   $("#taskTab_"+id).on("click",function(){
			  
			var win=$("#win_"+this.id.split("_")[1]),
			    left=win.data("oldLeft"),
			    i=$("div.desktop").index(win.parent()),
			    j=$("div.desktop").index($("div.currDesktop"));
		
		    if(win.hasClass("hideWin")){ 	
		     win.css("left",left).removeClass("hideWin");
 		    }
			 
			win.trigger("mousedown");
 			
			if(win.data("windowStatus")=="maximized"){
				$("#desktopsContainer").css("z-index",800);
				}
			
			if(i!=j){
		      myDesktop.desktopBar.moveDesktop(i);
		      }
			    
			   });
		   
 		   //如果tab超过最大显示数目，则显示左右移动按钮		
		   if(tabNum>maxTabNum){
			  taskNextBox.show();
			  taskPreBox.show();
  		    }
		
 		 
		 //初始化任务栏Tab右键菜单
		 var data=[
					[{
					text:"最大化",
					func:function(){
 						win.find('a.winMaxBtn').trigger('click');
						}
					  },{
					text:"最小化",
					func:function(){
						win.find('a.winMinBtn').trigger('click');
						}
						  }]
					,[{
					  text:"关闭",
					  func:function(){
						  $("#smartMenu_taskTab_"+id).remove();
 						  win.find('a.winCloseBtn').trigger('click');
						  } 
					  }]
					];
		 myDesktop.contextMenu($("#taskTab_"+id),data,"taskTab_"+id,10);
		} 
	};

//侧边栏
myDesktop.sildeBar={
	init:function(iconData,pos){
		 var desktopContainer=$("#desktopContainer"),
		     leftBar=$("#leftBar"),
			 rightBar=$("#rightBar"),
			 topBar=$("#topBar"),
			 dockContainer=$("#dockContainer"),
			 default_app=$("#default_app"),
			 html="",
			 dock_drap_effect=$(".dock_drap_effect"),
			 dock_drap_effect_left=$(".dock_drap_effect_left"),
			 dock_drap_effect_right=$(".dock_drap_effect_right"),
			 dock_drap_effect_top=$(".dock_drap_effect_top"),
			 dock_drap_mask=$(".dock_drap_mask"),
			 dock_drop_region_top=$(".dock_drop_region_top"),
			 dock_drop_region_left=$(".dock_drop_region_left"),
			 dock_drop_region_right=$(".dock_drop_region_right")
			 _self=this;
		 
		 //添加图标
		  for(var i=0;i<iconData.length;i++){
				 html+=myDesktop.desktop.creatIcon(iconData[i]);
				 }
		 
		 default_app.html(html);
		 
		 for(var i=0;i<iconData.length;i++){
				$("#"+iconData[i].windowsId).data("winAttrData",iconData[i]);
				}
  		 
		 var icons=default_app.find(".desktopIcon");
 
		 _self.xwInit(icons);
		 
		 
		 $("body").data("dropIcon",false);
		 
		 default_app
		 .droppable({
			scope:'a',
			drop: function(event,ui){
				var curDragPar=$("body").data("curDragPar");	
 				var num=ui.draggable.parent().is($(this))?8:7;
				 
				if($(this).find(".desktopIcon").size()<num){
				
				 if(!$("body").data("dropIcon")){
 					if(curDragPar.is($(this))){
					ui.draggable.appendTo($(this));
					}else{
					var data=ui.draggable.data("winAttrData");	
 				    _self.addIcon(data);
				    ui.draggable.remove();
					
					//桌面图标移动到侧边栏时
					myDesktop.desktop.moveIconTo("default_app",data.id);
					
						}
  					}
					
				  $("body").data("dropIcon",false);	
 				} 
			 }		
			});
 			
  	  //侧边栏位置	 
	  if(pos=="left"){
			  _self.moveLeft();
			 }
		
	   if(pos=="right"){
			 _self.moveRight();
 			}	 
 	   
	   if(pos=="top"){
			 _self.moveTop();
  			}
	   
	   //拖曳侧边栏
	   var isMd=false,isMo=false;
   		
		function hideMark(){
			isMd=false;
			isMo=false;
			dock_drap_effect.hide();
			dock_drap_mask.hide();
			}
		
		function showMk(id){
 			   
				if(id=="leftBar"){
				dock_drap_effect.removeClass("dock_drap_effect_current");
				dock_drap_effect_left.addClass("dock_drap_effect_current")
				}
				
				if(id=="rightBar"){
				dock_drap_effect.removeClass("dock_drap_effect_current");
				dock_drap_effect_right.addClass("dock_drap_effect_current")
				}
				
				if(id=="topBar"){
				dock_drap_effect.removeClass("dock_drap_effect_current");
				dock_drap_effect_top.addClass("dock_drap_effect_current")
				};
			}
		
	 dockContainer.mousedown(function(event) {
			isMd = true;
			$(this).mousemove(function(event) {
				isMo = true;
				if (isMd) {
					dock_drap_effect.show();
					dock_drap_mask.show();
					showMk($(this).parent().attr("id"));
				}
			});
			$("body").mouseup(function() {
				hideMark();
			});
			$(".dock_drap_effect_top,.dock_drop_region_top").mouseover(function() {
				showMk("topBar");
			}).mouseup(function() {
				hideMark();
				_self.moveTop();
			});
			$(".dock_drap_effect_left,.dock_drop_region_left").mouseover(function() {
				showMk("leftBar");
			}).mouseup(function() {
				hideMark();
				_self.moveLeft();
			});
			$(".dock_drap_effect_right,.dock_drop_region_right").mouseover(function() {
				showMk("rightBar");
			}).mouseup(function() {
				hideMark();
				_self.moveRight();
			});
		}).mouseup(function() {
			$(this).removeClass("dock_drap_effect_current");
		});
 	    
		//初始化小工具栏
		_self.wigInit();
 		},
	//添加图标到侧边栏
	addIcon:function(iconData,obj){
		 
		var default_app=$("#default_app"),
		html=myDesktop.desktop.creatIcon(iconData);
		//console.log(obj);
		obj==undefined?default_app.append(html):$(html).insertAfter(obj);
		$("#"+iconData.windowsId).data("winAttrData",iconData);
		
		this.xwInit($("#"+iconData.windowsId));
		 
		},	
	//---------小工具栏----------
	wigInit:function(){
	 
	 //时钟
	 $("#shizhong_btn").click(function(event){
		event.preventDefault(); 
		event.stopPropagation();
		 myDesktop.widget.init({
			id:"shizhong",
			width:140,
			height:230,
			title:"时钟",
			isDrag:true,
			iframeSrc:"template/default/home/app_tools/shizhong/index.html",
			top:20,
			left:'auto',
			right:50,
			parentTo:$("div.currDesktop")
 			 });
		 });
	
	 //天气预报
	 $("#weather_btn").click(function(event){
		event.preventDefault(); 
		event.stopPropagation();
		 myDesktop.widget.init({
			id:"weather",
			width:200,
			height:320,
			title:"天气预报",
			isDrag:true,
			iframeSrc:"template/default/home/app_tools/weather/index.html",
			top:260,
			left:'auto',
			right:20,
			parentTo:$("div.currDesktop")
 			 });
		 });	
	  
	 $("#shizhong_btn,#weather_btn").trigger("click");
	 
	 $("div.default_tools > a").mousemove(function(event){
		event.preventDefault(); 
		event.stopPropagation();
		 })
	 .mousedown(function(event){
		event.preventDefault(); 
		event.stopPropagation();
		 });
		
		},	
	xwInit:function(icons){
		var _self=this;
		 icons
		 .on("click",function(event){
							event.stopPropagation();	
							var data=$(this).data("winAttrData"),
 							p=$("div.currDesktop");
							data.parentPanel=p;
							
							myDesktop.myWindow.init(data);
							
							//添加到状态栏
							if(!$("#taskTab_"+data.windowsId).size()){
							myDesktop.taskBar.addTask(data.windowsId,data.windowTitle,data.iconSrc);
							}
 		 })
 		 .draggable({
			 helper: "clone",
			 scroll:false,
			 scope:'a',
			 containment:'body',
			 appendTo: 'parent' ,
			 start: function(event, ui) {
				ui.helper.removeClass("btnOver").removeClass("desktopIconOver");
				$("body").data("curDrag",$(this).next());
				$("body").data("curDragPar",$(this).parent());
				$("#desktopsContainer").css("z-index",44);
				 
 			 },
			stop:function(){
				$("#desktopsContainer").css("z-index",50);
				}
			 })
		.droppable({
			scope:'a',
			drop: function(event,ui) {
				event.stopPropagation();
 				var p=$(this).parent();
 				
				var curDrag=$("body").data("curDrag"),curDragPar=$("body").data("curDragPar");	
 				 
				if(curDragPar.is(p)){
					if(p.find(".desktopIcon").size()<8){
			        
					if($(this).is(curDrag)){
 				     ui.draggable.insertAfter($(this)); 
 				    }else{		
				     ui.draggable.insertBefore($(this)); 
					}
			     
				  }else{
					  alert("侧边栏放不下了，请先去掉一些");
					 }	
				}else{
				 if(p.find(".desktopIcon").size()<7){
 				 _self.addIcon(ui.draggable.data("winAttrData"),$(this));
				 ui.draggable.remove();
 				  }else{
					  alert("侧边栏放不下了，请先去掉一些");
					 }	
					}
				
				$("body").data("dropIcon",true);	

  				}
			})
		 .hover(function(){ 
							  $(this).addClass("btnOver");
							  },function(){
										  $(this).removeClass("btnOver"); 
										   })
 		.on("mousedown",function(event){
								  event.stopPropagation();
								 }); 
		},	
	moveLeft:function(){
		     var leftBar=$("#leftBar"),dockContainer=$("#dockContainer");
			 $("#rightBar,#topBar").hide();
 		     leftBar.show().append(dockContainer);
 			 dockContainer.removeClass("dock_pos_right").addClass("dock_pos_left").addClass("dock_container");
 			 myDesktop.desktop.arrangeIcons($(".desktop"),$("body").data("desktopCofig"));
		},
	moveRight:function(){
		    var rightBar=$("#rightBar"),dockContainer=$("#dockContainer");
			 $("#leftBar,#topBar").hide();
 			dockContainer.removeClass("dock_pos_left").addClass("dock_pos_right").addClass("dock_container");
			rightBar.show().append(dockContainer);
 			myDesktop.desktop.arrangeIcons($(".desktop"),$("body").data("desktopCofig"));
		},	
	moveTop:function(){
		    var topBar=$("#topBar"),dockContainer=$("#dockContainer");
		    $("#rightBar,#leftBar").hide();
 			topBar.show().append(dockContainer);
 		    dockContainer.removeClass("dock_container").removeClass("dock_pos_right").removeClass("dock_pos_left");
			myDesktop.desktop.arrangeIcons($(".desktop"),$("body").data("desktopCofig"));
			 
 		}	 
	};

//创建widget窗口
myDesktop.widget={
	init:function(options){
		
		var defaults={
			id:"",
			width:210,
			height:210,
			title:"小工具",
			isDrag:true,
			iframeSrc:"",
			top:0,
			left:0,
			right:'auto',
			bottom:'auto',
			parentTo:"body"
			},
			_self=this;
			
		var o = $.extend(defaults, options);	
		
		if(!$("#myWidget_"+o.id).size()){
			  
			$(o.parentTo).append(_self.widgetHtml(o));
 			
			var newWidget=$("#myWidget_"+o.id)
			    widgetTitle=newWidget.find("div.widgetTitle"),
				widgetClose=newWidget.find("a.widgetClose"),
				widgetCon=newWidget.find("div.widgetCon");
				
				newWidget
				.css({"width":o.width,"height":o.height,"left":o.left,"right":o.right,"top":o.top,"bottom":o.bottom})
 				.hover(function(){
 					$(this).find(".innerWidgetTitle").show();
					},function(){
						$(this).find(".innerWidgetTitle").hide();
						})
				.find("iframe")
				.attr("src",o.iframeSrc)
				.load(function(){
							 newWidget.find("div.loading").hide();
 							   });
				
				widgetCon.height(o.height-widgetTitle.height());
						
			    if(o.isDrag){			
				newWidget.draggable({
 					scroll:false,
					drag:function(){
						$(this).find(".iframeFix").show();
						},
					stop:function(){
						var l=parseInt($(this).css("left")),tw=$(this).width();
						$(this).find(".iframeFix").hide(); 
						$(this).css({"left":"auto","right":$(window).width()-l-tw-73});
						}
					});
					}
			
			widgetClose.click(function(){
									   newWidget.remove();
									   });
					
			}
  	  		
 		},
	widgetHtml:function(o){
		return "<div class='myWidget' id='myWidget_"+o.id+"'><div class='widgetTitle'><div class='innerWidgetTitle'><b>"+o.title+"</b><span class='widgetBtn'><a href='#' class='widgetClose'></a></span></div></div><div class='widgetCon'><iframe src='#' allowtransparency='true' frameborder='0' scrolling='no' width='100%' height='100%'></iframe><div class='loading'>正在加载中...</div><div class='iframeFix' id='iframeFix_"+o.id+"'></div></div></div>";
 		}	
	};
	
//开始菜单 
myDesktop.startBtn={
	init:function(data){
		
		//读取元素对象数据
		var $start_btn=$("#start_btn"),
		    $start_block=$("#start_block")
			,$start_item=$("#start_item")
			,slideBar=$("#topBar,#leftBar,#rightBar")
			,_this=this;
		
		//alert(data.length);
 		function creatItme(d,a){
		var itemHtml="",i,j;
		
		if(a){
		itemHtml+="<ul class='item childItem'>";
		}else{
			itemHtml+="<ul class='item'>";
			}
		
		for(i=0;i<d.length;i++){
		 
		var arr=d[i];
		if(i!=0){
			itemHtml+="<div class='line'></div>";
			}	
			
		for(j=0;j<arr.length;j++){
			
			if(arr[j]["iconSrc"]==undefined){
				arr[j]["iconSrc"]="template/default/home/theme/default/images/deficon1.gif";
				}
			 
			if(arr[j]["childItem"]==undefined){
			    itemHtml+="<li id='item0"+arr[j]["windowsId"]+"'   class='dragitem' ><span><img src='"+arr[j]["iconSrc"]+"'/>"+arr[j]["windowTitle"]+"</span></li>";
 			}else{
 				itemHtml+="<li id='item0"+arr[j]["windowsId"]+"'><span><img src='"+arr[j]["iconSrc"]+"'/>"+arr[j]["windowTitle"]+"</span><b></b>";
  				itemHtml+=creatItme(arr[j]["childItem"],1);
 				itemHtml+="</li>";
 			}
 			}	
  		}
		
		itemHtml+="</ul >";
		return itemHtml;
			};
  		
 		$start_item.append(creatItme(data,0));
		
		//鼠标经过展开下级菜单
		$(".item li").hover(function(){
            var childItem=$(this).children(".childItem");
            childItem.show(1,function(){
                 var of=childItem.offset(),h=childItem.outerHeight(),hh=$(window).height();
                
                if(hh-of.top-h < 0){
                    childItem.css("top",hh-of.top-h-10);
                }
            });
        
			},function(){
			$(this).children(".childItem").hide();   
			});
 		
		//单击打开窗口
		$(".dragitem").on("click",function(event){
							event.stopPropagation();	
							var data=$(this).data("winAttrData");
							    data.parentPanel="div.currDesktop";
							myDesktop.myWindow.init(data);
 							
							//添加到状态栏
							if(!$("#taskTab_"+data.windowsId).size()){
							     myDesktop.taskBar.addTask(data.windowsId,data.windowTitle,data.iconSrc);
							}
							
							$("#start_item").hide();
			   });
		
		
		//附加data数据
		function addData(data){
		   var i,a;
		   
		   for(a=0;a<data.length;a++){
			for(i=0;i<data[a].length;i++){
				
				if(data[a][i]["childItem"]==undefined){
					$("#item0"+data[a][i]["windowsId"]).data("winAttrData",data[a][i])
					.draggable({
							 helper: "clone",
							 scroll:false,
							 scope:'a',
							 containment:'body',
							 zIndex:100000,
							 appendTo: 'body'
						 });
					 
				  }else{
					 addData(data[a][i]["childItem"]);
				 
					}
 			   }
		   }
			}
 		
		addData(data);
		
		//开始按钮、菜单交互效果
		$start_btn.click(function(event){
								  event.preventDefault();
								  event.stopPropagation();
 								  
								  if($start_item.is(":hidden")){
								  slideBar.css("z-index",800);	  
								  $start_item.show();
								  }else{
								  slideBar.css("z-index",45);	  
								  $start_item.hide();
								  }
								  
								  })
		.on("mousemove",function(event){
								event.stopPropagation(); 
								 });
		
		$start_block.mousemove(function(event){event.preventDefault(); });
		
		$("body").click(function(event){
 								 event.preventDefault(); 
								 
								 slideBar.css("z-index",45); 
								 $start_item.hide();
								 $(".childItem").hide();
									  });
 
 		}
 	};

//登陆窗口
myDesktop.login={
	init:function(src){
		var loginHtml="<div class='login_box'><div id='ui_boxyClose' class='ui_boxyClose'></div><div class='login_logo'></div><iframe src='#' frameborder='0' width='380' height='258' scrolling='no'></iframe></div>",
		    loginMark="<div class='ui_maskLayer'></div>";
		
		$("body").append($(loginMark));
		$("body").append($(loginHtml));
		
		var login_box=$("div.login_box"),ui_boxyClose=$("#ui_boxyClose");
		
		login_box
		.draggable({
					scroll:false,
					containment:'parent',
					handle:".login_logo"
					})
		.find("iframe")
		.attr("src",src);
		
		ui_boxyClose.click(function(){
										$("div.login_box,div.ui_maskLayer").remove();  
										  });
		}};
		
//全局视图
myDesktop.appManagerPanel={
	init:function(){
		var appManagerPanel=$("#appManagerPanel"),
		    aMg_close=$(".aMg_close"),
			aMg_dock_container=$(".aMg_dock_container"),
			aMg_folder_container=$(".aMg_folder_container"),
			aMg_folder_innercontainer=$(".aMg_folder_innercontainer"),
 			aMg_prev=$("#aMg_prev"),
			aMg_next=$("#aMg_next"),
			wh=$(window).height(),
			ww=$(window).width(),
			deskTopNum=$("div.desktop").size(),
			dhtml="",
			_self=this;
			
			//取消右键菜单
			myDesktop.contextMenu(appManagerPanel,[],"appManagerPanel",10);
			
			aMg_folder_container.height(wh-aMg_dock_container.height());
  			
			aMg_dock_container.html($("#default_app").clone(true));
			
			function amgClose(){
				appManagerPanel.css("top","-9999px");
 				$("#desktopWrapper").show();
				aMg_folder_innercontainer.css("margin-left",0);
				myDesktop.desktop.arrangeIcons($("div.desktop"),$("body").data("desktopCofig"));
				}
				
			aMg_close.click(function(){
									 amgClose();
									 });
			
			for(var i=0;i<deskTopNum;i++){
				dhtml+="<div class='folderItem folderItem_turn' id='folder_"+i+"'><div class='folder_bg'>"+(i+1)+"</div><div class='folderOuter'><div class='folderInner' style='overflow: hidden;'></div></div><div class='aMg_line_y'></div></div>";
 				}
				
		   	aMg_folder_innercontainer.html(dhtml);
			
			var folderItem=$("div.folderItem"),fitemWidth=parseInt(ww/5),folderOuter=$(".folderOuter");
			folderItem.css("width",fitemWidth);
  			
			for(var i=0;i<deskTopNum;i++){
				$("#folder_"+i).find(".folderInner").append($("div.innerDesktop").eq(i).find(".desktopIcon:not(.addIcon)").clone());
				$("#folder_"+i).find(".folderOuter").niceScroll("#folder_"+i+" .folderInner",{touchbehavior:false,cursorcolor:"#666",horizrailenabled:true,cursoropacitymax:0.8,cursorborder:"1px solid #ccc"});
  				$(window).wresize(function(){$("#folder_"+i).find(".folderOuter").getNiceScroll().resize();});
 				}
  			
			var folderIcon=folderItem.find(".desktopIcon");
			
 			folderIcon
 			.on("mouseover",function(){
							$(this).addClass("hover");
							})
			.on("mouseout",function(){
									$(this).removeClass("hover");	 
										 })
			.attr("style","");
			
			$(".aMg_dock_container,.folderItem")
			.find(".desktopIcon")
			.on("click",function(e){
				                 amgClose();
								 var index=$(this).parent().parent().parent().attr("id").split("_")[1],navBar=$("#navBar");
								 $("#"+this.id).trigger('click');
 								 navBar.find("span > a").eq(parseInt(index)).trigger('click');
								 
								 var ev=e||event;
								 ev.stopPropagation();
								 return false;
 								 });
			
			aMg_folder_innercontainer.width(deskTopNum*(fitemWidth)).height(wh-aMg_dock_container.height());
			
			$(window).wresize(function(){
									var h=$(window).height()-aMg_dock_container.height(),fw=$(window).width()/5;   
									aMg_folder_container.height(h);    
									aMg_folder_innercontainer.height(h).width(deskTopNum*fw);
									folderItem.css("width",fw);
									fitemWidth=parseInt(fw);
									  });
									  
		   if(deskTopNum>5){
			   aMg_folder_container.mousemove(function(event){
				   if(event.pageX<50){
					   aMg_prev.show();
					   }else{
						   aMg_prev.hide();
						   }
				   		   
				   if(event.pageX>$(window).width()-50){
					   aMg_next.show();
					   }else{
						   aMg_next.hide();
						   }	   
				   });
			   }
		 
		 var moveIndex=0,maxMoveNum=deskTopNum-5;
		 
		 function move_amg(a){
 			 aMg_folder_innercontainer.animate({
				 "margin-left": '+='+a
				 },100,"easeInOutCirc");
			 }
			 	   
		 //单击向上翻页	   
		 aMg_prev.click(function(){
			 moveIndex=parseInt(aMg_folder_innercontainer.css("margin-left"));
   			 if(moveIndex<0){
				 move_amg(fitemWidth);
				 }
			 });	   		  
		
		 //下一页
		 aMg_next.click(function(){
			 moveIndex=parseInt(aMg_folder_innercontainer.css("margin-left"));
 
			 if(moveIndex>maxMoveNum*-1*fitemWidth){
				  move_amg(-1*fitemWidth);
				 }
			 });
		
 		} 	
	};
function db_ajax(urls){
	jQuery.ajax({
		type: 'GET',
		url: urls+'&date='+new Date()
	});
}