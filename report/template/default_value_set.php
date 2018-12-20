<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<!-- <link rel="stylesheet" type="text/css" href="template/default/content/css/style.css"> -->
<link rel="stylesheet" type="text/css" href="template/default/content/css/bootstrap.min.css" media="screen">
<script language="javascript" type="text/javascript" src="DatePicker/WdatePicker.js"></script>
<script src="template/default/tree/js/admincp.js?SES" type="text/javascript"></script>
<script charset="utf-8" src="eweb/kindeditor.js"></script>

<title>标融办公系统</title>
 <style type="text/css">
      .center{
        text-align:right !important;
        vertical-align: middle !important;
      }

      .center-second{
        text-align:center !important;
        vertical-align: middle !important;
      }
 </style>
</head>
<body class="bodycolor">


<table class="table table-responsive">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 周报默认值设置</span>&nbsp;&nbsp;&nbsp;&nbsp;
  <span style="font-size:12px; float:right;margin-right:20px;">
    </td>
  </tr>
</table>

<form name="save" method="post" action="">
<table class="table table-responsive ">
    <tr>
      <td class="center" width="40%">周总结中上限值：</td>

      <td>
        <input type="text" value="<?=$weekCeilAndcompare['max_a']?>" name="max_a">
        (个人打分和组长打分以及CTO打分上限值)
      </td>
    </tr>

    <!--  
     <tr>
      <td class="center">月考核重要性占比：</td>
      <td>
          <input type="text" value="<?=$weekCeilAndcompare['section_e']?>" name="section_e">
      </td>
    </tr> 
 -->
   <!--   <tr>
      <td class="center">季度考核重要性占比：</td>
      <td>
          <input type="text" value="<?=$weekCeilAndcompare['section_f']?>" name="section_f">
      </td>
    </tr>  -->

    <tr>
      <td class="center">周计划重要性占比：</td>

      <td>
        d:<input type="text" value="<?=$week_data['section_a']?>" class="first" name="section_a[]"> (个人建议重要性占比) <br>
        e: <input type="text" value="<?=$week_data['section_b']?>" class="first" name="section_b[]"> (组长建议重要性占比)<br>
        f: <input type="text" value="<?=$week_data['section_c']?>" class="first" name="section_c[]"> (CTO建议重要性占比)<br>
      </td>
    </tr> 

    <tr>
      <td class="center">周总结打分权重占比：</td>

      <td>
        a:<input type="text" value="<?=$week_data_plan['section_a']?>" class="second" name="section_a[]"> (个人打分权重占比) <br>
        b:<input type="text" value="<?=$week_data_plan['section_b']?>" class="second" name="section_b[]"> (组长打分权重占比)  <br>
        c:<input type="text" value="<?=$week_data_plan['section_c']?>" class="second" name="section_c[]"> (CTO打分权重占比) <br>
      </td>
    </tr>
   

   <tr>
      <td class="center">完成率：<font color="red">( * 设置周报完成率合格线范围是0到100 )</font></td>
      <td>
          <input type="text" value="<?=$info['line_complate']?>" name="line_complate"> %
      </td>
    </tr>

    <tr>
      <td class="center-second" colspan="6">
          <br>
          <br>
          <input type="button" name="Submit" value="设置保存" class="btn btn-info">
      </td>
    </tr>

  </table>
</form>
</body>
</html>
<script language="javascript" type="text/javascript" src="template/default/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript">

$('input[name=Submit]').click(function(){

  var status = true;
  //验证数据是否有为空的
  $('input[name^=section_a],input[name^=section_b],input[name^=section_c],input[name=max_a],input[name=line_complate]').each(function(key,value){

      if( $(this).val() == '' ){
        alert('所有的输入框都需要填写完，请仔细核对是否填写正确！')
          status = false;
          $(this).focus();
          return false;
      }

      var number = parseFloat($(this).val());

      if(  isNaN( number) ) { 
        alert('您必须输入数字类型，请重新输入！');
        status = false;
        $(this).focus();
        return false;
      }

      
  });

  var numbers_value = $("input[name=line_complate]").val();
  if(numbers_value < 0 || numbers_value >100) { alert('设置周报完成率合格线范围是0到100 '); return false;}

  var number = 0;
  var numbers = 0;

  //判断和是1
  $('.first').each(function(k,v){

      if( $(this).val() > 1 ){ number++;}
      numbers += Number($(this).val());
  }); 

  if(number > 0 || (numbers > 1 || (numbers < 1 && numbers > 0)) ){ alert('周计划重要性占比总和为1，并且单个占比是大于0，小于1');return false;}


  var num = 0;
  var nums = 0;
  $('.second').each(function(k,v){

      if( $(this).val() > 1 ){ num++;}
      nums += Number($(this).val());
  }); 

  if(num > 0 || (nums > 1 || (nums < 1 && nums > 0) ) ){ alert('周总结打分权重占比总和为1，并且单个占比是大于0，小于1');return false;}

  var complate = $('input[name=line_complate]');
  if(  complate < 0  || complate > 100 ){ alert('周报完成百分比合格线范围是0到100');return false;}
  if(status){ $('form').submit();}
});

</script>
