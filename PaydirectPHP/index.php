<?php
# Chỉnh charset
header("Content-Type: text/html; charset=UTF-8");
include_once('adodb/adodb.inc.php');
include('Paydirect.php');
# Cấu hình database
$config_server = array(
    'type' => 'mysql', // Loại cơ sở dữ liệu mssql hoặc mysql
    'server' => '127.0.0.1', // Địa chỉ cơ sở dữ liệu. Localhost hoặc 127.0.0.1
    'username' => 'root', // Tên đăng nhập vào cơ sở dữ liệu
    'password' => '', // Mật khẩu vào cơ sở dữ liệu
    'database' => 'paydirect', // Database sử dụng
    'hosting' => false // Nếu sử dụng hosting điền true , sử dụng server điền false
);

# Cấu hình table chứa tiền , sử dụng cho các Game Private
$config_money = array(
    'Table' => 'money',
    'FieldChuaTien' => 'money',
    'FieldUsername' => 'userAccount'
);
// neu su dụng db thì mở ra 
// 
// 
//if ($config_server['type'] == 'mysql') {
//    $link = @mysql_connect($config_server["server"], $config_server["username"], $config_server["password"]);
//    if (!$link) {
//        die('Kết nối MySQL thất bại');
//        echo 'khong ket noi dc db';
//    }
//    echo ' ket noi dc db';
//    mysql_select_db($config_server["database"]);
//} elseif ($config_server['type'] == 'mssql') {
//    // tạo đối tượng database
//    $db = &ADONewConnection('mssql');
//    // kết nối cơ sở dữ liệu
//    $connect_mssql = $db->Connect($config_server['server'], $config_server['username'], $config_server['password'], $config_server['database']);
//    if (!$connect_mssql) {
//        die("Lỗi , không thể kết nối tới SQL Server");
//    }
//} else {
//    die('Yêu cầu thiết lập đúng <pre>$config_server[\'type\']</pre> là mssql hoặc mysql');
//}

