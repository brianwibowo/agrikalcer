<?php
// Koneksi ke database
$conn = new mysqli('127.0.0.1', 'greenhouse', 'niFurVVaTtmW53egIGmu', 'greenhousedb');

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Insert rata-rata mingguan dari datamart_weekly ke datamart_monthly
$sql_insert_datamart_monthly = "
    INSERT INTO datamart_monthly (created_at, node, n, p, k, temperature, ph, humidity)
    SELECT 
        DATE_TRUNC('month', created_at) + INTERVAL '1 week' * (FLOOR((EXTRACT(DAY FROM created_at) - 1) / 7)) AS week_start,  -- Awal minggu
        node,
        AVG(n) AS avg_n,
        AVG(p) AS avg_p,
        AVG(k) AS avg_k,
        AVG(temperature) AS avg_temperature,
        AVG(ph) AS avg_ph,
        AVG(humidity) AS avg_humidity
    FROM datamart_weekly
    WHERE created_at >= DATE_TRUNC('month', NOW())  -- Awal bulan ini
      AND created_at < DATE_TRUNC('month', NOW()) + INTERVAL '1 month'  -- Akhir bulan ini
    GROUP BY node, week_start
    ORDER BY week_start, node;
";

if ($conn->query($sql_insert_datamart_monthly) === TRUE) {
    file_put_contents(__DIR__ . '/cron_log_datamart_monthly.txt', date('Y-m-d H:i:s') . " - Monthly data updated successfully\n", FILE_APPEND);
} else {
    file_put_contents(__DIR__ . '/cron_log_datamart_monthly.txt', date('Y-m-d H:i:s') . " - Error: " . $conn->error . "\n", FILE_APPEND);
}

$conn->close();
?>
