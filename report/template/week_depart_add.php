<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
  <title>周报部门信息添加编辑</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <!-- <link rel="stylesheet" type="text/css" href="template/default/content/css/style.css"> -->
  <link rel="stylesheet" type="text/css" href="template/default/content/css/bootstrap.min.css" media="screen">
  <!-- <script type="text/javascript" src="template/default/js/bootstrap.min.js"></script> -->
  <style type="text/css">
      .center{
        text-align:center !important;
        vertical-align:middle !important;
      }     
      .bgcircle{
        width:40px;
        height:40px;
        border-radius:20px; 
        border:1px solid blue; 
        padding:5px 10px ;
        color:blue;
      } 
      .bgcircle:hover{
        background: blue;
        color:white;
        cursor: pointer;
      }
  </style>
</head>
<body class="bodycolor" <?php if($user['keytype']=='1'){?>onLoad="toggle2('div1');"<?php }?>>
  <br>
  <br>
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3">添加部门</span>&nbsp;&nbsp;&nbsp;&nbsp;
	<span style="font-size:12px; float:right;margin-right:20px;">
	
	<a href="admin.php?ac=weeklyDpart&fileurl=report" style="font-size:12px;"><<返回列表页</a></span>
    </td>
  </tr>
</table>
<br>
<br>
<style type="text/css"> 
#div1{display:none;}
#div2{display:block;}
</style>  
<form name="save" method="post" action="">

     <table class="table table-condensed" border="0" width="90%" align="center" id="submit_person">

          <tr>
              <td class="center">所属部门：</td>
              <td> 
                  <?php
                  get_depabox(2,'department',get_realdepaname($user['departmentid']),'选择部门',$width=30,$height=3);
                  ?>
              </td>
          </tr>
          
          <tr>
            <td  class="center">人员：</td>
            <td>
              <select name="user_id[]" class="copy">
                  <?php 

                      if(count($info) > 0)
                      {
                          $html = '<option value="0">请选择</option>';
     
                          foreach($info as $key=>$value)
                          {
                              $html .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
                          }

                          echo $html;
                      }
                      else
                      {
                        echo $html = '<option value="0">暂无人员</option>';
                      }

                  ?>

              </select> 
              <span class="bgcircle">+添加</span>
            </td>  

          </tr>
      
        <tr align="center" class="TableControl">
        	<td class="center" colspan="6">
            <br>
            <br>
            <br>
        	   <input class="btn btn-primary" type="button" value="提交" class="BigButtonBHover" onClick="sendForm();">&nbsp;
    	    </td>
      </tr>
     </table>
  
</form>

 
</body>
</html>
<script language="javascript" type="text/javascript" src="template/default/js/jquery-1.10.2.min.js"></script>

<script type="text/javascript">
  
    function CheckForm()
    {
         if(document.save.department.value=="")
         { alert("部门不能为空！");
           document.save.department.focus();
           return false;
         }

         var status = 0;
        $("select[name^=user_id]").each(function(){
          if($(this).val() == 0){ status++; }
        });
        if(status){ alert("人员不能为空！");return false;}
         return true;
        
  }

function sendForm()
{
   if(CheckForm()){
      document.save.submit();
   }
}


    $(document).on('click',".bgcircle",function(){
        
        if( $(this).text() == '+添加')
        {
          var selct = $(this).parent().parent().clone(true);
          $("#submit_person").find('tr').find('span').text('-删除');
          $("#submit_person").find('tr').eq( $("tr").find('tr').length -2  ).after(selct);

        }
        else
        {
            $(this).parent().parent().remove();
        }
    })

    
</script>
