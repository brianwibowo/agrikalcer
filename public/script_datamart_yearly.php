<?php
// Koneksi ke database
$conn = new mysqli('127.0.0.1', 'greenhouse', 'niFurVVaTtmW53egIGmu', 'greenhousedb');

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Insert rata-rata bulanan dari datamart_monthly ke datamart_yearly
$sql_insert_datamart_yearly = "
    INSERT INTO datamart_yearly (created_at, node, n, p, k, temperature, ph, humidity)
    SELECT 
        DATE_TRUNC('year', created_at) + INTERVAL '1 month' * (EXTRACT(MONTH FROM created_at) - 1) AS month_start,
        node,
        AVG(n) AS avg_n,
        AVG(p) AS avg_p,
        AVG(k) AS avg_k,
        AVG(temperature) AS avg_temperature,
        AVG(ph) AS avg_ph,
        AVG(humidity) AS avg_humidity
    FROM datamart_monthly
    WHERE created_at >= DATE_TRUNC('year', NOW())  -- Awal tahun ini
      AND created_at < DATE_TRUNC('year', NOW()) + INTERVAL '1 year'  -- Akhir tahun ini
    GROUP BY node, month_start
    ORDER BY month_start, node;
";

if ($conn->query($sql_insert_datamart_yearly) === TRUE) {
    file_put_contents(__DIR__ . '/cron_log_datamart_yearly.txt', date('Y-m-d H:i:s') . " - Yearly data updated successfully\n", FILE_APPEND);
} else {
    file_put_contents(__DIR__ . '/cron_log_datamart_yearly.txt', date('Y-m-d H:i:s') . " - Error: " . $conn->error . "\n", FILE_APPEND);
}

$conn->close();
?>
