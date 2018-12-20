<html>
<head>
<title>周报信息</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="/template/default/content/css/style.css">

  <link rel="stylesheet" type="text/css" href="/template/default/css/normalize.css" />
  <link href="http://cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="/template/default/css/htmleaf-demo.css">
  <link href="/template/default/css/file-explore.css" rel="stylesheet" type="text/css">


<script language="javascript" type="text/javascript" src="DatePicker/WdatePicker.js"></script>
  <style type="text/css">
        .covers_bac{width:30%;height:90%;border:1px solid black; box-shadow: 1px 1px 10px #888888;float:left;}
        .covers_bac_right{width:68%;height:600px;border:1px solid black; box-shadow: 1px 1px 10px #888888;float:right;}
        .covers_first{width:100%;height:100%;}
        .centers_con{width:80%;height:80px;border:1px solid black;margin: 12px auto ;}
        .centers_con_left{width:120px;height:80px;float:left;text-align: center;line-height: 80px;}
         .centers_con_right{width:20%;height:80px;float:left;text-align: center;}
         .addslm{display:inline-block;height:30px;color:black;background:#A8CEEF;border-radius:8px;float:left;margin-top:5px;padding: 6px 10px;margin-right:3px;}
  </style>
</head>
<body class="bodycolor">



<table class="table table-responsive">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 添加审核流程页面</span>
    </td>
    
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td><input type="button" value="<<返回" style="color:white;margin-left:-60px;" class="btn btn-info" onClick="window.location='/admin.php?ac=weeklyAccess&fileurl=report&do=list'"></td>
    </tr>
  </tr>
</table>
<br/>

<form action="/admin.php?ac=weeklyAccess&fileurl=report&do=add" method="post" id="datasub">
  

     <div class="covers_first">
       <div class="covers_bac">
              
          <div class="container" style="color:black;">
            <h4>部门结构图</h4>
            <ul class="file-tree" style="color:black;">
                <?php echo $html;?>
          </div>
        </div>
            <div class="covers_bac_right" style="color:black;">
                  
              <div class="centers_con">
                  <div class="centers_con_left"> <font color="black">被审核部门：</font></div>
                  <div class="centers_con_right" id="addContent"></div>
              </div>

              <div class="centers_con">
                  <div class="centers_con_left"> <font color="black">被审核员工：</font></div>
                  <div class="centers_con_right" style="padding-top: 22px;">
                    
                    <select name="user_id" style="z-index:999999;position:relative;">
                    <option value="0">--请选择--</option>

                     <?php foreach($userInfo as $key=>$value){?>
                     
                      <option value=<?php echo $value['id'];?> ><?php echo $value['name'];?></option>
                    <?php }?>
                    
                    </select>
                  </div>
              </div>

              <div class="centers_con">
                  <div class="centers_con_left"> <font color="black">一级审核人：</font></div>
                   <div class="centers_con_right" style="padding-top: 22px;">
                    
                    <select name="one_person">
                    <option value="0">--请选择--</option>
                     <?php foreach($userInfo as $key=>$value){?>
                      <option value=<?php echo $value['id'];?> ><?php echo $value['name'];?></option>
                    <?php }?>
                    </select>
                  </div>
              </div>

              <div class="centers_con">
                  <div class="centers_con_left"> <font color="black">二级审核人：</font></div>
                   <div class="centers_con_right" style="padding-top: 22px;">
                    
                    <select name="two_person"  class="selectpicker">
                     <option value="0">--请选择--</option>
                      <?php foreach($userInfo as $key=>$value){?>
                      <option value=<?php echo $value['id'];?> ><?php echo $value['name'];?></option>
                    <?php }?>
                    </select>
                  </div>
              </div>

              <div class="centers_con" style="border:none;padding-left:160px;">
                  <br/>
                   <input type="button" class="btn btn-warning" ids="reset" value="重置"> &nbsp&nbsp&nbsp&nbsp
                   <input type="button" class="btn btn-success" ids="sub" value="提交">
              </div>


           
          </div>
      </div>
    

</form>

</body>
</html>
<script language="javascript" type="text/javascript" src="/template/default/js/jquery-1.10.2.min.js"></script>




<script src="http://cdn.bootcss.com/jquery/1.11.0/jquery.min.js" type="text/javascript"></script>
  <script>window.jQuery || document.write('<script src="/template/default/js/jquery-1.10.2.min.js"><\/script>')</script>
  <script src="/template/default/js/file-explore.js"></script> 

   
  
  <script type="text/javascript">
    //提交表单
    $('input[ids=reset]').click(function(){
        $("form")[0].reset();
        $("#addContent").children().remove();
    });


    //树状图
     $(document).ready(function() {
          $(".file-tree").filetree();
      });
    
    $(".choice").click(function(){

      var id = $(this).siblings('a').attr('ids');
      var cont = $(this).siblings('a').html();

      $html ='<span class="addslm" _id="'+id+'">'+cont+'</span><input type="hidden" value="'+id+'" name="departmentId[]">';

      var  data = $("span[_id="+id+"]");

      //判断是否有这个数据
      if(data.length > 0)
      {
           $("span[_id="+id+"]").remove();
      }
      else
      {
          $("#addContent").append($html);
      }

    });

    //判断提交是否为空
    $("input[ids=sub]").click(function(){

        var num = $("#addContent").children("span").length;
        var nums = $("select[name=user_id]").val();


        if(num > 0  || nums != 0)
        {
              //检查是否选择了审核人
              var data_num_one = $('select[name=one_person]').val();
              var data_num_two = $('select[name=two_person]').val();

              if(data_num_one == '0' || data_num_two == '0')
              {
                 alert('必须要选择一级审核人员和二级审核人员'); return false;
              } 

              $("form").submit();
            
        }
        else
        {
          alert('您必须选择被审核部门或是员工');return false;
        }

        
    
    });


  </script>