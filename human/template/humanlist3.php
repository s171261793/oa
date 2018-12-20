<!DOCTYPE html>
<!--[if IE 6 ]> <html class="ie6 lte_ie6 lte_ie7 lte_ie8 lte_ie9"> <![endif]--> 
<!--[if lte IE 6 ]> <html class="lte_ie6 lte_ie7 lte_ie8 lte_ie9"> <![endif]--> 
<!--[if lte IE 7 ]> <html class="lte_ie7 lte_ie8 lte_ie9"> <![endif]--> 
<!--[if lte IE 8 ]> <html class="lte_ie8 lte_ie9"> <![endif]--> 
<!--[if lte IE 9 ]> <html class="lte_ie9"> <![endif]--> 
<!--[if (gte IE 10)|!(IE)]><!--><html><!--<![endif]-->
 <head>
    <title><?php echo $_CONFIG->config_data('name')?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=10,chrome=1" />
<link rel="stylesheet" type="text/css" href="template/default/content/css/style2014.css">
<script type="text/javascript" src="template/default/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="template/default/content/js/lockTableTitle.js"></script>
<script language="javascript" type="text/javascript" src="template/default/content/js/common.js"></script>
<script language="javascript" type="text/javascript" src="DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
    
    var locktb;
    $(function(){
        locktb=new Kkctf.table.lockTableSingle({
            tMain:$('#lockTable'),            //table的层
            padWidth:15,                        //单元格左右的padding的值总和数值
            borWidth:2,                        //表格左右边框宽度总和值
            subtHeig:150,                    //表格高度减去多少
            dinamicDiv:$('#dynamicDiv'),      //动态层的高度.表格会根据动态层的显示或隐藏进行表格大小的动态调整(可选)
            autoHeight:true                 //表格窗口是否随着窗口的高度改变自动调整高度(可选)
        });
    });

    function formview(){
    
        if($('#dynamicDiv').is(':visible')){
            $('#dynamicDiv').hide();
        }else{
            $('#dynamicDiv').show();
        }
        
        locktb.autoHeightFn();
    }
    function sendForm(){
	   document.save.submit();
	}
	function updateform(type){
		if(type==1){
			document.getElementById("uptype").value='1';
		}
		document.update.submit();
	}
</script>
</head>
<body class="body-wrap">
<div class="tabbable work-nav"> <!-- Only required for left/right tabs -->
				<ul id="myTab" class="nav nav-tabs">
<li <?php if($type==1){?>class="active"<?php }?>><a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&type=1" data-toggle="tab">人事档案管理</a></li>
<li <?php if($type==2){?>class="active"<?php }?>><a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&type=2" data-toggle="tab">证照管理</a></li>
<li <?php if($type==3){?>class="active"<?php }?>><a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&type=3" data-toggle="tab">学习经历</a></li>
<li <?php if($type==4){?>class="active"<?php }?>><a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&type=4" data-toggle="tab">工作经历</a></li>
<li <?php if($type==5){?>class="active"<?php }?>><a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&type=5" data-toggle="tab">劳动技能</a></li>
<li <?php if($type==6){?>class="active"<?php }?>><a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&type=6" data-toggle="tab">社会关系</a></li>
<li <?php if($type==7){?>class="active"<?php }?>><a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&type=7" data-toggle="tab">人事调动</a></li>
<li <?php if($type==8){?>class="active"<?php }?>><a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&type=8" data-toggle="tab">复职管理</a></li>
<li <?php if($type==9){?>class="active"<?php }?>><a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&type=9" data-toggle="tab">职称评定</a></li>
<li <?php if($type==10){?>class="active"<?php }?>><a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&type=10" data-toggle="tab">员工关怀</a></li>
					
				</ul>
			</div>
