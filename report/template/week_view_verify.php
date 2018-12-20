<html>
<head>
  <title>周报信息</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <link rel="stylesheet" type="text/css" href="template/default/content/css/style.css"> -->
  <style type="text/css">
      /*  table tr td {
                text-align:center;
        }*/

        .th-inner {            width:120px !important;
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
    .danger{
      background: #f2dedf;
    }

  </style>
  <link rel="stylesheet" type="text/css" href="template/default/content/css/bootstrap.min.css" media="screen">
  <script language="javascript" type="text/javascript" src="DatePicker/WdatePicker.js"></script>
</head>
<body class="bodycolor">
  <table width="90%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
    <tr>
      <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3">审核周报信息</span>
      </td>
    </tr>

   <!--  <tr>
      <td><br/>1.本表由汇报人每周五18:00之前油价发送给相应负责人 2.汇总表A、B、C、D组成</td>
    </tr> -->
  </table>

  <form id="weeklyInfo" name="save" method="post" action="?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=sub">
  <input type="hidden" name="savetype" value="add" />
    <input type="hidden" name="uid" value="<?php echo $result['uid']?>" />
    <input type="hidden" name="name" value="<?php echo $result['name']?>" />
    <input type="hidden" name="weeknum" value="<?php echo $_GET['weeknum']?>" />
    <input type="hidden" name="scoreid" value="<?php echo $orderid ?>" />


    <table class="table table-bordered table-hover" id="first" width="200%" id="first">
        <caption >第
          <!-- 第多少周总结-->
          <select name="week_number" style = "width:60px;">
            <?php
              

                for( $i=1;$i<=54;$i++)
                {
                  if($infoWeek_order['weekly_number'] == $i)
                  {
                    echo "<option value=".$i." selected>".$i."</option>\r\n";
                  }else{
                    echo "<option value=".$i.">".$i."</option>\r\n";
                  }
                }
              
            ?>

            </select>
            周

            <?php 

            //输出周报时间
            $date_first = $infoWeek_order['create_time_start']?$infoWeek_order['create_time_start']:date('Y-m-d');
            $date_end = $infoWeek_order['create_time_end']?$infoWeek_order['create_time_end']:date('Y-m-d');

          ?>

           ( <input type="text" name="weekly_first_start" class="BigInput" size="20"  onClick="WdatePicker();" value="<?php echo $date_first?>" style="width:140px;height:30px;"/> 至 <input type="text" name="weekly_first_end" class="BigInput" size="20"  style="width:140px;height:30px;" onClick="WdatePicker();" value="<?php echo $date_end?>" /> ) 总结汇报表

        </caption >

        <thead>
        <tr bgcolor="#E7F0FB">
          <td colspan="3" style="text-align:center;vertical-align: middle;"><span>填表日期：<?php echo $infoWeek_order['create_time_early']?></span></td>
          <td style="text-align:center;vertical-align: middle;">汇报人：<?php echo $name;?></td>
          <td style="text-align:center;vertical-align: middle;">部门：

                <select name="departmentida" id="changeInfo" style = "width:200px;">
                <?php foreach ($departmentid_on as $key => $value) { ?>
                      <?php if($department_name_specil['id'] == $value['department_id']){?>

                          <option value="<?=$value['department_id']?>" selected='selected'><?=$value['name']?></option>
                      <?php }else{?>
                          <option value="<?=$value['department_id']?>"><?=$value['name']?></option>

                    <?php }?>
                  <?php }?>
              </select>


          </td>
          <td colspan="13" ></td>
        </tr>

        <tr style="text-align:center;vertical-align: middle;">
          <th style="text-align:center;vertical-align: middle;"><div style="width:40px;">序号</div></th>
          <th style="text-align:center;vertical-align: middle;"><div style="width:70px;">任务新旧</div></th>

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
                $date_fall = $time;

              

              //输出
              if($value['week_first_F'])
                $date_success = $value['week_first_F'];
              else 
                $date_success = $time;

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
                $html_all = '<td style="text-align:center;vertical-align: middle;">'.$infoWeek_order['score'].'</td>';
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
                <td><textarea rows="3" cols="20" name="week_first_A[]" disabled="disabled">'.$value['week_second_A'].'</textarea><input type="hidden" name="idFirstAr[]" value="'.$value['id'].'"></td>
                <td><textarea rows="3" cols="20" name="week_first_B[]" disabled="disabled">'.$value['week_second_B'].'</textarea></td>
                <td><textarea rows="3" cols="20" name="week_first_C[]" disabled="disabled">'.$value['week_second_C'].'</textarea></td>
                <td><textarea rows="3" cols="20" name="week_first_D[]" disabled="disabled">'.$value['week_second_D'].'</textarea></td>';

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
                        <select name="week_first_G[]" style="width:120px;" disabled="disabled">';
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
                        <select name="week_first_G[]" style="width:120px;" disabled="disabled">';
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
                    <textarea rows="3" cols="20" name="week_first_H[]" disabled="disabled">'.$value['week_first_H'].'</textarea>
                </td>
                <td>
                    <input type="number" min="0" max="10" step="0.01" name="week_first_I[]" style="width:200px;height:30px;" value="'.$value['week_first_I'].'" disabled="disabled"> 
                </td>
                ';
                
              //一级审核人 
              if( $key_level == 1  && $access_person == 1)
              {
                   $html_file_all .='
                   <td>
                    <textarea rows="3" cols="20" name="week_first_J[]">'.$value['week_first_J'].'</textarea>
                    </td>';
              }
              else
              {
                    $html_file_all .='
                   <td>
                    <textarea rows="3" cols="20" name="week_first_J[]" readonly="readonly">'.$value['week_first_J'].'</textarea>
                    </td>';
              }

              // if( ($key_level == 1) && ($value['is_show_to_plan'] == '2') && $value['week_second_L'])
              //总结只有上周在计划中二级审核人填写了就不能填写
              if( ($key_level == 1) && $value['week_second_L'] && $access_person == 1 )
              {
                   $html_file_all .=   
                    '<td>
                        <input type="number" min="0" max="10" step="0.01" name="week_first_K[]" style="width:200px;height:30px;"  value="'.$value['week_first_K'].'">
                        <input type="hidden" name="idFirstAr_fail[]" value="'.$value['id'].'"/>
                    </td>
                    ';
              }
              else
              {
                     $html_file_all .=   
                    '<td>
                        <input type="number" min="0" max="10" step="0.01" name="week_first_K[]" style="width:200px;height:30px;"  value="'.$value['week_first_K'].'" readonly="readonly">
                    </td>
                    ';
              }
            
              
              
          if( $key_level == 2  && $access_person == 2 )
          {
              //二级审核人 
              $html_file_all .=
                '<td>
                    <textarea rows="3" cols="20" name="week_first_L[]">'.$value['week_first_L'].'</textarea>
                </td>';
           }
           else
          {

              //二级审核人 
              $html_file_all .=
                '<td>
                    <textarea rows="3" cols="20" name="week_first_L[]" readonly="readonly">'.$value['week_first_L'].'</textarea>
                </td>';

          }

            //二级审核人确认本项任务的重要性占比 
           if( ($key_level == 2 && $access_person == 2)  && $value['week_second_L'])
            {
                 $html_file_all .=
                '<td>
                      <input type="number" min="0" max="10" step="0.01" name="week_first_M[]" class="fen" style="width:200px;height:30px;" value="'.$value['week_first_M'].'">
                </td>';
            }
            else
            {
                  $html_file_all .=
                '<td>
                      <input type="number" min="0" max="10" step="0.01" name="week_first_M[]" class="fen" style="width:200px;height:30px;" value="'.$value['week_first_M'].'" readonly="readonly">
                </td>';
            }

            $html_file_all .=
                  '<td>
                        <input type="number" min="0" max="10" step="0.01" name="week_first_N[]" readonly="readonly" style="width:200px;height:30px;" value="'.$value['week_first_N'].'">
                  </td>

                </tr>';

            echo $html_file_all;

              $s++;
            }


          }
         


      ?>

      <!--      END   -->
      <tr id="zuihouOne" class="text-center" style="text-align:center;vertical-align: middle;">
        <td  colspan="2" style="text-align:center;vertical-align: middle;">周总结概述 ：</td>

        <td colspan="3">
            <textarea rows="3" style="width:400px;" name="description" readonly="readonly"><?=$infoWeek_order['description']?></textarea>
          </td>
          <td colspan="2" style="text-align:center;vertical-align: middle;">
              本周绩效考核得分：  <?=$infoWeek_order['score']?>
        </td>
            
        <td colspan="9">
                <?php if($infoWeek_order['is_confirm'] != '1'){?> 
                      <input type="button" class="btn btn-warning" onclick="changeType()" value="总结确认">
                  <?php }?>
        </td>
      </tr>

  </tbody>
  </table>

  </br>


    <!-- 计划汇报表-->
    <table class="table table-bordered table-hover" id="second">
          <caption>
            <!-- 第多少周总结-->第
            <select name="week_number_plan" disabled="disabled" style="width:60px;">
              <?php   
                for( $i=1;$i<=54;$i++)
                {
                  if($infoWeek_order['weekly_number_plan'] == $i)
                  {
                    echo "<option value=".$i." selected='selected'>".$i."</option>\r\n"; 
                  }
                  else
                  {
                    echo "<option value=".$i.">".$i."</option>\r\n";
                    
                  }
                }
              ?>

              </select>
              周


              <?php 

            //输出周报时间
            $date_first_plan = $infoWeek_order['create_time_start_plan']?$infoWeek_order['create_time_start_plan']:date('Y-m-d');
            $date_end_plan = $infoWeek_order['create_time_end_plan']?$infoWeek_order['create_time_end_plan']:date('Y-m-d');

          ?>

             ( <input type="text" name="weekly_second_start" class="BigInput" size="20"  onClick="WdatePicker();" value="<?=$date_first_plan?>" style="width:140px;height:30px;"/> 至 <input type="text" name="weekly_second_end" class="BigInput" size="20"  style="width:140px;height:30px;" onClick="WdatePicker();" value="<?=$date_end_plan?>" /> ) 计划汇报表


        </caption>

        
        <thead>
        <tr bgcolor="#E7F0FB">
          <td colspan="3" style="text-align:center;vertical-align: middle;">填表日期：<?php echo $infoWeek_order['create_time_early']?></td>
          <td style="text-align:center;vertical-align: middle;">汇报人：<?php echo $name;?></td>
          <td style="text-align:center;vertical-align: middle;">部门：<?=$department_name_specil['name']?> </td>
          <td colspan="11" ></td>
        </tr>

        <tr class="TableControl">
          <td style="padding:25px 30px;" style="text-align:center;vertical-align: middle;"><div style="width:40px;">序号</div></td>
          <td style="padding:25px 30px;" style="text-align:center;vertical-align: middle;"><div style="width:70px;">任务新旧</div></td>
          <?php
                $thumbResult_second = array_filter($resultWeekInfo[1]);
                unset($thumbResult_second['id']);
                foreach($thumbResult_second as $key=>$val)
                {
                  echo "<th style='text-align:center;vertical-align: middle;'>".$val."</th>";
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
              $htmlWeekPlan = '
            <tr style="text-align:center;vertical-align: middle;" id="1er">

              <td style="text-align:center;vertical-align: middle;"  align="center">'.($k+1).'
              </td>

              <td style="text-align:center;vertical-align: middle;"  >'.$newInfo.'
              </td>

              <td><textarea rows="3" cols="20" readonly="readonly" name="week_second_A[]" '.$class_sy.'>'.$val['week_second_A'].'</textarea><input type="hidden" name="idSecondAr[]" value="'.$val['id'].'">
              </td>

              <td><textarea readonly="readonly" rows="3" cols="20" name="week_second_B[]">'.$val['week_second_B'].'</textarea>
              </td>

              <td><textarea readonly="readonly" rows="3" cols="20" name="week_second_C[]">'.$val['week_second_C'].'</textarea>
              </td>

              <td><textarea readonly="readonly" rows="3" cols="20" name="week_second_D[]">'.$val['week_second_D'].'</textarea>
              </td>

              <td>
                <input type="text" name="week_second_E[]" class="BigInput" size="20" onclick="WdatePicker();" value='.$planComplate.' style="width:160px;height:30px;">
              </td>

              <td><textarea readonly="readonly" rows="3" cols="20" name="week_second_F[]">'.$val['week_second_F'].'</textarea>
              </td>

              <td>';

              

              if($val['week_second_G_is'] == 1) //1代表有资源需求
              {
                $htmlWeekPlan .='<input name="week_second_G_is'.$k.'" class="is_check_false" type="radio" value="0" disabled="disabled"/>无
              <input name="week_second_G_is'.$k.'" type="radio" value="1" class="is_check_true" checked disabled="disabled"/>有<div style="width:140px;" ></div>';

                $htmlWeekPlan .='<textarea rows="3" cols="20" name="week_second_G[]" readonly="readonly">'.$val['week_second_G'].'</textarea>
              </td>';

              }
              else if($val['week_second_G_is'] == 0)//0代表没有资源需求
              {
                $htmlWeekPlan .='<input name="week_second_G_is'.$k.'" class="is_check_false" type="radio" value="0" checked="checked" disabled="disabled"/>无
              <input name="week_second_G_is'.$k.'" class="is_check_true" type="radio" value="1" disabled="disabled"/>有<div style="width:140px;"></div>';

                $htmlWeekPlan .='<textarea readonly="readonly" rows="3" style="display: none;" cols="20" name="week_second_G[]">'.$val['week_second_G'].'</textarea>
              </td>';
              }

              $htmlWeekPlan .='
                    
                <td>
                  <input type="number" min="0" max="10" step="0.01" name="week_second_H[]" value="'.$val['week_second_H'].'" readonly="readonly" style="width:200px;height:30px;">
                  <input type="hidden" name="idSecondAr_fail[]" value="'.$val['id'].'"/>
                </td>';
           
            
            if( $key_level == 1 && $access_person == 1)
            {
               $htmlWeekPlan .=
                '<td>
                 <textarea rows="3" cols="20" name="week_second_I[]">'.$val['week_second_I'].'</textarea>
                </td>';
            }
            else
            {
              $htmlWeekPlan .=
                '<td>
                 <textarea rows="3" cols="20" name="week_second_I[]" readonly="readonly">'.$val['week_second_I'].'</textarea>
                </td>';
            }

            if( ($key_level == 1 && $access_person == 1 ) && ($val['is_show_to_plan'] == '2') )
            {
              $htmlWeekPlan .='  <td>
                  <input type="number"   min="0" max="10" _isold="1" step="0.01" name="week_second_J[]" style="width:200px;height:30px;" value="'.$val['week_second_J'].'">
                </td>';
            }
            else
            {
               $htmlWeekPlan .='  <td>
                  <input type="number" readonly="readonly" _isold="4" min="0" max="10" step="0.01" name="week_second_J[]" style="width:200px;height:30px;" value="'.$val['week_second_J'].'">
                </td>';
            }
            
        //二级人意见
        if( $key_level == 2 && $access_person == 2)
        {

            $htmlWeekPlan .=
                '<td>
                  <textarea rows="3"  cols="20" name="week_second_K[]" >'.$val['week_second_K'].'</textarea>
                </td>';
        }
        else
        {
           $htmlWeekPlan .=
                '<td>
                  <textarea rows="3"  readonly="readonly" cols="20" name="week_second_K[]" >'.$val['week_second_K'].'</textarea>
                </td>';
        }

        //二级人确认占比
        if(   $val['weekly_is_new'] == '0'  && $key_level == 2 && $access_person == 2)
        {
             $htmlWeekPlan .= 
                '<td>
                  <input type="number"  min="0" max="10" _isolds="1" step="0.01" name="week_second_L[]" style="width:200px;height:30px;" value="'.$val['week_second_L'].'">
                </td>
        
              </tr>';
        }
        else
        {
             $htmlWeekPlan .=
                '<td>
                  <input type="number" readonly="readonly" _isolds="4" min="0" max="10" step="0.01" name="week_second_L[]" style="width:200px;height:30px;" value="'.$val['week_second_L'].'">
                </td>
        
              </tr>';
        }

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

        <tr style="text-align:center;vertical-align: middle;" id="zuihouTwo">
          <td style="text-align:center;vertical-align: middle;">周计划概述：</td>
          <td colspan="9">
            <textarea rows="3" cols="100" name="description_plan" style="width:400px" readonly="readonly"><?=$infoWeek_order['description_plan'] ?></textarea>
          </td>

          <td style="text-align:center;vertical-align: middle;">一级审核人意见：
          </td>
        <?php if( $key_level == 1 &&  $access_person == 1){?>

          <td colspan="1" style="text-align:center;vertical-align: middle;">
            <select name="opinion_one" style="width:290px;">

              <?php if( ( $infoWeek_order['opinion_one'] && empty($infoWeek_order['opinion_two']) ) || $infoWeek_order['access_weekly'] == '0' ){?>     
                <option value="0">--请选择--</option>

                <option value="1" <?php if($infoWeek_order['opinion_one'] == '1'){echo 'selected="selected"';}?> >拟同意组员计划</option>
                <option value="2" <?php if($infoWeek_order['opinion_one'] == '2'){echo 'selected="selected"';}?>>请按照上述各项任务批注意见，进行修改</option>
              
               <?php }else if($infoWeek_order['opinion_one'] && $infoWeek_order['opinion_two']){?> 
                    <option value="3" <?php if($infoWeek_order['opinion_one'] == '3'){echo 'selected="selected"';}?> >同意CTO意见</option>
              <?php }?>
              <?php if($infoWeek_order['access_weekly'] >= 1 && empty($infoWeek_order['opinion_two'])){?>
                  <option value="4" <?php if($infoWeek_order['opinion_one'] == '4'){echo 'selected="selected"';}?>>请组员再次修改</option>
              <?php }?>


            </select>
          </td>

         <?php }else{?>

            <td colspan="1" style="text-align:center;vertical-align: middle;">
              <select name="opinion_one" disabled="disabled" style="width:290px;">
                <option value="0">--请选择--</option>
                <option value="1" <?php if($infoWeek_order['opinion_one'] == '1'){echo 'selected="selected"';}?> >拟同意组员计划</option>
                <option value="2" <?php if($infoWeek_order['opinion_one'] == '2'){echo 'selected="selected"';}?>>请按照上述各项任务批注意见，进行修改</option>
                <option value="3" <?php if($infoWeek_order['opinion_one'] == '3'){echo 'selected="selected"';}?> >同意CTO意见</option>
                <option value="4" <?php if($infoWeek_order['opinion_one'] == '4'){echo 'selected="selected"';}?>>请组员再次修改</option>
              </select>
          </td>

         <?php }?>

          <td style="text-align:center;vertical-align: middle;">二级审核人意见：</td>

        <?php if( $key_level == 2 && $access_person == 2){?>
          <td style="text-align:center;vertical-align: middle;">
             <select name="opinion_two" style="width:290px;">
              <option value="0">--请选择--</option>
              <option value="1" <?php if($infoWeek_order['opinion_two'] == '1'){echo 'selected="selected"';}?> >同意组长意见</option>
              <option value="2" <?php if($infoWeek_order['opinion_two'] == '2'){echo 'selected="selected"';}?> >不完全同意组长意见，请按我意见做修改</option>
            </select>
          </td>
          <?php }else{?>
            <td style="text-align:center;vertical-align: middle;">
             <select name="opinion_two" disabled="disabled" style="width:340px;">
              <option value="0">--请选择--</option>
              <option value="1" <?php if($infoWeek_order['opinion_two'] == '1'){echo 'selected="selected"';}?> >同意组长意见</option>
              <option value="2" <?php if($infoWeek_order['opinion_two'] == '2'){echo 'selected="selected"';}?> >不完全同意组长意见，请按我意见做修改</option>
            </select>
          </td>

          <?php }?>

      </tr>
  </tbody>

    </table>


    <div style="margin-left: 40%;">
      
      
    
    <?php 

        if($is_hidden != 'string')
        {
          echo '<input type="button" value="提交审核" class="btn btn-success" ids="sub">&nbsp;';
        }
    ?>
      <input type="button" value="返回" class="btn btn-default" ids="return">

    </div>

  </form>

 
</body>
</html>
<script language="javascript" type="text/javascript" src="template/default/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript">

     //查看输入值是否超过了设定的值
    var number_set = "<?=$resultCeil['max_a']?>";

    $("input[name^=week_first_K],input[name^=week_first_M]").on('blur',function()
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

    //当用户没有选择意见的时候按照当前周报规定的级数审核
    var level = "<?php echo $key_level;?>";
    if(level == 1){
          $("select[name=opinion_one]").after("<input type='hidden' name='operation' value='one_level' >");
    }else if( level == 2){
          $("select[name=opinion_two]").after("<input type='hidden' name='operation' value='two_level' >");
    }
    //操作审核意见的时候区分一级和二级审核意见
    $("select[name=opinion_one]").change(function(){
        $(this).after("<input type='hidden' name='operation' value='one_level' >");
    });
    $("select[name=opinion_two]").change(function(){
        $(this).after("<input type='hidden' name='operation' value='two_level' >");

    });

    //提交表单
    $("input[ids=sub]").click(function(){

        //查看输入值是否超过了设定的值
        var number_set = "<?=$resultCeil['max_a']?>";
        $("input[name^=week_first_K],input[name^=week_first_M]").each(function(){

            if($(this).attr('readonly') != 'readonly'){

                if($(this).val() < 0  || $(this).val() > number_set)
                {
                     alert('输入值范围在0 ~ '+number_set);
                     this.value=0;
                }

            }
          
        })


          <?php    if($key_level == 1 && $access_person == 1){?>

                   //判断计划个人占比是否超过了1并且每个任务都是在1之内和0之间
                  var heightNumber = 0;
                  var heightNumbers = 0;
                  $('input[name^=week_second_J]').each(function(k,v){

                    if($(this).attr('_isold') == '4'){ return true; }   
                    if($(this).val() < 0   || $(this).val() > 1 || $(this).val()  == ''){ heightNumber++;}
                    heightNumbers += parseFloat(v.value);
                  });

                   //修复JS计算二进制BUG
                  heightNumbers = heightNumbers.toFixed(3);
                  if( heightNumber){ alert('单个计划任务一级审核人占比大于等于0，小于等于1'); return false;}
                  if( heightNumbers != 1){ alert('所有的计划任务的一级审核人提议占比总和等于1,单个计划任务一级审核人占比大于等于0，小于等于1'); return false;}
                 if($("select[name=opinion_one]").val() == 0)
                 {
                    alert('请选择一级审核人意见');return false;
                 } 
      

          <?php  }else{?>


                    //判断计划个人占比是否超过了1并且每个任务都是在1之内和0之间
                  var heightNumber = 0;
                  var heightNumbers = 0;
                  $('input[name^=week_second_L]').each(function(k,v){

                     if($(this).attr('_isolds') == '4'){ return true; }  

                    if($(this).val() < 0   || $(this).val() > 1 || $(this).val() == ''){ heightNumber++;}
                    heightNumbers += parseFloat(v.value);
                    
                  });

                    //修复JS计算二进制BUG
                    heightNumbers = heightNumbers.toFixed(3);

                  if( heightNumber){ alert('单个计划任务二级审核人占比大于等于0，小于等于1'); return false;}
                  if( heightNumbers != 1 ){ alert('所有的计划任务的二级审核人提议占比总和等于1,单个计划任务一级审核人占比大于等于0，小于等于1'); return false;}

                   if($("select[name=opinion_two]").val() == 0)
                 {
                    alert('请选择二级审核人意见');return false;
                 } 

          <?php  }?>

      $("form").submit();
    });
    //返回按钮
    $("input[ids=return]").click(function(){
      window.location='/admin.php?ac=weeklyVerify&fileurl=report&do=list';
    });
    //是否同意
  $(document).on('click','.is_check_false',function(){

      $(this).siblings('textarea').hide();
  });

  $(document).on('click','.is_check_true',function(){
     $(this).siblings('textarea').show();
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
    //是否有
      $("#zuihouOne").remove();
      var conn = $("#first tr:last").find("td:first").html();
      if(conn == "序号") conn =0
      conn++;
    var html ='<tr class="TableControl stleOne"> <td width="70px" align="center">'+conn+'</td> <td width="70px">新任务</td><td><textarea rows="3" cols="20" name="week_first_A[]"></textarea></td> <td><textarea rows="3" cols="20" name="week_first_B[]"></textarea></td> <td><textarea rows="3" cols="20" name="week_first_C[]"></textarea></td> <td>'; 
    // var name = "<?php echo $_USER->name;?>";
     html +='<textarea rows="3" cols="20" name="week_first_D[]"></textarea></td>';
      html +='<td><input id="meeting" type="date" value="2018-01-13" name="week_first_E[]"/></td> <td><input id="meeting" type="date" value="2018-01-13" name="week_first_F[]"/></td> <td width="60px"> <select name="week_first_G[]"> <option value="0">0%</option> <option value="5">5%</option> <option value="10">10%</option> <option value="15">15%</option> <option value="20">20%</option> <option value="25">25%</option> <option value="30">30%</option> <option value="35">35%</option> <option value="40">40%</option> <option value="45">45%</option> <option value="50">50%</option> <option value="55">55%</option> <option value="60">60%</option> <option value="65">65%</option> <option value="70">70%</option> <option value="75">75%</option> <option value="80">80%</option> <option value="85">85%</option> <option value="90">90%</option> <option value="95">95%</option> <option value="100">100%</option> </select> </td> <td><textarea rows="3" cols="20" name="week_first_H[]"></textarea></td> <td><input type="number" name="week_first_I[]" style="width:60px;">分</td> <td><textarea rows="3" cols="20" name="week_first_K[]" readonly="readonly"></textarea></td> <td><input type="text" name="week_first_L[]" style="width:60px;" readonly="readonly"> 分</td> <td><input type="text" name="week_first_M[]" style="width:60px;" readonly="readonly"> 分</td> <td>  <input type="text" name="week_first_M[]" style="width:60px;" readonly="readonly"> 分 </td></tr><tr class="TableControl" id="zuihouOne"><td width="30px">周计划概述：</td><td colspan="100"><textarea rows="3" cols="100" name="week_first_J"></textarea>&nbsp <input type="button" onclick="changeType()" value="总结确认"></td></tr>';
      $("#first tr:last").after(html);


    // console.log(first);//
  }

  function addInfoSecond(obj)
  {
    //是否有
      $("#zuihouTwo").remove();
    var conn = $("#second tr:last").find("td:first").html();
    if(conn == "序号") conn =0
      conn++;
    var html ='<tr class="TableControl stleTwo" id="1er"> <td width="70px" align="center">'+conn+'</td> <td width="70px">新任务</td><td><textarea rows="3" cols="20" name="week_second_A[]"></textarea></td> <td><textarea rows="3" cols="20" name="week_second_B[]"></textarea></td> <td><textarea rows="3" cols="20" name="week_second_C[]"></textarea></td>'; 
    // var name = "<?php echo $_USER->name;?>";
    html += '<td><textarea rows="3" cols="20" name="week_second_D[]"></textarea></td>';

    html += '<td><input id="meeting" type="date" value="2018-01-13" name="week_second_E[]"/></td> <td><textarea rows="3" cols="20" name="week_second_F[]"></textarea></td> <td width="60px"> <input name="week_second_G_is'+conn+'" type="radio" value="0" checked="checked" />无 <input name="week_second_G_is'+conn+'" type="radio" value="1" />有 <textarea rows="3" cols="20" name="week_second_G[]"></textarea> </td> <td colspan="6"> <input name="opinion_is_agree" type="radio" value="1" readonly="readonly" />同意 <input name="opinion_is_agree" type="radio" value="2" readonly="readonly" />修改意见 <textarea rows="3" cols="20" name="week_second_H[]" readonly="readonly"></textarea> </td></tr><tr class="TableControl" id="zuihouTwo"><td width="30px">概述：</td><td colspan="17"><textarea rows="3" cols="100" name="week_second_J"></textarea></td></tr>'; $("#second tr:last").after(html);
  }


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
  $(".fen").blur(function(){
    var values= $(this).val();
    if( values > 100){ alert('此处满分是100'); $(this).val(100);};
    if(values <0){ alert('此处最小分是0');  $(this).val(Math.abs(values)); };
  });

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

  $(function(){
      $("select[name=week_number],select[name=week_number_plan],select[name=departmentida]").click(function(){
          alert("此处不可选择！");
          return false;
      }) 
  }); 



  //确认之后不能修改
  <?php if($status_is_confirm == '1'){?>
  // $("#first").find('textarea','input[type=number]','input[type=date]','.meeting').attr("readonly",'readonly');

  $("select[name^=week_first_G]").attr('disabled','true');
  $("input[name^=week_first_I]").attr('readonly','readonly');
  $("input[name=is_poor_planing]").attr('disabled','true');

  
  //去除點擊事件
  $('input[name^=week_first_F]').removeAttr("onclick");
  $('input[name^=week_first_E]').removeAttr("onclick");
 

  $('input[name=weekly_first_start]').removeAttr("onclick");
  $('input[name=weekly_first_end]').removeAttr("onclick");
  $('input[name=weekly_first_end]').attr("readonly","true");
  $('input[name=weekly_first_start]').attr("readonly","true");

  $('input[name=weekly_second_start]').removeAttr("onclick");
  $('input[name=weekly_second_end]').removeAttr("onclick");
   $('input[name=weekly_second_start]').attr("readonly","true");
  $('input[name=weekly_second_end]').attr("readonly","true");

   $('input[name^=week_second_E]').removeAttr("onclick");
   $('input[name^=week_second_E]').attr("readonly","true");


  <?php }?>

</script>
