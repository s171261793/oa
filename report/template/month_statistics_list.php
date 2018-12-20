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
    }
    .floatFied{
      width:180px;
      height:109px;
      background:rgba(9,9,9,0.4);
      position: fixed;
      border:1px solid rgba(9,9,9,0.1); 
      border-radius:30px; 
      top:100px;
      left:0px;
      z-index:999;
      line-height:29px;
      padding:15px 17px;
    }
    .font-clickContent{
        display:inline-block;
        color:yellow;
        width:185px;
        margin: 0 auto;
        line-height:30px ;
        height:80px;
    }


  </style>
</head>
<body class="bodycolor">

  <table class="table table-responsive">
    <tr>
      <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 绩效信息提交时间段</span>
      </td>
    </tr>
  </table>
  <div class="floatFied">

    <span class="font-clickContent">点击此按钮可以提交最近几个月的周报信息进行统计。</span>
    <input type="button" style="margin-left:30px;" value="统计绩效信息" class="btn btn-success" id="list">&nbsp;  &nbsp;  &nbsp;
  </div>
  
  <form id="weeklyInfo" name="save" method="post" action="">

    <table class="table table-bordered table-hover" id="first">
        <thead>
          <!-- 表头-->
          <tr bgcolor="#E7F0FB" >
            <th style="text-align:center;vertical-align: middle;"><span class="blocks">序号</span></th>
            <th style="text-align:center;vertical-align: middle;"><span class="blocks">开始月份</span></th>
            <th style="text-align:center;vertical-align: middle;"><span class="blocks">结束月份</span></th>
            <th style="text-align:center;vertical-align: middle;"><span class="blocks">创建时间<span class="blocks"></th>
             <th style="text-align:center;vertical-align: middle;"><span class="blocks">考核状态<span class="blocks"></th>
            <th style="text-align:center;vertical-align: middle;"><span class="blocks">进入考核</span></th>
          </tr>
        </thead>

        <tbody>
              <?php if( count($infos) > 0 ) {?>
                  
                  <?php foreach($infos as $key=>$value):?>
                   
                  <tr>
                    <td style="text-align:center;vertical-align: middle;"> <?=$key+1?> </td>

                    <td style="text-align:center;vertical-align: middle;">
                      <?=get_realname($value['uid'])?>
                        <input type="text" name="min_month[]" id="<?=$value['min_month']?>" value="<?=$value['min_month'];?>" readonly="readonly">
                    </td>

                    <td style="text-align:center;vertical-align: middle;">
                        <input type="text" name="max_month[]" id="<?=$value['max_month']?>" value="<?=$value['max_month']?>" readonly="readonly">
                    </td>

                    <td style="text-align:center;vertical-align: middle;"><?=$value['create_time']?></td>
                      <?php   if($value['is_complate'] == '1'):?>
                          <td style="text-align:center;vertical-align: middle;">          完成</td>
                      <?php   else:?>
                                <td style="text-align:center;vertical-align: middle;">          未完成</td>
                      <?php   endif;?>
                    <td style="text-align:center;vertical-align: middle;">

                     <a href="?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=month&idsOrder=<?=$value['id']?>">进入</a>
                    </td>

              </tr>
                 <?php   $js++; ?>
                <?php endforeach; ?>
             <?php }else{?>
              <tr><td colspan="19">暂时没有更多的数据了！</td></tr>
             <?php }?>

        </tbody>
    </table>
    
    <div class="data-wrap">
      <div class="data-operation">
          
        <div class="pager_operation">
          <?php echo newshowpage($num,$pagesize,$page,$url);?>
        </div>

      </div>    
    </div>

  <body>
<html>

<script language="javascript" type="text/javascript" src="template/default/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript">

  $("#sub").click(function(){

      //验证数据这个数据在
      $("#weeklyInfo").submit();
  });


  $("#list").click(function(){

    var url = "?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=list";

    console.log(url)
      //验证数据这个数据在
      window.location.href=url;
  });


  
</script>
