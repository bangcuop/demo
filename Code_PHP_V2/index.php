<?php
# Chỉnh charset
header("Content-Type: text/html; charset=UTF-8");

# Include các file cần thiết
include_once('adodb/adodb.inc.php');
include './class/class.gateWay.php';

# Cấu hình giao diện
$config_style = array(
	'title' => 'Hệ thống nạp tiền', // trong thẻ <title> </title>
	'h1'	=> 'Hệ thống nạp tiền', // heading , chứa trong thẻ <h1> </h1>
	'note'  => '+ Yêu cầu điền đúng tên tài khoản', // Bạn có thể ghi chú ý tại đây
	'footer' => 'Cổng quản lý sản lượng thanh toán', // footer
);

# Cấu hình ketnoipay.com
$config_ketnoipay = array(
	# Sau khi đăng nhập ở http://id.cbviet.net/ketnoipay , bạn có thể lấy được PartnerID tại menu thông tin tài khoản , rồi điền vào đây
	'TxtPartnerId'  => 0, 
	# Sau khi đăng nhập ở http://id.cbviet.net/ketnoipay , bạn hãy thiết lập chữ kí giao dịch signal , rồi điền vào đây
	'TxtSignal' 	=> '' 
);

# Cấu hình database
$config_server = array(
	'type' 		 => 'mysql', // Loại cơ sở dữ liệu mssql hoặc mysql
	'server' 	 => '', // Địa chỉ cơ sở dữ liệu. Localhost hoặc 127.0.0.1
	'username'   => '', // Tên đăng nhập vào cơ sở dữ liệu
	'password'   => '', // Mật khẩu vào cơ sở dữ liệu
	'database'   => '', // Database sử dụng
	'hosting'	 => true // Nếu sử dụng hosting điền true , sử dụng server điền false
);

# Cấu hình table chứa tiền , sử dụng cho các Game Private
$config_money = array(
	'Table' 		=> '',
	'FieldChuaTien' => '',
	'FieldUsername' => ''
);

if($config_server['type'] == 'mysql')
{
	$link = @mysql_connect($config_server["server"], $config_server["username"], $config_server["password"]);
	if(!$link){die('Kết nối MySQL thất bại');}
	mysql_select_db($config_server["database"]);
}elseif($config_server['type'] == 'mssql')
{
	// tạo đối tượng database
	$db = &ADONewConnection('mssql'); 
	// kết nối cơ sở dữ liệu
	$connect_mssql = $db->Connect($config_server['server'],$config_server['username'],$config_server['password'],$config_server['database']); 
	if (!$connect_mssql){die("Lỗi , không thể kết nối tới SQL Server");}
}else{die('Yêu cầu thiết lập đúng <pre>$config_server[\'type\']</pre> là mssql hoặc mysql');}


