<?php


$con = mysql_connect("localhost","root","123456") or die (" Không tìm thấy cơ sở dữ liệu " );
mysql_select_db("qlsv",$con) or die  (" Không tìm thấy cơ sở dữ liệu " );

// Lua chon CSDL

// Cbeck submit Update
if(isset($_POST['update'])){
	if(isset($_POST['check'])){
		$arr_check=$_POST['check'];
		$num_arr=count($arr_check);
		if($num_arr>0){
			for($j=1;$j<=$num_arr;$j++){
				$sql_u=mysql_query('UPDATE khoa SET p_check=1 WHERE p_id='.$arr_check[$j-1]);
				if($sql_u){
					echo ' Bạn đã cập nhật thông tin thành công ';
				}
				else{
					echo ' Cập nhật thông tin không thành công ';
				}
			}
		}
	}
}
//Check submit Delete
if(isset($_POST['delete'])){
	if(isset($_POST['check'])){
		$arr_check=$_POST['check'];
		$num_arr=count($arr_check);
		if($num_arr>0){
			for($j=1;$j<=$num_arr;$j++){
				$sql_u=mysql_query('UPDATE khoa SET p_del=1 WHERE p_id='.$arr_check[$j-1]);
				if($sql_u){
					echo ' Bạn đã xóa thông tin thành công ';
				}
				else{
					echo ' Xóa thông tin không thành công ';
				}
			}
		}
	}
}
//Check sumit Undel
if(isset($_POST['undel'])){
	
				$sql_u=mysql_query('UPDATE khoa SET p_del=0,p_check=0');
				if($sql_u){
					echo ' Phục hồi dữ liệu thành công ';
				}
				else{
					echo ' Phục hồi dữ liệu thành công';
				}
			}
// Check Them

if(isset($_POST['new'])){
header("location: them_khoa.php");
}
//Index
if(isset($_POST['index'])){
header("location: index.php");
}

$sql=mysql_query("select * from khoa");
?>








<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Quản lý khoa</title>
<link href="css/styless.css" rel="stylesheet" type="text/css">
</head>
<body>

<h3> QUẢN LÝ - HIỂN THỊ KHOA</h3>
<div id='cssmenu'>
<ul>
   <li class='active '><a href='index.php'><span>Trang chủ</span></a></li>
   <li><a href='sinhvien.php'><span>Quản lý sinh viên</span></a></li>
   <li><a href='lop.php'><span>Quản lý lớp</span></a></li>
   <li><a href='khoa.php'><span>Quản lý khoa</span></a></li>
   <li><a href='monhoc.php'><span>Quản lý môn học</span></a></li>
   <li><a href='ketqua.php'><span>Quản lý kết quả</span></a></li>
</ul>
</div>
<form method="post" action="khoa.php">
	<table border="1" cellpadding="0" cellspacing="0" width="800">
    	<tr>
        	<td>Mã khoa</td>
            <td>Tên khoa</td>
            <td>Chọn</td>
           
     	</tr>
        <?php
        if($sql){
	if(mysql_num_rows($sql)>0){
		while($row=mysql_fetch_assoc($sql))
		{
			if($row['p_del']==0){
			echo '<tr>';
			echo '<td>'.$row['makhoa'].'</td>';
			echo '<td>'.$row['tenkhoa'].'</td>';
			echo '<td><input type="checkbox" name="check[]" value="'.$row['p_id'].'"></td>';
			//echo '<td>'.$row['p_check'].'</td>';
			echo '</tr>';
			}
		}
	}
}
?>
	<tr>
    	<td colspan="8">
        <div id="tt">
        	<input type="submit" name="update" value="Lưu thông tin dữ liệu" />
            <input type="submit" name="delete" value="Xóa dữ liệu" />
            <input type="submit" name="undel" value="Phục hồi dữ liệu" />
            <input type="submit" name="new" value="Thêm dữ liệu mới" />
             <input type="submit" name="index" value="Trở lại trang chủ" />
          
    </tr>
    	</div>
	</table>
</form>

</body>
</html>