if (isset($_POST['submit'])) {
    /*
     * Xử lý dữ liệu nạp thẻ
     */
    $CardTypeNum = array(
        'VT' => 'VT',
        'MOBI' => 'MOBI',
        'VINA' => 'VINA',
        'GATE' => 'GATE',
        'VCOIN' => 'VCOIN'
    );
    $cardCode = trim($_POST['TxtMaThe']);
    $cardSerial = trim($_POST['TxtSeri']);
    $CardType = trim($_POST['CardType']);
    $issuer = $CardTypeNum[$CardType];
    $TxtAccount = 'taikhoan'; //  tai khoan ng choi game
    if (empty($CardType)) {
        /*
         * Thông báo lỗi nếu chưa chọn loại thẻ
         */
        echo "<script>alert('Bạn chưa chọn loại thẻ.'); </script>";
    } else {
        if (empty($cardSerial) || empty($cardCode) || empty($issuer)) {
            $result = "0|Thông tin đầu vào không chính xác";
        } else {
            try {
                /*
                 * Gạch thẻ qua Homdirect
                 */
                //Thông tin đường dẫn webservice bên Paydirect
//               // su dung call webservice
//                $srv = 'http://202.160.125.66:8081/voucher/VoucherService?wsdl';
                //su dung call post get
                $srv = 'http://202.160.125.66:8081/voucher/Paydirect/userCardPost';
                /*
                 * Các thông tin $partnerCode ,$Password,$SecretKey khi chạy thật thì thay bằng thông tin mà Paydirect cấp
                 */
                $partnerCode = 'homedirect';
                $password = '123456';
                $SecretKey = 'homedirect_sk';
                $object = new Paydirect($srv, $partnerCode, $password, $SecretKey);
                //TransRef  là mã giao dịch bên đối tác để sinh ngẫu nhiên và không trùng nhau
                $transRef = date('YmdHms') . rand(0000, 9999);
                /*
                 * Gọi đến hàm getMoney với các tham số 
                 * $cardSerial : Mã serial 
                 * $cardCode : Mã code 
                 * $issuer : Loại thẻ (VT,VINA,MOBI,GATE,VCOIN) 
                 * $resp : Là kết quả trả về từ sau khi gọi vào hàm getMoney
                 * $resp có định dạng sau:
                 * Nếu thành công : Mã lỗi|Diền giải|mệnh giá
                 * Nếu không thành công : Mã lỗi|diễn giải
                 */

                //su dung goi ham call webservice
//                $resp = $object->getMoney($cardSerial, $cardCode, $issuer, $transRef);
                // su dung call post get
                $resp = $object->useCard($cardSerial, $cardCode, $issuer, $transRef);
                /*
                 * Thực hiện phân tích $resp
                 * Split $resp theo ký tự '|'
                 */
                $rs = split("\|", $resp);
                $stt = $rs[0];
                echo $stt;
                if ($stt == '01') {// Nếu trả về mã lỗi bằng 01(Thành công)
                    $amount = $rs['2']; //Mệnh giá thẻ 
                    $result = 'Thẻ đúng và có mệnh giá ' . $amount;
                    $TienDuocHuong = $amount;
                    echo 'TIen duoc huong' . $TienDuocHuong;

                    // neu su dụng db thì mở ra 
                    // 
                    // 
                    // 
//                    if ($config_server['type'] == 'mysql') {
//                        echo 'Vao update tien ';
//                        $query_update = "UPDATE " . $config_money['Table'] . " SET " . $config_money['FieldChuaTien'] . " = " . $config_money['FieldChuaTien'] . " + " . $TienDuocHuong . " WHERE " . $config_money['FieldUsername'] . " = '" . $TxtAccount . "';";
//                        echo 'Vao update tien' . $query_update;
//                        mysql_query($query_update);
//                    } elseif ($config_server['type'] == 'mssql') {
//                        $query_update = "UPDATE " . $config_money['Table'] . " SET " . $config_money['FieldChuaTien'] . " = " . $config_money['FieldChuaTien'] . " + " . $TienDuocHuong . " WHERE " . $config_money['FieldUsername'] . " = '" . $TxtAccount . "';";
//                        $db->Execute($query_update);
//                    }
                //
                } else if ($stt == '00') {
                    $result = 'Mã số nạp tiền không tồn tại hoặc đã được sử dụng';
                } else if ($stt == '03') {
                    $result = "Thẻ đã được sử dụng";
                } else if ($stt == '05') {
                    $result = "Thẻ đã hết hạn sử dụng";
                } else if ($stt == '06') {
                    $result = "Thẻ chưa được kích hoạt";
                } else if ($stt == '07') {
                    $result = "Thực hiện sai quá số lần cho phép";
                } else if ($stt == '08') {
                    $result = "Giao dịch nghi vấn";
                } else if ($stt == '09') {
                    $result = "Sai định dạng thông tin truyền vào";
                } else if ($stt == '10') {
                    $result = "Partner không tồn tại";
                } else if ($stt == '11') {
                    $result = "Partner bị khóa";
                } else if ($stt == '13') {
                    $result = "Hệ thống của Đơn vị phát hành đang bận";
                } else if ($stt == '14') {
                    $result = "Sai password";
                } else if ($stt == '15') {
                    $result = "Sai địa chỉ IP";
                } else if ($stt == '20') {
                    $result = "Sai độ dài mã số nạp tiền";
                } else if ($stt == '21') {
                    $result = "Mã giao dịch không hợp lệ";
                } else if ($stt == '23') {
                    $result = "Serial thẻ không hợp lệ";
                } else if ($stt == '24') {
                    $result = "Mã số nạp tiền và serial không khớp";
                } else if ($stt == '25') {
                    $result = "Trùng mã giao dịch (transRef)";
                } else if ($stt == '26') {
                    $result = "Mã giao dịch không tồn tại";
                } else if ($stt == '28') {
                    $result = "Mã số nạp tiền không đúng định dạng";
                } else if ($stt == '40') {
                    $result = "Lỗi kết nối tới Đơn vị phát hành";
                } else if ($stt == '41') {
                    $result = "Lỗi khi Đơn vị phát hành xử lý giao dịch";
                } else if ($stt == '51') {
                    $result = "Đơn vị phát hành không tồn tại";
                } else if ($stt == '52') {
                    $result = "Đơn vị phát hành không hỗ trợ nghiệp vụ này";
                } else {
                    $result = "Lỗi không xác định khi xử lý giao dịch";
                }
            } catch (Exception $E) {
                $arr_errors = $E->getMessage();
                die('<script>alert("' . $arr_errors . '");history.go(-1);</script>');
            }
        }
        die('<script>alert("' . $result . '");history.go(-1);</script>');
    }
} else {
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <style>
                body{margin:0; padding:0;background-color:#EFEFEF;}
                .form_napthe {width:500px; margin:auto;padding-top:5px;}
                .form_napthe tr td {padding-top: 10px;}
            </style>
        </head>
        <body>
            <hr>
                <form name="napthe" method="post" action="">	
                    <table cellpadding="0" cellspacing="0" border="0" class="form_napthe">
                        <tr>
                            <td width="30%">Loại thẻ</td>
                            <td width="70%">
                                <select name="CardType">
                                    <option value="VT">Viettel</option>
                                    <option value="MOBI">Mobifone</option>
                                    <option value="VINA">Vinaphone</option>
                                    <option value="GATE">Gate FPT</option>
                                    <option value="VCOIN">Vcoin VTC</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td width="30%">Mã thẻ</td>
                            <td width="70%"><input name="TxtMaThe" maxlength="15" type="text"></td>
                        </tr>
                        <tr>
                            <td width="30%">Seri</td>
                            <td width="70%"><input name="TxtSeri" maxlength="15" type="text"></td>
                        </tr>
                        <tr>
                            <td width="30%"></td>
                            <td width="70%"><input type="submit" name="submit" value="Xác nhận"></td>
                        </tr>
                    </table>
                </form>

        </body>
    </html>

<?php } ?>
