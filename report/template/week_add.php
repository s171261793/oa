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
</head>
<body class="bodycolor">

  <table class="table table-responsive">
    <tr>
      <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 周报信息</span>
      </td>
    </tr>
<!-- 
    <tr>
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
    <input type="hidden" name="operationType" value="weeklyadd" />

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

          ( <input type="text" name="weekly_first_start" class="BigInput" size="20"  onClick="WdatePicker();" value="<?=$monday?>" style="width:140px;height:30px;"/> 至 <input type="text" name="weekly_first_end" class="BigInput" size="20"  style="width:140px;height:30px;" onClick="WdatePicker();" value="<?=$time?>" /> ) 总结汇报表


          </caption>

        <thead>
        <!-- 表头-->
        <tr bgcolor="#E7F0FB" >
          <th colspan="3" style="text-align:center;vertical-align: middle;"><sapn>填表日期：<?php echo date("Y/m/d H:i:s",PHP_TIME)?></sapn></th>
          <th style="text-align:center;vertical-align: middle;">汇报人：<?php echo $_USER->name;?></th>
          <th colspan="2" style="text-align:center;vertical-align: middle;">部门：
          
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
          <th colspan="13" ></th>
        </tr>

        <!-- 参数 -->
        <tr style="text-align:center;vertical-align: middle;">
          <th  style="padding:25px 30px;"> <div style="width:40px;">序号</div></th>
          <th style="padding:25px 30px;">  <div style="width:70px;">任务新旧</div> </th>
          <?php 
            $thumbResult_first = array_filter($resultWeekInfo[0]);

            unset($thumbResult_first['id']);

            foreach( $thumbResult_first as $key=>$val)
            {
              
                echo "<th style='text-align:center;vertical-align: middle;'>".$val."</th>";
            }

          ?>
        </tr>
        </thead>

      <!--      START   -->


          <tbody>
        <?php 

            $s = 1;
            // if($infoWeek_fall)
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
                //  $score_person_tatol = $value['week_first_O'];
                // else 
                //  $score_person_tatol = 0;

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
                        $newInfo ='旧旧旧旧旧旧旧旧任务';
                        break;
                      
                      default:
                        $newInfo ='新任务';
                        break;
                  }



               $html_file_all =  '<tr style="text-align:center;vertical-align: middle;">
                <td  style="text-align:center;vertical-align: middle;">'.$s.'</td>
                <td  style="text-align:center;vertical-align: middle;">'.$newInfo.'</td>  
                <td><textarea rows="3" cols="20" name="week_first_A[]" >'.$value['week_second_A'].'</textarea><input type="hidden" name="idFirstAr[]" value="'.$value['id'].'"></td>
                <td><textarea rows="3" cols="20" name="week_first_B[]">'.$value['week_second_B'].'</textarea></td>
                <td><textarea rows="3" cols="20" name="week_first_C[]">'.$value['week_second_C'].'</textarea></td>
                <td><textarea rows="3" cols="20" name="week_first_D[]">'.$value['week_second_D'].'</textarea></td>';

                //确认不能编辑，不确认还继续修改
                if($status_is_confirm == '1')
                {

                  $html_file_all.='
                        <td>
                          <input type="text" class="meeting" name="week_first_E[]" class="BigInput" size="20"  onClick="WdatePicker();" value="'.$date_fall.'"  style="width:160px;height:30px;" readonly="readonly"/>
                        </td>
                        <td>
                            <input type="text" class="meeting" name="week_first_F[]" class="BigInput" size="20"  onClick="WdatePicker();" value="'.$date_success.'" style="width:160px;height:30px;" readonly="readonly"/>
                        </td>

                      <td>
                        <select name="week_first_G[]" style="width:120px;">';
                }
                else
                {        

                  $html_file_all.='

                       <td>
                          <input type="text" class="meeting" name="week_first_E[]" class="BigInput" size="20"  onClick="WdatePicker();" value="'.$date_fall.'"  style="width:160px;height:30px;"/>
                        </td>
                        <td>
                            <input type="text" class="meeting" name="week_first_F[]" class="BigInput" size="20"  onClick="WdatePicker();" value="'.$date_success.'" style="width:160px;height:30px;"/>
                        </td>

                      <td>
                        <select name="week_first_G[]" style="width:120px;">';
                }

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
                <td>
                    <textarea rows="3" cols="20" name="week_first_H[]">'.$value['week_first_H'].'</textarea>
                </td>
                
                <td>
                    <input type="number" min="0" max="10" step="0.01" name="week_first_I[]" style="width:200px;height:30px;" value="'.$value['week_first_I'].'"> 
                </td>

                <td>
                    <textarea rows="3" cols="20" name="week_first_J[]" readonly="readonly">'.$value['week_first_J'].'</textarea>
                </td>
                  
                <td>
                    <input type="number" min="0" max="10" step="0.01" name="week_first_K[]" style="width:200px;height:30px;" readonly="readonly" value="'.$value['week_first_K'].'">
                </td>

                <td>
                    <textarea rows="3" cols="20" name="week_first_L[]" readonly="readonly">'.$value['week_first_L'].'</textarea>
                </td>

                <td>
                      <input type="number" min="0" max="10" step="0.01" name="week_first_M[]" readonly="readonly" class="fen" style="width:200px;height:30px;" value="'.$value['week_first_M'].'">
                </td>

                <td>
                      <input type="number" min="0" max="10" step="0.01" name="week_first_N[]" readonly="readonly" style="width:200px;height:30px;" value="'.$value['week_first_N'].'">
                </td>

              </tr>';
              
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
              <input type="number" min="0" step="0.01" value="" name="week_first_I[]" style="width:200px;height:30px;">
              </td>
              <td>
                 <textarea rows="3" cols="20" name="week_first_J[]" readonly="readonly"></textarea>
              </td>
              
              <td><input type="number" min="0" max="10" step="0.01" name="week_first_K[]" style="width:200px;height:30px;" readonly="readonly">
              </td>

              <td>
              <textarea rows="3" cols="20" name="week_first_L[]" readonly="readonly"></textarea>
              </td>

              <td><input type="number" min="0" max="10" step="0.01" name="week_first_M[]" readonly="readonly" class="fen" style="width:200px;height:30px;" ></td>
              <td><input type="number" min="0" max="10" step="0.01" name="week_first_N[]" readonly="readonly" style="width:200px;height:30px;">
              </td>
            </tr>';
                }



        ?>

      <!--      END   -->


        <tr id="zuihouOne" class="text-center" >
            <td colspan="2" style="text-align:center;vertical-align: middle;">周总结概述 ：</td>

            <td colspan="3">
                <textarea rows="3" style="width:400px;"  name="description"></textarea>
            </td>

            <!-- <td style="text-align:center;vertical-align: middle;">
                  请对新增任务总结概述：
            </td> -->
           <!--   <td colspan="2" class="text-center">
                <textarea rows="3" style="width:300px;" name="desciption_new"></textarea>
                &nbsp<input type="button" class="btn btn-warning" onclick="changeType()" value="总结确认">
            </td> -->
            <td colspan="2" style="text-align:center;vertical-align: middle;">
                本周绩效考核得分：  
            </td>
            <td colspan="9" style="vertical-align: middle;">
                    <input type="button" class="btn btn-warning" onclick="changeType()" value="总结确认">
            </td>
             <!-- <td colspan="2" style="text-align:center;vertical-align: middle;"> -->

              <!--  <label for="man" class="radio">
                        <span class="radio-bg"></span>
                        <input type="radio" name="is_poor_planing" id="man" value="2"/> 计划不周
                        <span class="radio-on"></span>
                    </label>

                    <label for="woman" class="radio">
                        <span class="radio-bg"></span>
                        <input type="radio" name="is_poor_planing" id="woman" value="1" checked="checked"/> 非计划不周
                        <span class="radio-on"></span>
                    </label>
 -->
            
            <!-- </td> -->
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
    <table class="table table-bordered table-hover" id="second">
        <caption>
          
            <!-- 第多少周计划-->第
            <select name="week_number_plan" style="width:60px;">
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


             ( <input type="text" name="weekly_second_start" class="BigInput" size="20"  onClick="WdatePicker();" value="<?=$monday_next?>" style="width:140px;height:30px;"/> 至 <input type="text" name="weekly_second_end" class="BigInput" size="20"  style="width:140px;height:30px;" onClick="WdatePicker();" value="<?=$friday_next?>" /> ) 计划汇报表

        </caption>

       
        <thead>
            <tr bgcolor="#E7F0FB">
              <th colspan="3" style="text-align:center;vertical-align: middle;">填表日期：<?php echo date("Y-m-d H:i:s")?></th>
              <th  style="text-align:center;vertical-align: middle;">汇报人：<?php echo $_USER->name;?></th>
              <th  style="text-align:center;vertical-align: middle;">部门：<span id="departkk"> 
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

            <tr>
              <th  style="padding:25px 30px;" style="text-align:center;vertical-align: middle;"> <div style="width:40px;">序号</div></th>
              <th style="padding:25px 30px;" style="text-align:center;vertical-align: middle;">  <div style="width:70px;">任务新旧</div> </th>
              <?php
                $thumbResult_second = array_filter($resultWeekInfo[1]);
                unset($thumbResult_second['id']);
                foreach($thumbResult_second as $key=>$val)
                {
                  echo "<th>".$val."</th>";
                }

              ?>
            </tr>
        </thead>
  
         <tbody>
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
                            $newInfo ='旧旧旧旧旧旧旧旧任务';
                            break;
                          case 9:
                            $newInfo ='旧旧旧旧旧旧旧旧旧任务';
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
                $htmlWeekPlan = '<tr class="stleTwo" id="1er">
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
              echo '<tr  id="1er" style="text-align:center;vertical-align: middle;">
                <td style="text-align:center;vertical-align: middle;">1</td>
                <td style="text-align:center;vertical-align: middle;" >新任务
                </td>

                <td><textarea rows="3" cols="20" name="week_second_A[]"></textarea>
                </td>

                <td><textarea rows="3" cols="20" name="week_second_B[]"></textarea>
                </td>

                <td><textarea rows="3" cols="20" name="week_second_C[]"></textarea>
                </td>

                <td><textarea rows="3" cols="20" name="week_second_D[]"></textarea>
                </td>

                <td><input type="text" name="week_second_E[]" class="BigInput" size="20" onclick="WdatePicker();" value='.$time.' style="width:160px;height:30px;">
                </td>


                <td><textarea rows="3" cols="20" name="week_second_F[]"></textarea>
                </td>

                <td>
                <input name="week_second_G_is" type="radio" value="0" checked="checked" class="is_check_false"/>无
                <input name="week_second_G_is" type="radio" value="1" class="is_check_true"/>有
                <div style="width:140px;"></div><textarea rows="3" cols="20" name="week_second_G[]" style="display:none;"></textarea>
                </td>

                <td>
                  <input type="number" min="0" max="10" step="0.01" name="week_second_H[]" style="width:200px;height:30px;">
                </td>
                <td>
                 <textarea rows="3" cols="20" name="week_second_I[]" readonly="readonly"></textarea>
                </td>
                <td>
                  <input type="number" min="0" max="10" step="0.01" name="week_second_J[]" style="width:200px;height:30px;" readonly="readonly">
                </td>

                <td>
                  <textarea rows="3" cols="20" name="week_second_K[]" readonly="readonly"></textarea>
                </td>

                <td>
                  <input type="number" min="0" max="10" step="0.01" name="week_second_L[]" style="width:200px;height:30px;" readonly="readonly">
                </td>
        
              </tr>';
            }

            


        ?>

          <tbody>

        <tr id="zuihouTwo">
          <td style="text-align:center;vertical-align: middle;">周计划概述：</td>
          <td colspan="9"><textarea rows="3" cols="100" name="description_plan" style="width:400px"></textarea></td>
          <td colspan="1" style="text-align:center;vertical-align: middle;">一级审核人意见：</td>
          <td colspan="1" style="text-align:center;vertical-align: middle;">
            <select name="opinion_one" disabled="disabled">
              <option value="0">--请选择--</option>
              <option value="1">拟同意组员计划</option>
              <option value="2">请按照上述各项任务批注意见，进行修改</option>
              <option value="3">同意CTO意见</option>
              <option value="4">请组员再次修改</option>
            </select>
          </td>
          <td style="text-align:center;vertical-align: middle;">二级审核人意见：</td>
          <td style="text-align:center;vertical-align: middle;">
             <select name="opinion_two" disabled="disabled">
              <option value="0">--请选择--</option>
              <option value="1">同意组长意见</option>
              <option value="2">不完全同意组长意见，请按我意见做修改</option>
            </select>
          </td>
        </tr>

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
      <input type="button" value="提交" class="btn btn-success" id="sub">&nbsp;  &nbsp;  &nbsp; 
      <input type="button" value="返回" class="btn btn-default" id="return">
    </div>

  </form>

