<?php
$conn = new mysqli('127.0.0.1', 'greenhouse', 'niFurVVaTtmW53egIGmu', 'greenhousedb');

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sql_select_pvmart_daily = "
    INSERT INTO pvmart_daily (created_at, pv_voltage, pv_current, pv_power, battery_voltage, battery_current, battery_power, load_voltage, load_current, load_power)
    SELECT created_at, pv_voltage, pv_current, pv_power, battery_voltage, battery_current, battery_power, load_voltage, load_current, load_power 
    FROM data_pv_now
    WHERE created_at >= NOW() - INTERVAL '1 hour';
";
if ($conn->query($sql_insert_datamart_daily) === TRUE) {
    file_put_contents(__DIR__ . '/cron_log_datamart_daily.txt', date('Y-m-d H:i:s') . " - Data berhasil dimasukkan ke datamart_daily\n", FILE_APPEND);
} else {
    file_put_contents(__DIR__ . '/cron_log_datamart_daily.txt', date('Y-m-d H:i:s') . " - Error: " . $conn->error . "\n", FILE_APPEND);
}
$conn->close();
?>