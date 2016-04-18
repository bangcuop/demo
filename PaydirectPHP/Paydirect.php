<?php

// khi nao sư dung ham getMoney moi can dung cai nay
//include("nusoap/nusoap.php");

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

    function useCard($cardSerial = "", $cardCode = "", $issuer = "", $transRef = "") {
        //Chữ ký : Mã hóa md5 các thông số
        $signature = MD5($issuer . $cardCode . $transRef . $this->partnerCode . $this->password . $this->SecretKey);
        $ch = curl_init();                    
        $url = $this->srv; 
        $fields = array(
            'issuer' => $issuer,
            'cardSerial' => $cardSerial,
            'cardCode' => $cardCode,
            'transRef' => $transRef,
            'partnerCode' => $this->partnerCode,
            'password' => $this->password,
            'signature' => $signature
        );
        $fields_string = '';
      
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);  
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch); 

        curl_close($ch); 

        return $output; 
    }

}

?>
