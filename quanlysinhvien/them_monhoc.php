<?php
require_once __DIR__ . '/db_connect.php';
$con = new Database();

if (isset($_POST['them'])) {
    if ($_POST['mamonhoc'] == NULL) {
        echo ' Không được để trống thông tin ';
    } else {
        $mamonhoc = $_POST['mamonhoc'];
    }
    if ($_POST['tenmonhoc'] == NULL) {
        echo ' Không được để trống thông tin ';
    } else {
        $tenmonhoc = $_POST['tenmonhoc'];
    }
    if ($_POST['sotiet'] == NULL) {
        echo ' Không được để trống thông tin ';
    } else {
        $sotiet = $_POST['sotiet'];
    }
    $sql = "INSERT INTO monhoc (tensv,p_mnh, tenmonhoc,sotiet,p_check,p_del)VALUES
('$_POST[tensv]','$_POST[mamonhoc]','$_POST[tenmonhoc]','$_POST[sotiet]','0','0')";

    if (!mysql_query($sql, $con)) {
        echo " Phát sinh lỗi! Vui lòng kiểm tra lại Code ";
    }
    echo "Thêm thông tin thành công";

    mysql_close($con);
}
// Back
if (isset($_POST['back'])) {
    header("location: monhoc.php");
}
?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Thêm môn học</title>
        <link href="css/styles.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <h3 class="class_h3"> BẢNG TẠO MÔN HỌC MỚI</h3>
        <form method="post" action="them_monhoc.php">
            <div id="add_student">
                <div class="field">
                    <span class="tesxtspan">Tên sinh viên</span>   
                    <select name="tensv" style="margin-left: 10px;padding-left: 90px">
                        <?php
                        $name = mysql_query("select * from sinhvien");

                        while ($rown = mysql_fetch_array($name)) {
                            ?>
                            <option value="<?php echo $rown['tensv']; ?>"><?php echo $rown['tensv']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="field">
                    <span class="tesxtspan"> Mã môn học</span>   
                    <input type="text" name="mamonhoc" size="25" style="margin-left: 16px"/>
                </div>
                <div class="field">
                    <span class="tesxtspan">Tên môn học</span>   
                    <input type="text" name="tenmonhoc"size="25" style="margin-left: 12px" />
                </div>
                <div class="field">
                    <span class="tesxtspan">Số tiết học</span>   
                    <input type="text" name="sotiet"size="25" style="margin-left: 28px" />
                </div>
                <div class="button">
                    <input type="submit" name="them" value="Đồng ý thêm mới" />
                    <input type="submit" name="back" value="Quản lý môn học" />
                </div>
            </div>

        </form>
    </body>
</html>



