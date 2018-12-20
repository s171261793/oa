<html>
<head>
  <title>周报信息</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="template/default/content/css/bootstrap.min.css" media="screen">
  <!-- <script language="javascript" type="text/javascript" src="DatePicker/WdatePicker.js"></script> -->
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
    .blocks{
      display:inline-block;
      width:127px;
      height:20px;
    }welcome

  </style>
</head>
<body class="bodycolor">

  <table class="table table-responsive">
    <tr>
      <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 绩效信息</span>
      </td>
    </tr>
  </table>
  
  <form id="weeklyInfo" name="save" method="post" action="">
  <input type="hidden" name="savetype" value="add" />
    <input type="hidden" name="uid" value="<?php echo $result['uid']?>" />
    <input type="hidden" name="name" value="<?php echo $result['name']?>" />
    <input type="hidden" name="orderid" value="<?php echo $_GET['orderid']?>" />
    <input type="hidden" name="operationType" value="weeklyadd" />

    <table class="table table-bordered table-hover" id="first">

        <thead>
          <!-- 表头-->
          <tr bgcolor="#E7F0FB" >
            <th style="text-align:center;vertical-align: middle;"><span class="blocks">序号</span></th>
            <th style="text-align:center;vertical-align: middle;"><span class="blocks">姓名</span></th>
            <th style="text-align:center;vertical-align: middle;"><span class="blocks">部门</span></th>
            <th style="text-align:center;vertical-align: middle;"><span class="blocks">考核周期<span class="blocks"></th>
            <th style="text-align:center;vertical-align: middle;"><span class="blocks">月份</span></th>
            <th style="text-align:center;vertical-align: middle;"><span class="blocks">第一周权重</span></th>
            <th style="text-align:center;vertical-align: middle;"><span class="blocks">第一周绩效得分</span></th>
            <th style="text-align:center;vertical-align: middle;"><span class="blocks">第二周权重</span></th>
            <th style="text-align:center;vertical-align: middle;"><span class="blocks">第二周绩效得分</span></th>
            <th style="text-align:center;vertical-align: middle;"><span class="blocks">第三周权重</span></th>
            <th style="text-align:center;vertical-align: middle;"><span class="blocks">第三周绩效得分</span></th>
            <th style="text-align:center;vertical-align: middle;"><span class="blocks">第四周权重</span></th>
            <th style="text-align:center;vertical-align: middle;"><span class="blocks">第四周绩效得分</span></th>
            <th style="text-align:center;vertical-align: middle;"><span class="blocks">第五周权重</span></th>
            <th style="text-align:center;vertical-align: middle;"><span class="blocks">第五周绩效得分</span></th>
            <th style="text-align:center;vertical-align: middle;"><span class="blocks">总经理评价</span></th>
            <th style="text-align:center;vertical-align: middle;"><span class="blocks">本月绩效得分</span></th>
            <th style="text-align:center;vertical-align: middle;"><span class="blocks">本月权重</span></th>
            <th style="text-align:center;vertical-align: middle;"><span class="blocks">本季度绩效得分</span></th>
          </tr>
        </thead>

        <tbody>
              <?php if( count($infos) > 0 ) {?>
                  
                  <?php foreach($infos as $key=>$value):?>
                  
                  <tr>
                    <td style="text-align:center;vertical-align: middle;"> <?=$key+1?> </td>

                    <td style="text-align:center;vertical-align: middle;">
                      <?=get_realname($value['uid'])?>
                        <input type="hidden" name="uid[]" value="<?=$value['uid'];?>">
                    </td>

                    <td style="text-align:center;vertical-align: middle;">
                      <?php echo get_realdepaname($value['departmentName']);?>
                        <input type="hidden" name="departmentName[]" value="<?=$value['departmentName']?>">
                    </td>

                    <td style="text-align:center;vertical-align: middle;">月度</td>
                    <td style="text-align:center;vertical-align: middle;">
                      <?=$value['month']?>
                        <input type="hidden" name="month[]" value="<?=$value['month']?>"> 
                    </td>

                    <td style="text-align:center;vertical-align: middle;">
                      <input type="text" name="firstWeekWeight[]" placeholder="第一周权重" value="<?=$value['firstWeekWeight'];?>">
                    </td>

                    <td style="text-align:center;vertical-align: middle;">
                      <input type="text" name="firstWeekScore[]" readonly="readonly" value="<?=$value['firstWeekScore']?>">
                    </td>

                    <td style="text-align:center;vertical-align: middle;">
                      <input type="text" name="secondWeekWeight[]" placeholder="第二周权重" value="<?=$value['secondWeekWeight']?>">
                    </td>
                    <td style="text-align:center;vertical-align: middle;">
                        <input type="text" name="secondWeekScore[]" readonly="readonly" value="<?=$value['secondWeekScore']?>">
                    </td>

                    <td style="text-align:center;vertical-align: middle;">
                      <input type="text" name="thirdWeekWeight[]" placeholder="第三周权重" value="<?=$value['thirdWeekWeight']?>">
                    </td>
                    <td style="text-align:center;vertical-align: middle;">
                      <input type="text" name="thirdWeekScore[]" readonly="readonly" value="<?=$value['thirdWeekScore']?>">
                    </td>

                    <td style="text-align:center;vertical-align: middle;">
                      <input type="text" name="fourthWeekWeight[]" placeholder="第四周权重" value="<?=$fourthWeekWeight;?>">
                    </td>
                    <td style="text-align:center;vertical-align: middle;">
                       <input type="text" name="fourthWeekScore[]" readonly="readonly" value="<?=$value['fourthWeekScore']?>">
                    </td>

                    <td style="text-align:center;vertical-align: middle;">
                      <input type="text" name="fifthWeekWeight[]" placeholder="第五周权重" value="<?=$fifthWeekWeight;?>">
                    </td>
                    <td style="text-align:center;vertical-align: middle;">
                       <input type="text" name="fifthWeekScore[]" readonly="readonly" value="<?=$value['fifthWeekScore']?>">
                    </td>

                    <td style="text-align:center;vertical-align: middle;">
                       <input type="textarea" name="managerContent[]" placeholder="总经理评价" value="<?=$value['managerContent']?>">
                    </td>

                    <td style="text-align:center;vertical-align: middle;"><?=$value['monthScore']?></td>
                    <td style="text-align:center;vertical-align: middle;">
                   
                        <input type="text" name="monthpreg[]" placeholder="本月权重" value="<?=$value['monthpreg']?>">
                    </td>

                    <td style="text-align:center;vertical-align: middle;"><?=$value['seasonScore']?></td>
              </tr>
                 <?php   $js++; ?>
                <?php endforeach; ?>
             <?php }else{?>
              <tr><td colspan="19">暂时没有更多的数据了！</td></tr>
             <?php }?>

        </tbody>
    </table>
    <br>
    <br>
    <br>

    <?php if( count($infos) > 0 ) {?>
    <div style="margin-left: 40%;">
      <input type="button" value="提交" class="btn btn-success" id="sub">&nbsp;  &nbsp;  &nbsp; 
      <input type="button" value="返回" class="btn btn-default" id="return">&nbsp;  &nbsp;  &nbsp; 
    </div>
  <? };?>

  <body>
<html>

<script language="javascript" type="text/javascript" src="template/default/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript">

  $("#sub").click(function(){

      //验证数据
      $('#first').find('tr').each(function(k,v){
            // var firstWeekWeight = $(this).find('td input[name^=firstWeekWeight]');
            // var secondWeekWeight = $(this).find('td input[name^=secondWeekWeight]');
            // var thirdWeekWeight = $(this).find('td input[name^=thirdWeekWeight]');
            // var fourthWeekWeight = $(this).find('td input[name^=fourthWeekWeight]'); 
            // var fifthWeekWeight = $(this).find('td input[name^=fifthWeekWeight]');

            var strings  = $(this).find('td');
             console.log( strings)
             // console.log(secondWeekWeight.val())
             // console.log(thirdWeekWeight.val())
             // console.log(fourthWeekWeight.val())
             // console.log(fifthWeekWeight.val())

             // return false;
      });
      //提交表单
      // $("#weeklyInfo").submit();
  });


   $("#return").click(function(){

    var  url = "?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=detailList";
    window.location.href = url;
  });


</script>
