<?php

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
    $decoded_signature = base64_decode($signature);
    return openssl_verify($data, $decoded_signature, $public_key, OPENSSL_ALGO_SHA256) === 1;
}

?>
