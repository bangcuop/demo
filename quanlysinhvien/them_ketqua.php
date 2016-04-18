<?php
require_once __DIR__ . '/db_connect.php';
$con = new Database();

if (isset($_POST['them'])) { {
        $lanthi = $_POST['lanthi'];
    }
    if ($_POST['diem'] == NULL) {
        echo ' Không được để trống thông tin ';
    } else {
        $diem = $_POST['diem'];
    }

    $sql = "INSERT INTO ketqua (tensv, mnh,tenmonhoc,lanthi,diem,p_check,p_del)VALUES
('$_POST[tensv]','$_POST[p_mnh]','$_POST[tenmonhoc]','$_POST[lanthi]','$_POST[diem]','0','0')";

    if (!mysql_query($sql, $con)) {
        die('Error: ' . mysql_error());
    }
    echo "Thêm thông tin thành công";

    mysql_close($con);
}
// Back
if (isset($_POST['back'])) {
    header("location: ketqua.php");
}
?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Thêm kết quả</title>
        <link href="css/styles.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <h3 class="class_h3"> BẢNG TẠO KẾT QUẢ MỚI</h3>
        <form method="post" action="them_ketqua.php">
            <div id="add_student">
                <div class="field">
                    <span class="tesxtspan">Tên sinh viên</span>   
                    <select name="tensv" style="margin-left: 16px;padding-left: 90px;">
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
                    <select name="p_mnh" style="margin-left: 22px;padding-left: 176px;">
                        <?php
                        $name = mysql_query("select * from monhoc");

                        while ($rown = mysql_fetch_array($name)) {
                            ?>
                            <option value="<?php echo $rown['p_mnh']; ?>"><?php echo $rown['p_mnh']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="field">
                    <span class="tesxtspan">Tên môn học</span>   
                    <select name="tenmonhoc" style="margin-left: 19px;padding-left: 84px;">
                        <?php
                        $name = mysql_query("select * from monhoc");

                        while ($rown = mysql_fetch_array($name)) {
                            ?>
                            <option value="<?php echo $rown['tenmonhoc']; ?>"><?php echo $rown['tenmonhoc']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="field">
                    <span class="tesxtspan">Lần thi</span>   
                    <input type="text" name="lanthi" size="25" style="margin-left: 58px"/>
                </div>
                <div class="field">
                    <span class="tesxtspan"> Mã môn học</span>   
                    <input type="text" name="diem" size="25" style="margin-left: 24px"/>
                </div>
                <div class="button">
                    <input type="submit" name="them" value="Đồng ý thêm mới" />
                    <input type="submit" name="back" value="Quản lý kết quả" />
                </div>
            </div>

        </form>

    </body>
</html>



