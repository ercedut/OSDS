<?php

function generate_des_key() {
    return openssl_random_pseudo_bytes(8);
}

function rotate_des_keys($db_connection, $table) {
    $query = "select id, des_key from $table";
    $result = mysqli_query($db_connection, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $new_key = generate_des_key();
        $data_query = "select sensitive_data from $table where id=" . $row['id'];
        $data_result = mysqli_query($db_connection, $data_query);
        $data_row = mysqli_fetch_assoc($data_result);
        $decrypted_data = des_decrypt($data_row['sensitive_data'], $row['des_key']);
        $encrypted_data = des_encrypt($decrypted_data, $new_key);
        $update_query = "update $table set des_key='" . base64_encode($new_key) . "', sensitive_data='$encrypted_data' where id=" . $row['id'];
        mysqli_query($db_connection, $update_query);
    }
}

?>
