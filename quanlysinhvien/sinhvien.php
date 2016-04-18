
<?php
require_once __DIR__ . '/db_connect.php';
$con = new Database();
// Lua chon CSDL
// Cbeck submit Update
if (isset($_POST['update'])) {
    if (isset($_POST['check'])) {
        $arr_check = $_POST['check'];
        $num_arr = count($arr_check);
        if ($num_arr > 0) {
            for ($j = 1; $j <= $num_arr; $j++) {
                $sql_u = mysql_query('UPDATE sinhvien SET p_check=1 WHERE p_id=' . $arr_check[$j - 1]);
                if ($sql_u) {
                    echo ' Bạn đã cập nhật thông tin thành công ';
                } else {
                    echo ' Cập nhật thông tin không thành công ';
                }
            }
        }
    }
}
//Check submit Delete
if (isset($_POST['delete'])) {
    if (isset($_POST['check'])) {
        $arr_check = $_POST['check'];
        $num_arr = count($arr_check);
        if ($num_arr > 0) {
            for ($j = 1; $j <= $num_arr; $j++) {
                $sql_u = mysql_query('UPDATE sinhvien SET p_del=1 WHERE p_id=' . $arr_check[$j - 1]);
                if ($sql_u) {
                    echo ' Bạn đã xóa thông tin thành công ';
                } else {
                    echo ' Xóa thông tin không thành công ';
                }
            }
        }
    }
}
//Check sumit Undel
if (isset($_POST['undel'])) {

    $sql_u = mysql_query('UPDATE sinhvien SET p_del=0,p_check=0');
    if ($sql_u) {
        echo ' Phục hồi dữ liệu thành công ';
    } else {
        echo ' Phục hồi dữ liệu thành công';
    }
}
// Check Them

if (isset($_POST['new'])) {
    header("location: them_sinhvien.php");
}

//Index
if (isset($_POST['index'])) {
    header("location: index.php");
}

//edit
if (isset($_POST['edit'])) {
    if (isset($_POST['check'])) {
        $arr_check = $_POST['check'];
        $num_arr = count($arr_check);
        if ($num_arr == 1) {
            header("location: them_sinhvien.php");
        }
    }
}

$sql = mysql_query("select * from sinhvien");
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Quản lý sinh viên</title>
        <link href="css/styless.css" rel="stylesheet" type="text/css">
    </head>
    <body>

        <h3> QUẢN LÝ - HIỂN THỊ SINH VIÊN</h3>
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
        <form method="post" action="sinhvien.php">
            <table border="1" cellpadding="0" cellspacing="0" width="999">
                <tr>
                    <td>Mã sinh viên</td>
                    <td>Tên sinh viên</td>
                    <td>Ngày sinh</td>
                    <td>Giới tính</td>
                    <td>Quê quán</td>
                    <td>Lớp</td>
                    <td>Khoa</td>
                    <td>Chọn</td>

                </tr>
                <?php
                if ($sql) {
                    if ($con->num_rows($sql) > 0) {
                        while ($row = $con->fetch($sql)) {
                            if ($row['p_del'] == 0) {
                                echo '<tr>';
                                echo '<td>' . $row['masv'] . '</td>';
                                echo '<td>' . $row['tensv'] . '</td>';
                                echo '<td>' . $row['ngaysinh'] . '</td>';
                                echo '<td>' . $row['gioitinh'] . '</td>';
                                echo '<td>' . $row['quequan'] . '</td>';
                                echo '<td>' . $row['lop'] . '</td>';
                                echo '<td>' . $row['khoa'] . '</td>';
                                echo '<td><input type="checkbox" name="check[]" value="' . $row['p_id'] . '"></td>';
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
                            <input type="submit" name="edit" value="Chính sửa" />
                            <input type="submit" name="index" value="Trở lại trang chủ" />
                        </div>
                    </td>
                </tr>
                </div>
            </table>
        </form>

    </body>
</html>