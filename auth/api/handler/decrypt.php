<?php

class Crypto
{
    public static function EncryptAES($input, $key)
    {
        $BlockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);

        $PaddedInput = self::AddPKCS5Padding($input, $BlockSize);

        $EncryptionModule = mcrypt_module_open(MCRYPT_RIJNDAEL_128, "", MCRYPT_MODE_ECB, "");
        $InitialVector = mcrypt_create_iv(mcrypt_enc_get_iv_size($EncryptionModule), MCRYPT_RAND);

        mcrypt_generic_init($EncryptionModule, $key, $InitialVector);

        $Data = mcrypt_generic($EncryptionModule, $PaddedInput);
        mcrypt_generic_deinit($EncryptionModule);
        mcrypt_module_close($EncryptionModule);

        $Data = base64_encode($Data);

        return $Data;
    }

    public static function DecryptAES($input, $key)
    {
        $DecryptedInput = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($input), MCRYPT_MODE_ECB);

        $DataLength = strlen($DecryptedInput);
        $Padding = ord($DecryptedInput[$DataLength -1]);
        $DecryptedInput = substr($DecryptedInput, 0, -$Padding);

        return $DecryptedInput;
    }

    private static function AddPKCS5Padding($input, $blockSize)
    {
        $Padding = $blockSize - (strlen($input) % $blockSize);
        return $input . str_repeat(chr($Padding), $Padding);
    }
}
?>
<?
$data = $_POST['data']
$key = $_POST['key'];
echo DecryptAES($data, $key);
die();
?>