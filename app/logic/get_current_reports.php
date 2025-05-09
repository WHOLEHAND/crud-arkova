<?php

require '../config/database.php';

$id = $conn->real_escape_string($_POST['id']);

$sql = "SELECT id, id_report_type, name, description, date FROM reports WHERE id=$id LIMIT 1";
$result = $conn->query($sql);
$rows = $result->num_rows;

$report = [];

if($rows > 0){
    $report = $result->fetch_array();
}

echo json_encode($report, JSON_UNESCAPED_UNICODE);
