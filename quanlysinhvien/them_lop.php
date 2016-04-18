<?php
require_once __DIR__ . '/db_connect.php';
$con = new Database();

if (isset($_POST['them'])) {
    if ($_POST['malop'] == NULL) {
        echo ' Không được để trống thông tin ';
    } else {
        $malop = $_POST['malop'];
    }
    if ($_POST['tenlop'] == NULL) {
        echo ' Không được để trống thông tin ';
    } else {
        $tenlop = $_POST['tenlop'];
    }
    if ($tenlop && $malop) {

        $sql = "INSERT INTO lop (malop, tenlop,khoa,p_check,p_del)VALUES
('$_POST[malop]','$_POST[tenlop]','$_POST[khoa]','0','0')";

        if (!mysql_query($sql, $con)) {
            die('Error: ' . mysql_error());
        }
        echo "Thêm thông tin thành công";

        mysql_close($con);
    }
}
// Back
if (isset($_POST['back'])) {
    header("location: lop.php");
}
?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Thêm lớp</title>
        <link href="css/styles.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <h3 class="class_h3"> BẢNG TẠO LỚP MỚI</h3>
        <form method="post" action="them_lop.php">
            <div id="add_student">
                <div class="field">
                    <span class="tesxtspan">Mã lớp</span>   
                    <input type="text" name="malop" size="25" style="margin-left: 31px;"/>
                </div>
                <div class="field">
                    <span class="tesxtspan">Tên lớp</span>   
                    <input type="text" name="tenlop"size="25"   style="margin-left: 27px;"/>
                </div>
                <div class="field">
                    <span class="tesxtspan">Tên khoa</span>   
                    <select name="khoa" style="margin-left: 17px;padding-left: 98px;">
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
                    <input type="submit" name="back" value="Quản lý lớp" />
                </div>
            </div>

        </form>
    </body>
</html>



