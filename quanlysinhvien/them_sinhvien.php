<?php
require_once __DIR__ . '/db_connect.php';
$con = new Database();

if (isset($_POST['them'])) {
    if ($_POST['masinhvien'] == NULL) {
        echo ' Không được để trống thông tin ';
    } else {
        $masinhvien = $_POST['masinhvien'];
    }
    if ($_POST['tensinhvien'] == NULL) {
        echo ' Không được để trống thông tin ';
    } else {
        $tensinhvien = $_POST['tensinhvien'];
    }
    if ($_POST['ngaysinh'] == NULL) {
        echo ' Không được để trống thông tin ';
    } else {
        $ngaysinh = $_POST['ngaysinh'];
    }
    if ($_POST['gioitinh'] == NULL) {
        echo ' Không được để trống thông tin ';
    } else {
        $gioitinh = $_POST['gioitinh'];
    }
    if ($_POST['quequan'] == NULL) {
        echo ' Không được để trống thông tin ';
    } else {
        $quequan = $_POST['quequan'];
    }
    if ($quequan && $gioitinh && $ngaysinh && $tensinhvien && $masinhvien) {
        $sql = "INSERT INTO sinhvien (masv, tensv,ngaysinh,gioitinh,quequan,lop,khoa,p_check,p_del)VALUES
('$_POST[masinhvien]','$_POST[tensinhvien]','$_POST[ngaysinh]','$_POST[gioitinh]','$_POST[quequan]','$_POST[lop]','$_POST[khoa]','0','0')";

        if (!$con->exec_query($sql)) {
            die('Error: ' . mysql_error());
        }
        echo "Thêm thông tin thành công";
    }
}
// Back
if (isset($_POST['back'])) {
    header("location: sinhvien.php");
}
// Lop
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Thêm sinh viên</title>
        <link rel="stylesheet" type="text/css" href="css/datepicker.css" /> 
        <link href="css/styles.css" rel="stylesheet" type="text/css">
            <script type="text/javascript" src="js/datepicker.js"></script> 
    </head>
    <body>
        <h3 class="class_h3">BẢNG TẠO SINH VIÊN</h3>
        <form method="post" action="them_sinhvien.php">
            <div id="add_student">
                <div class="field">
                    <span class="tesxtspan">Mã sinh viên</span>   
                    <input type="text" name="masinhvien" size="25" style="margin-left: 10px">
                </div>
                <div class="field" >
                    <span class="tesxtspan">Tên sinh viên</span>   
                    <input type="text" name="tensinhvien"size="25" style="margin-left: 6px;" />
                </div>
                <div class="field" >
                    <span class="tesxtspan">Ngày sinh</span>   
                    <input type="text" name="ngaysinh"size="25" id="start_dt" class='datepicker' style="margin-left: 28px;"/>
                </div>
                <div class="field" >
                    <span class="tesxtspan">Giới tính</span>   
                    <input type="text" name="gioitinh" size="25" style="margin-left: 35px;"/>
                </div>
                <div class="field" >
                    <span class="tesxtspan"> Quê quán</span>   
                    <input type="text" name="quequan"size="25" style="margin-left: 31px;" />
                </div>
                <div class="field" >
                    <span class="tesxtspan">Lớp</span>   
                    <select name="lop" style=" margin-left: 65px;text-align: left">
                        <?php
                        $name = mysql_query("select * from lop");

                        while ($rown = mysql_fetch_array($name)) {
                            ?>
                            <option value="<?php echo $rown['tenlop']; ?>"><?php echo $rown['tenlop']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="field" >
                    <span class="tesxtspan"> Khoa </span>   
                    <select name="khoa" style="margin-left: 57px; padding-left: 97px;text-align:left">
                        <?php
                        $name = mysql_query("select * from khoa");

                        while ($rown = mysql_fetch_array($name)) {
                            ?>
                            <option value="<?php echo $rown['tenkhoa']; ?>"><?php echo $rown['tenkhoa']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="button">
                    <input type="submit" name="them" value="Đồng ý thêm mới" />
                    <input type="submit" name="back" value="Quản lý sinh viên" />
                </div>
            </div>
        </form>
    </body>
</html>



