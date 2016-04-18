<?php

$con=mysql_connect("localhost","root","mysql") or die (" Không thể kết nối tới cơ sở dữ liệu");
mysql_select_db("qlsv",$con) or die  (" Không thể kết nối tới cơ sở dữ liệu");

if(isset($_POST['them']))
{
	 if($_POST['makhoa'] == NULL)
	 {
		 echo ' Không được để trống thông tin ';
	 }
	 else
	 {
	 $makhoa=$_POST['makhoa'];
	 }
	  if($_POST['tenkhoa'] == NULL)
	 {
		 echo ' Không được để trống thông tin ';
	 }
	 else
	 {
	 $tenkhoa=$_POST['tenkhoa'];
	 }
	   if( $makhoa &&  $tenkhoa ){
			$sql="INSERT INTO khoa (makhoa, tenkhoa,p_check,p_del)VALUES
('$_POST[makhoa]','$_POST[tenkhoa]','0','0')";

if (!mysql_query($sql,$con))
  {
 die('Error: ' . mysql_error());
  }
echo "Thêm thông tin thành công";

mysql_close($con);		
	 }
}
// Back
if(isset($_POST['back'])){
header("location: khoa.php");
}

?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Thêm khoa</title>
</head>
<body>
<h3> BẢNG TẠO KHOA MỚI</h3>
<form method="post" action="them_khoa.php">

Mã khoa   <input type="text" name="makhoa" size="25">
<br />
Tên khoa <input type="text" name="tenkhoa"size="25" />
<br />
<input type="submit" name="them" value="Đồng ý thêm mới" />
<input type="submit" name="back" value="Quản lý khoa" />
</form>
</body>
</html>