# Xử lý rồi gửi tới ketnoipay
if(isset($_POST['submit']))
{
	# Nhận dữ liệu nhập vào từ người dùng
	$TxtAccount = mysql_escape_string($_POST['TxtAccount']);
	$TxtSeri 	= mysql_escape_string($_POST['TxtSeri']);
	$TxtMaThe 	= mysql_escape_string($_POST['TxtMaThe']);
	$TxtCard	= intval($_POST['TxtCard']);
	$TxtThoiGian= date('y-m-d H:i:s',time());
	
	# Thiết lập loại thẻ và cổng kết nối
	if($config_server['hosting'])
	{
		switch($TxtCard)
		{
			case 1:
				$TxtType = 'VTT';
				$TxtUrl  = 'http://pay.ketnoipay.com/VIETTEL';
			break;
			case 2:
				$TxtType = 'VMS';
				$TxtUrl  = 'http://pay.ketnoipay.com/VINAMOBI';
			break;
			case 3:
				$TxtType = 'VNP';
				$TxtUrl  = 'http://pay.ketnoipay.com/VINAMOBI';
			break;
			case 4:
				$TxtType = 'GATE';
				$TxtUrl  = 'http://pay.ketnoipay.com/GATE';
			break;
			case 5:
				$TxtType = 'VTC';
				$TxtUrl  = 'http://pay.ketnoipay.com/VTC';
			break;
		}
	}else{
		switch($TxtCard)
		{
			case 1:
				$TxtType = 'VTT';
				$TxtUrl  = 'http://pay.ketnoipay.com:64990';
			break;
			case 2:
				$TxtType = 'VMS';
				$TxtUrl  = 'http://pay.ketnoipay.com:64980';
			break;
			case 3:
				$TxtType = 'VNP';
				$TxtUrl  = 'http://pay.ketnoipay.com:64980';
			break;
			case 4:
				$TxtType = 'GATE';
				$TxtUrl  = 'http://pay.ketnoipay.com:64986';
			break;
			case 5:
				$TxtType = 'VTC';
				$TxtUrl  = 'http://pay.ketnoipay.com:64987';
			break;
		}
	}
	# Gửi thẻ lên máy chủ FPAY
	$TxtKey   = md5(trim($config_ketnoipay['TxtPartnerId'].$TxtType.$TxtMaThe.$config_ketnoipay['TxtSignal']));
	$gateWay  = new gateWay($config_ketnoipay['TxtPartnerId'],$TxtType,$TxtMaThe,$TxtSeri,'',$TxtKey,$TxtUrl);
	$response = $gateWay->ReturnResult();
	
	# Xử lý kết quả
	if(strpos($response,'RESULT:10') !== false) // thẻ đúng
	{
		$TxtMenhGia	   = intval(str_replace('RESULT:10@','',$response));
		
		$TienDuocHuong = $TxtMenhGia;
		
		if($config_server['type'] == 'mysql')
		{
			$query_update = "UPDATE `".$config_money['Table']."` SET `".$config_money['FieldChuaTien']."` = `".$config_money['FieldChuaTien']."` + '".$TienDuocHuong."' WHERE `".$config_money['FieldUsername']."` = '".$TxtAccount."';";
			mysql_query($query_update);
		}elseif($config_server['type'] == 'mssql')
		{
			$query_update = "UPDATE ".$config_money['Table']." SET ".$config_money['FieldChuaTien']." = ".$config_money['FieldChuaTien']." + ".$TienDuocHuong." WHERE ".$config_money['FieldUsername']." = '".$TxtAccount."';";
			$db->Execute($query_update);
		}
		
		$result = 'Thẻ đúng và có mệnh giá '.$TxtMenhGia;
	}elseif(strpos($response,'RESULT:03') !== false || strpos($response,'RESULT:05') !== false || strpos($response,'RESULT:07') !== false || strpos($response,'RESULT:06') !== false) // thẻ sai
	{
		$result = 'Mã thẻ cào hoặc seri không chính xác.';
	}elseif(strpos($response,'RESULT:08') !== false)
	{
		$result = 'Thẻ đã gửi sang hệ thống rồi. Không gửi thẻ này nữa.';
	}elseif(strpos($response,'RESULT:12') !== false)
	{
		$result = 'Bạn phải nhập seri thẻ.';
	}elseif(strpos($response,'RESULT:11') !== false)
	{
		$result = 'Thẻ đã gửi sang hệ thống nhưng bị trễ.';
	}elseif(strpos($response,'RESULT:99') !== false || strpos($response,'RESULT:00') !== false || strpos($response,'RESULT:01') !== false || strpos($response,'RESULT:04') !== false || strpos($response,'RESULT:09') !== false)
	{
		$result = 'Hệ thống nạp thẻ đang bảo trì. Mã bảo trì là '.$response;
	}else{
		$result = 'Có lỗi xảy ra trong quá trình nạp thẻ. Vui lòng quay lại sau.';
	}
	
	die('<script>alert("'.$result.'");history.go(-1);</script>');
} else {
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title><?php echo $config_style['title'];?></title>
<style>
body{margin:0; padding:0;background-color:#EFEFEF;}
.form_napthe {width:500px; margin:auto;padding-top:5px;}
.form_napthe tr td {padding-top: 10px;}
</style>
</head>
<body>
	<center><h1><?php echo $config_style['h1'];?></h1></center>
	<hr>
	<form name="napthe" method="post" action="">	
	<table cellpadding="0" cellspacing="0" border="0" class="form_napthe">
		<tr>
			<td width="30%">Tài khoản</td>
			<td width="70%"><input name="TxtAccount" type="text" maxlength="50"/></td>
		</tr>
		<tr>
			<td width="30%">Loại thẻ</td>
			<td width="70%">
				<select name="TxtCard">
					<option value="1">Viettel</option>
					<option value="2">Mobifone</option>
					<option value="3">Vinaphone</option>
					<option value="4">Gate FPT</option>
					<option value="5">Vcoin VTC</option>
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
	<center>
	<p>Lưu ý khi nạp thẻ:</p>
	<p>
		<?php echo nl2br($config_style['note']);?>	
	</p>
	<hr />
	<p><?php echo $config_style['footer'];?></p>
	</center>
</body>
</html>
	
<?}?>