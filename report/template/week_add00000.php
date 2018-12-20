<html>
<head>
  <title>周报信息</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <link rel="stylesheet" type="text/css" href="template/default/css/bootstrap.css"> -->
  <!-- <link rel="stylesheet" type="text/css" href="template/default/css/build.css"> -->
  <!-- <link rel="stylesheet" type="text/css" href="template/default/content/css/bootstrap-modal.css"> -->
  <link rel="stylesheet" type="text/css" href="template/default/content/css/bootstrap.min.css" media="screen">
  <script language="javascript" type="text/javascript" src="DatePicker/WdatePicker.js"></script>
  <style>
      /*  table tr td {
                text-align:center;
        }*/

        .th-inner {
            width:120px !important;
        }

       body{
      background-color:#FAFAFC;
    }

 
        .radio{
        display: inline-block;
        position: relative;
        line-height: 18px;
        margin-right: 10px;
        cursor: pointer;
    }
    .radio input{
        display: none;
    }
    .radio .radio-bg{
        display: inline-block;
        height: 19px;
        width: 19px;
        margin-right: 5px;
        padding: 0;
        background-color: #5BD3DE;
        border-radius: 100%;
        vertical-align: top;
        box-shadow: 0 1px 15px rgba(0, 0, 0, 0.1) inset, 0 1px 4px rgba(0, 0, 0, 0.1) inset, 1px -1px 2px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .radio .radio-on{
        display: none;
    }
    .radio input:checked + span.radio-on{
        width: 10px;
        height: 10px;
        position: absolute;
        border-radius: 100%;
        background: #FFFFFF;
        top: 4px;
        left: 24px;
        box-shadow: 0 2px 5px 1px rgba(0, 0, 0, 0.3), 0 0 1px rgba(255, 255, 255, 0.4) inset;
        background-image: linear-gradient(#ffffff 0, #e7e7e7 100%);
        transform: scale(0, 0);
        transition: all 0.2s ease;
        transform: scale(1, 1);
        display: inline-block;
    }

</style>
  </style>
</head>
<body class="bodycolor">

  <table class="table table-responsive">
    <tr>
      <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 周报信息</span>
      </td>
    </tr>

   <!--  <tr>
    	<td><br/>1.本表由汇报人每周五18:00之前油价发送给相应负责人 2.汇总表A、B、C、D组成</td>
    </tr> -->
  </table>
  <script Language="JavaScript"> 
        // function CheckForm()
        // {
        //    if(document.save.name.value=="")
        //    { alert("姓名不能为空！");
        //      document.save.name.focus();
        //      return (false);
        //    }
        //    if(document.save.phone.value=="")
        //    { alert("手机不能为空！");
        //      document.save.phone.focus();
        //      return (false);
        //    }
        //    if(document.save.birthdate.value=="")
        //    { alert("出生日期不能为空！");
        //      document.save.birthdate.focus();
        //      return (false);
        //    }
        //    return true;
        // }
        function sendForm()
        {
           if(CheckForm())
              document.save.submit();
        }
         
  </script>
  <form id="weeklyInfo" name="save" method="post" action="?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=sub">
  <input type="hidden" name="savetype" value="add" />
  	<input type="hidden" name="uid" value="<?php echo $result['uid']?>" />
  	<input type="hidden" name="name" value="<?php echo $result['name']?>" />
    <input type="hidden" name="orderid" value="<?php echo $_GET['orderid']?>" />

    <table class="table table-bordered table-hover" id="first" width="200%">
    <!-- <table class="table table-condensed" style="word-break:break-all; word-wrap:break-all;" id="first" > -->
    		<caption >
    				第
  				<!-- 第多少周总结-->
  				<select name="week_number" class="selectpicker" style = "width:60px;" >
  					<?php
  						

  							for( $i=1;$i<=54;$i++)
  							{

  								if(date("W")== $i)
  								{
  									echo "<option style = 'background-color:#33CC33;' value=".$i."  selected = 'selected'>".$i."</option>\r\n";
  								}else{
  									echo "<option value=".$i.">".$i."</option>\r\n";
  								}	
  							}
  						
  					?>

    				</select>
    				周
  				<?php 

  					//输出周报时间
  					$date_first = $infoWeek_fall[0]['weekly_first_start']?$infoWeek_fall[0]['weekly_first_start']:date('Y-m-d',PHP_TIME);
  					$date_end = $infoWeek_fall[0]['weekly_first_end']?$infoWeek_fall[0]['weekly_first_end']:date('Y-m-d',PHP_TIME);

  				?>

    			( <input type="text" name="weekly_first_start" class="BigInput" size="20"  onClick="WdatePicker();" value="<?=$date_first?>" style="width:140px;height:30px;"/> 至 <input type="text" name="weekly_first_end" class="BigInput" size="20"  style="width:140px;height:30px;" onClick="WdatePicker();" value="<?=$date_end?>" /> ) 总结汇报表


    			</caption>

        <thead>
        <!-- 表头-->
    		<tr bgcolor="#E7F0FB" >
    			<th colspan="3" ><sapn>填表日期：<?php echo date("Y/m/d H:i:s",PHP_TIME)?></sapn></th>
    			<th >汇报人：<?php echo $_USER->name;?></th>
    			<th colspan="2" >部门：
          
              <select name="departmentida" id="changeInfo" style = "width:200px;">
                <?php if(!$_GET['depid']){?>

                  <?php foreach ($departmentid_on as $key => $value) { ?>
                    <option value="<?=$value['department_id']?>"><?=$value['name']?></option>
                    <?php }?>
                
                <?php }else{?>

                       <?php foreach ($departmentid_on as $key => $value) { ?>
                          <?php if($_GET['depid'] == $value['department_id']){?>
                              <option value="<?=$value['department_id']?>" selected="selected"><?=$value['name']?></option>
                          <?php }else{?>
                              <option value="<?=$value['department_id']?>"><?=$value['name']?></option>
                          <?php }?>
                      <?php }?>

                <?php }?>
              </select>
           </th>
    			<th colspan="11" ></th>
    		</tr>

        <!-- 参数 -->
        <tr style="text-align:center;vertical-align: middle;">
          <th  style="padding:25px 30px;"> <div style="width:40px;"></div>序号</th>
          <th style="padding:25px 30px;">  <div style="width:70px;"></div>任务新旧 </th>
          <?php 
            $i = 0;
            foreach(array_filter($resultWeekInfo) as $key=>$val)
            {
              if($i <= 15 && $i>0 && $i != 10)
              {
                echo "<th style='text-align:center;vertical-align: middle;'>".$val."</th>";
              }
              $i++;
            }

          ?>
        </tr>
        </thead>

  		<!--      START   -->


          <tbody>
  			<?php 

    				$s = 1;
    				if($infoWeek_fall)
    				{

    					foreach($infoWeek_fall as $key=>$value)
    					{
    						//输出计划完成日期
    						if($value['week_second_E'])
    							$date_fall = $value['week_second_E'];
    						// var_dump($date_fall);die;
    						else 
    							$date_fall = $time ;

    						

    						//输出
    						if($value['week_first_F'])
    							$date_success = $value['week_first_F'];
    						else 
    							$date_success =  $time ;

    						//个人打分
    						if($value['week_first_I'])
    							$score_person = $value['week_first_I'];
    						else 
    							$score_person = 0;
    						//一级审核人打分
    						if($value['week_first_L'])
    							$score_person_one = $value['week_first_L'];
    						else 
    							$score_person_one = 0;
    						//二级审核人打分
    						if($value['week_first_M'])
    							$score_person_two = $value['week_first_M'];
    						else 
    							$score_person_two = 0;
    						//三级审核人打分
    						if($value['week_first_N'])
    							$score_person_three = $value['week_first_N'];
    						else 
    							$score_person_three = 0;
    						// //本周绩效打分
    						// if($value['week_first_O'])
    						// 	$score_person_tatol = $value['week_first_O'];
    						// else 
    						// 	$score_person_tatol = 0;

    						//输出绩效得分
    						if($key == 0)
    							$html_all = '<td align="center">'.$score_weekly_info['score'].'</td>';
    						else
    							$html_all = '';

    				//判断是新旧任务
                    switch ($value['weekly_is_new'])
                    {
                      case 1:
                        $newInfo ='旧任务';
                        break;
                      case 2:
                        $newInfo ='旧旧任务';
                        break;
                      case 3:
                        $newInfo ='旧旧旧任务';
                        break;
                      case 4:
                        $newInfo ='旧旧旧旧任务';
                        break;
                      case 5:
                        $newInfo ='旧旧旧旧旧任务';
                        break;
                      case 6:
                        $newInfo ='旧旧旧旧旧旧任务';
                        break;
                      case 7:
                        $newInfo ='旧旧旧旧旧旧旧任务';
                        break;
                      case 8:
                        $newInfo ='旧旧旧任务';
                        break;
                      
                      default:
                        $newInfo ='新任务';
                        break;
                  }



    						$html_file_all =  '<tr style="text-align:center;vertical-align: middle;">
  				  			<td>'.$s.'</td>
  				  			<td>'.$newInfo.'</td>	
  				  			<td><textarea rows="3" cols="20" name="week_first_A[]" >'.$value['week_second_A'].'</textarea><input type="hidden" name="idFirstAr[]" value="'.$value['id'].'"></td>
  				  			<td><textarea rows="3" cols="20" name="week_first_B[]">'.$value['week_second_B'].'</textarea></td>
  				  			<td><textarea rows="3" cols="20" name="week_first_C[]">'.$value['week_second_C'].'</textarea></td>
  				  			<td><textarea rows="3" cols="20" name="week_first_D[]">'.$value['week_second_D'].'</textarea></td>
  				  			<td><input  type="date" value="'.$date_fall.'" name="week_first_E[]"/></td>
  				  			<td><input  type="date" value="'.$date_success.'" name="week_first_F[]"/></td>
  				  			<td width="60px">
  				  				<select name="week_first_G[]" style="width:80px;">';

  				  				//输出完成的百分比
  				  				for($j = 0 ;$j<=100;$j++)
  				  				{
  				  					if( $j%5 == 0)   //取模
  				  					{
  				  						
  				  						if($j == $value['week_first_G'])
  				  						{
  				  							$html_file_all .= '<option value="'.$j.'" selected>'.$j.'%</option>';
  				  						}
  				  						else
  				  						{
  				  							$html_file_all .= '<option value="'.$j.'">'.$j.'%</option>';
  				  						}
  				  					}
  				  				}

  				  			
  							$html_file_all .= '
  				  				</select>
  				  				
  				  			</td>
  				  			<td><textarea rows="3" cols="20" name="week_first_H[]">'.$value['week_first_H'].'</textarea></td>
  				  			<td>';

  				  			$html_file_all .='<select name="week_first_I[]">';

  				  			for ($i=0; $i < 11; $i++)
  				  			{ 
  				  				if($score_person == $i)
  				  				{

  				  					$html_file_all .='<option value="'.$i.'" selected="selected">'.$i.'</option>';
  				  				}
  				  				else
  				  				{
  				  					$html_file_all .='<option value="'.$i.'">'.$i.'</option>';	
  				  				}
  				  			}
  									
  				  			$html_file_all .='</select>'; //<input type="number" name="" style="width:60px;" class="fen" value="'.$score_person.'">分
  				  			$html_file_all .='</td>
  				  			<td><textarea rows="3" cols="20" name="week_first_K[]" readonly="readonly">'.$value['week_first_K'].'</textarea></td>
  				  			<td><input type="number" name="week_first_L[]" readonly="readonly" class="fen" style="width:60px;" value="'.$score_person_one.'"> 分</td>
  				  			<td><input type="number" name="week_first_M[]" readonly="readonly" class="fen" style="width:60px;" value="'.$score_person_two.'"> 分</td>
  				  			<td><input type="number" name="week_first_N[]" readonly="readonly" style="width:60px;" value="'.$score_person_three.'"> 分</td>
  				  			'.$html_all.'
  				  		</tr>';

  				  		// var_dump( $html_file_all );die;
  				  	echo $html_file_all;

  				  		$s++;
    					}


    				}
    				else
    				{
    					echo '<tr style="text-align:center;vertical-align: middle;">
  		  			<td style="text-align:center;vertical-align: middle;">'.$s.'</td>
  		  			<td style="text-align:center;vertical-align: middle;">新任务</td>
  		  			<td><textarea rows="3" cols="20" name="week_first_A[]"></textarea></td>
  		  			<td><textarea rows="3" cols="20" name="week_first_B[]"></textarea></td>
  		  			<td><textarea rows="3" cols="20" name="week_first_C[]"></textarea></td>
  		  			<td><textarea rows="3" cols="20" name="week_first_D[]"></textarea></td>
        
              <td><input type="text" name="week_first_E[]" class="BigInput" size="20"  onClick="WdatePicker();" value="'.$time.'"  style="width:160px;height:30px;"/></td>
  		  			<td><input type="text" name="week_first_F[]" class="BigInput" size="20"  onClick="WdatePicker();" value="'.$time.'" style="width:160px;height:30px;"/></td>

  		  			<td >
  		  				<select name="week_first_G[]" style="width:120px;">
  		  					<option value="0">0%</option>
  		  					<option value="5">5%</option>
  		  					<option value="10">10%</option>
  		  					<option value="15">15%</option>
  		  					<option value="20">20%</option>
  		  					<option value="25">25%</option>
  		  					<option value="30">30%</option>
  		  					<option value="35">35%</option>
  		  					<option value="40">40%</option>
  		  					<option value="45">45%</option>
  		  					<option value="50">50%</option>	
  		  					<option value="55">55%</option>
  		  					<option value="60">60%</option>
  		  					<option value="65">65%</option>
  		  					<option value="70">70%</option>
  		  					<option value="75">75%</option>
  		  					<option value="80">80%</option>
  		  					<option value="85">85%</option>
  		  					<option value="90">90%</option>
  		  					<option value="95">95%</option>
  		  					<option value="100">100%</option>
  		  				</select>
  		  			</td>
  		  			<td>
              <textarea rows="3" cols="20" name="week_first_H[]"   required ></textarea></td>
  		  			<td>

              <input type="number" name="week_first_I[]" style="width:200px;height:30px;">
  		  		
  		  			</td>
  		  			
  		  			<td><textarea rows="3" cols="20" name="week_first_K[]" readonly="readonly"></textarea></td>
  		  			<td><input type="number" name="week_first_L[]" readonly="readonly" class="fen" style="width:200px;height:30px;"></td>
  		  			<td><input type="number" name="week_first_M[]" readonly="readonly" class="fen" style="width:200px;height:30px;" ></td>
  		  			<td><input type="number" name="week_first_N[]" readonly="readonly" style="width:200px;height:30px;"></td>
  		  		</tr>';
  		  				}



    		?>

  		<!--      END   -->


    		<tr id="zuihouOne" class="text-center" >
            <td colspan="3" style="text-align:center;vertical-align: middle;">请对上周计划完成情况总结概述 ：</td>
            <td colspan="2">
                <textarea rows="3" style="width:400px;"  name="week_first_J"></textarea>
            </td>

            <td style="text-align:center;vertical-align: middle;">
                  请对新增任务总结概述：
            </td>
             <td colspan="2" class="text-center">
                <textarea rows="3" style="width:300px;" name="week_first_J"></textarea>
                &nbsp<input type="button" class="btn btn-warning" onclick="changeType()" value="总结确认">
            </td>

             <td colspan="2" style="text-align:center;vertical-align: middle;">

               <label for="man" class="radio">
                        <span class="radio-bg"></span>
                        <input type="radio" name="plan" id="man" value="1"/> 计划不周
                        <span class="radio-on"></span>
                    </label>

                    <label for="woman" class="radio">
                        <span class="radio-bg"></span>
                        <input type="radio" name="plan" id="woman" value="2" /> 非计划不周
                        <span class="radio-on"></span>
                    </label>

            
            </td>

            <td colspan="2" style="text-align:center;vertical-align: middle;">
                本周绩效得分：   0.00
            </td>

            <td colspan="3">
             
            </td>
        </tr>
      </tbody>
    </table>
    	<div style="align:center;width:100px;height:40px;margin:0 auto;">
  	  	<!-- 加法运算-->
  	  	<span style="display:inline-block;width: 20px;height:20px;border-radius:10px;text-align: center;line-height: 20px;background: #5BD3DE;color:white;margin-top: 20px;cursor:pointer;" onclick="addInfoFirst(this)"><strong>+</strong>
  	  	</span>
  	  	<!-- 减法运算-->
  	  	<span style="display:inline-block;width: 20px;height:20px;border-radius:10px;text-align: center;line-height: 20px;background: #5BD3DE;color:white;margin-top: 20px;cursor:pointer;" onclick="minusInfoFirst(this)"><strong>-</strong>
  	  	</span>
    	</div>

    </br>
    </br>
    </br>


    <!-- 计划汇报表-->
    <table class="table table-bordered" id="second">
    		<caption>
    			
  					<!-- 第多少周计划-->第
  					<select name="week_number_plan">
  						<?php   
  							for( $i=1;$i<=54;$i++)
  							{

  									if( (date("W")+1)== $i)
                    {
                      echo "<option value=".$i."  selected = 'selected'>".$i."</option>\r\n";
                    }else{
                      echo "<option value=".$i.">".$i."</option>\r\n";
                    } 
  								
  							}
  						?>

  	  				</select>
  	  				周


  	  				<?php 

  					//输出周报时间
  					$date_first_plan = $infoWeek_plan_fall[0]['weekly_second_start']?$infoWeek_plan_fall[0]['weekly_second_start']:date('Y-m-d');
  					$date_end_plan = $infoWeek_plan_fall[0]['weekly_second_end']?$infoWeek_plan_fall[0]['weekly_second_end']:date('Y-m-d');

  				?>

  	  				（ <input type="date" value=<?php echo $date_first_plan?> name="weekly_second_start"/>- <input type="date" value=<?php echo $date_end_plan?> name="weekly_second_end"/>）计划汇报表

  			</caption>

    		<!-- <tr class="TableControl">
    			<td class="TableData" colspan="15">1.本表由汇报人每周五18:00之前油价发送给相应负责人
    					2.汇总表A、B、C、D组成
    			</td>
    		</tr> -->
        <thead>
    		<tr>
    			<th colspan="3">填表日期：<?php echo date("Y-m-d H:i:s")?></th>
    			<th width="100px">汇报人：<?php echo $_USER->name;?></th>
    			<th width="100px" >部门：<span id="departkk"> 
          <?php  
                  if(!$_GET['depid'])
                  {
                      echo $departmentid_on[0]['name'];
                  }
                  else
                  {
                        echo $depName['name'];
                  }

            ?>

           </span></th>
    			<th colspan="11" ></th>
    		</tr>
    		<tr class="TableControl">
    			<th width="70px">序号</th>
    			<th width="70px">任务新旧</th>
    			<?php
    				$i = 0;
    				foreach($resultWeekInfo as $key=>$val)
    				{
    					if( ($i > 15 && $i < 24) )
    					echo "<th>".$val."</th>";
    					$i++;
    				}

    			?>
    		</tr>
      </thead>

    		<?php   

    				if(count($infoWeek_plan_fall) > 0)
    				{

    					foreach( $infoWeek_plan_fall as $k=>$val)
  	  				{
  	  					
  		  				//判断是新旧任务
  		                  switch ($val['weekly_is_new'])
  		                  {
  		                    case 1:
  		                      $newInfo ='旧任务';
  		                      break;
  		                    case 2:
  		                      $newInfo ='旧旧任务';
  		                      break;
  		                    case 3:
  		                      $newInfo ='旧旧旧任务';
  		                      break;
  		                    case 4:
  		                      $newInfo ='旧旧旧旧任务';
  		                      break;
  		                    case 5:
  		                      $newInfo ='旧旧旧旧旧任务';
  		                      break;
  		                    case 6:
  		                      $newInfo ='旧旧旧旧旧旧任务';
  		                      break;
  		                    case 7:
  		                      $newInfo ='旧旧旧旧旧旧旧任务';
  		                      break;
  		                    case 8:
  		                      $newInfo ='旧旧旧任务';
  		                      break;
  		                    
  		                    default:
  		                      $newInfo ='新任务';
  		                      break;
  		                }


  	  					//任务计划完成时间
  	  					if($val['week_second_E'])
  	  					{
  	  						$planComplate = $val['week_second_E'];
  	  					}else{
  	  						$planComplate = date('Y-m-d');
  	  					}

  	  					//输出html
  	  					$htmlWeekPlan = '<tr class="TableControl stleTwo" id="1er">
  			  			<td width="70px" align="center">'.($k+1).'</td>
  			  			<td width="70px" >'.$newInfo.'</td>
  			  			<td><textarea rows="3" cols="20" name="week_second_A[]">'.$val['week_second_A'].'</textarea><input type="hidden" name="idSecondAr[]" value="'.$val['id'].'"></td>
  			  			<td><textarea rows="3" cols="20" name="week_second_B[]">'.$val['week_second_B'].'</textarea></td>
  			  			<td><textarea rows="3" cols="20" name="week_second_C[]">'.$val['week_second_C'].'</textarea></td>
  			  			<td><textarea rows="3" cols="20" name="week_second_D[]">'.$val['week_second_D'].'</textarea></td>
  			  			<td><input id="meeting" type="date" value="'.$planComplate.'" name="week_second_E[]"/></td>
  			  			<td><textarea rows="3" cols="20" name="week_second_F[]">'.$val['week_second_F'].'</textarea></td>
  			  			<td width="60px">';

  			  			

  			  			if($val['week_second_G_is'] == 1) //1代表有资源需求
  						{
  			  				$htmlWeekPlan .='<input name="week_second_G_is'.$k.'" type="radio" value="0" class="is_check_false"/>无
  			  			<input name="week_second_G_is'.$k.'" type="radio" value="1" checked="checked" class="is_check_true"/>有';

  			  			$htmlWeekPlan .='<textarea rows="3" cols="20" name="week_second_G[]">'.$val['week_second_G'].'</textarea>
  			  			</td>
  			  			<td colspan="8">';

  			  			}
  			  			else if($val['week_second_G_is'] == 0)//0代表没有资源需求
  			  			{
  			  				$htmlWeekPlan .='<input name="week_second_G_is'.$k.'" type="radio" value="0" checked="checked" class="is_check_false"/>无
  			  			<input name="week_second_G_is'.$k.'" type="radio" value="1" class="is_check_true"/>有';

  			  			$htmlWeekPlan .='<textarea rows="3" style="display: none;" cols="20" name="week_second_G[]">'.$val['week_second_G'].'</textarea>
  			  			</td>
  			  			<td colspan="8">';
  			  			}


  			  			if($val['opinion_is_agree'] == '1')
  			  			{
  			  				$htmlWeekPlan .='
  			  				<input name="opinion_is_agree'.$k.'" type="radio" value="1" readonly="readonly" checked="checked"  disabled="disabled" />同意
  			  				<input name="opinion_is_agree'.$k.'" type="radio" value="2" readonly="readonly"  disabled="disabled" />修改意见';
  			  			}else if($val['opinion_is_agree'] == '2')
  			  			{
  			  				$htmlWeekPlan .='
  			  				<input name="opinion_is_agree'.$k.'" type="radio" value="1" readonly="readonly"  disabled="disabled" />同意
  			  				<input name="opinion_is_agree'.$k.'" type="radio" value="2" readonly="readonly" checked="checked"  disabled="disabled" />修改意见';
  			  			}else{

  			  				$htmlWeekPlan .='
  			  				<input name="opinion_is_agree'.$k.'" type="radio" value="1" readonly="readonly"  disabled="disabled" />同意
  			  				<input name="opinion_is_agree'.$k.'" type="radio" value="2" readonly="readonly"  disabled="disabled" />修改意见';
  			  			}
  			  			
  			  			$htmlWeekPlan .='	
  			  				<textarea rows="3" cols="20" name="week_second_H[]" readonly="readonly">'.$val['week_second_H'].'</textarea>
  			  			</td>
  			  		</tr>';

  			  		echo $htmlWeekPlan;
  	  					

  	  				}

    				}
    				else
    				{
    					echo '<tr class="TableControl stleTwo" id="1er">
  			  			<td width="70px" align="center">1</td>
  			  			<td width="70px" >新任务</td>
  			  			<td><textarea rows="3" cols="20" name="week_second_A[]"></textarea></td>
  			  			<td><textarea rows="3" cols="20" name="week_second_B[]"></textarea></td>
  			  			<td><textarea rows="3" cols="20" name="week_second_C[]"></textarea></td>
  			  			<td><textarea rows="3" cols="20" name="week_second_D[]"></textarea></td>
  			  			<td><input id="meeting" type="date" value="'.$time.'" name="week_second_E[]"/></td>
  			  			<td><textarea rows="3" cols="20" name="week_second_F[]"></textarea></td>
  			  			<td width="60px">
  			  			<input name="week_second_G_is" type="radio" value="0" checked="checked" class="is_check_false"/>无
  			  			<input name="week_second_G_is" type="radio" value="1" class="is_check_true"/>有
  			  			<textarea rows="3" cols="20" name="week_second_G[]" style="display:none;"></textarea>
  			  			</td>
  			  			<td colspan="8">
  			  				<input name="opinion_is_agree" type="radio" value="1" disabled />同意
  			  				<input name="opinion_is_agree" type="radio" value="2" disabled />修改意见
  			  				<textarea rows="3" cols="20" name="week_second_H[]" readonly="readonly"></textarea>
  			  			</td>
  			  		</tr>';
    				}

    				


    		?>



    		<tr class="TableControl" id="zuihouTwo"><td width="30px">周计划概述：</td><td colspan="17"><textarea rows="3" cols="100" name="week_second_J"></textarea></td></tr>

    </table>

    <div style="align:center;width:100px;height:40px;margin:0 auto;">
  	  	<!-- 加法运算-->
  	  	<span style="display:inline-block;width: 20px;height:20px;border-radius:10px;text-align: center;line-height: 20px;background: #5BD3DE;color:white;margin-top: 20px;cursor:pointer;" onclick="addInfoSecond(this)" ><strong>+</strong>
  	  	</span>
  	  	<!-- 减法运算-->
  	  	<span style="display:inline-block;width: 20px;height:20px;border-radius:10px;text-align: center;line-height: 20px;background: #5BD3DE;color:white;margin-top: 20px;cursor:pointer;" onclick="minusInfoSecond(this)"><strong>-</strong>
  	  	</span>
    	</div>

    <br/>
    <br/>
    <br/>

    <div style="margin-left: 40%;">
    	
    	<input type="button" value="保存" class="btn btn-warning" onClick="storage();">&nbsp;&nbsp;&nbsp;	
    	<input type="button" value="提交" class="btn btn-success" >&nbsp;  &nbsp;  &nbsp;	
    	<input type="button" value="返回" class="btn btn-default" onClick="javascript:history.back(-1)" disabled="disabled">
    </div>

  </form>

</body>
</html>
<script language="javascript" type="text/javascript" src="template/default/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript">

	//输入框动态添加下拉框选择工具
	// $(".fen").on('click',function(){

	// 	// var _this = $(".fen").attr('list','myDatalist');
	// 	// var _this = $(".fen").removeAttr('type');
	
	// 	// var  strings = '<datalist id="myDatalist"> <option value="Internet Explorer"> <option value="Firefox"> <option value="Chrome"> <option value="Opera"> <option value="Safari"> </datalist>';
	// 	// _this.after(strings);
	// 	// $(this).html("");
	// 	// $(this).remove();
	// 	// 添加展示
	// 	var html ='<div class="sonovs" ><ul><li>10</li><li>9</li><li>8</li><li>7</li><li>6</li><li>6</li><li>5</li><li>4</li><li>3</li><li>2</li><li>1</li></ul></div>';
	// 	$(this).after(html);


	// });
	

	//提交数据
  	$("input[type=submit]").click(function(){
      	          	
      	alert('周报必须确认后才能提交,请先点击总结确认!'); return false;

	});



	function storage()
	{
		var info = "<?php echo $ac."&fileurl=".$fileurl?>";
		var urls = "?ac="+info+"&do=save";
		var form  = document.getElementById('weeklyInfo');
		form.action=urls;
		form.submit();
	}


	function addInfoFirst(obj)
	{
		var _time  = "<?php echo $time ?>";
		//是否有
  		$("#zuihouOne").remove();
  		var conn = $("#first tr:last").find("td:first").html();
  		if(conn == "序号") conn =0
  		conn++;
		var html ='<tr class="TableControl stleOne"> <td width="70px" align="center">'+conn+'</td> <td width="70px">新任务</td><td><textarea rows="3" cols="20" name="week_first_A[]"></textarea></td> <td><textarea rows="3" cols="20" name="week_first_B[]"></textarea></td> <td><textarea rows="3" cols="20" name="week_first_C[]"></textarea></td> <td>'; 
		// var name = "<?php echo $_USER->name;?>";
		 html +='<textarea rows="3" cols="20" name="week_first_D[]"></textarea></td>';
  		html +='<td><input id="meeting" type="date" value="'+_time+'" name="week_first_E[]"/></td> <td><input id="meeting" type="date" value="'+_time+'" name="week_first_F[]"/></td> <td width="60px"> <select name="week_first_G[]"> <option value="0">0%</option> <option value="5">5%</option> <option value="10">10%</option> <option value="15">15%</option> <option value="20">20%</option> <option value="25">25%</option> <option value="30">30%</option> <option value="35">35%</option> <option value="40">40%</option> <option value="45">45%</option> <option value="50">50%</option> <option value="55">55%</option> <option value="60">60%</option> <option value="65">65%</option> <option value="70">70%</option> <option value="75">75%</option> <option value="80">80%</option> <option value="85">85%</option> <option value="90">90%</option> <option value="95">95%</option> <option value="100">100%</option> </select> </td> <td><textarea rows="3" cols="20" name="week_first_H[]"></textarea></td> <td>	<select name="week_first_I[]"> <option value="0">0</option> <option value="1">1</option> <option value="2">2</option> <option value="3">3</option> <option value="4">4</option> <option value="5">5</option> <option value="6">6</option> <option value="7">7</option> <option value="8">8</option> <option value="9">9</option> <option value="10">10</option> </select> 分</td> <td><textarea rows="3" cols="20" name="week_first_K[]" readonly="readonly"></textarea></td> <td><input type="text" name="week_first_L[]" style="width:60px;" readonly="readonly"> 分</td> <td><input type="text" name="week_first_M[]" style="width:60px;" readonly="readonly"> 分</td> <td>  <input type="text" name="week_first_M[]" style="width:60px;" readonly="readonly"> 分 </td></tr><tr class="TableControl" id="zuihouOne"><td width="30px">概述：</td><td colspan="100"><textarea rows="3" cols="100" name="week_first_J"></textarea>&nbsp <input type="button" onclick="changeType()" value="总结确认"></td></tr>'; $("#first tr:last").after(html);


		// console.log(first);//
	}

	function addInfoSecond(obj)
	{
		var _time  = "<?php echo $time ?>";
		//是否有
  		$("#zuihouTwo").remove();
		var conn = $("#second tr:last").find("td:first").html();
		if(conn == "序号") conn =0
  		conn++;
		var html ='<tr class="TableControl stleTwo" id="1er"> <td width="70px" align="center">'+conn+'</td> <td width="70px">新任务</td><td><textarea rows="3" cols="20" name="week_second_A[]"></textarea></td> <td><textarea rows="3" cols="20" name="week_second_B[]"></textarea></td> <td><textarea rows="3" cols="20" name="week_second_C[]"></textarea></td>'; 
		// var name = "<?php echo $_USER->name;?>";
		html += '<td><textarea rows="3" cols="20" name="week_second_D[]"></textarea></td>';

		html += '<td><input id="meeting" type="date" value="'+_time+'" name="week_second_E[]"/></td> <td><textarea rows="3" cols="20" name="week_second_F[]"></textarea></td> <td width="60px"> <input name="week_second_G_is'+conn+'" type="radio" value="0" checked="checked"  class="is_check_false"/>无 <input name="week_second_G_is'+conn+'" type="radio" value="1" class="is_check_true"/>有 <textarea rows="3" cols="20" name="week_second_G[]" style="display:none;"></textarea> </td> <td colspan="6"> <input name="opinion_is_agree" type="radio" value="1" disabled />同意 <input name="opinion_is_agree" type="radio" value="2" disabled />修改意见 <textarea rows="3" cols="20" name="week_second_H[]" readonly="readonly"></textarea> </td></tr><tr class="TableControl" id="zuihouTwo"><td width="30px">概述：</td><td colspan="17"><textarea rows="3" cols="100" name="week_second_J"></textarea></td></tr>'; $("#second tr:last").after(html);
	}

   //是否添加资源
  $(document).on('click','.is_check_false',function(){

      $(this).siblings('textarea').html('');
      $(this).siblings('textarea').hide();
  });

  $(document).on('click','.is_check_true',function(){
     $(this).siblings('textarea').show();
  });




	//删除最后一个添加的表格
	function minusInfoFirst()
	{
		//判断当前剩下几个TR
		$(".stleOne:last").remove();

	}

	function minusInfoSecond()
	{
		$(".stleTwo:last").remove();
	}

	//打分判断
	// $(".fen").blur(function(){
	// 	var values= $(this).val();
	// 	if( values > 100){ alert('此处满分是100'); $(this).val(100);};
	// 	if(values <0){ alert('此处最小分是0');  $(this).val(Math.abs(values)); };
	// });

	function changeType()
	{
		if(confirm('确定执行总结确认命令？（确认后不可更改总结内容）'))
		{
			var info = "<?php echo $ac."&fileurl=".$fileurl?>";
			var urls = "?ac="+info+"&do=confirm";
			var form  = document.getElementById('weeklyInfo');
			form.action=urls;
			form.submit();
		}
		return false;
	}

	//改变部门
  $("#changeInfo").change(function(){

        var calue = $(this).val();

          var info = "<?php echo $ac."&fileurl=".$fileurl?>";
          var urls = "?ac="+info+"&do=add&depid="+calue;
          window.location = urls;

      // $("#departkk").text($(this).find("option:selected").text());
  });



</script>
