<?php

$con=mysql_connect("localhost","root","mysql") or die (" Không thể kết nối tới cơ sở dữ liệu");
mysql_select_db("qlsv",$con) or die  (" Không thể kết nối tới cơ sở dữ liệu");

if(isset($_POST['them']))
{
	 if($_POST['masinhvien'] == NULL)
	 {
		 echo ' Không được để trống thông tin ';
	 }
	 else
	 {
	 $masinhvien=$_POST['masinhvien'];
	 }
	  if($_POST['tensinhvien'] == NULL)
	 {
		 echo ' Không được để trống thông tin ';
	 }
	 else
	 {
	 $tensinhvien=$_POST['tensinhvien'];
	 }
	   if($_POST['ngaysinh'] == NULL)
	 {
		 echo ' Không được để trống thông tin ';
	 }
	 else
	 {
	 $ngaysinh=$_POST['ngaysinh'];
	 }
	 if($_POST['gioitinh'] == NULL)
	 {
		 echo ' Không được để trống thông tin ';
	 }
	 else
	 {
	 $gioitinh=$_POST['gioitinh'];
	 }
	  if($_POST['quequan'] == NULL)
	 {
		 echo ' Không được để trống thông tin ';
	 }
	 else
	 {
	 $quequan=$_POST['quequan'];
	 }
	 	if($quequan && $gioitinh && $ngaysinh && $tensinhvien && $masinhvien ){
			$sql="INSERT INTO sinhvien (masv, tensv,ngaysinh,gioitinh,quequan,lop,khoa,p_check,p_del)VALUES
('$_POST[masinhvien]','$_POST[tensinhvien]','$_POST[ngaysinh]','$_POST[gioitinh]','$_POST[quequan]','$_POST[lop]','$_POST[khoa]','0','0')";

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
header("location: sinhvien.php");
}
// Lop




?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Thêm sinh viên</title>
</head>
<body>
<h3> BẢNG TẠO SINH VIÊN</h3>

<form method="post" action="them_sinhvien.php">

Mã sinh viên   <input type="text" name="masinhvien" size="25">
<br />
Tên sinh viên <input type="text" name="tensinhvien"size="25" />
<br />
Ngày sinh <input type="text" name="ngaysinh"size="25" />
<br />
Giới tính   <input type="text" name="gioitinh" size="25">
<br />
Quê quán <input type="text" name="quequan"size="25" />
<br />
Lớp 
    <select name="lop">
<?php 
$name=mysql_query("select * from lop");

while($rown = mysql_fetch_array($name)){?>
   		 <option value="<?php echo $rown['tenlop']; ?>"><?php echo $rown['tenlop']; ?></option>
<?php } ?>
    </select>

<br />
Khoa 
    <select name="khoa">
<?php 
$name=mysql_query("select * from khoa");

while($rown = mysql_fetch_array($name)){?>
   		 <option value="<?php echo $rown['tenkhoa']; ?>"><?php echo $rown['tenkhoa']; ?></option>
<?php } ?>
    </select>
    <br/>
    
<input type="submit" name="them" value="Đồng ý thêm mới" />
<input type="submit" name="back" value="Quản lý sinh viên" />

</form>
</body>
</html>



