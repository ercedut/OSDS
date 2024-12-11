<?php

function des_encrypt($data, $key) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('des-cbc'));
    $encrypted = openssl_encrypt($data, 'des-cbc', $key, 0, $iv);
    return base64_encode($iv . $encrypted);
}

function des_decrypt($data, $key) {
    $decoded = base64_decode($data);
    $iv_length = openssl_cipher_iv_length('des-cbc');
    $iv = substr($decoded, 0, $iv_length);
    $encrypted_data = substr($decoded, $iv_length);
    return openssl_decrypt($encrypted_data, 'des-cbc', $key, 0, $iv);
}

?>
