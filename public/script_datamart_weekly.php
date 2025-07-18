<?php
// Koneksi ke database
$conn = new mysqli('127.0.0.1', 'greenhouse', 'niFurVVaTtmW53egIGmu', 'greenhousedb');

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Insert data dari datamart_daily ke datamart_weekly (jam 10:00 dan 22:00)
$sql_insert_datamart_weekly = "
    INSERT INTO datamart_weekly (created_at, node, n, p, k, temperature, ph, humidity)
    SELECT 
        created_at,
        node,
        n,
        p,
        k,
        temperature,
        ph,
        humidity
    FROM datamart_daily
    WHERE created_at >= NOW() - INTERVAL '7 days'
      AND (EXTRACT(HOUR FROM created_at) = 10 OR EXTRACT(HOUR FROM created_at) = 22)
    ORDER BY created_at;
";

if ($conn->query($sql_insert_datamart_weekly) === TRUE) {
    file_put_contents(__DIR__ . '/cron_log_datamart_weekly.txt', date('Y-m-d H:i:s') . " - Weekly data updated successfully\n", FILE_APPEND);
} else {
    file_put_contents(__DIR__ . '/cron_log_datamart_weekly.txt', date('Y-m-d H:i:s') . " - Error: " . $conn->error . "\n", FILE_APPEND);
}

$conn->close();
?>
