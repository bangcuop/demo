<?php

include("nusoap/nusoap.php");

class Paydirect {

    function __construct($srv, $partnerCode, $password, $SecretKey) {
        $this->srv = mysql_escape_string($srv);
        $this->partnerCode = mysql_escape_string($partnerCode);
        $this->password = mysql_escape_string($password);
        $this->SecretKey = mysql_escape_string($SecretKey);
    }

    function getMoney($cardSerial = "", $cardCode = "", $issuer = "", $transRef = "") {
        if (empty($cardSerial) || empty($cardCode) || empty($issuer))
            $result = "0|Thông tin đầu vào không chính xác";
        else {

            //Chữ ký : Mã hóa md5 các thông số
            $signature = MD5($issuer . $cardCode . $transRef . $this->partnerCode . $this->password . $this->SecretKey);
            try {
                $client = new nusoap_client($this->srv, 'wsdl', '', '', '', '');
                $client->soap_defencoding = 'UTF-8';
                $client->decode_utf8 = false;
                $prs = array(
                    'issuer' => $issuer,
                    'cardSerial' => $cardSerial,
                    'cardCode' => $cardCode,
                    'transRef' => $transRef,
                    'partnerCode' => $this->partnerCode,
                    'password' => $this->password,
                    'signature' => $signature
                );
                $resp = $client->call('useCard', $prs, '', '', false, true);
                $result = $resp['return'];
            } catch (Exception $E) {
                throw new Exception("Loi ket noi", "", "");
            }
            return $result;
        }
    }

}

?>
