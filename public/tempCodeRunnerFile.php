<?php
$conn = new mysqli('127.0.0.1', 'greenhouse', 'niFurVVaTtmW53egIGmu', 'greenhousedb');

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sql_select_data_one_hour = "
    INSERT INTO data_one_hour (created_at, tegangan, arus, hambatan)
    SELECT created_at, tegangan, arus, hambatan
    WHERE created_at >= NOW() - INTERVAL '1 hour';
";
if ($conn->query($sql_insert_data_one_hour) === TRUE) {
    file_put_contents(__DIR__ . '/cron_log_data_one_hour.txt', date('Y-m-d H:i:s') . " - Data berhasil dimasukkan ke datamart_daily\n", FILE_APPEND);
}