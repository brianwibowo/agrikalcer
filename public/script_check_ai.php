<?php
// Koneksi ke database
$conn = new mysqli('127.0.0.1', 'greenhouse', 'niFurVVaTtmW53egIGmu', 'greenhousedb');

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Insert data dari data_sensor_now ke historical_data setiap 10 menit
$sql_select_data_sensor_now = "
    SELECT created_at, node, n, p, k, temperature, ph, humidity
    FROM data_sensor_now
";
if ($conn->query($sql_select_data_sensor_now) === TRUE) {
    file_put_contents(__DIR__ . '/cron_log_historical.txt', date('Y-m-d H:i:s') . " - Historical data updated successfully\n", FILE_APPEND);
} else {
    file_put_contents(__DIR__ . '/cron_log_historical.txt', date('Y-m-d H:i:s') . " - Error: " . $conn->error . "\n", FILE_APPEND);
}

$conn->close();
?>
