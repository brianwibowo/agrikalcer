<?php
$conn = new mysqli('127.0.0.1', 'greenhouse', 'niFurVVaTtmW53egIGmu', 'greenhousedb');

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sql_select_data_sensor_now = "
    SELECT created_at, node, n, p, k, temperature, ph, humidity 
    FROM data_sensor_now
";
$result = $conn->query($sql_select_data_sensor_now);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data = json_encode($row);
        $response = file_get_contents("http://<url-api-ai>/predict", false, stream_context_create([
            "http" => [
                "method" => "POST",
                "header" => "Content-type: application/json\r\n",
                "content" => $data
            ]
        ]));

        $prediction = json_decode($response, true);
        $sql_insert = "
            INSERT INTO check_ai 
            (created_at, node, n, p, k, temperature, ph, humidity, crop, parameters) 
            VALUES (
                '{$row['created_at']}', '{$row['node']}', {$row['n']}, {$row['p']}, {$row['k']}, 
                {$row['temperature']}, {$row['ph']}, {$row['humidity']}, 
                '{$prediction['Crop']}', '" . json_encode($prediction['Parameters']) . "'
            )
        ";
        $conn->query($sql_insert);
    }
}

$conn->close();
?>
