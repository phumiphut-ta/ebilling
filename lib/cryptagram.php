
<?php
function Encrypt($key,$message)
{
        $ckey = crc32($key);
        $strLen = strlen($message); 
        $keyLen= strlen($ckey); 
        for ($i = 0; $i < $strLen; $i++) 
        { 
                $ordStr = ord(substr($this->message,$i,1)); 
                if($j == $keyLen) 
                { 
                        $j = 0; 
                } 
                $ordKey = ord(substr($ckey,$j,1)); 
                $j++; 
                $hashMessage .=strrev(base_convert(dechex($ordStr + $ordKey),16,36)); 
        } 
        return $hashMessage; 
}
function Decrypt($key,$message) 
{ 
        $ckey = crc32($key);
        $strLen = strlen($message); 
        $keyLen= strlen($ckey); 
        for ($i = 0; $i < $strLen; $i+=2) 
        { 
                $ordStr =hexdec(base_convert(strrev(substr($message,$i,2)),36,16));
                if ($j == $keyLen) 
                { 
                        $j = 0; 
                }
                $ordKey = ord(substr($ckey,$j,1)); 
                $j++; 
                $message .= chr($ordStr - $ordKey);
         } 
        return $message; 
}
echo Encrypt("PHUMISANTIPHONG","2");
//  echo "TEST: ".Decrypt("PHUMISANTIPHONG",Encrypt("PHUMISANTIPHONG","2")); 
        
?>