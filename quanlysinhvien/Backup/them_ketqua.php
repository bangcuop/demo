<?php

$con=mysql_connect("localhost","root","mysql") or die (" Không thể kết nối tới cơ sở dữ liệu");
mysql_select_db("qlsv",$con) or die  (" Không thể kết nối tới cơ sở dữ liệu");

if(isset($_POST['them']))
{
	
	 {
	 $lanthi=$_POST['lanthi'];
	 }
	 if($_POST['diem'] == NULL)
	 {
		 echo ' Không được để trống thông tin ';
	 }
	 else
	 {
	 $diem=$_POST['diem'];
	 }
	 
			$sql="INSERT INTO ketqua (tensv, mnh,tenmonhoc,lanthi,diem,p_check,p_del)VALUES
('$_POST[tensv]','$_POST[p_mnh]','$_POST[tenmonhoc]','$_POST[lanthi]','$_POST[diem]','0','0')";

if (!mysql_query($sql,$con))
  {
 die('Error: ' . mysql_error());
  }
echo "Thêm thông tin thành công";

mysql_close($con);		
	 }
// Back
if(isset($_POST['back'])){
header("location: ketqua.php");
}

?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Thêm kết quả</title>

</head>
<body>
<h3> BẢNG TẠO KẾT QUẢ MỚI</h3>

<form method="post" action="them_ketqua.php">

Tên sinh viên
    <select name="tensv">
<?php 
$name=mysql_query("select * from sinhvien");

while($rown = mysql_fetch_array($name)){?>
   		 <option value="<?php echo $rown['tensv']; ?>"><?php echo $rown['tensv']; ?></option>
<?php } ?>
    </select>

<br />
Mã môn học
    <select name="p_mnh">
<?php 
$name=mysql_query("select * from monhoc");

while($rown = mysql_fetch_array($name)){?>
   		 <option value="<?php echo $rown['p_mnh']; ?>"><?php echo $rown['p_mnh']; ?></option>
<?php } ?>
    </select>


<br />
Tên môn học
    <select name="tenmonhoc">
<?php 
$name=mysql_query("select * from monhoc");

while($rown = mysql_fetch_array($name)){?>
   		 <option value="<?php echo $rown['tenmonhoc']; ?>"><?php echo $rown['tenmonhoc']; ?></option>
<?php } ?>
    </select>


<br />
Lần thi <input type="text" name="lanthi"size="25" />
<br />
Điểm   <input type="text" name="diem" size="25">
<br />

<input type="submit" name="them" value="Đồng ý thêm mới" />
<input type="submit" name="back" value="Quản lý kết quả" />

</form>

</body>
</html>



