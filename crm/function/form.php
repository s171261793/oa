<?php
!defined('IN_TOA') && exit('Access Denied!');
function form_add($name,$mod){
	if($name!=''){
		echo '<table class="TableBlock" border="0" width="90%" align="center">	';
		echo '<tr>';
		echo '<td nowrap class="TableHeader" colspan="4">'.$name.'</td>';
		echo '</tr>';
	}else{
		echo '<table class="TableBlock" border="0" width="90%" style="border-top:0px;" align="center">	';
	}
	echo '<tr>';
	global $db;
	$num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."crm_form where type1='".$mod."' and inputtype!='2' ORDER BY inputnumber Asc");
	$query = $db->query("SELECT * FROM ".DB_TABLEPRE."crm_form where type1='".$mod."' and inputtype!='2' ORDER BY inputnumber Asc");
		$n=0;
		while ($row = $db->fetch_array($query)) {
		$n++;
        echo '<td nowrap class="TableContent" width="15%">'.$row["formname"].'：';
		if($row["confirmation"]=='1'){
			get_helps();
		}
        echo '</td><td class="TableData">';
		$name=$row["inputname"];
		$value=$row["inputvalue"];
		$w=$row["w"];
		$h=$row["h"];
		if($row["type"]=='0'){
			if($row["inputtype"]=='1'){
				echo crm_input($name,$value,$w,$h);
			}elseif($row["inputtype"]=='2'){
				crm_textarea($name,$value,$w,$h);
			}elseif($row["inputtype"]=='3'){
				echo crm_radio($name,$row["inputvaluenum"],$value); 
			}elseif($row["inputtype"]=='4'){
				echo crm_checkbox($name,$row["inputvaluenum"],$value);
			}elseif($row["inputtype"]=='5'){
				echo crm_select($name,$row["inputvaluenum"],$value,$w,$h);	
			}
		}elseif($row["type"]=='1'){
			public_upload($name,'',$w,$h,'图片上传');
		}elseif($row["type"]=='2'){
			public_upload($name,$value,$w,$h);
		}elseif($row["type"]=='3'){
			echo crm_date($name,$w,$h);
		}elseif($row["type"]=='4'){
			if($w=='' || $w=='0') $w='40';
			if($h=='' || $h=='0') $h='4';
			get_depabox(2,$name,"","+选择部门",$w,$h);
		}elseif($row["type"]=='5'){
			if($w=='' || $w=='0') $w='40';
			if($h=='' || $h=='0') $h='4';
			get_pubuser(2,$name,"","+选择人员",$w,$h);
		}
		echo'</td>';
		if($n%2==0){
			echo '</tr><tr>';
		}
		if($num==$n && $num%2!=0){
			echo '<td nowrap class="TableContent" width="15%"> </td>
		  <td class="TableData"></td>';
		}
	}	
	echo '</tr>';
	echo '</table>';
}
function form_add_eweb($mod){
	echo '<table  width="90%" style="border-left:#4686c6 solid 1px;border-right:#ccc solid 1px;border-bottom:#ccc solid 1px;margin-bottom:20px;" align="center">';	
	global $db;
	$query = $db->query("SELECT * FROM ".DB_TABLEPRE."crm_form where type1='".$mod."' and inputtype='2' ORDER BY inputnumber Asc");
		while ($row = $db->fetch_array($query)) {
			echo '<tr>';
			echo '	  <td nowrap style="border-right:#cccccc solid 1px;padding-left:3px;border-bottom:#ccc solid 1px;background:#f2f8ff;" width="15%"> '.$row["formname"].'：';
			if($row["confirmation"]=='1'){
				get_helps();
			}
			echo '</td>';
			echo '	  <td style="padding-top:10px; padding-bottom:10px; padding-left:3px;background:#fff;border-bottom:#ccc solid 1px;">';
			$name=$row["inputname"];
			$value=$row["inputvalue"];
			$w=$row["w"];
			$h=$row["h"];
			if($row["type"]=='0'){
				echo crm_textarea($name,$value,$w,$h);
			}
			echo '</td></tr>';
	}	
	echo '</table>';
}
function form_edit($name,$mod,$viewid){
	if($name!=''){
		echo '<table class="TableBlock" border="0" width="90%" align="center">	';
		echo '<tr>';
		echo '<td nowrap class="TableHeader" colspan="4">'.$name.'</td>';
		echo '</tr>';
	}else{
		echo '<table class="TableBlock" border="0" width="90%" style="border-top:0px;" align="center">	';
	}
	echo '<tr>';
	global $db;
	$num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."crm_form where type1='".$mod."' and inputtype!='2' ORDER BY inputnumber Asc");
	$query = $db->query("SELECT * FROM ".DB_TABLEPRE."crm_form where type1='".$mod."' and inputtype!='2' ORDER BY inputnumber Asc");
		$n=0;
		while ($row = $db->fetch_array($query)) {
		$n++;
        echo '<td nowrap class="TableContent" width="15%">'.$row["formname"].'：';
		if($row["confirmation"]=='1'){
			get_helps();
		}
        echo '</td><td class="TableData">';
		$name=$row["inputname"];
		$value=crm_db($viewid,$row['inputname'],$mod);
		$w=$row["w"];
		$h=$row["h"];
		if($row["type"]=='0'){
			if($row["inputtype"]=='1'){
				echo crm_input($name,$value,$w,$h);
			}elseif($row["inputtype"]=='2'){
				crm_textarea($name,$value,$w,$h);
			}elseif($row["inputtype"]=='3'){
				echo crm_radio($name,$row["inputvaluenum"],$value); 
			}elseif($row["inputtype"]=='4'){
				echo crm_checkbox($name,$row["inputvaluenum"],$value);
			}elseif($row["inputtype"]=='5'){
				echo crm_select($name,$row["inputvaluenum"],$value,$w,$h);	
			}
		}elseif($row["type"]=='1'){
			public_upload($name,$value,$w,$h,'图片上传');
		}elseif($row["type"]=='2'){
			public_upload($name,$value,$w,$h);
		}elseif($row["type"]=='3'){
			echo crm_date($name,$w,$h,$value);
		}elseif($row["type"]=='4'){
			if($w=='' || $w=='0') $w='40';
			if($h=='' || $h=='0') $h='4';
			get_depabox(2,$name,$value,"+选择部门",$w,$h);
		}elseif($row["type"]=='5'){
			if($w=='' || $w=='0') $w='40';
			if($h=='' || $h=='0') $h='4';
			get_pubuser(2,$name,$value,"+选择人员",$w,$h);
		}
		echo'</td>';
		if($n%2==0){
			echo '</tr><tr>';
		}
		if($num==$n && $num%2!=0){
			echo '<td nowrap class="TableContent" width="15%"> </td>
		  <td class="TableData"></td>';
		}
	}	
	echo '</tr>';
	echo '</table>';
}
function form_edit_eweb($mod,$viewid){
	echo '<table  width="90%" style="border-left:#4686c6 solid 1px;border-right:#ccc solid 1px;border-bottom:#ccc solid 1px;margin-bottom:20px;" align="center">';	
	global $db;
	$query = $db->query("SELECT * FROM ".DB_TABLEPRE."crm_form where type1='".$mod."' and inputtype='2' ORDER BY inputnumber Asc");
		while ($row = $db->fetch_array($query)) {
			echo '<tr>';
			echo '	  <td nowrap style="border-right:#cccccc solid 1px;padding-left:3px;border-bottom:#ccc solid 1px;background:#f2f8ff;" width="15%"> '.$row["formname"].'：';
			if($row["confirmation"]=='1'){
				get_helps();
			}
			echo '</td>';
			echo '	  <td style="padding-top:10px; padding-bottom:10px; padding-left:3px;background:#fff;border-bottom:#ccc solid 1px;">';
			$name=$row["inputname"];
			$value=crm_db($viewid,$row['inputname'],$mod);
			$w=$row["w"];
			$h=$row["h"];
			if($row["type"]=='0'){
				echo crm_textarea($name,$value,$w,$h);
			}
			echo '</td></tr>';
	}	
	echo '</table>';
}
function form_view($name,$mod,$viewid){
	if($name!=''){
		echo '<table class="TableBlock" border="0" width="95%" align="center">	';
		echo '<tr>';
		echo '<td nowrap class="TableHeader" colspan="4">'.$name.'</td>';
		echo '</tr>';
	}else{
		echo '<table class="TableBlock" border="0" width="95%" style="border-top:0px;" align="center">	';
	}
	echo '<tr>';
	global $db;
	$num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."crm_form where type1='".$mod."' and inputtype!='2' ORDER BY inputnumber Asc");
	$query = $db->query("SELECT * FROM ".DB_TABLEPRE."crm_form where type1='".$mod."' and inputtype!='2' ORDER BY inputnumber Asc");
		$n=0;
		while ($row = $db->fetch_array($query)) {
		$n++;
        echo '<td nowrap class="TableContent" width="15%">'.$row["formname"].'：';
        echo '</td><td class="TableData" width="35%">';
		$name=$row["inputname"];
		$value=crm_db($viewid,$name,$mod);
		if($row["type"]=='1'){
			if($value!=''){
				echo $value.'<br><a href="'.$value.'" target="_blank">浏览图片</a> | <a href="down.php?urls='.$value.'">下载图片</a>';
			}
		}elseif($row["type"]=='2'){
			if($value!=''){
				echo '<a href="down.php?urls='.$value.'">下载附件</a>';
			}
		}else{
			echo $value;
		}
		echo'</td>';
		if($n%2==0){
			echo '</tr><tr>';
		}
		if($num==$n && $num%2!=0){
			echo '<td nowrap class="TableContent" width="15%"> </td>
		  <td class="TableData" width="35%"></td>';
		}
	}	
	echo '</tr>';
	echo '</table>';
}
function form_view_eweb($mod,$viewid){
	echo '<table  width="95%" style="border-left:#4686c6 solid 1px;border-right:#ccc solid 1px;border-bottom:#ccc solid 1px;margin-bottom:20px;height:50px;" align="center">';	
	global $db;
	$query = $db->query("SELECT * FROM ".DB_TABLEPRE."crm_form where type1='".$mod."' and inputtype='2' ORDER BY inputnumber Asc");
		while ($row = $db->fetch_array($query)) {
			echo '<tr>';
			echo '	  <td nowrap style="border-right:#cccccc solid 1px;padding-left:3px;background:#f2f8ff;border-bottom:#ccc solid 1px;" width="15%"> '.$row["formname"].'：';
			echo '</td>';
			echo '	  <td style="padding-top:10px; padding-bottom:10px; padding-left:3px;background:#fff;border-bottom:#ccc solid 1px;">';
			$name=$row["inputname"];
			$value=crm_db($viewid,$row['inputname'],$mod);
			echo $value;
			echo '</td></tr>';
	}	
	echo '</table>';
}
function form_list($mod){
	global $db;
	$query = $db->query("SELECT * FROM ".DB_TABLEPRE."crm_form where type1='".$mod."' and type2='1' ORDER BY inputnumber Asc");
	while ($row = $db->fetch_array($query)) {
		echo '<td width="100" align="center" class="TableHeader">'.$row['formname'].'</td>';	
	}
}
function form_list_view($mod,$viewid){
	global $db;
	$query = $db->query("SELECT * FROM ".DB_TABLEPRE."crm_form where type1='".$mod."' and type2='1' ORDER BY inputnumber Asc");
	while ($row = $db->fetch_array($query)) {
		echo '<td align="center" class="TableData">'.crm_db($viewid,$row['inputname'],$mod).'</td>';	
	}
}
?>