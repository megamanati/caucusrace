<link href="{{ url('/css/app.css') }}" rel="stylesheet">
<!DOCTYPE html>
<html>
    <body>
        <h1>Hello, {{ $name; }} </h1> <a href="{{ route('profile', ['id' => 1, 'photos' => 'yes']); }}">Ve mi profile</a>
        <a href="{{ route('midominio.lista'); }}">Otra liga</a>
    </body>
</html>


<?php

function encrypt_decrypt($string, $action = 'encrypt')
{
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'AA74CDCC2BBRT935136HH7B63C27'; // user define private key
    $secret_iv = '5fgf5HJ5g27'; // user define secret key
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16); // sha256 is hash_hmac_algo
    if ($action == 'encrypt') {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if ($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}
 
echo "Your Encrypted password is = ". $pwd = encrypt_decrypt('spaceo', 'encrypt');
echo "Your Decrypted password is = ". encrypt_decrypt($pwd, 'decrypt');



function encryptPass($password) {
    $sSalt = '20adeb83e85f03cfc84d0fb7e5f4d290';
    $sSalt = substr(hash('sha256', $sSalt, true), 0, 32);
    $method = 'aes-256-cbc';

    $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

    $encrypted = base64_encode(openssl_encrypt($password, $method, $sSalt, OPENSSL_RAW_DATA, $iv));
    return $encrypted;
}

function decryptPass($password) {
    $sSalt = '20adeb83e85f03cfc84d0fb7e5f4d290';
    $sSalt = substr(hash('sha256', $sSalt, true), 0, 32);
    $method = 'aes-256-cbc';

    $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

    $decrypted = openssl_decrypt(base64_decode($password), $method, $sSalt, OPENSSL_RAW_DATA, $iv);
    return $decrypted;
}

function encryptor($action, $string) {
	$output = FALSE;
	$encrypt_method = "AES-256-CBC";
	$secret_key = 'SecretKeyWord';
	$secret_iv  = 'SecretIV@123GKrQp';
	// hash
	$key = hash('sha256', $secret_key);
	// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	$iv = substr(hash('sha256', $secret_iv), 0, 16);
	//do the encryption given text/string/number
	if ($action == 'encrypt') {
		$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
		$output = base64_encode($output);
	} elseif ($action == 'decrypt') {
		//decrypt the given text/string/number
		$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	}
	return $output;
}

function encrypt($data) {
	return urlencode(self::encryptor('encrypt', self::sanitize($data)));
}

function decrypt($data) {
	return self::encryptor('decrypt', urldecode(self::sanitize($data)));
}
// Now you can just call encrypt($string) or decrypt($string)
?>