<div class="search_area">
    <form method="get" action="admin.php" name="save">
	<input type="hidden" name="ac" value="<?php echo $ac?>" />
		<input type="hidden" name="do" value="list" />
		<input type="hidden" name="fileurl" value="<?php echo $fileurl?>" />
		<input type="hidden" name="type" value="<?php echo $type?>" />
        <div class="form-search form-search-top" style="text-align:left;padding-left:10px;">
                        <?php echo get_keyuser($ui,$un);?>    
			            
	        <div class="adv-select-label">流水号：</div>
       		<input type="text"  name="number" size="20" class="span1" value="<?php echo urldecode($number)?>">  

            <div class="adv-select-label">起止日期：</div>
            <input type="text" class="span1" value="<?php echo $vstartdate?>"  style="width:80px;" readonly="readonly"  onClick="WdatePicker();" name='vstartdate'> 至 <input type="text" class="span1" value="<?php echo $venddate?>"  style="width:80px;" readonly="readonly"  onClick="WdatePicker();" name='venddate'>
			
           
            <button id="do_search" type="button" onClick="sendForm();" class="btn btn-primary">查 询</button>
           <button  onClick="formview()" type="button" class="btn">切换更多查询</button>
        </div>
       <div class="form-search form-search-bottom query-fom-search" id="dynamicDiv" style="display:none;margin-top:10px;text-align:left;padding-left:10px;"> 
	   <?php
						$numss=0;
						foreach ($companylist as $row) {
						$numss++
						?>
						<input type="hidden" name="kinputname[]" value="<?php echo $row["inputname"]?>" /> 
          <div class="adv-select-label"><?php echo $row["formname"]?>：</div>
       		<?php
							if($row["type"]=='3'){
								echo '<input type="text" value="'.$fromkeyword[$row["inputname"]].'"  style="width:90px;" readonly="readonly"  onClick="WdatePicker();" name="fromkeyword['.$row["inputname"].']" >';
							}elseif($row["inputtype"]=='3' || $row["inputtype"]=='4' || $row["inputtype"]=='5'){
								
								$inputvaluenum=explode('|',$row["inputvaluenum"]); 
								echo '<select name="fromkeyword['.$row["inputname"].']" id="'.$row["inputname"].'" style="width:90px;">';
								echo '<option value="" selected="selected">选择内容</option>';
								for($i=0;$i<sizeof($inputvaluenum);$i++){
									echo '<option value="'.$inputvaluenum[$i].'" ';
									if(trim($fromkeyword[$row["inputname"]])==trim($inputvaluenum[$i])){
										echo 'selected="selected"';
									}
									echo '>'.$inputvaluenum[$i].'</option>';
									
								}
								echo '</select> ';
							}else{
								echo '<input type="text" value="'.$fromkeyword[$row["inputname"]].'" name="fromkeyword['.$row["inputname"].']" style="width:90px;">';
							}
							}
							?>     
    
       </div>   
    </form>
</div>


<div class="data-wrap">
	<div class="data-operation">
		<div class="button-operation">
		<button type="button" action="new_work" class="btn btn-success" onClick="javascript:window.location='admin.php?ac=<?php echo $fileurl?>add&fileurl=<?php echo $fileurl?>&type=<?php echo $type?>'">新增信息</button>				
<button type="button" onClick="updateform(1);" action="cancel_concern" class="btn btn-danger">清理数据</button>

				<?php echo get_exceldown('excel_50',1);?>
				
		</div>

<div class="pager_operation">
	<?php echo newshowpage($num,$pagesize,$page,$url);?>
	
	
</div>
</div>		
</div>
<form name="update" method="post" action="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>">
		<input type="hidden" name="do" value="update" />
		<input type="hidden" name="uptype" id="uptype" value="2" />
		<input type="hidden" name="type" value="<?php echo $type?>" />

<div class="data-list" >
<div  id="lockTable">
<table  class="table table-bordered table-hover" width="100%">
      <tr class="editThead" align="center">
      <td width="40"><input type="checkbox" value="1" name="chkall" onClick="check_all(this)" /></td>
      <td width="100">流水号</td>
								<td>单位员工</td>
									<td width="120">所学专业</td>
									<td width="120">所获学历</td>
									<td width="120">所在院校</td>
									<td width="120">证明人</td>
									<td width="140">发布时间</td>
									<td width="120">操作</td>
   </tr>
<?php
foreach ($result as $row) {
?>
    <tr >
      <td width="40"><?php
get_boxlistkey("id[]",$row['id'],$row['uid'],$_USER->id);
?></td>
<td><?php echo $row['number']?></td>
<td>
<a href="admin.php?ac=humanlist&do=view&fileurl=human&id=<?php echo $row['id']?>&type=<?php echo $type?>"><?php echo $row['username']?></a>
</td>
<td><?php echo get_human_db($row['id'],"toa_3_MAJOR")?></td>
<td><?php echo get_human_db($row['id'],"toa_3_ACADEMY_DEGREE")?></td>
<td><?php echo get_human_db($row['id'],"toa_3_SCHOOL")?></td>
<td><?php echo get_human_db($row['id'],"toa_3_WITNESS")?></td>
<td><?php echo $row['date']?></td>
<td>
<?php get_urlkey("编辑","admin.php?ac=".$fileurl."add&fileurl=".$fileurl."&do=edit&id=".$row['id']."&type=".$type."","".$row['uid']!=$_USER->id && $row['workuser']!=$_USER->id."")?> | 
<a href="admin.php?ac=humanlist&do=view&fileurl=human&id=<?php echo $row['id']?>&type=<?php echo $type?>">查看</a>
</td>
    </tr>
<?php } ?>	       
    </table>
</div>
</div>
</form>
<form name="excel" method="post" action="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>">
		<input type="hidden" name="do" value="excel" />
		<input type="hidden" name="type" value="<?php echo $type?>" />
		<input type="hidden" name="vstartdate" value="<?php echo $vstartdate?>" />
		<input type="hidden" name="venddate" value="<?php echo $venddate?>" />
		<input type="hidden" name="number" value="<?php echo $number?>" />
		<input type="hidden" name="un" value="<?php echo urldecode($un)?>" />
		<input type="hidden" name="ui" value="<?php echo urldecode($ui)?>" />
		<?foreach ($companylist as $row) {?>
		<input type="hidden" name="kinputname[]" value="<?php echo $row["inputname"]?>" />
		<input type="hidden" name="fromkeyword[<?php echo $row["inputname"]?>]" value="<?php echo $fromkeyword[$row["inputname"]]?>" />
		<?}?>
	</form>
</body>
</html>