<?php
function des_encrypt($data, $key) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('des-ede3-cbc'));
    $encrypted = openssl_encrypt($data, 'des-ede3-cbc', $key, 0, $iv);
    return base64_encode($iv . $encrypted);
}

function des_decrypt($data, $key) {
    $data = base64_decode($data);
    $iv_length = openssl_cipher_iv_length('des-ede3-cbc');
    $iv = substr($data, 0, $iv_length);
    $encrypted = substr($data, $iv_length);
    return openssl_decrypt($encrypted, 'des-ede3-cbc', $key, 0, $iv);
}

function rsa_generate_keys($key_size = 2048) {
    $config = [
        "private_key_bits" => $key_size,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    ];
    $resource = openssl_pkey_new($config);
    openssl_pkey_export($resource, $private_key);
    $public_key = openssl_pkey_get_details($resource)['key'];
    return ['private' => $private_key, 'public' => $public_key];
}

function rsa_sign($data, $private_key) {
    openssl_sign($data, $signature, $private_key, OPENSSL_ALGO_SHA256);
    return base64_encode($signature);
}

function rsa_verify($data, $signature, $public_key) {
    $signature = base64_decode($signature);
    return openssl_verify($data, $signature, $public_key, OPENSSL_ALGO_SHA256) === 1;
}

?>