</body>
</html>
<script language="javascript" type="text/javascript" src="template/default/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript">

    //检查是否能够输入
    // $(document).on('blur','input[name^=week_second_H]',function(){

    //     isPregMath();


    //  });
      


    //查看输入值是否超过了设定的值
    var number_set = "<?=$resultCeil['max_a']?>";

    $(document).on('blur','input[name^=week_first_I]',function()
    {
        if( $(this).val() < 0 )
        {
            alert('输入值范围在0 ~ '+number_set);
           this.value=0;
        }

        if( $(this).val() > number_set)
        {
            alert('输入值范围在0 ~ '+number_set);
           this.value=0;
        }

    });

   


  //返回
   $("#return").click(function(){
                
        window.location='/admin.php?ac=weekly&fileurl=report&do=list';    
        return false;

  });
  //提交数据
    $("#sub").click(function(){
        
        alert('周报必须确认后才能提交,请先点击总结确认!'); return false;

  });


  function storage()
  {
    var status=isPregMath();
    if(status)
    {
      var info = "<?php echo $ac."&fileurl=".$fileurl?>";
      var urls = "?ac="+info+"&do=save";
      var form  = document.getElementById('weeklyInfo');
      form.action=urls;
      form.submit();
    }
   
  }


  //验证每条数据是否合法
  function isPregMath()
  {
    //保存验证、
    var heightNumbers = 0;
    var heightNumber = 0;

      $('input[name^=week_second_H]').each(function(k,v){

          if($(this).attr('_isold') == 1)  return true;
          if($(this).val() < 0  ||  $(this).val() > 1 || $(this).val() == ''){ heightNumber++;}
          if(v.value == ''){ v.value = 0;}
          heightNumbers += parseFloat(v.value);

      });
      //修复JS计算二进制BUG
      heightNumbers = heightNumbers.toFixed(3);
      if( heightNumber){ alert('单个计划任务占比应该是大于等于0，小于等于1,并且所有的计划任务的个人提议占比总和等于1'); return false;}
      if( heightNumbers != 1){ alert('所有的计划任务的个人提议占比总和等于1,单个计划任务占比应该是大于等于0，小于等于1!'); return false;}
      return true;
  }



  function addInfoFirst(obj)
  {
    var _time  = "<?php echo $time ?>";
    //是否有
      $("#zuihouOne").remove();
      var conn = $("#first tr:last").find("td:first").html();
      if(conn == "序号") conn =0
      conn++;
    var html ='<tr style="text-align:center;vertical-align: middle;" class="stleOne"> <td style="text-align:center;vertical-align: middle;">'+conn+'</td> <td style="text-align:center;vertical-align: middle;">新任务</td><td><textarea rows="3" cols="20" name="week_first_A[]"></textarea></td> <td><textarea rows="3" cols="20" name="week_first_B[]"></textarea></td> <td><textarea rows="3" cols="20" name="week_first_C[]"></textarea></td> <td>'; 

     html +='<textarea rows="3" cols="20" name="week_first_D[]"></textarea></td>';

     html +=' <td><input type="text" name="week_first_E[]" class="BigInput" size="20"  onClick="WdatePicker();" value="'+_time+'"  style="width:160px;height:30px;"/></td> <td><input type="text" name="week_first_F[]" class="BigInput" size="20"  onClick="WdatePicker();" value="'+_time+'" style="width:160px;height:30px;"/></td>';

      html +='<td> <select style="width:120px;" name="week_first_G[]"> <option value="0">0%</option> <option value="5">5%</option> <option value="10">10%</option> <option value="15">15%</option> <option value="20">20%</option> <option value="25">25%</option> <option value="30">30%</option> <option value="35">35%</option> <option value="40">40%</option> <option value="45">45%</option> <option value="50">50%</option> <option value="55">55%</option> <option value="60">60%</option> <option value="65">65%</option> <option value="70">70%</option> <option value="75">75%</option> <option value="80">80%</option> <option value="85">85%</option> <option value="90">90%</option> <option value="95">95%</option> <option value="100">100%</option> </select> </td> <td><textarea rows="3" cols="20" name="week_first_H[]"></textarea></td> <td> <input type="number" min="0" max="10" step="0.01" name="week_first_I[]" style="width:200px;height:30px;" value=""> </td> <td> <textarea rows="3" cols="20" name="week_first_J[]" readonly="readonly"></textarea> </td> <td><input type="number" min="0" max="10" step="0.01" name="week_first_K[]" style="width:200px;height:30px;" readonly="readonly"></td> <td> <textarea rows="3" cols="20" name="week_first_L[]" readonly="readonly"></textarea> </td> <td><input type="number" min="0" max="10" step="0.01" name="week_first_M[]" readonly="readonly" class="fen" style="width:200px;height:30px;" ></td> <td><input type="number" min="0" max="10" step="0.01" name="week_first_N[]" readonly="readonly" style="width:200px;height:30px;"></td> </tr>';

      html +='<tr id="zuihouOne" class="text-center" > <td colspan="2" style="text-align:center;vertical-align: middle;">周总结概述 ：</td> <td colspan="3"> <textarea rows="3" style="width:400px;"  name="description"></textarea> </td> <td colspan="2" style="text-align:center;vertical-align: middle;"> 本周绩效考核得分： </td> <td colspan="9" style="vertical-align: middle;"> <input type="button" class="btn btn-warning" onclick="changeType()" value="总结确认"> </td> </tr>';
        $("#first tr:last").after(html);

  }

  function addInfoSecond(obj)
  {
    var _time  = "<?php echo $time ?>";
    //是否有
      $("#zuihouTwo").remove();
    var conn = $("#second tr:last").find("td:first").html();
    if(conn == "序号") conn =0
      conn++;
    var html ='<tr class="stleTwo" style="text-align:center;vertical-align: middle;" id="1er"> <td style="text-align:center;vertical-align: middle;">'+conn+'</td> <td style="text-align:center;vertical-align: middle;">新任务</td><td><textarea rows="3" cols="20" name="week_second_A[]"></textarea></td> <td><textarea rows="3" cols="20" name="week_second_B[]"></textarea></td> <td><textarea rows="3" cols="20" name="week_second_C[]"></textarea></td>'; 
    // var name = "<?php echo $_USER->name;?>";
    html += '<td><textarea rows="3" cols="20" name="week_second_D[]"></textarea></td>';

    html += '<td><input type="text" name="week_second_E[]" class="BigInput" size="20" onclick="WdatePicker();" value='+_time+' style="width:160px;height:30px;"></td> <td><textarea rows="3" cols="20" name="week_second_F[]"></textarea></td> <td width="60px"> <input name="week_second_G_is'+conn+'" type="radio" value="0" checked="checked"  class="is_check_false"/>无 <input name="week_second_G_is'+conn+'" type="radio" value="1" class="is_check_true"/>有 <textarea rows="3" cols="20" name="week_second_G[]" style="display:none;"></textarea> </td>  <td> <input type="number" min="0" max="10" step="0.01" name="week_second_H[]" style="width:200px;height:30px;"> </td> <td> <textarea rows="3" cols="20" name="week_second_I[]" readonly="readonly"></textarea> </td> <td> <input type="number" min="0" max="10" step="0.01" name="week_second_J[]" style="width:200px;height:30px;" readonly="readonly"> </td> <td> <textarea rows="3" cols="20" name="week_second_K[]" readonly="readonly"></textarea> </td> <td> <input type="number" min="0" max="10" step="0.01" name="week_second_L[]" style="width:200px;height:30px;" readonly="readonly"> </td></tr> <tr id="zuihouTwo"> <td style="text-align:center;vertical-align: middle;">周计划概述：</td> <td colspan="9"><textarea rows="3" cols="100" name="description_plan" style="width:400px"></textarea></td> <td colspan="1" style="text-align:center;vertical-align: middle;">一级审核人意见：</td> <td colspan="1" style="text-align:center;vertical-align: middle;"> <select name="opinion_one" disabled="disabled"> <option value="0">--请选择--</option> <option value="1">拟同意组员计划</option> <option value="2">请按照上述各项任务批注意见，进行修改</option> <option value="3">同意CTO意见</option> <option value="4">请组员再次修改</option> </select> </td> <td style="text-align:center;vertical-align: middle;">二级审核人意见：</td> <td style="text-align:center;vertical-align: middle;"> <select name="opinion_two" disabled="disabled"> <option value="0">--请选择--</option> <option value="1">同意组长意见</option> <option value="2">不完全同意组长意见，请按我意见做修改</option> </select> </td> </tr>'; 

      $("#second tr:last").after(html); }

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
  //  var values= $(this).val();
  //  if( values > 100){ alert('此处满分是100'); $(this).val(100);};
  //  if(values <0){ alert('此处最小分是0');  $(this).val(Math.abs(values)); };
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
